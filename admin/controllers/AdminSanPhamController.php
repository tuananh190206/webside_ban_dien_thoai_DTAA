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

                // Xử lý thêm biến thể (Màu sắc, Dung lượng)
                $v_colors = $_POST['variant_color'] ?? [];
                $v_capacities = $_POST['variant_capacity'] ?? [];
                $v_prices = $_POST['variant_price'] ?? [];
                $v_discount_prices = $_POST['variant_discount_price'] ?? [];
                $v_stocks = $_POST['variant_stock'] ?? [];
                $v_images = $_FILES['variant_image'] ?? null;

                if (!empty($v_colors)) {
                    foreach ($v_colors as $index => $color) {
                        $capacity = $v_capacities[$index] ?? '';
                        $v_price = !empty($v_prices[$index]) ? $v_prices[$index] : $price;
                        $v_discount = !empty($v_discount_prices[$index]) ? $v_discount_prices[$index] : null;
                        $v_stock = !empty($v_stocks[$index]) ? $v_stocks[$index] : 0;
                        
                        $v_image_path = $file_thumb; // Mặc định sử dụng ảnh sản phẩm chính
                        if (isset($v_images['name'][$index]) && $v_images['error'][$index] == 0) {
                            $file = [
                                'name' => $v_images['name'][$index],
                                'type' => $v_images['type'][$index],
                                'tmp_name' => $v_images['tmp_name'][$index],
                                'error' => $v_images['error'][$index],
                                'size' => $v_images['size'][$index]
                            ];
                            $upload_variant = uploadFile($file, './uploads/');
                            if ($upload_variant) {
                                $v_image_path = $upload_variant;
                            }
                        }

                        // Lưu vào CSDL
                        $this->modelSanPham->insertProductVariant($product_id, $capacity, $color, $v_price, $v_discount, $v_stock, $v_image_path);
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
        $listVariants = $this->modelSanPham->getProductVariants($id);

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
        // PHẢI LÀ 'id_san_pham' mới khớp với file editSanPham.php bạn gửi
        $product_id = $_POST['product_id'] ?? ''; 
        
        $sanPhamOld = $this->modelSanPham->getDetailSanPham($product_id);

        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $discount_price = $_POST['discount_price'] ?? 0;
        $quantity = $_POST['quantity'] ?? 0; // Số lượng Admin nhập
        $import_date = $_POST['import_date'] ?? '';
        $category_id = $_POST['category_id'] ?? '';
        $status = $_POST['status'] ?? 0;
        $description = $_POST['description'] ?? '';

        // Sửa lỗi Parse Error dấu == == ở dòng 113
        $image = $_FILES['image'] ?? null;
        if ($image && $image['error'] === 0) {
            $file_thumb = uploadFile($image, './uploads/');
            if (!empty($sanPhamOld['image'])) deleteFile($sanPhamOld['image']);
        } else {
            $file_thumb = $sanPhamOld['image'] ?? '';
        }

        if (!empty($product_id)) {
            // Gọi Model cập nhật
            $this->modelSanPham->updateSanPham(
                $product_id, $name, $price, $discount_price, 
                $quantity, $import_date, $category_id, 
                $status, $description, $file_thumb
            );
<<<<<<< ducdat

            // Xử lý biến thể (Phiên bản, màu sắc...)
            // 1. Xóa các biến thể đã bị người dùng nhấn xóa
            $deleted_variants_str = $_POST['deleted_variants'] ?? '';
            if (!empty($deleted_variants_str)) {
                $deleted_ids = explode(',', $deleted_variants_str);
                foreach ($deleted_ids as $did) {
                    if (!empty($did) && is_numeric($did)) {
                        $this->modelSanPham->destroyProductVariant($did);
                    }
                }
            }

            // 2. Thêm mới / Cập nhật biến thể
            $v_ids = $_POST['variant_id'] ?? [];
            $v_colors = $_POST['variant_color'] ?? [];
            $v_capacities = $_POST['variant_capacity'] ?? [];
            $v_prices = $_POST['variant_price'] ?? [];
            $v_discounts = $_POST['variant_discount_price'] ?? [];
            $v_stocks = $_POST['variant_stock'] ?? [];
            $v_old_images = $_POST['variant_old_image'] ?? [];
            $v_images = $_FILES['variant_image'] ?? null;

            foreach ($v_ids as $index => $v_id) {
                if (empty($v_colors[$index])) continue;
                
                $capacity = $v_capacities[$index] ?? '';
                $color = $v_colors[$index];
                $v_price = !empty($v_prices[$index]) ? $v_prices[$index] : $price;
                $v_discount = !empty($v_discounts[$index]) ? $v_discounts[$index] : null;
                $v_stock = !empty($v_stocks[$index]) ? $v_stocks[$index] : 0;
                $v_image_path = !empty($v_old_images[$index]) ? $v_old_images[$index] : $new_file;

                if (isset($v_images['name'][$index]) && $v_images['error'][$index] == 0) {
                    $file = [
                        'name' => $v_images['name'][$index],
                        'type' => $v_images['type'][$index],
                        'tmp_name' => $v_images['tmp_name'][$index],
                        'error' => $v_images['error'][$index],
                        'size' => $v_images['size'][$index]
                    ];
                    $upload_var = uploadFile($file, './uploads/');
                    if ($upload_var) {
                        $v_image_path = $upload_var;
                    }
                }

                if ($v_id === 'new') {
                    $this->modelSanPham->insertProductVariant($product_id, $capacity, $color, $v_price, $v_discount, $v_stock, $v_image_path);
                } else {
                    $this->modelSanPham->updateProductVariant($v_id, $capacity, $color, $v_price, $v_discount, $v_stock, $v_image_path);
                }
            }

            header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        } else {
            $_SESSION['error'] = $errors;
            $_SESSION['flash'] = true;
            header("Location:" . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $product_id);
            exit();
=======
>>>>>>> main
        }

        header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
        exit();
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
    $listVariants = $this->modelSanPham->getProductVariants($id);

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