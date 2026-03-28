<?php
class AdminSanPhamController
{
    public $modelSanPham;
    public $modelCategory;

    public function __construct()
    {
        $this->modelSanPham = new AdminSanPham();
        $this->modelCategory = new AdminCategory();
    }

    public function danhSachSanPham()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/sanpham/listSanPham.php';
    }

    public function formAddSanPham()
    {
        $listDanhMuc = $this->modelCategory->getAllCategory();
        require_once './views/sanpham/addSanPham.php';
        deleteSessionError();
    }

    public function postAddSanPham()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $status = $_POST['status'] ?? '';
            $description = $_POST['description'] ?? '';

            // Xử lý hình ảnh đại diện
            $image = $_FILES['image'] ?? null;
            $file_thumb = ''; // Mặc định rỗng

            $errors = [];
            if (empty($name)) { $errors['name'] = 'Tên sản phẩm không được để trống'; }
            if (empty($price)) { $errors['price'] = 'Giá sản phẩm không được để trống'; }
            if (empty($quantity)) { $errors['quantity'] = 'Số lượng không được để trống'; }
            if (empty($category_id)) { $errors['category_id'] = 'Tên danh mục không được để trống'; }
            if (empty($status)) { $errors['status'] = 'Trạng thái không được để trống'; }
            
            // Validate file ảnh
            if ($image && $image['error'] !== 0) {
                $errors['image'] = 'Phải chọn ảnh sản phẩm hợp lệ';
            }

            $_SESSION['error'] = $errors;

            if (empty($errors)) {
                // Upload file ảnh vào thư mục ./uploads/
                $file_thumb = uploadFile($image, './uploads/');

                // Gọi Model để thêm sản phẩm (Lưu ý: Thêm biến $file_thumb vào cuối)
                $product_id = $this->modelSanPham->insertSanPham($name, $price, $quantity, $category_id, $status, $description, $file_thumb);

                header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("Location:" . BASE_URL_ADMIN . '?act=form-them-product');
                exit();
            }
        }
    }

    public function formEditSanPham()
    {
        $id = $_GET['id'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listDanhMuc = $this->modelCategory->getAllCategory();

        if ($sanPham) {
            require_once './views/sanpham/editSanPham.php';
            deleteSessionError();
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }

    public function postEditSanPham()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            $sanPhamOld = $this->modelSanPham->getDetailSanPham($id);
            $old_file = $sanPhamOld['image'];

            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $status = $_POST['status'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $_FILES['image'] ?? null;

            $errors = [];
            if (empty($name)) { $errors['name'] = 'Tên sản phẩm không được để trống'; }
            if (empty($price)) { $errors['price'] = 'Giá sản phẩm không được để trống'; }
            if (empty($quantity)) { $errors['quantity'] = 'Số lượng không được để trống'; }
            if (empty($category_id)) { $errors['category_id'] = 'Tên danh mục không được để trống'; }
            if (empty($status)) { $errors['status'] = 'Trạng thái không được để trống'; }

            $_SESSION['error'] = $errors;

            if (empty($errors)) {
                // Logic sửa ảnh: Nếu người dùng chọn ảnh mới thì upload và xóa ảnh cũ
                if ($image && $image['error'] == UPLOAD_ERR_OK) {
                    $new_file = uploadFile($image, './uploads/');
                    if (!empty($old_file)) {
                        deleteFile($old_file); // Xóa file vật lý cũ
                    }
                } else {
                    $new_file = $old_file; // Giữ nguyên ảnh cũ
                }

                // Cập nhật CSDL
                $this->modelSanPham->updateSanPham($id, $name, $price, $quantity, $category_id, $status, $description, $new_file);

                header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-san-pham&id=' . $id);
                exit();
            }
        }
    }

    public function detailSanPham()
    {
        $id = $_GET['id'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

        if ($sanPham) {
            require_once './views/sanpham/detailSanPham.php';
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }

    public function deleteSanPham()
    {
        $id = $_GET['id'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);

        if ($sanPham) {
            // Xóa ảnh vật lý của sản phẩm trước khi xóa trong DB
            deleteFile($sanPham['image']);
            $this->modelSanPham->destroySanPham($id);
        }

        header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
        exit();
    }

    public function updateTrangThaiBinhLuan()
    {
        $id_binh_luan = $_POST['id_binh_luan'];
        $name_view = $_POST['name_view'];
        $id_khach_hang = $_POST['id_khach_hang'];
        $binhLuan = $this->modelSanPham->getDetailBinhLuan($id_binh_luan);

        if ($binhLuan) {
            $trang_thai_update = ($binhLuan['trang_thai'] == 1) ? 2 : 1;
            $status = $this->modelSanPham->updateTrangThaiBinhLuan($id_binh_luan, $trang_thai_update);
            if ($status && $name_view == 'detail_khach') {
                header("Location: " . BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $id_khach_hang);
                exit();
            }
        }
    }
}