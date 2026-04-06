<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sửa danh mục</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .admin-panel {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      overflow: hidden;
    }

    .header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 32px 40px;
      color: #ffffff;
    }

    .form-container {
      padding: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: 600;
      display: block;
      margin-bottom: 8px;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      border-color: #667eea;
      outline: none;
    }

    .form-actions {
      margin-top: 20px;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    .btn-primary {
      padding: 10px 20px;
      background: #7a2aea;
      color: white;
      border: none;
      border-radius: 6px;
    }

    .btn-secondary {
      padding: 10px 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background: white;
    }

    .error {
      color: red;
      font-size: 13px;
    }
  </style>
</head>

<body>

  <div class="admin-panel">

    <!-- HEADER -->
    <div class="header">
      <h2 class="text-2xl font-bold">Sửa danh mục</h2>
      <p>Cập nhật thông tin danh mục điện thoại</p>
    </div>

    <!-- FORM -->
    <div class="form-container">
    <form action="<?= BASE_URL_ADMIN . '?act=sua-category&id_category=' . $category['id'] ?>" method="POST">
  
  <input type="hidden" name="id" value="<?= $category['id'] ?>">

        <!-- TÊN -->
        <div class="form-group">
          <label>Tên danh mục *</label>
          <input type="text" name="name"
            value="<?= $category['name'] ?>"
            required>

          <?php if (isset($errors['name'])): ?>
            <div class="error"><?= $errors['name'] ?></div>
          <?php endif; ?>
        </div>
<label>Số lượng</label>
<input type="number" name="quantity" value="<?= $sanPham['quantity'] ?>">

<label>Ngày nhập</label>
<input type="date" name="import_date" value="<?= $sanPham['import_date'] ?>">

<label>Trạng thái</label>
<select name="status">
    <option value="1" <?= $sanPham['status'] == 1 ? 'selected' : '' ?>>Hiển thị</option>
    <option value="2" <?= $sanPham['status'] == 2 ? 'selected' : '' ?>>Ẩn</option>
</select>
        <!-- MÔ TẢ -->
        <div class="form-group">
          <label>Mô tả</label>
          <textarea name="description" rows="5"><?= $category['description'] ?></textarea>
        </div>

        <!-- BUTTON -->
        <div class="form-actions">
          <a href="<?= BASE_URL_ADMIN . '?act=category' ?>">
            <button type="button" class="btn-secondary">Hủy</button>
          </a>

          <button type="submit" class="btn-primary">
            Cập nhật
          </button>
        </div>

      </form>
    </div>

  </div>

</body>
</html>