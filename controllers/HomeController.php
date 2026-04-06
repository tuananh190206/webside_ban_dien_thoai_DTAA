<?php

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDonHang;


    public function gioiThieu() {
    require_once './views/gioiThieu.php';
}

public function lienHe() {
    require_once './views/lienHe.php';
}

    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
    }

    public function home()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/home.php';
    }

    public function trangchu()
    {
        echo "day la trang chu";
    }

    public function chiTietSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFormSanPham($id);
        
        // Khớp DB: Sử dụng 'category_id' thay vì 'danh_muc_id'
        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['category_id']);

        if ($sanPham) {
            require_once './views/detailSanPham.php';
        } else {
            header("Location: " . BASE_URL);
            exit();
        }
    }

    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = $this->modelTaiKhoan->checkLogin($email, $password);

            if ($result == $email) {
                // Khớp DB: Truy vấn từ bảng 'users'
                $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->modelTaiKhoan->conn->prepare($sql);
                $stmt->execute(['email' => $email]);
                $userData = $stmt->fetch();

                $_SESSION['user_client'] = $userData;

                header("Location: " . BASE_URL);
                exit();
            }

            $_SESSION['error'] = $result;
            $_SESSION['flash'] = true;
            header("Location: " . BASE_URL . '?act=login');
            exit();
        }
    }

    public function addGioHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['user_client']['email'])) {
                $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
                
                // Khớp DB: Lấy giỏ hàng theo 'user_id'
                $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
                
                if (!$gioHang) {
                    $gioHangId = $this->modelGioHang->addGioHang($user['id']);
                    $gioHang = ['id' => $gioHangId];
                }
                
                $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

                $product_id = $_POST['san_pham_id'];
                $quantity = $_POST['so_luong'];

                $checkSanPham = false;
                foreach ($chiTietGioHang as $detail) {
                    // Khớp DB: Bảng 'cart_items' sử dụng 'product_id' và 'quantity'
                    if ($detail['product_id'] == $product_id) {
                        $newSoLuong = $detail['quantity'] + $quantity;
                        $this->modelGioHang->updateSoLuong($gioHang['id'], $product_id, $newSoLuong);
                        $checkSanPham = true;
                        break;
                    }
                }
                
                if (!$checkSanPham) {
                    $this->modelGioHang->addDetailGioHang($gioHang['id'], $product_id, $quantity);
                }
                header('Location: ' . BASE_URL . '?act=gio-hang');

            } else {
                header('Location: ' . BASE_URL . '?act=login');
                exit();
            }
        }
    }

    public function gioHang()
    {
        if (isset($_SESSION['user_client']['email'])) {
            $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
            $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
            
            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($user['id']);
                $gioHang = ['id' => $gioHangId];
            }
            
            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            require_once './views/gioHang.php';

        } else {
            header('Location: ' . BASE_URL . '?act=login');
        }
    }

    // public function postThanhToan()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         // Khớp DB: Các trường tương ứng bảng 'orders'
    //         $receiver_name = $_POST['ten_nguoi_nhan'];
    //         $receiver_email = $_POST['email_nguoi_nhan'];
    //         $receiver_phone = $_POST['sdt_nguoi_nhan'];
    //         $receiver_address = $_POST['dia_chi_nguoi_nhan'];
    //         $note = $_POST['ghi_chu'];
    //         $total_amount = $_POST['tong_tien'];
    //         $payment_method_id = $_POST['phuong_thuc_thanh_toan_id'];

    //         $order_date = date('Y-m-d');
    //         $status_id = 1; // Mặc định: 'Đang xử lý'
    //         $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         $user_id = $user['id'];
    //         $order_code = 'DH' . rand(1000, 9999);

    //         $orderId = $this->modelDonHang->addDonHang(
    //             $order_code, $user_id, $receiver_name, $receiver_email, 
    //             $receiver_phone, $receiver_address, $order_date, 
    //             $total_amount, $note, $payment_method_id, $status_id
    //         );

    //         if ($orderId) {
    //             $gioHang = $this->modelGioHang->getGioHangFromUser($user_id);
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

    //             foreach($chiTietGioHang as $item){
    //                 // Khớp DB: 'discount_price' hoặc 'price' từ bảng products
    //                 $donGia = $item['discount_price'] ?? $item['price'];
                    
    //                 // Khớp DB: Bảng 'order_items' (order_id, product_id, price, quantity, total_price)
    //                 $this->modelDonHang->addChiTietDonHang(
    //                     $orderId,
    //                     $item['product_id'],
    //                     $donGia,
    //                     $item['quantity'],
    //                     $donGia * $item['quantity']
    //                 );
    //             }
                
    //             // Sau khi thanh toán: Xóa sản phẩm trong chi tiết giỏ hàng
    //             $this->modelGioHang->clearDetailGioHang($gioHang['id']);
                
    //             header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
    //             exit();
    //         } else {
    //             echo "Lỗi khi đặt hàng, vui lòng thử lại sau.";
    //         }
    //     }
    // }

    // public function lichSuMuaHang()
    // {
    //     if (isset($_SESSION['user_client'])) {
    //         $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         $user_id = $user['id'];
            
    //         $arrTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();
    //         $arrPhuongThucThanhToan = $this->modelDonHang->getAllPhuongThucThanhToan();
            
    //         // Lấy danh sách đơn hàng dựa trên 'user_id'
    //         $donHangs = $this->modelDonHang->getDonHangFormUser($user_id);
    //         require_once './views/lichSuMuaHang.php';
          
    //     } else {
    //         header('Location: ' . BASE_URL . '?act=login');
    //         exit();
    //     }
    // }
}