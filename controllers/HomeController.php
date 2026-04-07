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

    // public function chiTietSanPham()
    // {
    //     $id = $_GET['id_san_pham'];
    //     $sanPham = $this->modelSanPham->getDetailSanPham($id);
    //     $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
    //     $listBinhLuan = $this->modelSanPham->getBinhLuanFormSanPham($id);
    //     $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id']);
    //     // var_dump($listSanPhamCungDanhMuc);die;

    //     if ($sanPham) {
    //         require_once './views/detailSanPham.php';
    //     } else {
    //         header("Location: " . BASE_URL);
    //         exit();
    //     }
    // }

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
    // public function thanhToan()
    // {

    //     if (isset($_SESSION['user_client']['email'])) {
    //         $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         //lấy dữ liệu giỏ hàng của người dùng
    //         $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
    //         if (!$gioHang) {
    //             $gioHangId = $this->modelGioHang->addGioHang($user['id']);
    //             $gioHang = ['id' => $gioHangId];
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
    //         } else {
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

    //         }
    //         require_once './views/thanhToan.php';
    //         header('Location: ' . BASE_URL . '?act=gio-hang');

    //     } else {
    //         var_dump('Lỗi chưa đăng nhập');
    //         die;
    //     }

    // }
    // public function postThanhToan()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
    //         $email_nguoi_nhan = $_POST['email_nguoi_nhan'];
    //         $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'];
    //         $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'];
    //         $ghi_chu = $_POST['ghi_chu'];
    //         $tong_tien = $_POST['tong_tien'];
    //         $phuong_thuc_thanh_toan_id = $_POST['phuong_thuc_thanh_toan_id'];

    //         $ngay_dat = date('y-m-d ');
    //         $trang_thai_id = 1;
    //         $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         $tai_khoan_id = $user['id'];
    //         $ma_don_hang = 'DH' . rand(1000, 9999);

    //         $donHang=$this->modelDonHang->addDonHang($tai_khoan_id, $ten_nguoi_nhan, $email_nguoi_nhan, $sdt_nguoi_nhan, $dia_chi_nguoi_nhan, $ghi_chu, $tong_tien, $phuong_thuc_thanh_toan_id, $ngay_dat, $ma_don_hang, $trang_thai_id);
    //         $gioHang = $this->modelGioHang->getGioHangFromUser($tai_khoan_id);
    //         if ($donHang) {
    //             // lay ra toan bo san pham trong gio hang
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
    //             //them tung san pham tu gio hang vao bang chi tiet don hang
    //             foreach($chiTietGioHang as $item){
    //                 $donGia=$item['gia_khuyen_mai'] ?? $item['gia_san_pham'];
    //                 $this->modelDonHang->addChiTietDonHang(
    //                     $donHang,// id don hang vua tao
    //                     $item['san_pham_id'],// id san pham
    //                     $donGia,// don gia cua san pham
    //                     $item['so_luong'],// so luong san pham
    //                     $donGia * $item['so_luong']// thanh tien cua san pham
    //                 );
    //             }
    //             // sau khi thanh toán thì xác nhận xóa sản phẩm trong giỏ hàng
    //             // Xóa toàn bộ sản phẩm trong chi tiết giỏ hàng
    //             $this->modelGioHang->clearDetailGioHang($gioHang['id']);
    //             // Xóa toàn bộ giỏ hàng người dùng
    //             $this->modelGioHang->clearGioHang($gioHang['id']);

    //             // Chuyển hướng về trang lịch sử mua hàng 
    //             header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
    //             exit();
    //         }else{
    //             var_dump('Lỗi khi đặt hàng,vui lòng thử lại sau');
    //         }
    //     }

    // }
    // public function lichSuMuaHang(){
    //     if(isset($_SESSION['user_client'])){
    //          $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         $tai_khoan_id = $user['id'];
    //         //lấy ra đơn sách trạng thái đơn hàng 
    //         $arrTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();

    //         // lẩy ra danh sách trạngt thái thanh toán 
    //         $arrPhuongThucThanhToan = $this->modelDonHang->getAllPhuongThucThanhToan();
    //         //lấy ra danh sách tất cả đơn hang của tài khoản
    //         $donHangs = $this->modelDonHang->getDonHangFormUser($tai_khoan_id);
    //        require_once './views/lichSuMuaHang.php';
          
    //     }else{
    //         var_dump('Bạn chưa đăng nhập');  
    //         die;
    //     }
    // }
    // public function chiTietMuaHang(){

    // }
    // public function huyDonHang(){

    // }
}   