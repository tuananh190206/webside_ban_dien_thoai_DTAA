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
    // xoa session sau khi load trang

    public function postAddSanPham()
    {
        //ham nay dung de xu ly them du lieu
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $status = $_POST['status'] ?? '';
            $description = $_POST['description'] ?? '';


            // $hinh_anh = $_FILES['hinh_anh'] ?? null;

            // luu hinh anh vao
            // $file_thumb = uploadFile($hinh_anh, './uploads/');

            // $img_array = $_FILES['img_array'];
            $errors = [];
            if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
            }
            if (empty($price)) {
                $errors['price'] = 'Giá sản phẩm không được để trống';
            }
            if (empty($quantity)) {
                $errors['quantity'] = 'Số lượng không được để trống';
            }
            if (empty($category_id)) {
                $errors['category_id'] = 'Tên danh mục không được để trống';
            }
            if (empty($status)) {
                $errors['status'] = 'Trạng thái không được để trống';
            }
            // if ($hinh_anh['error'] !== 0) {
            //     $errors['hinh_anh'] = 'Phải chọn ảnh sản phẩm';
            // }
            $_SESSION['error'] = $errors;


            if (empty($errors)) {
                $product_id = $this->modelSanPham->insertSanPham($name, $price, $quantity, $category_id, $status, $description);

                // xu ly them album anh san pham
                // if (!empty($img_array['name'])) {
                //     foreach ($img_array['name'] as $key => $value) {
                //         $file = [
                //             'name' => $img_array['name'][$key],
                //             'type' => $img_array['type'][$key],
                //             'tmp_name' => $img_array['tmp_name'][$key],
                //             'error' => $img_array['error'][$key],
                //             'size' => $img_array['size'][$key]
                //         ];

                //         $link_hinh_anh = uploadFile($file, './uploads/');
                //         $this->modelSanPham->insertAlbumAnhSanPham($product_id, $link_hinh_anh);
                //     }
                // }

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
        // Hàm này dùng để hiển thị form sửa
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
        //ham nay dung de xu ly them du lieu
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';
            // truy van
            $sanPhamOld = $this->modelSanPham->getDetailSanPham($id);
            $old_file = $sanPhamOld['hinh_anh'];

            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $status = $_POST['status'] ?? '';
            $description = $_POST['description'] ?? '';


            // $hinh_anh = $_FILES['hinh_anh'] ?? null;

            $errors = [];
            if (empty($name)) {
                $errors['name'] = 'Tên sản phẩm không được để trống';
            }
            if (empty($price)) {
                $errors['price'] = 'Giá sản phẩm không được để trống';
            }
            if (empty($quantity)) {
                $errors['quantity'] = 'Số lượng không được để trống';
            }
            if (empty($category_id)) {
                $errors['category_id'] = 'Tên danh mục không được để trống';
            }
            if (empty($status)) {
                $errors['status'] = 'Trạng thái không được để trống';
            }

            $_SESSION['error'] = $errors;
            // //logic sua anh
            // if (isset($hinh_anh) && $hinh_anh['error'] == UPLOAD_ERR_OK) {
            //     //upload file  anh mơi len
            //     $new_file = uploadFile($hinh_anh, './uploads/');
            //     if (!empty($old_file)) { //nếu có ảnh thì xóa đi
            //         deleteFile($old_file);
            //     }
            // } else {
            //     $new_file = $old_file;

            // }

            if (empty($errors)) {
                $id = $this->modelSanPham->updateSanPham($id, $name, $price, $quantity, $category_id, $status, $description);

                // xu ly them album anh san pham


                header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                $_SESSION['flash'] = true;
                header("Location:" . BASE_URL_ADMIN . '?act=form-sua-san-pham&id=' . $id);
                exit();
            }
        }
    }

    //sửa album ảnh
    // -sửa ảnh cũ
    // +Thêm ảnh mới
    // +Không thêm ảnh mới
    // -không sửa ảnh cũ
    //  +Thêm ảnh mới
    // +Không thêm ảnh mới
    // -Xóa ảnh cũ
    //  +Thêm ảnh mới
    // +Không thêm ảnh mới

    // public function postEditAnhSanPham()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $san_pham_id = $_POST['san_pham_id'] ?? '';

    //         //lấy danh sách ảnh hiện tại của sp
    //         $listAnhSanPhamCurrent = $this->modelSanPham->getListAnhSanPham($san_pham_id);

    //         //xử lí các ảnh được gợi từ form
    //         $img_array = $_FILES['img_array'];
    //         $img_delete = isset($_POST['img_delete']) ? explode(',', $_POST['img_delete']) : [];
    //         $current_img_ids = $_POST['current_img_ids'] ?? [];

    //         // Khai bảo mảng để lưu ảnh thêm mới hoặc thay thế

    //         $upload_file = [];
    //         // upload ảnh mới hoặc thay thế ảnh cũ
    //         foreach ($img_array['name'] as $key => $value) {
    //             if ($img_array['error'][$key] == UPLOAD_ERR_OK) {
    //                 $new_file = uploadFileAlbum($img_array, './uploads/', $key);
    //                 if ($new_file) {
    //                     $upload_file[] = [
    //                         'id' => $current_img_ids[$key] ?? null,
    //                         'file' => $new_file
    //                     ];
    //                 }
    //             }
    //         }

    //         // lưu ảnh mới vào db và xóa ảnh cũ
    //         foreach ($upload_file as $file_info) {
    //             if ($file_info['id']) {
    //                 $old_file = $this->modelSanPham->getDetailAnhSanPham($file_info['id'])['link_hinh_anh'];
    //                 // cập nhật ảnh cũ
    //                 $this->modelSanPham->updateAnhSanPham($file_info['id'], $file_info['file']);

    //                 // xóa ảnh cũ
    //                 deleteFile($old_file);
    //             } else {
    //                 // thêm ảnh mới
    //                 $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $file_info['file']);
    //             }
    //         }

    //         // xử lý xóa ảnh
    //         foreach ($listAnhSanPhamCurrent as $anhSP) {
    //             $anh_id = $anhSP['id'];
    //             if (in_array($anh_id, $img_delete)) {
    //                 //xóa ảnh
    //                 $this->modelSanPham->destroyAnhSanPham($anh_id);
    //                 //Xóa file
    //                 deleteFile($anhSP['link_hinh_anh']);
    //             }
    //         }
    //         header("Location:" . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $san_pham_id);
    //         exit();
    //     }
    // }

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
    public function deleteSanPham(){
        $id = $_GET['id'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);

        if($sanPham){
             deleteFile($sanPham['hinh_anh']);
            $this->modelSanPham->destroySanPham($id);
        }
        // if($listAnhSanPham){
        //     foreach($listAnhSanPham as $key=>$anhSP){
        //         deleteFile($anhSP['link_hinh_anh']);
        //         $this->modelSanPham->destroyAnhSanPham($anhSP['id']);
        //     }
        // }

        header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
        exit();
    }

    public function updateTrangThaiBinhLuan(){
        $id_binh_luan = $_POST['id_binh_luan'];
        $name_view = $_POST['name_view'];
        $id_khach_hang = $_POST['id_khach_hang'];
        $binhLuan = $this->modelSanPham->getDetailBinhLuan($id_binh_luan);

        if($binhLuan){
            $trang_thai_update = '';
            if($binhLuan['trang_thai']== 1){
                $trang_thai_update = 2;
            }else{
                $trang_thai_update = 1;
            }
           $status = $this->modelSanPham->updateTrangThaiBinhLuan($id_binh_luan, $trang_thai_update);
           if($status){
            if($name_view == 'detail_khach'){
                header("Location: " . BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $id_khach_hang);
            }
           }
            
        }
    }

}

?>
