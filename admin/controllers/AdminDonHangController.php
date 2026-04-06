<?php
class AdminDonHangController
{
    public $modelDonHang;

    public function __construct()
    {
        $this->modelDonHang = new AdminDonHang();
    }

    public function danhSachDonHang()
    {
        $listDonHang = $this->modelDonHang->getAllDonHang();
        require_once './views/donhang/listDonHang.php';
    }

    public function detailDonHang(){
        $id = $_GET['id_don_hang'];
        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $sanPhamDonHang = $this->modelDonHang->getListSpDonHang($id);
        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();

        if ($donHang) {
            require_once './views/donhang/detailDonHang.php';
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }
    }

    public function formEditDonHang()
    {
        $id = $_GET['id_don_hang'];
        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();

        if ($donHang) {
            require_once './views/donhang/editDonHang.php';
            if(function_exists('deleteSessionError')) deleteSessionError();
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }
    }

    public function postEditDonHang()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $don_hang_id = $_POST['don_hang_id'] ?? '';
            $receiver_name = $_POST['receiver_name'] ?? '';
            $receiver_phone = $_POST['receiver_phone'] ?? '';
            $receiver_email = $_POST['receiver_email'] ?? '';
            $receiver_address = $_POST['receiver_address'] ?? '';
            $note = $_POST['note'] ?? '';
            $status_id = $_POST['status_id'] ?? '';

            $errors = [];
            if (empty($receiver_name)) $errors['receiver_name'] = 'Tên người nhận không được để trống';
            if (empty($receiver_phone)) $errors['receiver_phone'] = 'Số điện thoại không được để trống';
            if (empty($status_id)) $errors['status_id'] = 'Vui lòng chọn trạng thái đơn hàng';

            $_SESSION['error'] = $errors;
            
            if (empty($errors)) {
                $this->modelDonHang->updateDonHang($don_hang_id, $receiver_name, $receiver_phone, $receiver_email, $receiver_address, $note, $status_id);
                header("Location:" . BASE_URL_ADMIN . '?act=don-hang');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang=' . $don_hang_id);
                exit();
            }
        }
    }
    
}