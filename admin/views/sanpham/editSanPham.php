<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa sản phẩm | Quản trị</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .admin-panel { max-width: 1100px; margin: 30px auto; background: #fff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; }
    .header { background: linear-gradient(135deg, rgb(40, 115, 235) 0%, #2f7ce7 100%); padding: 25px; color: white; }
    .content-wrapper { display: grid; grid-template-columns: 1.5fr 1fr; gap: 1px; background: #e2e8f0; }
    .form-section, .album-section { background: #fff; padding: 30px; }
    label { font-weight: 600; display: block; margin-top: 15px; color: #3d80ec; font-size: 0.9rem; }
    input, select, textarea { 
        width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; margin-top: 5px;
        transition: border-color 0.2s;
    }
    input:focus { border-color: #6366f1; outline: none; }
    .btn-update { 
        background: #4f46e5; color: white; padding: 12px; border-radius: 8px; 
        font-weight: bold; width: 100%; margin-top: 25px; cursor: pointer;
        transition: background 0.2s;
    }
    .btn-update:hover { background: #4338ca; }
    .album-img-card { 
        border: 1px solid #f1f5f9; padding: 10px; border-radius: 10px; 
        background: #f8fafc; position: relative; margin-bottom: 12px; 
    }
    .error-text { color: #ef4444; font-size: 0.8rem; margin-top: 4px; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h2 class="text-2xl font-bold">Cập Nhật Sản Phẩm</h2>
      <p class="opacity-80">Đang chỉnh sửa: <span class="font-semibold"><?= $sanPham['name'] ?></span> (Mã: #<?= $sanPham['id'] ?>)</p>
    </div>

    <div class="content-wrapper">
      <div class="form-section">
        <h3 class="font-bold border-b pb-2 mb-4 text-indigo-600 uppercase text-sm tracking-wider">Thông tin cơ bản</h3>
        <form action="<?= BASE_URL_ADMIN . '?act=sua-san-pham' ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="product_id" value="<?= $sanPham['id'] ?>">
          
          <label>Tên sản phẩm</label>
          <input type="text" name="name" value="<?= $sanPham['name'] ?>" placeholder="Nhập tên sản phẩm...">
          <?php if(isset($_SESSION['error']['name'])): ?>
            <p class="error-text"><?= $_SESSION['error']['name'] ?></p>
          <?php endif; ?>

          <div class="grid grid-cols-2 gap-4">
              <div>
                <label>Giá gốc (VNĐ)</label>
                <input type="number" name="price" value="<?= $sanPham['price'] ?>">
              </div>
              <div>
                <label>Giá khuyến mãi</label>
                <input type="number" name="discount_price" value="<?= $sanPham['discount_price'] ?>">
              </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
              <div>
                <label>Số lượng</label>
                <input type="number" name="quantity" value="<?= $sanPham['quantity'] ?>">
              </div>
              <div>
                <label>Ngày nhập</label>
                <input type="date" name="import_date" value="<?= $sanPham['import_date'] ?>">
              </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
              <div>
                <label>Danh mục</label>
                <select name="category_id">
                    <?php foreach($listDanhMuc as $dm): ?>
                        <option value="<?= $dm['id'] ?>" <?= $dm['id'] == $sanPham['category_id'] ? 'selected' : '' ?>>
                            <?= $dm['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
              </div>
              <div>
                <label>Trạng thái</label>
                <select name="status">
                    <option value="1" <?= $sanPham['status'] == 1 ? 'selected' : '' ?>>Đang bán</option>
                    <option value="2" <?= $sanPham['status'] == 2 ? 'selected' : '' ?>>Dừng bán</option>
                </select>
              </div>
          </div>

          <label>Ảnh đại diện sản phẩm</label>
          <div class="flex items-center gap-4 mt-2">
            <img src="<?= BASE_URL . $sanPham['image'] ?>" class="w-24 h-24 object-cover rounded-lg border shadow-sm">
            <div class="flex-1">
                <input type="file" name="image" class="text-sm">
                <p class="text-gray-400 text-xs mt-1">Chọn ảnh mới nếu muốn thay đổi</p>
            </div>
          </div>

          <label>Mô tả sản phẩm</label>
          <textarea name="description" rows="4" placeholder="Nhập mô tả chi tiết..."><?= $sanPham['description'] ?></textarea>
          
          <!-- Phần quản lý biến thể -->
          <h3 class="font-bold border-b pb-2 mb-4 mt-8 text-indigo-600 uppercase text-sm tracking-wider">Quản lý Phiên bản (Màu sắc & Dung lượng)</h3>
          <input type="hidden" name="deleted_variants" id="deleted_variants" value="">
          
          <div id="variants-container">
            <?php foreach($listVariants as $v): ?>
            <div class="variant-item bg-gray-50 border border-gray-200 p-4 rounded-xl mb-4 relative shadow-sm" id="variant-<?= $v['id'] ?>">
                <input type="hidden" name="variant_id[]" value="<?= $v['id'] ?>">
                <input type="hidden" name="variant_old_image[]" value="<?= $v['image'] ?>">
                <button type="button" class="absolute top-3 right-3 text-red-500 font-bold hover:text-red-700 hover:bg-red-50 p-1 rounded transition-colors text-sm" onclick="removeVariantUI(this, <?= $v['id'] ?>)">
                    ✕ Xóa bản này
                </button>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div>
                        <label>Màu sắc *</label>
                        <input type="text" name="variant_color[]" value="<?= $v['color'] ?>" required>
                    </div>
                    <div>
                        <label>Dung lượng *</label>
                        <input type="text" name="variant_capacity[]" value="<?= $v['capacity'] ?>" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div>
                        <label>Giá bán (VNĐ) *</label>
                        <input type="number" name="variant_price[]" value="<?= $v['price'] ?>" required>
                    </div>
                    <div>
                        <label>Giá khuyến mãi (VNĐ)</label>
                        <input type="number" name="variant_discount_price[]" value="<?= $v['discount_price'] ?>">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <div>
                        <label>Số lượng kho *</label>
                        <input type="number" name="variant_stock[]" value="<?= $v['stock'] ?>" required>
                    </div>
                    <div>
                        <label>Ảnh đại diện (Riêng cho màu này)</label>
                        <div class="flex items-center gap-2 mt-1">
                            <?php if(!empty($v['image'])): ?>
                                <img src="<?= BASE_URL . $v['image'] ?>" class="w-10 h-10 object-cover border rounded">
                            <?php endif; ?>
                            <input type="file" name="variant_image[]" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
          </div>

          <button type="button" onclick="addVariantUI()" class="mt-2 px-4 py-2 border-2 border-indigo-500 text-indigo-600 rounded-lg hover:bg-indigo-50 font-semibold mb-6 flex items-center gap-2 transition-colors">
              + Thêm phiên bản mới
          </button>

          <button type="submit" class="btn-update">LƯU CẬP NHẬT (Kèm biến thể)</button>
        </form>
      </div>

      <div class="album-section">
        <h3 class="font-bold border-b pb-2 mb-4 text-indigo-600 uppercase text-sm tracking-wider">Album ảnh phụ</h3>
        <form action="<?= BASE_URL_ADMIN . '?act=sua-anh-san-pham' ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= $sanPham['id'] ?>">
            <input type="hidden" name="img_delete" id="img_delete" value="">
            
            <div id="album-container">
                <?php foreach($listAnhSanPham as $anh): ?>
                    <div class="album-img-card flex items-center gap-3" id="anh-phu-<?= $anh['id'] ?>">
                        <img src="<?= BASE_URL . $anh['image_url'] ?>" class="w-16 h-16 object-cover rounded-md">
                        <div class="flex-1">
                            <input type="hidden" name="current_img_ids[]" value="<?= $anh['id'] ?>">
                            <input type="file" name="img_array[]" class="text-xs">
                        </div>
                        <button type="button" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-2 py-1 rounded transition-all" 
                                onclick="removeOldImage(<?= $anh['id'] ?>)">
                            ✕
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-4 p-3 border-2 border-dashed border-gray-200 rounded-lg text-center">
                <p class="text-xs text-gray-500 mb-2">Thêm ảnh mới vào album</p>
                <input type="file" name="img_array[]" multiple class="text-xs block w-full">
            </div>

            <button type="submit" class="btn-update bg-slate-800 hover:bg-slate-900">CẬP NHẬT ALBUM ẢNH</button>
            
            <a href="<?= BASE_URL_ADMIN . '?act=san-pham' ?>" class="block text-center mt-6 text-indigo-600 font-medium hover:underline text-sm">
                ← Quay lại danh sách sản phẩm
            </a>
        </form>
      </div>
    </div>
  </div>

  <script>
    /**
     * Xử lý xóa ảnh cũ: Lưu ID vào input ẩn và xóa trên UI
     */
    function removeOldImage(id) {
        if(confirm('Bạn có chắc chắn muốn xóa ảnh này khỏi album?')) {
            // Lấy giá trị hiện tại của input ẩn
            const inputDelete = document.getElementById('img_delete');
            let deleteIds = inputDelete.value ? inputDelete.value.split(',') : [];
            
            // Thêm ID mới vào mảng xóa
            deleteIds.push(id);
            inputDelete.value = deleteIds.join(',');
            
            // Xóa phần tử trên giao diện
            const element = document.getElementById('anh-phu-' + id);
            if(element) element.remove();
        }
    }

    function removeVariantUI(btn, id) {
        if(confirm('Chắc chắn xóa phiên bản này? (sẽ xóa thật khi bấm Lưu)')) {
            if (id !== 'new') {
                const deletedInput = document.getElementById('deleted_variants');
                let dIds = deletedInput.value ? deletedInput.value.split(',') : [];
                dIds.push(id);
                deletedInput.value = dIds.join(',');
            }
            btn.closest('.variant-item').remove();
        }
    }

    function addVariantUI() {
        const container = document.getElementById('variants-container');
        const itemHtml = `
        <div class="variant-item bg-gray-50 border border-gray-200 p-4 rounded-xl mb-4 relative shadow-sm">
            <input type="hidden" name="variant_id[]" value="new">
            <input type="hidden" name="variant_old_image[]" value="">
            <button type="button" class="absolute top-3 right-3 text-red-500 font-bold hover:text-red-700 hover:bg-red-50 p-1 rounded transition-colors text-sm" onclick="removeVariantUI(this, 'new')">
                ✕ Xóa bản này
            </button>
            <div class="grid grid-cols-2 gap-4 mt-2">
                <div><label>Màu sắc *</label><input type="text" name="variant_color[]" required></div>
                <div><label>Dung lượng *</label><input type="text" name="variant_capacity[]" required></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-2">
                <div><label>Giá bán (VNĐ) *</label><input type="number" name="variant_price[]" required></div>
                <div><label>Giá khuyến mãi</label><input type="number" name="variant_discount_price[]"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-2">
                <div><label>Số lượng kho *</label><input type="number" name="variant_stock[]" value="0" required></div>
                <div><label>Ảnh đại diện (Riêng cho màu này)</label><input type="file" name="variant_image[]" accept="image/*"></div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', itemHtml);
    }
  </script>
</body>
</html>