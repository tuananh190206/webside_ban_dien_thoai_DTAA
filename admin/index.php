<?php
session_start();
// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/AdminCategoryController.php';
require_once './controllers/AdminSanPhamController.php';
// require_once './controllers/AdminTaiKhoanController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/AdminVaiTroController.php';
require_once './controllers/AdminDonHangController.php'; 
require_once './models/AdminDonHang.php';




// Require toàn bộ file Models

require_once './models/AdminCategory.php';
 require_once './models/AdminSanPham.php';

// require_once './models/AdminTaiKhoan.php';



// Route
$act = $_GET['act'] ?? '/';


// if ($act !== 'login-admin' && $act !== 'check-login-admin' && $act !== 'check-logout-admin') {
//     // Kiểm tra đăng nhập admin
//     checkLoginAdmin();
// }
// if ($act !== 'login-hdv' && $act !== 'check-loginHDV' && $act !== 'check-logout-hdv') {
//     // Kiểm tra đăng nhập admin
//     checkLoginAdmin();
// }

// if($act!== 'login-admin'&& $act!=='check-login-admin' && $act!=='check-logout-admin'){
//     // Kiểm tra đăng nhập admin
//     checkLoginAdmin();
// }


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // route danh mục
    'category' => (new AdminCategoryController())->listCategory(),
    'form-them-category' => (new AdminCategoryController())->formAddCategory(),
    'them-category' => (new AdminCategoryController())->postAddCategory(),
    'form-sua-category' => (new AdminCategoryController())->formEditCategory(),
    'sua-category' => (new AdminCategoryController())->postEditCategory(),
    'xoa-category' => (new AdminCategoryController())->deleteCategory(),

    // // // route Sản phẩm
// Quản lý sản phẩm
'san-pham'               => (new AdminSanPhamController())->danhSachSanPham(),
'form-them-san-pham'     => (new AdminSanPhamController())->formAddSanPham(),
'them-san-pham'          => (new AdminSanPhamController())->postAddSanPham(),
'form-sua-san-pham'      => (new AdminSanPhamController())->formEditSanPham(),
'sua-san-pham'           => (new AdminSanPhamController())->postEditSanPham(),
'xoa-san-pham'           => (new AdminSanPhamController())->deleteSanPham(),
'chi-tiet-san-pham'      => (new AdminSanPhamController())->chiTietSanPham(), // Đổi detail -> chiTiet

// Quản lý album ảnh (Khớp với action trong file editSanPham.php)
'sua-anh-san-pham'       => (new AdminSanPhamController())->postEditAnhSanPham(),

// route đơn hàng
'don-hang'              => (new AdminDonHangController())->danhSachDonHang(),
    'chi-tiet-don-hang'     => (new AdminDonHangController())->detailDonHang(),
    'form-sua-don-hang'     => (new AdminDonHangController())->formEditDonHang(),
    'sua-don-hang'          => (new AdminDonHangController())->postEditDonHang(),
    

    // route Trang chủ
    '/' => (new AdminBaoCaoThongKeController())->home(),

    //route Thống kê báo cáo
    'thong-ke-bao-cao' =>(new AdminBaoCaoThongKeController())->thongKeBaoCao(),

    ////route vai trò

    // 'vai-tro'=>(new AdminVaiTroController())->listVaiTro(),
    // 'form-them-vai-tro'=>(new AdminVaiTroController())->formAddVaiTro(),
    // 'them-vai-tro'=>(new AdminVaiTroController())->postAddVaiTro(),
    // 'form-sua-vai-tro'=>(new AdminVaiTroController())->formEditVaiTro(),
    // 'sua-vai-tro'=>(new AdminVaiTroController())->postEditVaiTro(),
    // 'xoa-vai-tro'=>(new AdminVaiTroController())->deleteVaiTro(),
    // route quản lí tài khoản
    // Quản lí tài khoản quản trị
    // 'list-tai-khoan-quan-tri' => (new AdminTaiKhoanController())->listTaiKhoan(),
    // 'form-them-quan-tri' => (new AdminTaiKhoanController())->formAddQuanTri(),
    // 'them-quan-tri' => (new AdminTaiKhoanController())->postAddQuanTri(),
    // 'form-sua-quan-tri' => (new AdminTaiKhoanController())->formEditQuanTri(),
    // 'sua-quan-tri' => (new AdminTaiKhoanController())->postEditQuanTri(),
    // 'xoa-quan-tri' => (new AdminTaiKhoanController())->deleteQuanTri(),
    //route reset password

    



};