<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cập nhật vai trò - DTAA Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 700px; margin: 60px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #8845f3 0%, #7b35e3 100%); padding: 30px 40px; color: white; }
    .form-group { margin-bottom: 20px; padding: 0 40px; }
    label { display: block; font-size: 12px; font-weight: bold; color: #a0aec0; text-transform: uppercase; margin-bottom: 8px; }
    input { width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; transition: all 0.3s; }
    input:focus { border-color: #7042da; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1); }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h1 class="text-2xl font-bold">Chỉnh Sửa Vai Trò</h1>
      <p class="text-sm opacity-80">Cập nhật tên chức vụ cho ID: #<?= $role['id'] ?></p>
    </div>

    <form action="?act=sua-vai-tro" method="POST" class="py-10">
      <input type="hidden" name="id" value="<?= $role['id'] ?>">

      <div class="form-group">
        <label>Tên vai trò / Chức vụ</label>
        <input type="text" name="name" value="<?= $role['name'] ?>" placeholder="Ví dụ: Quản lý, Nhân viên bán hàng..." required>
      </div>

      <div class="flex justify-end gap-4 px-10 mt-6">
        <a href="?act=vai-tro" class="px-6 py-3 font-bold text-gray-400 hover:text-gray-600 transition">HỦY BỎ</a>
        <button type="submit" class="px-10 py-3 bg-amber-500 text-white font-bold rounded-lg shadow-lg hover:bg-amber-600 transition uppercase text-sm">
          Xác nhận thay đổi
        </button>
      </div>
    </form>
  </div>
</body>
</html>