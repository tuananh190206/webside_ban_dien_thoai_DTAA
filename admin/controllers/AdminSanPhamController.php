<?php
class AdminSanPhamController
{
    public $modelSanPham;
    public $modelDanhMuc;

    public function __construct()
    {
        $this->modelSanPham = new AdminSanPham();
        $this->modelDanhMuc = new AdminCategory(); // Sử dụng model danh mục của bạn
    }

    public function danhSachSanPham()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/sanpham/listSanPham.php';
    }

    public function formAddSanPham()
    {
        $listDanhMuc = $this->modelDanhMuc->getAllCategory(); // Gọi đúng hàm từ AdminCategory.php
        require_once './views/sanpham/addSanPham.php';
        if(function_exists('deleteSessionError')) deleteSessionError();
    }

    public function postAddSanPham()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $discount_price = $_POST['discount_price'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $import_date = $_POST['import_date'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $status = $_POST['status'] ?? '';
            $description = $_POST['description'] ?? '';

            $image = $_FILES['image'] ?? null;
            $file_thumb = uploadFile($image, './uploads/');

            $img_array = $_FILES['img_array'] ?? null;
            $errors = [];

            if (empty($name)) $errors['name'] = 'Tên sản phẩm không được để trống';
            if (empty($price)) $errors['price'] = 'Giá sản phẩm không được để trống';
            if (empty($category_id)) $errors['category_id'] = 'Danh mục không được để trống';
            if ($image['error'] !== 0) $errors['image'] = 'Phải chọn ảnh sản phẩm';

            $_SESSION['error'] = $errors;

            if (empty($errors)) {
                $product_id = $this->modelSanPham->insertSanPham($name, $price, $discount_price, $quantity, $import_date, $category_id, $status, $description, $file_thumb);

                // Xử lý thêm album ảnh sản phẩm
                if (!empty($img_array['name'][0])) {
                    foreach ($img_array['name'] as $key => $value) {
                        $file = [
                            'name' => $img_array['name'][$key],
                            'type' => $img_array['type'][$key],
                            'tmp_name' => $img_array['tmp_name'][$key],
                            'error' => $img_array['error'][$key],
                            'size' => $img_array['size'][$key]
                        ];
                        $link_hinh_anh = uploadFile($file, './uploads/');
                        $this->modelSanPham->insertAlbumAnhSanPham($product_id, $link_hinh_anh);
                    }
                }

                header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("Location:" . BASE_URL_ADMIN . '?act=form-them-san-pham');
                exit();
            }
        }
    }

    public function formEditSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listDanhMuc = $this->modelDanhMuc->getAllCategory();

        if ($sanPham) {
            require_once './views/sanpham/editSanPham.php';
            if(function_exists('deleteSessionError')) deleteSessionError();
        } else {
            header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }

    public function postEditSanPham()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_id = $_POST['product_id'] ?? '';
        $sanPhamOld = $this->modelSanPham->getDetailSanPham($product_id);
        $old_file = $sanPhamOld['image'];

        // Lấy đầy đủ dữ liệu từ POST
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $discount_price = $_POST['discount_price'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $import_date = $_POST['import_date'] ?? '';
        $category_id = $_POST['category_id'] ?? '';
        $status = $_POST['status'] ?? '';
        $description = $_POST['description'] ?? '';

        $image = $_FILES['image'] ?? null;
        $errors = [];
        
        if (empty($name)) $errors['name'] = 'Tên sản phẩm không được để trống';
        if (empty($category_id)) $errors['category_id'] = 'Danh mục không được để trống';

        if (empty($errors)) {
            // Xử lý file ảnh đại diện
            if (isset($image) && $image['error'] == UPLOAD_ERR_OK) {
                $new_file = uploadFile($image, './uploads/');
                if (!empty($old_file)) deleteFile($old_file);
            } else {
                $new_file = $old_file;
            }

            // TRUYỀN ĐỦ 10 THAM SỐ VÀO MODEL
            $this->modelSanPham->updateSanPham(
                $product_id, 
                $name, 
                $price, 
                $discount_price, 
                $quantity, 
                $import_date, 
                $category_id, 
                $status, 
                $description, 
                $new_file
            );

            header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        } else {
            $_SESSION['error'] = $errors;
            $_SESSION['flash'] = true;
            header("Location:" . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $product_id);
            exit();
        }
    }
}

    public function postEditAnhSanPham()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = $_POST['product_id'] ?? '';
            $listAnhSanPhamCurrent = $this->modelSanPham->getListAnhSanPham($product_id);

            $img_array = $_FILES['img_array'];
            $img_delete = isset($_POST['img_delete']) ? explode(',', $_POST['img_delete']) : [];
            $current_img_ids = $_POST['current_img_ids'] ?? [];

            // Upload ảnh mới hoặc thay thế
            foreach ($img_array['name'] as $key => $value) {
                if ($img_array['error'][$key] == UPLOAD_ERR_OK) {
                    $new_file = uploadFileAlbum($img_array, './uploads/', $key);
                    if ($new_file) {
                        if (isset($current_img_ids[$key])) {
                            $old_img = $this->modelSanPham->getDetailAnhSanPham($current_img_ids[$key]);
                            deleteFile($old_img['image_url']);
                            $this->modelSanPham->updateAnhSanPham($current_img_ids[$key], $new_file);
                        } else {
                            $this->modelSanPham->insertAlbumAnhSanPham($product_id, $new_file);
                        }
                    }
                }
            }

            // Xóa ảnh theo danh sách img_delete
            foreach ($listAnhSanPhamCurrent as $anhSP) {
                if (in_array($anhSP['id'], $img_delete)) {
                    $this->modelSanPham->destroyAnhSanPham($anhSP['id']);
                    deleteFile($anhSP['image_url']);
                }
            }
            header("Location:" . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $product_id);
            exit();
        }
    }

    public function deleteSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

        if ($sanPham) {
            deleteFile($sanPham['image']);
            $this->modelSanPham->destroySanPham($id);
        }
        if ($listAnhSanPham) {
            foreach ($listAnhSanPham as $anhSP) {
                deleteFile($anhSP['image_url']);
                $this->modelSanPham->destroyAnhSanPham($anhSP['id']);
            }
        }

        header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
        exit();
    }
    public function chiTietSanPham() {
    // 1. Lấy ID từ URL
    $id = $_GET['id_san_pham'];

    // 2. Lấy dữ liệu từ Model
    $sanPham = $this->modelSanPham->getDetailSanPham($id);
    $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

    // 3. Kiểm tra nếu có sản phẩm thì render view, không thì quay về list
    if ($sanPham) {
        require_once './views/sanpham/detailSanPham.php';
    } else {
        header("Location: " . BASE_URL_ADMIN . "?act=san-pham");
        exit();
    }
}

}
?>