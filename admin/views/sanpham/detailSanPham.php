<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chi tiết sản phẩm: <?= $sanPham['name'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; display: flex; justify-content: space-between; align-items: center; }
    .content-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 40px; padding: 40px; }
    .info-label { font-weight: 700; color: #4b5563; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 4px; }
    .info-value { font-size: 1.1rem; color: #111827; margin-bottom: 20px; border-bottom: 1px solid #f3f4f6; pb-2; }
    .album-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 20px; }
    .album-item { aspect-ratio: 1; border-radius: 8px; overflow: hidden; border: 2px solid #f3f4f6; transition: transform 0.2s; }
    .album-item:hover { transform: scale(1.05); border-color: #667eea; }
    .badge { padding: 6px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; }
    .status-active { background-color: #d1fae5; color: #065f46; }
    .status-inactive { background-color: #fee2e2; color: #991b1b; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <div>
        <h1 class="text-3xl font-bold"><?= $sanPham['name'] ?></h1>
        <p class="opacity-80">Mã sản phẩm: #PROD-<?= $sanPham['id'] ?></p>
      </div>
      <div class="flex gap-3">
        <a href="<?= BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $sanPham['id'] ?>" class="bg-white text-indigo-700 px-6 py-2 rounded-lg font-bold shadow-md hover:bg-gray-100 transition">Sửa thông tin</a>
        <a href="<?= BASE_URL_ADMIN . '?act=san-pham' ?>" class="bg-indigo-800 text-white px-6 py-2 rounded-lg font-bold shadow-md hover:bg-indigo-900 transition">Quay lại</a>
      </div>
    </div>

    <div class="content-grid">
      <div>
        <div class="mb-6">
            <p class="info-label">Ảnh đại diện</p>
            <img src="<?= BASE_URL . $sanPham['image'] ?>" class="w-full rounded-2xl shadow-lg border border-gray-100 object-cover" onerror="this.src='https://placehold.co/400x400?text=No+Image'">
        </div>

        <div class="bg-gray-50 p-6 rounded-2xl">
            <p class="info-label">Trạng thái kinh doanh</p>
            <div class="flex items-center gap-2 mb-4">
                <?php if($sanPham['status'] == 1): ?>
                    <span class="badge status-active">● ĐANG KINH DOANH</span>
                <?php else: ?>
                    <span class="badge status-inactive">● NGỪNG KINH DOANH</span>
                <?php endif; ?>
            </div>

            <p class="info-label">Danh mục sản phẩm</p>
            <p class="font-bold text-indigo-600"><?= $sanPham['ten_danh_muc'] ?></p>
        </div>
      </div>

      <div>
        <div class="grid grid-cols-2 gap-x-8">
            <div>
                <p class="info-label">Giá niêm yết</p>
                <p class="info-value line-through text-gray-400"><?= number_format($sanPham['price'], 0, ',', '.') ?> đ</p>
            </div>
            <div>
                <p class="info-label">Giá khuyến mãi</p>
                <p class="info-value text-red-600 font-extrabold text-2xl"><?= number_format($sanPham['discount_price'], 0, ',', '.') ?> đ</p>
            </div>
            <div>
                <p class="info-label">Số lượng trong kho</p>
                <p class="info-value"><?= $sanPham['quantity'] ?> sản phẩm</p>
            </div>
            <div>
                <p class="info-label">Ngày nhập kho</p>
                <p class="info-value"><?= date('d/m/Y', strtotime($sanPham['import_date'])) ?></p>
            </div>
        </div>

        <div class="mt-4">
            <p class="info-label">Mô tả sản phẩm</p>
            <div class="bg-gray-50 p-4 rounded-xl text-gray-600 text-sm leading-relaxed mb-8 italic">
                <?= nl2br($sanPham['description']) ?: 'Chưa có mô tả cho sản phẩm này.' ?>
            </div>
        </div>

        <div class="mt-8">
            <p class="info-label">Album ảnh chi tiết (<?= count($listAnhSanPham) ?>)</p>
            <div class="album-grid">
                <?php if(!empty($listAnhSanPham)): ?>
                    <?php foreach($listAnhSanPham as $anh): ?>
                        <div class="album-item">
                            <img src="<?= BASE_URL . $anh['image_url'] ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-400 text-sm italic">Sản phẩm này chưa có album ảnh.</p>
                <?php endif; ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>