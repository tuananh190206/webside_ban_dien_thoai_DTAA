<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bảng Điều Khiển - DTAA Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 1250px; margin: 40px auto; background: #f8f9fa; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
    .stat-card { background: white; padding: 24px; border-radius: 12px; border: 1px solid #edf2f7; transition: transform 0.3s; height: 100%; }
    .stat-card:hover { transform: translateY(-5px); }
    .icon-box { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Bảng Điều Khiển</h1>
                <p>Chào mừng trở lại, <?= $_SESSION['user_admin']['full_name'] ?? 'Quản trị viên' ?>!</p>
            </div>
            <div class="text-right">
                <p class="text-sm opacity-80"><?= date('l, d F Y') ?></p>
            </div>
        </div>
    </div>

    <div class="p-8">
        <!-- Bộ lọc ngày -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
            <form action="<?= BASE_URL_ADMIN ?>" method="GET" class="flex flex-wrap items-end gap-4">
                <input type="hidden" name="act" value="/">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date" value="<?= $_GET['start_date'] ?? '' ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date" value="<?= $_GET['end_date'] ?? '' ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Lọc báo cáo
                    </button>
                    <a href="<?= BASE_URL_ADMIN ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Làm mới
                    </a>
                </div>
                <?php if (isset($_GET['start_date']) && isset($_GET['end_date'])): ?>
                    <div class="ml-auto self-center text-sm text-gray-500 italic">
                        Đang hiển thị dữ liệu từ <strong><?= date('d/m/Y', strtotime($_GET['start_date'])) ?></strong> đến <strong><?= date('d/m/Y', strtotime($_GET['end_date'])) ?></strong>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Doanh thu (Đã giao)</p>
                        <h2 class="text-2xl font-bold text-gray-800 mt-1"><?= number_format($tongDoanhThu, 0, ',', '.') ?>đ</h2>
                    </div>
                    <div class="icon-box bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Tổng đơn hàng</p>
                        <h2 class="text-2xl font-bold text-gray-800 mt-1"><?= number_format($tongDonHang) ?></h2>
                    </div>
                    <div class="icon-box bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Khách hàng mới</p>
                        <h2 class="text-2xl font-bold text-gray-800 mt-1"><?= number_format($tongKhachHang) ?></h2>
                    </div>
                    <div class="icon-box bg-orange-100 text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Sản phẩm</p>
                        <h2 class="text-2xl font-bold text-gray-800 mt-1"><?= number_format($tongSanPham) ?></h2>
                    </div>
                    <div class="icon-box bg-purple-100 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-700 uppercase text-sm tracking-wider">
                    <?= (isset($_GET['start_date']) && isset($_GET['end_date'])) ? 'Danh sách đơn hàng trong khoảng thời gian' : 'Đơn hàng mới nhất' ?>
                </h3>
                <a href="<?= BASE_URL_ADMIN . '?act=don-hang' ?>" class="text-blue-500 text-xs font-bold hover:underline">XEM TẤT CẢ</a>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Mã đơn</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Khách hàng</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-right">Tổng tiền</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-center">Ngày đặt</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php if (!empty($listDonHangMoi)): ?>
                        <?php foreach($listDonHangMoi as $dh): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-blue-600">#<?= $dh['order_code'] ?></td>
                            <td class="px-6 py-4 font-medium text-gray-700"><?= $dh['full_name'] ?></td>
                            <td class="px-6 py-4 text-right font-bold text-red-500"><?= number_format($dh['total_amount'], 0, ',', '.') ?>đ</td>
                            <td class="px-6 py-4 text-center text-gray-500"><?= date('d/m/Y', strtotime($dh['order_date'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Chưa có dữ liệu đơn hàng mới.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</body>
</html>