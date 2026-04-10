<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý sản phẩm</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 1250px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
    .toolbar { padding: 20px 40px; background: #f8f9fa; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
    .btn-primary { padding: 10px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; font-weight: 600; }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f8f9fa; }
    th { padding: 15px 20px; text-align: left; color: #495057; text-transform: uppercase; font-size: 12px; }
    td { padding: 15px 20px; border-bottom: 1px solid #eee; font-size: 14px; }
    .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
    .badge-success { background: #e8f5e9; color: #2e7d32; }
    .badge-danger { background: #ffebee; color: #c62828; }
    .product-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h1 class="text-3xl font-bold">Quản Lý Sản Phẩm</h1>
      <p>Danh sách điện thoại đang kinh doanh trên hệ thống</p>
    </div>

    <div class="toolbar">
        <input type="text" placeholder="Tìm kiếm sản phẩm..." class="border p-2 rounded-lg w-1/3">
        <a href="<?= BASE_URL_ADMIN . '?act=form-them-san-pham' ?>">
            <button class="btn-primary">+ Thêm Sản Phẩm Mới</button>
        </a>
    </div>

    <div class="overflow-x-auto">
      <table>
        <thead>
          <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá bán</th>
            <th>Số lượng</th>
            <th>Danh mục</th>
            <th>Trạng thái</th>
            <th class="text-center">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listSanPham as $key => $sanPham): ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td>
              <img src="<?= BASE_URL . $sanPham['image'] ?>" class="product-img" onerror="this.src='https://placehold.co/60x60?text=No+Image'">
            </td>
            <td>
              <div class="font-bold"><?= $sanPham['name'] ?></div>
              <div class="text-xs text-gray-400">Ngày nhập: <?= date('d/m/Y', strtotime($sanPham['import_date'])) ?></div>
            </td>
            <td>
              <div class="text-red-600 font-bold"><?= number_format($sanPham['discount_price'] ?? $sanPham['price'], 0, ',', '.') ?>đ</div>
              <?php if($sanPham['discount_price']): ?>
                <strike class="text-xs text-gray-400"><?= number_format($sanPham['price'], 0, ',', '.') ?>đ</strike>
              <?php endif; ?>
            </td>
            <td><?= $sanPham['quantity'] ?></td>
            <td><span class="text-blue-600 font-medium"><?= $sanPham['ten_danh_muc'] ?></span></td>
            <td>
            <?php if ($sanPham['quantity'] <= 0): ?>
    <span class="badge badge-danger" style="background-color: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; border: 1px solid #f5c6cb;">Hết hàng</span>
  <?php elseif ($sanPham['status'] == 1): ?>
    <span class="badge badge-success" style="background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; border: 1px solid #c3e6cb;">Còn hàng</span>
  <?php else: ?>
    <span class="badge badge-secondary" style="background-color: #e2e3e5; color: #383d41; padding: 4px 8px; border-radius: 4px; border: 1px solid #d6d8db;">Dừng bán</span>
  <?php endif; ?>
            </td>
           <td>
  <div class="flex gap-2 justify-center">
    <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id'] ?>" 
       class="bg-green-100 text-green-700 px-3 py-1 rounded-md text-sm hover:bg-green-200 transition">
       Chi tiết
    </a>

    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $sanPham['id'] ?>" 
       class="bg-blue-100 text-blue-700 px-3 py-1 rounded-md text-sm hover:bg-blue-200 transition">
       Sửa
    </a>

    <a href="<?= BASE_URL_ADMIN . '?act=xoa-san-pham&id_san_pham=' . $sanPham['id'] ?>" 
       onclick="return confirm('Xóa sản phẩm này sẽ xóa cả album ảnh liên quan. Bạn chắc chứ?')"
       class="bg-red-100 text-red-700 px-3 py-1 rounded-md text-sm hover:bg-red-200 transition">
       Xóa
    </a>
  </div>
</td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>