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
        // $this->modelTaiKhoan = new TaiKhoan();
        // $this->modelGioHang = new GioHang();
        // $this->modelDonHang = new DonHang();
    }

    public function home()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/home.php';
    }
    // public function trangchu()
    // {
    //     echo "day la trang chu";
    // }

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

    // public function formLogin()
    // {
    //     require_once './views/auth/formLogin.php';
    //     deleteSessionError();
    // }

    // public function postLogin()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //         $email = $_POST['email'] ?? '';
    //         $password = $_POST['password'] ?? '';

    //         $result = $this->modelTaiKhoan->checkLogin($email, $password);

    //         // Nếu đăng nhập thành công → $result sẽ là email
    //         if ($result == $email) {
    //             // Lấy lại thông tin user để lưu vào session
    //             $sql = "SELECT * FROM tai_khoans WHERE email = :email LIMIT 1";
    //             $stmt = $this->modelTaiKhoan->conn->prepare($sql);
    //             $stmt->execute(['email' => $email]);
    //             $userData = $stmt->fetch();

    //             $_SESSION['user_client'] = $userData;

    //             header("Location: " . BASE_URL);
    //             exit();
    //         }

    //         // Nếu thất bại → $result là chuỗi báo lỗi
    //         $_SESSION['error'] = $result;
    //         $_SESSION['flash'] = true;
    //         header("Location: " . BASE_URL . '?act=login');
    //         exit();
    //     }
    // }

    // public function addGioHang()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         if (isset($_SESSION['user_client']['email'])) {
    //             $mail = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //             //lấy dữ liệu giỏ hàng của người dùng
    //             $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
    //             if (!$gioHang) {
    //                 $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
    //                 $gioHang = ['id' => $gioHangId];
    //                 $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
    //             } else {
    //                 $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

    //             }


    //             $san_pham_id = $_POST['san_pham_id'];
    //             $so_luong = $_POST['so_luong'];

    //             $checkSanPham = false;
    //             foreach ($chiTietGioHang as $detail) {
    //                 if ($detail['san_pham_id'] == $san_pham_id) {
    //                     $newSoLuong = $detail['so_luong'] + $so_luong;
    //                     $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
    //                     $checkSanPham = true;
    //                     break;
    //                 }
    //             }
    //             if (!$checkSanPham) {
    //                 $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
    //             }
    //             header('Location: ' . BASE_URL . '?act=gio-hang');

    //         } else {
    //             var_dump('Lỗi chưa đăng nhập');
    //             die;
    //         }
    //     }
    // }
    // public function gioHang()
    // {
    //     if (isset($_SESSION['user_client']['email'])) {
    //         $mail = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         //lấy dữ liệu giỏ hàng của người dùng
    //         $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
    //         if (!$gioHang) {
    //             $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
    //             $gioHang = ['id' => $gioHangId];
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
    //         } else {
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

    //         }
    //         require_once './views/gioHang.php';
    //         header('Location: ' . BASE_URL . '?act=gio-hang');

    //     } else {
    //         header('Location: ' . BASE_URL . '?act=login');

    //     }
    // }
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