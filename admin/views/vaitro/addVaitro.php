<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thêm vai trò mới - DTAA Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 700px; margin: 60px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
    .form-group { margin-bottom: 20px; padding: 0 40px; }
    label { display: block; font-size: 12px; font-weight: bold; color: #a0aec0; text-transform: uppercase; margin-bottom: 8px; }
    input { width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; transition: all 0.3s; }
    input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h1 class="text-2xl font-bold">Thêm Vai Trò Mới</h1>
      <p class="text-sm opacity-80">Tạo chức vụ mới để phân quyền người dùng</p>
    </div>

    <form action="?act=them-vai-tro" method="POST" class="py-10">
      <div class="form-group">
        <label>Tên vai trò / Chức vụ</label>
        <input type="text" name="name" placeholder="Ví dụ: Quản trị viên, Nhân viên..." required>
      </div>

      <div class="flex justify-end gap-4 px-10 mt-6">
        <a href="?act=vai-tro" class="px-6 py-3 font-bold text-gray-400 hover:text-gray-600 transition">HỦY BỎ</a>
        <button type="submit" class="px-10 py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 transition uppercase text-sm">
          Lưu vai trò
        </button>
      </div>
    </form>
  </div>
</body>
</html>