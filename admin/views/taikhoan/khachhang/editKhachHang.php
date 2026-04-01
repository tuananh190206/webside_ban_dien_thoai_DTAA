<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cập nhật khách hàng - <?= $khachHang['full_name'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
    .admin-panel { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
    .form-label { display: block; font-size: 14px; font-weight: 600; color: #4a5568; margin-bottom: 8px; }
    .form-input { width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; transition: all 0.3s; }
    .form-input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2); }
    .btn-submit { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px; border-radius: 8px; font-weight: bold; transition: opacity 0.3s; }
    .btn-submit:hover { opacity: 0.9; }
    .error-text { color: #e53e3e; font-size: 12px; margin-top: 4px; }
  </style>
</head>
<body>

<div class="admin-panel">
    <div class="header">
        <h1 class="text-2xl font-bold"><i class="fa-solid fa-user-pen mr-2"></i> Chỉnh Sửa Tài Khoản</h1>
        <p class="opacity-80">Cập nhật thông tin chi tiết cho khách hàng: <strong><?= $khachHang['full_name'] ?></strong></p>
    </div>

    <form action="<?= BASE_URL_ADMIN . '?act=sua-khach-hang' ?>" method="POST" class="p-8 space-y-6">
        <input type="hidden" name="khach_hang_id" value="<?= $khachHang['id'] ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-2 md:col-span-1">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="ho_ten" class="form-input" value="<?= $khachHang['full_name'] ?>" placeholder="Nhập họ tên">
                <?php if (isset($_SESSION['error']['ho_ten'])): ?>
                    <p class="error-text"><?= $_SESSION['error']['ho_ten'] ?></p>
                <?php endif; ?>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="<?= $khachHang['email'] ?>" placeholder="example@gmail.com">
                <?php if (isset($_SESSION['error']['email'])): ?>
                    <p class="error-text"><?= $_SESSION['error']['email'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="so_dien_thoai" class="form-input" value="<?= $khachHang['phone'] ?>" placeholder="Nhập số điện thoại">
                <?php if (isset($_SESSION['error']['so_dien_thoai'])): ?>
                    <p class="error-text"><?= $_SESSION['error']['so_dien_thoai'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="form-label">Ngày sinh</label>
                <input type="date" name="ngay_sinh" class="form-input" value="<?= $khachHang['birthday'] ?>">
                <?php if (isset($_SESSION['error']['ngay_sinh'])): ?>
                    <p class="error-text"><?= $_SESSION['error']['ngay_sinh'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="form-label">Giới tính</label>
                <select name="gioi_tinh" class="form-input bg-white">
                    <option <?= $khachHang['gender'] == 1 ? 'selected' : '' ?> value="1">Nam</option>
                    <option <?= $khachHang['gender'] == 2 ? 'selected' : '' ?> value="2">Nữ</option>
                </select>
            </div>

            <div>
                <label class="form-label">Trạng thái tài khoản</label>
                <select name="trang_thai" class="form-input bg-white">
                    <option <?= $khachHang['status'] == 1 ? 'selected' : '' ?> value="1">Hoạt động (Online)</option>
                    <option <?= $khachHang['status'] != 1 ? 'selected' : '' ?> value="2">Bị khóa (Offline)</option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="form-label">Địa chỉ</label>
                <textarea name="dia_chi" rows="2" class="form-input" placeholder="Nhập địa chỉ cụ thể"><?= $khachHang['address'] ?></textarea>
                <?php if (isset($_SESSION['error']['dia_chi'])): ?>
                    <p class="error-text"><?= $_SESSION['error']['dia_chi'] ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
            <a href="<?= BASE_URL_ADMIN . '?act=khach-hang' ?>" class="text-gray-500 hover:text-gray-700 font-medium text-sm">
                Hủy bỏ
            </a>
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-save mr-2"></i> Lưu thay đổi
            </button>
        </div>
    </form>
</div>

</body>
</html>