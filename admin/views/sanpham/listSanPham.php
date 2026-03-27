
<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danh Sách Sản Phẩm</title>

  <style>
    body {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .container {
      width: 100%;
      margin: auto;
    }

    .admin-panel {
      max-width: 1200px;
      margin: 20px auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      overflow: hidden;
    }

    .header {
      background: linear-gradient(135deg, #667eea, #764ba2);
      padding: 30px;
      color: #fff;
    }

    .header h1 {
      margin: 0;
      font-size: 28px;
    }

    .toolbar {
      padding: 20px;
      background: #f8f9fa;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    .search-box input {
      padding: 10px;
      border: 2px solid #ddd;
      border-radius: 8px;
      width: 250px;
    }

    .btn-primary {
      padding: 10px 20px;
      background: #667eea;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead {
      background: #f1f1f1;
    }

    th, td {
      padding: 14px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    tr:hover {
      background: #f9f9f9;
    }

    .price {
      color: red;
      font-weight: bold;
    }

    .actions {
      display: flex;
      gap: 6px;
    }

    .btn-edit {
      background: #e3f2fd;
      border: none;
      padding: 6px 10px;
      cursor: pointer;
    }

    .btn-delete {
      background: #ffebee;
      border: none;
      padding: 6px 10px;
      cursor: pointer;
    }

  </style>
</head>

<body>

<div class="container">
  <div class="admin-panel">

    <!-- HEADER -->
    <div class="header">
      <h1>📱 Danh Sách Sản Phẩm</h1>
      <p>Quản lý sản phẩm điện thoại</p>
    </div>

    <!-- TOOLBAR -->
    <div class="toolbar">
      <div class="search-box">
        <input type="text" placeholder="Tìm kiếm sản phẩm...">
      </div>

      <a href="<?= BASE_URL_ADMIN . '?act=form-them-product' ?>">
        <button class="btn-primary">➕ Thêm sản phẩm</button>
      </a>
    </div>

    <!-- TABLE -->
    <table>
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên</th>
          <th>Danh mục</th>
          <th>Giá</th>
          <th>Số lượng</th>
          <th>Mô tả</th>
          <th>Ngày tạo</th>
          <th>Hành động</th>
        </tr>
      </thead>

      <tbody>
        <?php if (!empty($listSanPham)) : ?>
          <?php foreach ($listSanPham as $key => $sanpham): ?>
            <tr>
              <td><?= $key + 1 ?></td>

              <td><?= $sanpham['name'] ?></td>

              <td>
                <?= $sanpham['category_name'] ?? $sanpham['category_id'] ?>
              </td>

              <td class="price">
                <?= number_format($sanpham['price'], 0, ',', '.') ?> ₫
              </td>

              <td><?= $sanpham['quantity'] ?></td>

              <td><?= $sanpham['description'] ?></td>

              <td><?= $sanpham['created_at'] ?></td>

              <td>
                <div class="actions">
                  <a href="<?= BASE_URL_ADMIN . '?act=form-sua-san-pham&id=' . $sanpham['id'] ?>">
                    <button class="btn-edit">Sửa</button>
                  </a>

                  <a href="<?= BASE_URL_ADMIN . '?act=xoa-product&id=' . $sanpham['id'] ?>"
                     onclick="return confirm('Xóa sản phẩm này?')">
                    <button class="btn-delete">Xóa</button>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach ?>
        <?php else: ?>
          <tr>
            <td colspan="8" style="text-align:center;">Không có sản phẩm</td>
          </tr>
        <?php endif ?>
      </tbody>

    </table>

  </div>
</div>

</body>
</html>