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
        $variants = $this->modelSanPham->getVariantsByProductId($id);
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
        $identifier = trim($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        $result = $this->modelTaiKhoan->checkLoginUnified($identifier, $password);

        if (is_array($result) && !empty($result['ok'])) {
            $cookiePath = parse_url(BASE_URL, PHP_URL_PATH) ?: '/';
            $cookiePath = rtrim($cookiePath, '/') . '/';
            $rememberVal = $identifier;
            if (trim((string) ($result['email'] ?? '')) !== '') {
                $rememberVal = strtolower(trim((string) $result['email']));
            } elseif (trim((string) ($result['phone'] ?? '')) !== '') {
                $rememberVal = trim((string) $result['phone']);
            }
            if (!empty($_POST['remember'])) {
                setcookie('client_remember_email', $rememberVal, [
                    'expires' => time() + 30 * 86400,
                    'path' => $cookiePath,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]);
            } else {
                setcookie('client_remember_email', '', [
                    'expires' => time() - 3600,
                    'path' => $cookiePath,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]);
            }

            $roleId = (int) $result['role_id'];

            if ($roleId === 1) {
                unset($_SESSION['user_client']);
                $_SESSION['user_admin'] = [
                    'id' => (int) $result['id'],
                    'email' => (string) $result['email'],
                    'full_name' => (string) $result['full_name'],
                ];
                header('Location: ' . BASE_URL_ADMIN);
                exit();
            }

            if ($roleId === 2) {
                unset($_SESSION['user_admin']);
                $userData = $this->modelTaiKhoan->getTaiKhoanById((int) $result['id']);
                if ($userData) {
                    unset($userData['password']);
                }
                $_SESSION['user_client'] = $userData;
                header('Location: ' . BASE_URL);
                exit();
            }
        }

        $msg = 'Đăng nhập thất bại, vui lòng thử lại.';
        if (is_string($result)) {
            $msg = $result;
        }
        $_SESSION['error'] = $msg;
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

    $productId = (int)($_POST['san_pham_id'] ?? 0);
    $quantity   = max(1, (int)($_POST['so_luong'] ?? 1));

    if ($productId < 1) {
        header('Location: ' . BASE_URL);
        exit();
    }

    $sp = $this->modelSanPham->getDetailSanPham($productId);

    if (!$sp) {
        header('Location: ' . BASE_URL);
        exit();
    }

    // ❗ KHÔNG CHECK TỒN KHO NỮA (cho vượt thoải mái)

    $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

    $daTonTai = false;

    foreach ($chiTietGioHang as $detail) {
        if ((int)$detail['product_id'] === $productId) {

            $newQuantity = (int)$detail['quantity'] + $quantity;

            $this->modelGioHang->updateSoLuong($gioHang['id'], $productId, $newQuantity);

            $daTonTai = true;
            break;
        }
    }

    if (!$daTonTai) {
        $this->modelGioHang->addDetailGioHang(
            $gioHang['id'],
            $productId,
            $quantity
        );
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

    // ========== ĐĂNG KÝ KHÁCH HÀNG ==========
    public function formRegister(): void
    {
        if (isset($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL);
            exit();
        }
        [, $chiTietGioHang] = $this->layGioHangChoUser();
        require_once './views/auth/formRegister.php';
        unset($_SESSION['error']);
        unset($_SESSION['old_register']);
    }

    public function postRegister(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=dang-ky');
            exit();
        }

        $ho_ten = trim($_POST['ho_ten'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $dieu_khoan = isset($_POST['dieu_khoan']) && $_POST['dieu_khoan'] === '1';

        $errors = [];
        if (empty($ho_ten)) {
            $errors[] = 'Họ tên không được để trống.';
        }
        if (empty($email)) {
            $errors[] = 'Email không được để trống.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        }
        if (!$dieu_khoan) {
            $errors[] = 'Vui lòng đồng ý điều khoản dịch vụ.';
        }
        if (strlen($password) < 6) {
            $errors[] = 'Mật khẩu phải từ 6 ký tự.';
        }
        if ($password !== $password_confirm) {
            $errors[] = 'Xác nhận mật khẩu không khớp.';
        }

        if ($this->modelTaiKhoan->getTaiKhoanFormEmail($email)) {
            $errors[] = 'Email đã tồn tại.';
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(' ', $errors);
            $_SESSION['old_register'] = $_POST;
            header('Location: ' . BASE_URL . '?act=dang-ky');
            exit();
        }

        $hash_pass = password_hash($password, PASSWORD_BCRYPT);
        $dia_chi = '';
        $check = $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $so_dien_thoai, $dia_chi, $hash_pass, 2, 1);

        if ($check) {
            unset($_SESSION['old_register']);
            header('Location: ' . BASE_URL . '?act=login&registered=1');
            exit();
        } else {
            $_SESSION['error'] = 'Không thể tạo tài khoản. Email hoặc số điện thoại có thể đã tồn tại.';
            $_SESSION['old_register'] = $_POST;
            header('Location: ' . BASE_URL . '?act=dang-ky');
            exit();
        }
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

    // --- ĐÃ LOẠI BỎ ĐOẠN CHECK TỒN KHO TẠI ĐÂY ---
    
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

    $receiver_name     = trim($_POST['receiver_name'] ?? '');
    $receiver_email    = trim($_POST['receiver_email'] ?? '');
    $receiver_phone    = trim($_POST['receiver_phone'] ?? '');
    $receiver_address  = trim($_POST['receiver_address'] ?? '');
    $note              = trim($_POST['note'] ?? '');
    $total_amount      = (float)($_POST['tong_tien'] ?? 0);
    $payment_method_id = (int)($_POST['phuong_thuc_thanh_toan_id'] ?? 0);

    $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    $userId = $user['id'];

    [$gioHang, $chiTietGioHang] = $this->layGioHangChoUser();

    if (!$gioHang || empty($chiTietGioHang)) {
        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit();
    }

    // 1. Check tồn kho trước khi tạo đơn
    foreach ($chiTietGioHang as $item) {
        $sp = $this->modelSanPham->getDetailSanPham($item['product_id']);
        if (!$sp) {
            $_SESSION['flash_loi_gio_hang'] = "Sản phẩm không tồn tại.";
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }

        if ($item['quantity'] > (int)$sp['quantity']) {
            $_SESSION['flash_loi_gio_hang'] = "Sản phẩm \"" . $sp['name'] . "\" không đủ số lượng trong kho.";
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit();
        }
    }

    // 2. Tạo đơn hàng chính
    $order_date = date('Y-m-d'); // SQL của bạn là kiểu DATE
    $order_code = 'DH' . strtoupper(substr(md5(time()), 0, 8));
    $status_id  = 1;

    $orderId = $this->modelDonHang->addDonHang(
        $userId, $receiver_name, $receiver_email, $receiver_phone, 
        $receiver_address, $note, $total_amount, $payment_method_id, 
        $order_date, $order_code, $status_id
    );

    if ($orderId) {
        foreach ($chiTietGioHang as $item) {
            $price = !empty($item['discount_price']) ? (float)$item['discount_price'] : (float)$item['price'];
            $qty = (int)$item['quantity'];
            $totalItemPrice = $price * $qty;

            // Thêm chi tiết đơn hàng với total_price đã tính toán
            $this->modelDonHang->addChiTietDonHang($orderId, $item['product_id'], $price, $qty, $totalItemPrice);

            // Trừ kho và cập nhật trạng thái (đảm bảo truyền số vào status)
            $this->modelSanPham->truSoLuongKho($item['product_id'], $qty);
        }

        $this->modelGioHang->clearDetailGioHang($gioHang['id']);
        header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
        exit();
    }
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
    
    $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    $userId = $user['id'];
    $orderId = $_GET['id'] ?? 0;

    // 1. Kiểm tra đơn hàng có thuộc về user này không
    $donHang = $this->modelDonHang->getDonHangByIdAndUser($orderId, $userId);

    if ($donHang) {
        // Chỉ cho phép hủy khi đơn hàng ở trạng thái "Đang xử lý" (Giả sử id = 1)
        if ($donHang['status_id'] == 1) {
            
            // --- BẮT ĐẦU LOGIC CỘNG LẠI SỐ LƯỢNG ---
            // 2. Lấy danh sách sản phẩm trong đơn hàng này
            $chiTietDonHang = $this->modelDonHang->getChiTietDonHangByDonHangId($orderId);
            
            if (!empty($chiTietDonHang)) {
                foreach ($chiTietDonHang as $item) {
                    // Gọi hàm tăng số lượng trong kho (Bạn cần tạo hàm này trong Model SanPham)
                    $this->modelSanPham->congSoLuongKho($item['product_id'], $item['quantity']);
                }
            }
            // --- KẾT THÚC LOGIC CỘNG LẠI SỐ LƯỢNG ---

            // 3. Cập nhật trạng thái đơn hàng thành 5 (Hủy đơn)
            $this->modelDonHang->updateTrangThaiDonHang($orderId, 5);
            
            $_SESSION['success'] = "Hủy đơn hàng thành công. Số lượng sản phẩm đã được hoàn lại kho.";
        } else {
            $_SESSION['error'] = "Không thể hủy đơn hàng ở trạng thái hiện tại.";
        }
    }
    
    header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
    exit();
}
}
