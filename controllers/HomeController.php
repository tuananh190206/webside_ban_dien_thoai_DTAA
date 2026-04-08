<?php

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;

    public $modelGioHang;
    public $modelDonHang;

    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
    }

    public function home(): void
    {
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/home.php';
    }  
    
    public function trangchu()
    {
        $this->home();
    }

    private function yeuCauKhachHangDangNhap(): void
    {
        $role = (int) ($_SESSION['user_client']['chuc_vu_id'] ?? $_SESSION['user_client']['role_id'] ?? 0);
        if (!isset($_SESSION['user_client']['email']) || $role !== 2) {
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }
    }

    private function layGioHangChoUser(): array
    {
        if (!isset($_SESSION['user_client']['email'])) {
            return [null, []];
        }
        $mail = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        if (!$mail) {
            return [null, []];
        }
        $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
        if (!$gioHang) {
            $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
            $gioHang = ['id' => $gioHangId];
        }
        $chiTiet = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        return [$gioHang, is_array($chiTiet) ? $chiTiet : []];
    }
    private function mapTrangThaiDonHang(): array
    {
        $rows = $this->modelDonHang->getTrangThaiDonHang();
        $map = [];
        foreach ($rows ?: [] as $r) {
            $map[$r['id']] = $r['name'] ?? $r['ten_trang_thai'] ?? '';
        }
        return $map;
    }

    private function mapPhuongThucThanhToan(): array
    {
        $rows = $this->modelDonHang->getPhuongThucThanhToan();
        $map = [];
        foreach ($rows ?: [] as $r) {
            $map[$r['id']] = $r['name'] ?? $r['ten_phuong_thuc'] ?? '';
        }
        return $map;
    }
    public function chiTietSanPham(): void
    {
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        $id = (int) ($_GET['id_san_pham'] ?? 0);
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFormSanPham($id);
        $listSanPhamCungDanhMuc = $sanPham
            ? $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id'])
            : [];
        
        if ($sanPham) {
            require_once './views/detailSanPham.php';
        } else {
            header('Location: ' . BASE_URL);
            exit();
        }
    }

    public function formLogin(): void
    {
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    public function postLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $result = $this->modelTaiKhoan->checkLogin($email, $password);

        // Kiểm tra nếu đăng nhập thành công (kết quả trả về là email)
        if ($result === $email) {
            $userData = $this->modelTaiKhoan->getTaiKhoanFormEmail($email);
            if ($userData) {
                $_SESSION['user_client'] = $userData;
            }
            header('Location: ' . BASE_URL);
            exit();
        }

        $_SESSION['error'] = $result;
        $_SESSION['flash'] = true;
        header('Location: ' . BASE_URL . '?act=login');
        exit();
    }


    public function addGioHang(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit();
        }
        $this->yeuCauKhachHangDangNhap();

        $mail = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
        if (!$gioHang) {
            $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
            $gioHang = ['id' => $gioHangId];
        }
        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

        $san_pham_id = (int) ($_POST['san_pham_id'] ?? 0);
        $so_luong = max(1, (int) ($_POST['so_luong'] ?? 1));
        if ($san_pham_id < 1) {
            $_SESSION['flash_loi_gio_hang'] = 'Không tìm thấy sản phẩm để thêm giỏ.';
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }
        $sp = $this->modelSanPham->getDetailSanPham($san_pham_id);
        if (!$sp || (int) ($sp['so_luong'] ?? 0) < 1) {
            $_SESSION['flash_loi_gio_hang'] = 'Sản phẩm hiện không còn hàng.';
            header('Location: ' . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $san_pham_id);
            exit();
        }
        $tonKho = (int) $sp['so_luong'];

        $checkSanPham = false;
        foreach ($chiTietGioHang ?: [] as $detail) {
            if ((int) $detail['san_pham_id'] === $san_pham_id) {
                $newSoLuong = (int) $detail['so_luong'] + $so_luong;
                if ($newSoLuong > $tonKho) {
                    $newSoLuong = $tonKho;
                }
                $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
                $checkSanPham = true;
                break;
            }
        }
        if (!$checkSanPham) {
            $them = min($so_luong, $tonKho);
            $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $them);
        }
        // Tự kiểm tra lại để biết chắc dữ liệu đã được insert và query hiển thị không bị lỗi
        $chiTietSauKhiThem = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        if (empty($chiTietSauKhiThem)) {
            $_SESSION['flash_loi_gio_hang'] = 'Đã bấm thêm, nhưng giỏ hàng vẫn chưa có sản phẩm. Kiểm tra bảng `carts` / `cart_items` và cột `user_id`, `cart_id`, `product_id`, `quantity`.';
        } else {
            $_SESSION['flash_gio_hang'] = 'Đã thêm sản phẩm vào giỏ hàng.';
        }
        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit();
    }

    public function taiKhoanKhachHang(): void
    {
        $this->yeuCauKhachHangDangNhap();
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        if (!$user) {
            unset($_SESSION['user_client']);
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }
        $soDonHang = 0;
        $ds = $this->modelDonHang->getDonHangFromUser($user['id']);
        $soDonHang = is_array($ds) ? count($ds) : 0;
        require_once './views/taiKhoanKhachHang.php';
    }

    public function capNhatTaiKhoanKhach(): void
    {
        $this->yeuCauKhachHangDangNhap();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=tai-khoan');
            exit();
        }
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        if (!$user) {
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }
        $ho_ten = trim($_POST['ho_ten'] ?? '');
        $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
        $dia_chi = trim($_POST['dia_chi'] ?? '');
        if ($ho_ten === '') {
            $_SESSION['flash_loi_tai_khoan'] = 'Vui lòng nhập họ tên.';
            header('Location: ' . BASE_URL . '?act=tai-khoan');
            exit();
        }
        if ($this->modelTaiKhoan->capNhatThongTinKhachHang((int) $user['id'], $ho_ten, $so_dien_thoai, $dia_chi)) {
            $fresh = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
            if ($fresh) {
                $_SESSION['user_client'] = $fresh;
            }
            $_SESSION['flash_thanh_cong_tai_khoan'] = 'Đã cập nhật thông tin.';
        } else {
            $_SESSION['flash_loi_tai_khoan'] = 'Không thể cập nhật. Thử lại sau.';
        }
        header('Location: ' . BASE_URL . '?act=tai-khoan');
        exit();
    }

    public function dangXuatKhachHang(): void
    {
        unset($_SESSION['user_client']);
        header('Location: ' . BASE_URL);
        exit();
    }

    public function capNhatGioHang(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }
        $this->yeuCauKhachHangDangNhap();
        [$gioHang] = $this->layGioHangChoUser();
        if (!$gioHang) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }
        $sanPhamId = (int) ($_POST['san_pham_id'] ?? 0);
        $soLuong = max(1, (int) ($_POST['so_luong'] ?? 1));
        $sp = $this->modelSanPham->getDetailSanPham($sanPhamId);
        if (!$sp) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }
        $tonKho = (int) ($sp['so_luong'] ?? 0);
        if ($soLuong > $tonKho) {
            $soLuong = max(0, $tonKho);
        }
        if ($soLuong < 1) {
            $this->modelGioHang->xoaChiTietSanPham($gioHang['id'], $sanPhamId);
        } else {
            $this->modelGioHang->updateSoLuong($gioHang['id'], $sanPhamId, $soLuong);
        }
        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit();
    }
    public function xoaGioHang(): void
    {
        $this->yeuCauKhachHangDangNhap();
        [$gioHang] = $this->layGioHangChoUser();
        if (!$gioHang) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }
        $sanPhamId = (int) ($_GET['san_pham_id'] ?? 0);
        if ($sanPhamId > 0) {
            $this->modelGioHang->xoaChiTietSanPham($gioHang['id'], $sanPhamId);
        }
        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit();
    }

    public function gioHang(): void
    {
        $this->yeuCauKhachHangDangNhap();
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        require_once './views/gioHang.php';
    }
    public function thanhToan()
    {
        $this->yeuCauKhachHangDangNhap();
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        [$gioHang, $chiTietGioHang] = $this->layGioHangChoUser();
        if (!$gioHang || empty($chiTietGioHang)) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }
        require_once './views/thanhToan.php';

    }
    public function postThanhToan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit();
        }
        $this->yeuCauKhachHangDangNhap();
       $ten_nguoi_nhan = trim($_POST['ten_nguoi_nhan'] ?? '');
       $email_nguoi_nhan = trim($_POST['email_nguoi_nhan'] ?? '');
         $sdt_nguoi_nhan = trim($_POST['sdt_nguoi_nhan'] ?? '');
            $dia_chi_nguoi_nhan = trim($_POST['dia_chi_nguoi_nhan'] ?? '');
            $ghi_chu = trim($_POST['ghi_chu'] ?? '');
            $tong_tien = (float) ($_POST['tong_tien'] ?? 0);
            $phuong_thuc_thanh_toan_id = (int) ($_POST['phuong_thuc_thanh_toan_id'] ?? 0);
      $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
      $tai_khoan_id = $user['id'];
        [$gioHang, $chiTietGioHang] = $this->layGioHangChoUser();
        if (!$gioHang || empty($chiTietGioHang)) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }
        $tinhTong = 0;
        foreach ($chiTietGioHang ?: [] as $item) {
            $gia = !empty($item['gia_khuyen_mai']) ? (float) $item['gia_khuyen_mai'] : (float) $item['gia_san_pham'];
            $soLuong = (int) ($item['so_luong'] ?? 0);
            $tinhTong += $gia * $soLuong;
        }
        $tinhTong += PHI_VAN_CHUYEN;
        if (abs($tinhTong - $tong_tien) > 1) {
            $tong_tien = $tinhTong;
        }

        $order_date = date('Y-m-d H:i:s');
        $status_id = 1;
        $order_code = 'DH' . time() . rand(1000, 9999);

        $donHangId = $this->modelDonHang->addDonHang(
            $user['id'],
            $ten_nguoi_nhan,
            $email_nguoi_nhan,
            $sdt_nguoi_nhan,
            $dia_chi_nguoi_nhan,
            $ghi_chu,
            $tong_tien,
            $phuong_thuc_thanh_toan_id,
            $order_date,
            $order_code,
            $status_id
        );
        if ($donHangId) {
            foreach ($chiTietGioHang as $item) {
                $donGia = !empty($item['gia_khuyen_mai']) ? (float) $item['gia_khuyen_mai'] : (float) $item['gia_san_pham'];
                $sl = (int) $item['so_luong'];
                $this->modelDonHang->addChiTietDonHang(
                    $donHangId,
                    (int) $item['san_pham_id'],
                    $donGia,
                    $sl,
                    $donGia * $sl
                );
            }
            $this->modelGioHang->clearDetailGioHang($gioHang['id']);
            $this->modelGioHang->clearGioHang($tai_khoan_id);

            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit();
        }

        header('Location: ' . BASE_URL . '?act=thanh-toan');
        exit();
       
    }
    public function lichSuMuaHang(){
        $this->yeuCauKhachHangDangNhap();
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        $donHangs = $this->modelDonHang->getDonHangFromUser($user['id']);
        $phuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
        $trangThaiDonHang = $this->mapTrangThaiDonHang();
        require_once './views/lichSuMuaHang.php';
    }
    public function chiTietMuaHang(){
            $this->yeuCauKhachHangDangNhap();
            [, $chiTietGioHang] = $this->layGioHangChoUser();
            $id = (int) ($_GET['id'] ?? 0);
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        $donHang = $this->modelDonHang->getDonHangByIdAndUser($id, $user['id']);
        if (!$donHang) {
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit();
        }
        $chiTietDonHang = $this->modelDonHang->getChiTietDonHangByDonHangId($id);
        $trangThaiDonHang = $this->mapTrangThaiDonHang();
        $phuongThucThanhToan = $this->mapPhuongThucThanhToan();
        require_once './views/chiTietMuaHang.php';
    }
    public function huyDonHang(){
        $this->yeuCauKhachHangDangNhap();
        $id = (int) ($_GET['id'] ?? 0);
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        $donHang = $this->modelDonHang->getDonHangByIdAndUser($id, $user['id']);
        if ($donHang && donHangCoTheHuy($donHang['status_id'] ?? 0)) {
            $this->modelDonHang->updateTrangThaiDonHang($id, TRANG_THAI_DON_HUY);
        }
        header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
        exit();
    }
}   