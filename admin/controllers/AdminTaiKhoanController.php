<?php

class AdminTaiKhoanController
{
    public $modelTaiKhoan;
    public $modelDonHang;
    public $modelSanPham;

    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan();
        $this->modelDonHang = new AdminDonHang();
        $this->modelSanPham = new AdminSanPham();
    }

    // 1. DANH SÁCH QUẢN TRỊ VIÊN (role_id = 1)
    public function danhSachQuanTri()
    {
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);
        require_once './views/taikhoan/quantri/listQuanTri.php';
    }

    public function formAddQuanTri()
    {
        require_once './views/taikhoan/quantri/addQuanTri.php';
        deleteSessionError();
    }

    public function postAddQuanTri()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';

            $errors = [];
            if (empty($full_name)) $errors['full_name'] = 'Tên không được để trống';
            if (empty($email)) $errors['email'] = 'Email không được để trống';

            $_SESSION['error'] = $errors;

            if (empty($errors)) {
                // Password mặc định: 12345 (khớp với dữ liệu mẫu trong SQL)
                $password = password_hash('12345', PASSWORD_BCRYPT);
                $role_id = 1; // Admin

                $this->modelTaiKhoan->insertTaiKhoan($full_name, $email, $password, $role_id);
                header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-quan-tri');
                exit();
            }
        }
    }

    public function formEditQuanTri()
    {
        $id = $_GET['id_quan_tri'];
        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id);
        require_once './views/taikhoan/quantri/editQuanTri.php';
        deleteSessionError();
    }

    public function postEditQuanTri()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $status = $_POST['status'] ?? 1;

            $errors = [];
            if (empty($full_name)) $errors['full_name'] = 'Tên không được để trống';
            if (empty($email)) $errors['email'] = 'Email không được để trống';

            $_SESSION['error'] = $errors;

            if (empty($errors)) {
                $this->modelTaiKhoan->updateTaiKhoan($id, $full_name, $email, $phone, $status);
                header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-quan-tri&id_quan_tri=' . $id);
                exit();
            }
        }
    }

    // 2. DANH SÁCH KHÁCH HÀNG (role_id = 2)
    public function danhSachKhachHang()
    {
        $listKhachHang = $this->modelTaiKhoan->getAllTaiKhoan(2);
        require_once './views/taikhoan/khachhang/listKhachHang.php';
    }

    public function formEditKhachHang()
    {
        $id = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id);
        require_once './views/taikhoan/khachhang/editKhachHang.php';
        deleteSessionError();
    }

    public function postEditKhachHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $birthday = $_POST['birthday'] ?? '';
            $gender = $_POST['gender'] ?? 1;
            $address = $_POST['address'] ?? '';
            $status = $_POST['status'] ?? 1;

            $errors = [];
            if (empty($full_name)) $errors['full_name'] = 'Tên không được để trống';
            if (empty($email)) $errors['email'] = 'Email không được để trống';

            $_SESSION['error'] = $errors;

            if (empty($errors)) {
                $this->modelTaiKhoan->updateKhachHang($id, $full_name, $email, $phone, $birthday, $gender, $address, $status);
                header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-khach-hang&id_khach_hang=' . $id);
                exit();
            }
        }
    }

    public function detailKhachHang()
    {
        $id = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id);
        $listDonHang = $this->modelDonHang->getDonHangFromKhachHang($id);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromKhachHang($id);
        require_once './views/taikhoan/khachhang/detailKhachHang.php';
    }

    // 3. AUTHENTICATION (LOGIN/LOGOUT)
    public function postLoginAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Gọi model check login (Lưu ý: trong SQL của bạn pass đang để text thuần '12345')
            $user = $this->modelTaiKhoan->checkLogin($email, $password);

            if ($user && $user['role_id'] == 1) { // Phải là Admin
                $_SESSION['user_admin'] = $user['email'];
                header("Location: " . BASE_URL_ADMIN);
                exit();
            } else {
                $_SESSION['error'] = "Email hoặc mật khẩu không chính xác!";
                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['user_admin']);
        header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
        exit();
    }

    // 4. RESET PASSWORD
    public function resetPassword()
    {
        $id = $_GET['id_quan_tri'] ?? $_GET['id_khach_hang'];
        $taiKhoan = $this->modelTaiKhoan->getDetailTaiKhoan($id);
        $new_password = password_hash('12345', PASSWORD_BCRYPT);
        
        $status = $this->modelTaiKhoan->resetPassword($id, $new_password);
        
        if ($status) {
            $redirect = ($taiKhoan['role_id'] == 1) ? 'list-tai-khoan-quan-tri' : 'list-tai-khoan-khach-hang';
            header("Location: " . BASE_URL_ADMIN . "?act=" . $redirect);
            exit();
        } else {
            die('Lỗi khi reset mật khẩu');
        }
    }
}