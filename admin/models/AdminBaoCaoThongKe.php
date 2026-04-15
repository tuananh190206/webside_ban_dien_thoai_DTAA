<?php
class AdminBaoCaoThongKe {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Thống kê tổng doanh thu từ bảng 'orders'
    public function getTongDoanhThu() {
        // Trong SQL của bạn, cột là 'total_amount', trạng thái 'Đã giao' là id = 4
        $sql = "SELECT SUM(total_amount) as total FROM orders WHERE status_id = 4"; 
        $result = $this->conn->query($sql)->fetch();
        return $result['total'] ?? 0;
    }

    // Thống kê tổng số đơn hàng từ bảng 'orders'
    public function getTongDonHang() {
        $sql = "SELECT COUNT(*) as total FROM orders";
        $result = $this->conn->query($sql)->fetch();
        return $result['total'] ?? 0;
    }

    // Thống kê tổng số khách hàng từ bảng 'users'
    public function getTongKhachHang() {
        // Trong SQL của bạn, bảng là 'users', role_id = 2 là khách hàng
        $sql = "SELECT COUNT(*) as total FROM users WHERE role_id = 2";
        $result = $this->conn->query($sql)->fetch();
        return $result['total'] ?? 0;
    }

    // Lấy 5 đơn hàng mới nhất
    public function getDonHangMoiNhat() {
        $sql = "SELECT orders.*, users.full_name 
                FROM orders 
                JOIN users ON orders.user_id = users.id 
                ORDER BY orders.id DESC LIMIT 5";
        return $this->conn->query($sql)->fetchAll();
    }
    public function getTongSanPham() {
        $sql = "SELECT COUNT(*) as total FROM products";
        return $this->conn->query($sql)->fetch()['total'] ?? 0;
    }

    // =====================================================
    // THỐNG KÊ SẢN PHẨM - THEO KHOẢNG NGÀY
    // =====================================================

    // 1. Top sản phẩm bán chạy (theo số lượng bán ra)
    public function getTopSanPhamBanChay($fromDate = null, $toDate = null, $limit = 10) {
        $where = "WHERE o.status_id IN (2, 3, 4)"; // Đã xác nhận, Đang giao, Đã giao
        
        if ($fromDate && $toDate) {
            $where .= " AND o.order_date BETWEEN '$fromDate' AND '$toDate'";
        }

        $sql = "SELECT 
                    p.id,
                    p.name,
                    p.price,
                    p.discount_price,
                    p.image,
                    SUM(oi.quantity) AS tong_so_luong_ban,
                    SUM(oi.total_price) AS tong_doanh_thu
                FROM order_items oi
                JOIN orders o ON oi.order_id = o.id
                JOIN products p ON oi.product_id = p.id
                $where
                GROUP BY p.id, p.name, p.price, p.discount_price, p.image
                ORDER BY tong_so_luong_ban DESC
                LIMIT $limit";

        return $this->conn->query($sql)->fetchAll();
    }

    // 2. Top sản phẩm bán ế (ít bán nhất trong khoảng ngày)
    public function getTopSanPhamBanE($fromDate = null, $toDate = null, $limit = 10) {
        $where = "o.status_id IN (2, 3, 4)";
        $whereDate = "";
        
        if ($fromDate && $toDate) {
            $whereDate = "AND o.order_date BETWEEN '$fromDate' AND '$toDate'";
        }

        $sql = "SELECT 
                    p.id,
                    p.name,
                    p.price,
                    p.discount_price,
                    p.image,
                    COALESCE(SUM(oi.quantity), 0) AS tong_so_luong_ban,
                    COALESCE(SUM(oi.total_price), 0) AS tong_doanh_thu
                FROM products p
                LEFT JOIN order_items oi ON p.id = oi.product_id
                LEFT JOIN orders o ON oi.order_id = o.id AND $where $whereDate
                GROUP BY p.id, p.name, p.price, p.discount_price, p.image
                HAVING tong_so_luong_ban > 0
                ORDER BY tong_so_luong_ban ASC
                LIMIT $limit";

        return $this->conn->query($sql)->fetchAll();
    }

    // 3. Tồn kho thực tế (trừ đơn thành công, cộng đơn hủy)
    public function getTonKhoSanPham() {
        $sql = "SELECT 
                    p.id,
                    p.name,
                    p.price,
                    p.discount_price,
                    p.image,
                    p.quantity AS so_luong_goc,
                    COALESCE(SUM(CASE 
                        WHEN o.status_id IN (2, 3, 4) THEN oi.quantity 
                        ELSE 0 
                    END), 0) AS da_ban,
                    COALESCE(SUM(CASE 
                        WHEN o.status_id = 5 THEN oi.quantity 
                        ELSE 0 
                    END), 0) AS da_huy,
                    (p.quantity - COALESCE(SUM(CASE 
                        WHEN o.status_id IN (2, 3, 4) THEN oi.quantity 
                        ELSE 0 
                    END), 0) + COALESCE(SUM(CASE 
                        WHEN o.status_id = 5 THEN oi.quantity 
                        ELSE 0 
                    END), 0)) AS ton_kho_thuc_te
                FROM products p
                LEFT JOIN order_items oi ON p.id = oi.product_id
                LEFT JOIN orders o ON oi.order_id = o.id
                GROUP BY p.id, p.name, p.price, p.discount_price, p.image, p.quantity
                ORDER BY ton_kho_thuc_te ASC";

        return $this->conn->query($sql)->fetchAll();
    }

    // 4. Thống kê theo ngày (số đơn, doanh thu, số SP bán)
    public function getThongKeTheoNgay($fromDate = null, $toDate = null) {
        $where = "";
        if ($fromDate && $toDate) {
            $where = "WHERE o.order_date BETWEEN '$fromDate' AND '$toDate' AND o.status_id IN (2, 3, 4)";
        } else {
            $where = "WHERE o.status_id IN (2, 3, 4)";
        }

        $sql = "SELECT 
                    o.order_date,
                    COUNT(DISTINCT o.id) AS so_don_hang,
                    SUM(o.total_amount) AS doanh_thu,
                    SUM(oi.quantity) AS so_san_pham_ban
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                $where
                GROUP BY o.order_date
                ORDER BY o.order_date DESC";

        return $this->conn->query($sql)->fetchAll();
    }

    // 5. Tổng hợp thống kê trong khoảng ngày (tổng doanh thu, số đơn, số SP)
    public function getTongHopThongKe($fromDate = null, $toDate = null) {
        $where = "o.status_id IN (2, 3, 4)";
        if ($fromDate && $toDate) {
            $where .= " AND o.order_date BETWEEN '$fromDate' AND '$toDate'";
        }

        $sql = "SELECT 
                    COUNT(DISTINCT o.id) AS tong_don,
                    COALESCE(SUM(o.total_amount), 0) AS tong_doanh_thu,
                    COUNT(oi.id) AS tong_san_pham_ban
                FROM orders o
                LEFT JOIN order_items oi ON o.id = oi.order_id
                WHERE $where";

        return $this->conn->query($sql)->fetch();
    }
}