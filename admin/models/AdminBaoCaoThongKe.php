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
}