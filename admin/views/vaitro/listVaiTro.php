<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách phân quyền - DTAA Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 1000px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
    th { background: #f8f9fa; color: #666; font-size: 11px; text-transform: uppercase; padding: 15px 20px; border-bottom: 2px solid #eee; }
    td { padding: 15px 20px; border-bottom: 1px solid #eee; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold">Phân Quyền Chức Vụ</h1>
        <p class="text-sm opacity-80">Danh sách tài khoản và vai trò tương ứng</p>
      </div>
      <a href="?act=form-them-vai-tro" class="bg-white text-indigo-600 px-5 py-2 rounded-lg font-bold shadow-md hover:bg-gray-100 transition text-sm">QUẢN LÝ VAI TRÒ</a>
    </div>

    <div class="p-6">
      <table class="w-full text-left">
        <thead>
          <tr>
            <th>ID Người dùng</th>
            <th>Họ và Tên</th>
            <th>Chức vụ hiện tại</th>
            <th class="text-center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listRoles as $item): ?>
          <tr class="hover:bg-gray-50 transition">
            <td class="text-gray-400 font-mono">#<?= $item['user_id'] ?></td>
            <td class="font-bold text-gray-700"><?= $item['full_name'] ?></td>
            <td>
              <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold uppercase">
                <?= $item['ten_vai_tro'] ?>
              </span>
            </td>
            <td class="text-center">
              <div class="flex justify-center gap-4">
                <a href="?act=form-sua-vai-tro&id_vai_tro=<?= $item['role_id'] ?>" class="text-blue-500 hover:underline font-bold text-sm">Cấu hình vai trò</a>
                <a href="?act=xoa-vai-tro&id_vai_tro=<?= $item['role_id'] ?>" onclick="return confirm('Xác nhận xóa vai trò này?')" class="text-red-500 hover:underline font-bold text-sm">Xóa</a>
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