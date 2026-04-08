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

    public function gioiThieu()
    {
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        require_once './views/gioiThieu.php';
    }

    public function lienHe()
    {
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        require_once './views/lienHe.php';
    }

    private function yeuCauKhachHangDangNhap(): void
    {
        if (!isset($_SESSION['user_client']['email']) || (int)($_SESSION['user_client']['role_id'] ?? 0) !== 2) {
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }
    }

    private function layGioHangChoUser(): array
    {
        if (!isset($_SESSION['user_client']['email'])) {
            return [null, []];
        }
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        if (!$user) {
            return [null, []];
        }
        $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
        if (!$gioHang) {
            $gioHangId = $this->modelGioHang->addGioHang($user['id']);
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
            $map[$r['id']] = $r['name'] ?? '';
        }
        return $map;
    }

    private function mapPhuongThucThanhToan(): array
    {
        $rows = $this->modelDonHang->getPhuongThucThanhToan();
        $map = [];
        foreach ($rows ?: [] as $r) {
            $map[$r['id']] = $r['name'] ?? '';
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
            ? $this->modelSanPham->getListSanPhamDanhMuc($sanPham['category_id'])
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

        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
        if (!$gioHang) {
            $gioHangId = $this->modelGioHang->addGioHang($user['id']);
            $gioHang = ['id' => $gioHangId];
        }
        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

        $productId = (int) ($_POST['san_pham_id'] ?? 0);
        $quantity = max(1, (int) ($_POST['so_luong'] ?? 1));

        if ($productId < 1) {
            header('Location: ' . BASE_URL);
            exit();
        }

        $sp = $this->modelSanPham->getDetailSanPham($productId);
        if (!$sp) {
            header('Location: ' . BASE_URL);
            exit();
        }

        $stock = (int) ($sp['quantity'] ?? 0);
        if ($stock < 1) {
            $_SESSION['flash_loi_gio_hang'] = 'Sản phẩm hiện đã hết hàng.';
            header('Location: ' . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $productId);
            exit();
        }

        $checkSanPham = false;
        foreach ($chiTietGioHang ?: [] as $detail) {
            if ((int) $detail['product_id'] === $productId) {
                $newQuantity = (int) $detail['quantity'] + $quantity;
                if ($newQuantity > $stock) {
                    $newQuantity = $stock;
                }
                $this->modelGioHang->updateSoLuong($gioHang['id'], $productId, $newQuantity);
                $checkSanPham = true;
                break;
            }
        }

        if (!$checkSanPham) {
            $them = min($quantity, $stock);
            $this->modelGioHang->addDetailGioHang($gioHang['id'], $productId, $them);
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
        $full_name = trim($_POST['full_name'] ?? $_POST['ho_ten'] ?? '');
        $phone = trim($_POST['phone'] ?? $_POST['so_dien_thoai'] ?? '');
        $address = trim($_POST['address'] ?? $_POST['dia_chi'] ?? '');
        
        if ($full_name === '') {
            $_SESSION['flash_loi_tai_khoan'] = 'Vui lòng nhập họ tên.';
            header('Location: ' . BASE_URL . '?act=tai-khoan');
            exit();
        }
        if ($this->modelTaiKhoan->capNhatThongTinKhachHang((int) $user['id'], $full_name, $phone, $address)) {
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
        $productId = (int) ($_POST['san_pham_id'] ?? 0);
        $quantity = max(0, (int) ($_POST['so_luong'] ?? 1));
        $sp = $this->modelSanPham->getDetailSanPham($productId);
        if (!$sp) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }
        $stock = (int) ($sp['quantity'] ?? 0);
        if ($quantity > $stock) {
            $quantity = max(0, $stock);
        }
        if ($quantity < 1) {
            $this->modelGioHang->xoaChiTietSanPham($gioHang['id'], $productId);
        } else {
            $this->modelGioHang->updateSoLuong($gioHang['id'], $productId, $quantity);
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
        $productId = (int) ($_GET['san_pham_id'] ?? 0);
        if ($productId > 0) {
            $this->modelGioHang->xoaChiTietSanPham($gioHang['id'], $productId);
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
        
        $receiver_name = trim($_POST['receiver_name'] ?? $_POST['ten_nguoi_nhan'] ?? '');
        $receiver_email = trim($_POST['receiver_email'] ?? $_POST['email_nguoi_nhan'] ?? '');
        $receiver_phone = trim($_POST['receiver_phone'] ?? $_POST['sdt_nguoi_nhan'] ?? '');
        $receiver_address = trim($_POST['receiver_address'] ?? $_POST['dia_chi_nguoi_nhan'] ?? '');
        $note = trim($_POST['note'] ?? $_POST['ghi_chu'] ?? '');
        $total_amount = (float) ($_POST['total_amount'] ?? $_POST['tong_tien'] ?? 0);
        $payment_method_id = (int) ($_POST['payment_method_id'] ?? $_POST['phuong_thuc_thanh_toan_id'] ?? 0);

        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        $userId = $user['id'];
        [$gioHang, $chiTietGioHang] = $this->layGioHangChoUser();

        if (!$gioHang || empty($chiTietGioHang)) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }

        $calculatedTotal = 0;
        foreach ($chiTietGioHang ?: [] as $item) {
            $price = !empty($item['discount_price']) ? (float) $item['discount_price'] : (float) $item['price'];
            $qty = (int) ($item['quantity'] ?? 0);
            $calculatedTotal += $price * $qty;
        }
        $calculatedTotal += PHI_VAN_CHUYEN;
        if (abs($calculatedTotal - $total_amount) > 1) {
            $total_amount = $calculatedTotal;
        }

        $order_date = date('Y-m-d');
        $status_id = 1;
        $order_code = 'DH' . time() . rand(1000, 9999);

        $orderId = $this->modelDonHang->addDonHang(
            $userId,
            $receiver_name,
            $receiver_email,
            $receiver_phone,
            $receiver_address,
            $note,
            $total_amount,
            $payment_method_id,
            $order_date,
            $order_code,
            $status_id
        );

        if ($orderId) {
            foreach ($chiTietGioHang as $item) {
                $price = !empty($item['discount_price']) ? (float) $item['discount_price'] : (float) $item['price'];
                $qty = (int) $item['quantity'];
                $this->modelDonHang->addChiTietDonHang(
                    $orderId,
                    (int) $item['product_id'],
                    $price,
                    $qty,
                    $price * $qty
                );
            }
            $this->modelGioHang->clearDetailGioHang($gioHang['id']);
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit();
        }

        header('Location: ' . BASE_URL . '?act=thanh-toan');
        exit();
    }

    public function lichSuMuaHang()
    {
        $this->yeuCauKhachHangDangNhap();
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        $donHangs = $this->modelDonHang->getDonHangFromUser($user['id']);
        $phuongThucThanhToan = $this->mapPhuongThucThanhToan();
        $trangThaiDonHang = $this->mapTrangThaiDonHang();
        require_once './views/lichSuMuaHang.php';
    }

    public function chiTietMuaHang()
    {
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

    public function huyDonHang()
    {
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
