<?php require './views/layout/sidebar.php' ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê báo cáo - Website bán điện thoại DTAA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php 
    $summary = $summary ??['tong_san_pham'=>0, 'tong_don_hang' =>0, 'tong_khach_hang'=>0,'doanh_thu'=>0];
    $recentOrders = $recentOrders ?? [];
  $topProducts = $topProducts ?? [];
     ?>
<div class="w-full min-h-screen" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="px-10 py-8 text-white"style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h1 class="text-3xl font-bold"> Thống kê báo cáo</h1>
            <p class="opacity-90 mt-1">Tổng quan hoạt động kinh doanh</p>
        </div>
        <div class="px-10 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <p class="text-gray-500 text-sm">Tổng sản phẩm</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2"><?= (int)($summary['tong_san_pham'] ?? 0)?></p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <p class="text-gray-500 text-sm">Đơn hàng</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2"><?= (int)($summary['tong_don_hang'] ?? 0)?></p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <p class="text-gray-500 text-sm">Khách hàng</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2"><?= (int)($summary['tong_khach_hang'] ?? 0)?></p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <p class="text-gray-500 text-sm">Doanh thu</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2"><?=formatPrice((float)($summary['doanh_thu'] ?? 0)) ?>đ</p>
                </div>
            </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border">
                <h4 class="text-lg font-bold mb-4">Đơn hàng gần đây</h4>
                <div class="space-y-3">
                <?php foreach ($recentOrders as $o): ?>
  <div class="p-3 bg-gray-50 rounded-lg flex justify-between items-center">
    
    <div>
      <p class="font-medium">
        #<?= htmlspecialchars($o['id'] ?? '') ?> - 
        <?= htmlspecialchars($o['ten_khach_hang'] ?? '') ?>
      </p>

      <p class="text-sm text-gray-500">
        <?= htmlspecialchars($o['order_date'] ?? '') ?> · 
        <?= formatPrice((float)($o['total_amount'] ?? 0)) ?>đ
      </p>
    </div>

    <span class="text-xs px-2 py-1 rounded bg-indigo-100 text-indigo-700">
      <?= htmlspecialchars($o['ten_trang_thai'] ?? '') ?>
    </span>

  </div>
<?php endforeach; ?>
                <?php if (empty($recentOrders)): ?>
                  <div class="p-4 text-gray-500 bg-gray-50 rounded-lg">Chưa có dữ liệu đơn hàng.</div>
                <?php endif; ?>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border">
              <h4 class="text-lg font-bold mb-4">Sản phẩm bán chạy</h4>
              <div class="space-y-3">
                <?php foreach ($topProducts as $p): ?>
                  <div class="p-3 bg-gray-50 rounded-lg flex justify-between items-center gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                      <?php if (!empty($p['image'])): ?>
                        <img src="<?= BASE_URL . ltrim($p['image'], '/') ?>" class="w-10 h-10 rounded object-cover" alt="">
                      <?php else: ?>
                        <div class="w-10 h-10 rounded bg-indigo-100"></div>
                      <?php endif; ?>
                      <p class="font-medium truncate"><?= htmlspecialchars($p['name'] ?? '') ?></p>
                    </div>
                    <span class="font-bold text-indigo-700 whitespace-nowrap"><?= (int)($p['so_luong_ban'] ?? 0) ?> bán</span>
                  </div>
                <?php endforeach; ?>
                <?php if (empty($topProducts)): ?>
                  <div class="p-4 text-gray-500 bg-gray-50 rounded-lg">Chưa có dữ liệu sản phẩm bán chạy.</div>
                <?php endif; ?>
              </div>
            </div>
        </div>
        </div>
    </div>

</div>
</body>
</html>