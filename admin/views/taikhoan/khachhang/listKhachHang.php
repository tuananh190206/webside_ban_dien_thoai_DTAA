<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý tài khoản khách hàng</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 1250px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
    .toolbar { padding: 20px 40px; background: #f8f9fa; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f8f9fa; }
    th { padding: 15px 20px; text-align: left; color: #495057; text-transform: uppercase; font-size: 12px; font-weight: 700; }
    td { padding: 15px 20px; border-bottom: 1px solid #eee; font-size: 14px; vertical-align: middle; }
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; display: inline-block; }
    .badge-success { background: #e8f5e9; color: #2e7d32; }
    .badge-danger { background: #ffebee; color: #c62828; }
    .user-avatar { width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h1 class="text-3xl font-bold">Quản Lý Khách Hàng</h1>
      <p>Danh sách tài khoản người dùng đăng ký trên hệ thống</p>
    </div>

    <div class="toolbar">
        <input type="text" placeholder="Tìm kiếm tên, email, số điện thoại..." class="border p-2 rounded-lg w-1/3 focus:outline-none focus:ring-2 focus:ring-purple-500">
        <div class="text-sm text-gray-500">
            Tổng cộng: <strong><?= count($listKhachHang) ?></strong> tài khoản
        </div>
    </div>

    <div class="overflow-x-auto">
      <table>
        <thead>
          <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Thông tin khách hàng</th>
            <th>Liên hệ</th>
            <th>Địa chỉ</th>
            <th>Trạng thái</th>
            <th class="text-center">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listKhachHang as $key => $khachHang): ?>
          <tr>
            <td class="font-medium text-gray-400"><?= $key + 1 ?></td>
            <td>
              <img src="<?= !empty($khachHang['avatar']) ? BASE_URL . $khachHang['avatar'] : 'https://placehold.co/100x100?text=User' ?>" 
                   class="user-avatar" 
                   onerror="this.src='https://placehold.co/100x100?text=User'">
            </td>
            <td>
              <div class="font-bold text-gray-800"><?= $khachHang['full_name'] ?></div>
              <div class="text-xs text-gray-400">Ngày tạo: <?= date('d/m/Y', strtotime($khachHang['created_at'])) ?></div>
            </td>
            <td>
              <div class="text-sm"><i class="fa-regular fa-envelope mr-1 text-gray-400"></i> <?= $khachHang['email'] ?></div>
              <div class="text-sm font-medium text-purple-700"><i class="fa-solid fa-phone mr-1 text-gray-300"></i> <?= $khachHang['phone'] ?></div>
            </td>
            <td class="max-w-[200px] truncate text-gray-600"><?= $khachHang['address'] ?></td>
            <td>
              <?php if($khachHang['status'] == 1): ?>
                <span class="badge badge-success"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Hoạt động</span>
              <?php else: ?>
                <span class="badge badge-danger"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Bị khóa</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="flex gap-2 justify-center">
                <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $khachHang['id'] ?>" 
                   class="bg-green-100 text-green-700 px-3 py-1.5 rounded-md text-sm hover:bg-green-200 transition font-medium">
                   <i class="fa-solid fa-eye"></i> Chi tiết
                </a>

                <a href="<?= BASE_URL_ADMIN . '?act=form-sua-khach-hang&id_khach_hang=' . $khachHang['id'] ?>" 
                   class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-md text-sm hover:bg-blue-200 transition font-medium">
                   <i class="fa-solid fa-pen-to-square"></i> Sửa
                </a>

                <a href="<?= BASE_URL_ADMIN . '?act=reset-password&id_khach_hang=' . $khachHang['id'] ?>" 
                   onclick="return confirm('Bạn có chắc muốn reset mật khẩu cho tài khoản này?')"
                   class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-md text-sm hover:bg-gray-200 transition font-medium">
                   <i class="fa-solid fa-key"></i> Reset
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