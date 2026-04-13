<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm sản phẩm</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-family: sans-serif; }
    .admin-panel { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; color: white; }
    .form-container { padding: 30px; }
    label { font-weight: 600; display: block; margin-bottom: 5px; color: #444; }
    input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; }
    .grid-cols-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h2 class="text-2xl font-bold">Thêm Sản Phẩm Điện Thoại</h2>
      <p>Thông tin sản phẩm và Album ảnh đi kèm</p>
    </div>

    <div class="form-container">
      <form action="<?= BASE_URL_ADMIN . '?act=them-san-pham' ?>" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
          <label>Tên sản phẩm *</label>
          <input type="text" name="name" placeholder="VD: iPhone 15 Pro Max" required>
        </div>

        <div class="grid-cols-2">
            <div>
                <label>Giá gốc (VNĐ) *</label>
                <input type="number" name="price" required>
            </div>
            <div>
                <label>Giá khuyến mãi (VNĐ)</label>
                <input type="number" name="discount_price">
            </div>
        </div>

        <div class="grid-cols-2">
            <div>
                <label>Số lượng kho *</label>
                <input type="number" name="quantity" required>
            </div>
            <div>
                <label>Ngày nhập hàng *</label>
                <input type="date" name="import_date" required>
            </div>
        </div>

        <div class="grid-cols-2">
            <div>
                <label>Danh mục sản phẩm *</label>
                <select name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach($listDanhMuc as $dm): ?>
                        <option value="<?= $dm['id'] ?>"><?= $dm['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Trạng thái</label>
                <select name="status">
                    <option value="1">Còn hàng</option>
                    <option value="0">Hết hàng / Dừng bán</option>
                </select>
            </div>
        </div>

        <div class="grid-cols-2">
            <div>
                <label>Ảnh đại diện (Thumbnail) *</label>
                <input type="file" name="image" required>
            </div>
            <div>
                <label>Album ảnh (Chọn nhiều ảnh)</label>
                <input type="file" name="img_array[]" multiple>
            </div>
        </div>

        <label>Mô tả chi tiết</label>
        <textarea name="description" rows="4" placeholder="Thông số kỹ thuật, cấu hình..."></textarea>

        <!-- Phần thêm biến thể (Màu sắc, Dung lượng) -->
        <h3 class="text-lg font-bold text-indigo-600 mt-6 mb-3 uppercase tracking-wide border-b pb-2">Các phiên bản (Màu sắc & Dung lượng)</h3>
        <p class="text-sm text-gray-500 mb-4">Các phiên bản của điện thoại (VD: iPhone 15 Pro Max 256GB - Đen Titan). Có thể để trống nếu không có chia phiên bản.</p>
        
        <div id="variants-container">
            <!-- Container chứa các biến thể -->
        </div>

        <button type="button" onclick="addVariant()" class="mt-2 px-4 py-2 border-2 border-indigo-500 text-indigo-600 rounded-lg hover:bg-indigo-50 font-semibold mb-6 flex items-center gap-2 transition-colors">
            + Thêm cấu hình / màu sắc
        </button>

        <div class="flex justify-end gap-3 mt-5">
          <a href="<?= BASE_URL_ADMIN . '?act=san-pham' ?>" class="px-6 py-2 border rounded-lg hover:bg-gray-100">Hủy</a>
          <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-bold">Thêm sản phẩm</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function addVariant() {
        const container = document.getElementById('variants-container');
        const itemHtml = `
        <div class="variant-item bg-gray-50 border border-gray-200 p-4 rounded-xl mb-4 relative shadow-sm">
            <button type="button" class="absolute top-3 right-3 text-red-500 font-bold hover:text-red-700 hover:bg-red-50 p-1 rounded transition-colors text-sm" onclick="this.closest('.variant-item').remove()">
                ✕ Xóa bản này
            </button>
            <div class="grid-cols-2">
                <div>
                    <label>Màu sắc *</label>
                    <input type="text" name="variant_color[]" placeholder="VD: Đen Titan" required>
                </div>
                <div>
                    <label>Dung lượng *</label>
                    <input type="text" name="variant_capacity[]" placeholder="VD: 256GB" required>
                </div>
            </div>
            <div class="grid-cols-2">
                <div>
                    <label>Giá bán (VNĐ) *</label>
                    <input type="number" name="variant_price[]" placeholder="Giá riêng cho bản này" required>
                </div>
                <div>
                    <label>Giá khuyến mãi (VNĐ)</label>
                    <input type="number" name="variant_discount_price[]">
                </div>
            </div>
            <div class="grid-cols-2">
                <div>
                    <label>Số lượng kho *</label>
                    <input type="number" name="variant_stock[]" value="0" required>
                </div>
                <div>
                    <label>Ảnh đại diện (Riêng cho màu này)</label>
                    <input type="file" name="variant_image[]" accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Để trống hệ thống sẽ dùng ảnh chính của sản phẩm</p>
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', itemHtml);
    }
  </script>
</body>
</html>