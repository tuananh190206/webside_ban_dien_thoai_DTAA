<?php

class AdminBaoCaoThongKeController
{
    public $modelThongKe;

    public function __construct()
    {
        // Phải đảm bảo file AdminBaoCaoThongKe.php đã được require trong index.php
        $this->modelThongKe = new AdminBaoCaoThongKe();
    }

    public function home()
    {
        // Lấy ngày bắt đầu và ngày kết thúc từ request
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;

        // 1. Lấy tổng doanh thu từ các đơn hàng đã giao (status_id = 4)
        $tongDoanhThu = $this->modelThongKe->getTongDoanhThu($startDate, $endDate);

        // 2. Lấy tổng số lượng đơn hàng trong hệ thống
        $tongDonHang = $this->modelThongKe->getTongDonHang($startDate, $endDate);

        // 3. Lấy tổng số lượng khách hàng (role_id = 2)
        $tongKhachHang = $this->modelThongKe->getTongKhachHang($startDate, $endDate);

        // 4. Lấy tổng số sản phẩm đang kinh doanh
        $tongSanPham = $this->modelThongKe->getTongSanPham();

        // 5. Lấy danh sách đơn hàng
        if ($startDate && $endDate) {
            $listDonHangMoi = $this->modelThongKe->getDonHangTheoKhoangThoiGian($startDate, $endDate);
        } else {
            $listDonHangMoi = $this->modelThongKe->getDonHangMoiNhat();
        }

        // 6. Truyền dữ liệu sang View
        require_once './views/home.php';
    }

    public function thongKeBaoCao()
    {
        // Hàm này dành cho trang chi tiết báo cáo nếu bạn cần sau này
        require_once './views/baocaothongke/listBaoCao.php';
    }
}