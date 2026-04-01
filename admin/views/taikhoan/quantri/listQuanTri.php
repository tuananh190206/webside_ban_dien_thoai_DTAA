<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý tài khoản quản trị</title>
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
    .user-avatar { width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h1 class="text-3xl font-bold">Quản Lý Tài Khoản Quản Trị</h1>
      <p>Danh sách nhân viên có quyền truy cập hệ thống quản trị</p>
    </div>

    <div class="toolbar">
        <input type="text" placeholder="Tìm kiếm tài khoản..." class="border p-2 rounded-lg w-1/3">
        <a href="<?= BASE_URL_ADMIN . '?act=form-them-quan-tri' ?>">
            <button class="btn-primary">+ Thêm Quản Trị Viên</button>
        </a>
    </div>

    <div class="overflow-x-auto">
      <?php if (isset($_GET['msg']) && $_GET['msg'] == 'error_last_admin'): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded-md border border-red-200 mb-4">
        <i class="fa-solid fa-triangle-exclamation mr-2"></i> 
        <strong>Không thể xóa:</strong> Đây là tài khoản Quản trị duy nhất còn lại. Hệ thống phải có ít nhất 1 Admin.
    </div>
<?php endif; ?>
      <table>
        <thead>
          <tr>
            <th>STT</th>
            <th>Ảnh đại diện</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Trạng thái</th>
            <th class="text-center">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listQuanTri as $key => $taiKhoan): ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td>
              <img src="<?= $taiKhoan['avatar'] ? BASE_URL . $taiKhoan['avatar'] : 'https://ui-avatars.com/api/?name=' . urlencode($taiKhoan['full_name']) ?>" class="user-avatar">
            </td>
            <td><div class="font-bold"><?= $taiKhoan['full_name'] ?></div></td>
            <td><span class="text-gray-600"><?= $taiKhoan['email'] ?></span></td>
            <td><?= $taiKhoan['phone'] ?></td>
            <td>
              <?php if($taiKhoan['status'] == 1): ?>
                <span class="badge badge-success">Hoạt động</span>
              <?php else: ?>
                <span class="badge badge-danger">Bị khóa</span>
              <?php endif; ?>
            </td>
            <td>
             <div class="flex gap-2 justify-center">
    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-quan-tri&id_quan_tri=' . $taiKhoan['id'] ?>" 
       class="bg-blue-100 text-blue-700 px-3 py-1 rounded-md text-sm hover:bg-blue-200 transition">
       Sửa
    </a>
    <a href="<?= BASE_URL_ADMIN . '?act=reset-password-quan-tri&id_quan_tri=' . $taiKhoan['id'] ?>" 
       onclick="return confirm('Bạn có chắc muốn reset mật khẩu tài khoản này?')"
       class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-md text-sm hover:bg-yellow-200 transition">
       Reset Pass
    </a>
    
    <a href="<?= BASE_URL_ADMIN . '?act=xoa-quan-tri&id_quan_tri=' . $taiKhoan['id'] ?>" 
       onclick="return confirm('Xác nhận xóa tài khoản quản trị này? Lưu ý: Hành động này không thể hoàn tác!')"
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