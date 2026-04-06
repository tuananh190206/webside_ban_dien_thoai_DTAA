<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Cập nhật đơn hàng | Quản trị</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
    .admin-panel { max-width: 800px; margin: 30px auto; background: #fff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; }
    .header { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 25px; color: white; }
    label { font-weight: 600; display: block; margin-top: 15px; color: #1e40af; font-size: 0.9rem; }
    input, select, textarea { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; margin-top: 5px; font-size: 0.95rem; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
        <h2 class="text-xl font-bold uppercase tracking-wider">Cập nhật đơn hàng #<?= $donHang['id'] ?></h2>
    </div>
    
    <form action="<?= BASE_URL_ADMIN . '?act=sua-don-hang' ?>" method="POST" class="p-8">
        <input type="hidden" name="don_hang_id" value="<?= $donHang['id'] ?>">

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Tên người nhận</label>
                <input type="text" name="receiver_name" value="<?= $donHang['receiver_name'] ?>">
                <p class="text-red-500 text-xs italic"><?= $_SESSION['error']['receiver_name'] ?? '' ?></p>
            </div>
            <div>
                <label>Số điện thoại</label>
                <input type="text" name="receiver_phone" value="<?= $donHang['receiver_phone'] ?>">
                <p class="text-red-500 text-xs italic"><?= $_SESSION['error']['receiver_phone'] ?? '' ?></p>
            </div>
        </div>

        <label>Địa chỉ người nhận</label>
        <textarea name="receiver_address" rows="2"><?= $donHang['receiver_address'] ?></textarea>

        <label class="text-blue-700">Trạng thái đơn hàng</label>
        <select name="status_id" class="bg-blue-50 border-blue-200">
            <?php foreach ($listTrangThaiDonHang as $status): ?>
                <option <?= $status['id'] == $donHang['status_id'] ? 'selected' : '' ?> value="<?= $status['id'] ?>">
                    <?= $status['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Ghi chú đơn hàng</label>
        <textarea name="note" rows="3"><?= $donHang['note'] ?></textarea>

        <div class="mt-8">
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition uppercase shadow-lg">Lưu thay đổi</button>
            <a href="<?= BASE_URL_ADMIN . '?act=don-hang' ?>" class="block text-center mt-4 text-gray-500 hover:underline">Quay lại danh sách</a>
        </div>
    </form>
  </div>
</body>
</html>