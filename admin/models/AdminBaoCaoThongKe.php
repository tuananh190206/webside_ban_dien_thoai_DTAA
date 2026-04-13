<?php
class AdminBaoCaoThongKe {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Thống kê tổng doanh thu từ bảng 'orders'
    public function getTongDoanhThu($startDate = null, $endDate = null) {
        $sql = "SELECT SUM(total_amount) as total FROM orders WHERE status_id = 4"; 
        if ($startDate && $endDate) {
            $sql .= " AND order_date BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";
        }
        $result = $this->conn->query($sql)->fetch();
        return $result['total'] ?? 0;
    }

    // Thống kê tổng số đơn hàng từ bảng 'orders'
    public function getTongDonHang($startDate = null, $endDate = null) {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE 1=1";
        if ($startDate && $endDate) {
            $sql .= " AND order_date BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";
        }
        $result = $this->conn->query($sql)->fetch();
        return $result['total'] ?? 0;
    }

    // Thống kê tổng số khách hàng từ bảng 'users'
    public function getTongKhachHang($startDate = null, $endDate = null) {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role_id = 2";
        if ($startDate && $endDate) {
            $sql .= " AND created_at BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";
        }
        $result = $this->conn->query($sql)->fetch();
        return $result['total'] ?? 0;
    }

    // Lấy danh sách đơn hàng trong khoảng thời gian
    public function getDonHangTheoKhoangThoiGian($startDate, $endDate) {
        $sql = "SELECT orders.*, users.full_name 
                FROM orders 
                JOIN users ON orders.user_id = users.id 
                WHERE orders.order_date BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'
                ORDER BY orders.id DESC";
        return $this->conn->query($sql)->fetchAll();
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