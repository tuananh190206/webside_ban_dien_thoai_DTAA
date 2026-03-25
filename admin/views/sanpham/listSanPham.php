<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Quản lý sản phẩm</title>
</head>

<body>
  <div class="container">
    <div class="admin-panel">

      <!-- HEADER -->
      <header class="header">
        <h1>Danh Sách Sản Phẩm</h1>
        <p>Quản lý sản phẩm trên website</p>
      </header>

      <!-- TOOLBAR -->
      <div class="toolbar">
        <div class="search-box">
          <input type="text" placeholder="Tìm kiếm sản phẩm...">
        </div>

        <a href="<?= BASE_URL_ADMIN . '?act=form-them-product' ?>">
          <button class="btn-primary">➕ Thêm Sản Phẩm</button>
        </a>
      </div>

      <!-- TABLE -->
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên Sản Phẩm</th>
              <th>Giá</th>
              <th>Số Lượng</th>
              <th>Mô Tả</th>
              <th>Danh Mục</th>
              <th>Ngày Tạo</th>
              <th>Thao Tác</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($listSanPham as $key => $sanpham): ?>
              <tr>
                <td><?= $key + 1 ?></td>

                <td>
                  <div class="category-name">
                    <?= $sanpham['name'] ?>
                  </div>
                </td>

                <td>
                  <?= number_format($sanpham['price']) ?> đ
                </td>

                <td>
                  <?= $sanpham['quantity'] ?>
                </td>

                <td>
                  <div class="category-description">
                    <?= $sanpham['description'] ?>
                  </div>
                </td>

                <td>
                  <?= $sanpham['category_name'] ?>
                </td>

                <td>
                  <?= $sanpham['created_at'] ?>
                </td>

                <td>
                  <div class="actions">
                    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-product&id_product=' . $sanpham['id'] ?>">
                      <button class="btn-edit">Sửa</button>
                    </a>

                    <a href="<?= BASE_URL_ADMIN . '?act=xoa-product&id_product=' . $sanpham['id'] ?>"
                      onclick="return confirm('Bạn có chắc muốn xóa không?')">
                      <button class="btn-delete">Xóa</button>
                    </a>
                  </div>
                </td>

              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</body>
</html>