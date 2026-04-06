<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa quản trị viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 40px 0; }
        .form-container { max-width: 900px; margin: auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
        .form-group label { display: block; font-weight: 700; color: #4a5568; margin-bottom: 8px; font-size: 14px; }
        .form-control { width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 10px; transition: all 0.3s; outline: none; }
        .form-control:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .btn-update { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px; border-radius: 10px; font-weight: 700; transition: transform 0.2s; }
        .btn-update:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Chỉnh Sửa Tài Khoản Quản Trị</h1>
                <p class="text-purple-100 mt-1">Cập nhật thông tin nhân viên: <span class="font-semibold"><?= $quanTri['full_name'] ?></span></p>
            </div>
            <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri' ?>" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm transition">
                Quay lại danh sách
            </a>
        </div>

        <form action="<?= BASE_URL_ADMIN . '?act=sua-quan-tri' ?>" method="POST" class="p-8">
            <input type="hidden" name="id" value="<?= $quanTri['id'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="full_name" class="form-control" value="<?= $quanTri['full_name'] ?>" required>
                    <?php if(isset($_SESSION['error']['full_name'])): ?>
                        <p class="text-red-500 text-xs mt-1"><?= $_SESSION['error']['full_name'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Email (Tài khoản đăng nhập)</label>
                    <input type="email" name="email" class="form-control" value="<?= $quanTri['email'] ?>" required>
                    <?php if(isset($_SESSION['error']['email'])): ?>
                        <p class="text-red-500 text-xs mt-1"><?= $_SESSION['error']['email'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?= $quanTri['phone'] ?>">
                </div>

                <div class="form-group">
                    <label>Trạng thái tài khoản</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= $quanTri['status'] == 1 ? 'selected' : '' ?>>Đang hoạt động</option>
                        <option value="0" <?= $quanTri['status'] == 0 ? 'selected' : '' ?>>Khóa tài khoản</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t flex justify-between items-center">
                <div class="text-sm text-gray-500 italic">
                    * Lưu ý: Việc thay đổi Email sẽ ảnh hưởng đến tài khoản đăng nhập của nhân viên.
                </div>
                <div class="flex gap-4">
                    <button type="reset" class="px-6 py-3 text-gray-600 font-semibold hover:text-gray-800 transition">Hoàn tác</button>
                    <button type="submit" class="btn-update">Lưu thay đổi</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>