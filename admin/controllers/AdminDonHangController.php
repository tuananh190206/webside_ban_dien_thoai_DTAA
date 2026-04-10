<?php
class AdminDonHangController
{
    public $modelDonHang;

    public function __construct()
    {
        $this->modelDonHang = new AdminDonHang();
    }

    // 📌 1. Danh sách đơn hàng
    public function danhSachDonHang()
    {
        $listDonHang = $this->modelDonHang->getAllDonHang();
        require_once './views/donhang/listDonHang.php';
    }

    // 📌 2. Chi tiết đơn hàng
    public function detailDonHang()
    {
        $id = $_GET['id_don_hang'] ?? 0;

        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $sanPhamDonHang = $this->modelDonHang->getListSpDonHang($id);

        if ($donHang) {
            require_once './views/donhang/detailDonHang.php';
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }
    }

    // 📌 3. Form sửa (CHỈ sửa trạng thái)
    public function formEditDonHang()
    {
        $id = $_GET['id_don_hang'] ?? 0;

        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();

        if (!$donHang) {
            header("Location: " . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }

        // ❌ Nếu đã hủy hoặc hoàn thành → không cho vào form
        if (in_array($donHang['status_id'], [5, 6])) {
            $_SESSION['error'] = ['logic' => 'Đơn hàng đã hoàn tất hoặc bị hủy, không thể chỉnh sửa'];
            header("Location: " . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }

        require_once './views/donhang/editDonHang.php';

        if (function_exists('deleteSessionError')) {
            deleteSessionError();
        }
    }

    // 📌 4. Xử lý update trạng thái
    public function postEditDonHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['don_hang_id'] ?? 0;
            $status_id = $_POST['status_id'] ?? 0;
            $note = $_POST['note'] ?? '';

            $errors = [];

            if (empty($status_id)) {
                $errors['status_id'] = 'Vui lòng chọn trạng thái';
            }

            // Lấy đơn hàng hiện tại
            $donHang = $this->modelDonHang->getDetailDonHang($id);

            if (!$donHang) {
                $errors['logic'] = 'Đơn hàng không tồn tại';
            } else {

                $current = (int)$donHang['status_id'];

                // ❌ Đã hủy hoặc hoàn thành → khóa
                if (in_array($current, [5, 6])) {
                    $errors['logic'] = 'Đơn hàng đã kết thúc, không thể sửa';
                }

                // ❌ Không cho quay ngược
                if ($status_id < $current) {
                    $errors['logic'] = 'Không thể quay ngược trạng thái';
                }

                // ❌ Không cho hủy nếu đã xác nhận
                if ($status_id == 5 && $current >= 2) {
                    $errors['logic'] = 'Không thể hủy đơn đã xác nhận';
                }
            }

            $_SESSION['error'] = $errors;

            // ❌ Có lỗi → quay lại form
            if (!empty($errors)) {
                $_SESSION['flash'] = true;
                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang=' . $id);
                exit();
            }

            // ✅ Update
            $result = $this->modelDonHang->updateDonHang($id, $note, $status_id);

            if (!$result) {
                $_SESSION['error']['logic'] = 'Cập nhật thất bại';
                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang=' . $id);
                exit();
            }

            // ✅ Thành công
            header("Location:" . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }
    }
}