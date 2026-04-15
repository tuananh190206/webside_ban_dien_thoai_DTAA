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
        // 1. Lấy tổng doanh thu từ các đơn hàng đã giao (status_id = 4)
        $tongDoanhThu = $this->modelThongKe->getTongDoanhThu();

        // 2. Lấy tổng số lượng đơn hàng trong hệ thống
        $tongDonHang = $this->modelThongKe->getTongDonHang();

        // 3. Lấy tổng số lượng khách hàng (role_id = 2)
        $tongKhachHang = $this->modelThongKe->getTongKhachHang();

        // 4. Lấy tổng số sản phẩm đang kinh doanh
        // (Bạn nên bổ sung hàm getTongSanPham vào Model nếu muốn hiển thị)
        $tongSanPham = $this->modelThongKe->getTongSanPham();

        // 5. Lấy danh sách 5 đơn hàng mới nhất để hiển thị bảng
        $listDonHangMoi = $this->modelThongKe->getDonHangMoiNhat();

        // 6. Truyền dữ liệu sang View
        // Đường dẫn file view dựa trên cấu trúc thư mục của bạn
        require_once './views/home.php';
    }

    public function thongKeBaoCao()
    {
        // Hàm này dành cho trang chi tiết báo cáo nếu bạn cần sau này
        require_once './views/baocaothongke/listBaoCao.php';
    }

    public function thongKeSanPham()
    {
        // 1. Set timezone cho Việt Nam
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        // 2. Lấy ngày bắt đầu và kết thúc từ form (mặc định: 30 ngày gần nhất)
        $fromDate = $_GET['from'] ?? date('Y-m-d', strtotime('-30 days'));
        $toDate = $_GET['to'] ?? date('Y-m-d');

        // 3. Validate ngày (đảm bảo format Y-m-d)
        $fromDate = date('Y-m-d', strtotime($fromDate));
        $toDate = date('Y-m-d', strtotime($toDate));

        // 4. Lấy dữ liệu thống kê từ Model
        $topBanChay = $this->modelThongKe->getTopSanPhamBanChay($fromDate, $toDate, 10);
        $topBanE = $this->modelThongKe->getTopSanPhamBanE($fromDate, $toDate, 10);
        $tonKho = $this->modelThongKe->getTonKhoSanPham();
        $thongKeTheoNgay = $this->modelThongKe->getThongKeTheoNgay($fromDate, $toDate);
        $tongHop = $this->modelThongKe->getTongHopThongKe($fromDate, $toDate);

        // 5. Truyền dữ liệu ra View
        require_once './views/baocaothongke/thongKeSanPham.php';
    }
}