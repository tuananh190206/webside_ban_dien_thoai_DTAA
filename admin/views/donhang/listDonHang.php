<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý đơn hàng</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 1280px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
    th { background: #f8f9fa; color: #4b5563; font-size: 0.75rem; text-transform: uppercase; padding: 15px 20px; text-align: left; }
    td { padding: 15px 20px; border-bottom: 1px solid #edf2f7; font-size: 0.875rem; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h1 class="text-2xl font-bold">Danh sách đơn hàng</h1>
      <p class="opacity-80">Theo dõi lộ trình và trạng thái thanh toán</p>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr>
            <th>Mã Đơn</th>
            <th>Người nhận</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th class="text-center">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listDonHang as $donHang): ?>
          <tr class="hover:bg-gray-50 transition">
            <td class="font-bold text-indigo-600"><?= $donHang['order_code'] ?></td>
            <td>
              <div class="font-semibold"><?= $donHang['receiver_name'] ?></div>
              <div class="text-xs text-blue-500 italic"><?= $donHang['receiver_email'] ?></div>
              <div class="text-xs text-gray-500"><?= $donHang['receiver_phone'] ?></div>
            </td>
            <td><?= date('d/m/Y H:i', strtotime($donHang['order_date'])) ?></td>
            <td class="font-bold text-red-500"><?= number_format($donHang['total_price'], 0, ',', '.') ?>đ</td>
            <td>
              <?php
                $color = match($donHang['status_id']) {
                    1 => 'bg-yellow-100 text-yellow-700',
                    4 => 'bg-green-100 text-green-700',
                    5 => 'bg-red-100 text-red-700',
                    default => 'bg-blue-100 text-blue-700',
                };
              ?>
              <span class="px-3 py-1 rounded-full text-[10px] font-bold <?= $color ?> uppercase">
                <?= $donHang['ten_trang_thai'] ?>
              </span>
            </td>
            <td class="text-center">
                <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-don-hang&id_don_hang=' . $donHang['id'] ?>" class="text-emerald-600 hover:underline font-bold px-2">Xem</a>
                <a href="<?= BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang=' . $donHang['id'] ?>" class="text-blue-600 hover:underline font-bold px-2">Sửa</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>