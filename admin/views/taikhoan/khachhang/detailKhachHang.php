<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chi tiết khách hàng - <?= $khachHang['full_name'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
    .admin-panel { max-width: 1200px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; display: flex; justify-content: space-between; align-items: center; }
    .section-title { border-left: 4px solid #764ba2; padding-left: 15px; margin: 30px 0 20px; font-weight: bold; color: #4a5568; }
    .info-label { color: #718096; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; }
    .info-value { color: #2d3748; font-size: 1.1rem; font-weight: 500; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f8f9fa; padding: 12px 15px; text-align: left; font-size: 12px; text-transform: uppercase; color: #495057; }
    td { padding: 12px 15px; border-bottom: 1px solid #edf2f7; font-size: 14px; }
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
    .badge-success { background: #e8f5e9; color: #2e7d32; }
    .badge-warning { background: #fff3e0; color: #ef6c00; }
  </style>
</head>
<body>

<div class="admin-panel">
    <div class="header">
        <div>
            <h1 class="text-2xl font-bold">Hồ Sơ Khách Hàng</h1>
            <p class="opacity-80">Chi tiết thông tin và lịch sử hoạt động</p>
        </div>
        <a href="<?= BASE_URL_ADMIN . '?act=khach-hang' ?>" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition text-sm">
            <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>

    <div class="p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center space-y-4">
                <div class="relative inline-block">
                    <img src="<?= !empty($khachHang['avatar']) ? BASE_URL . $khachHang['avatar'] : 'https://placehold.co/200x200?text=User' ?>" 
                         class="w-48 h-48 rounded-2xl object-cover shadow-xl border-4 border-gray-100 mx-auto"
                         onerror="this.src='https://placehold.co/200x200?text=User'">
                    <span class="absolute bottom-2 right-2 w-6 h-6 <?= $khachHang['status'] == 1 ? 'bg-green-500' : 'bg-red-500' ?> border-4 border-white rounded-full"></span>
                </div>
                <h3 class="text-xl font-bold text-gray-800"><?= $khachHang['full_name'] ?></h3>
                <p class="text-gray-500 text-sm">Khách hàng thành viên</p>
            </div>

            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-2xl">
                <div>
                    <p class="info-label">Email</p>
                    <p class="info-value"><?= $khachHang['email'] ?></p>
                </div>
                <div>
                    <p class="info-label">Số điện thoại</p>
                    <p class="info-value"><?= $khachHang['phone'] ?></p>
                </div>
                <div>
                    <p class="info-label">Ngày sinh</p>
                    <p class="info-value"><?= !empty($khachHang['birthday']) ? date('d/m/Y', strtotime($khachHang['birthday'])) : 'Chưa cập nhật' ?></p>
                </div>
                <div>
                    <p class="info-label">Giới tính</p>
                    <p class="info-value"><?= $khachHang['gender'] == 1 ? 'Nam' : 'Nữ' ?></p>
                </div>
                <div class="md:col-span-2">
                    <p class="info-label">Địa chỉ</p>
                    <p class="info-value"><?= $khachHang['address'] ?></p>
                </div>
            </div>
        </div>

        <hr class="my-10 border-gray-100">

        <h2 class="section-title text-xl">Lịch Sử Mua Hàng</h2>
        <div class="overflow-x-auto rounded-xl border border-gray-100">
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Người nhận</th>
                        <th>Số điện thoại</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($listDonHang)): ?>
                        <?php foreach ($listDonHang as $donHang): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="font-bold text-purple-700"><?= $donHang['order_code'] ?></td>
                            <td><?= $donHang['receiver_name'] ?></td>
                            <td><?= $donHang['receiver_phone'] ?></td>
                            <td><?= date('d/m/Y', strtotime($donHang['order_date'])) ?></td>
                            <td class="font-bold text-red-600"><?= number_format($donHang['total_amount'], 0, ',', '.') ?>đ</td>
                            <td>
                                <span class="badge badge-warning"><?= $donHang['status_name'] ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-don-hang&id_don_hang=' . $donHang['id'] ?>" 
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                   Xem chi tiết <i class="fa-solid fa-chevron-right ml-1"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center py-4 text-gray-400">Chưa có lịch sử đơn hàng.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h2 class="section-title text-xl mt-12">Lịch Sử Đánh Giá Sản Phẩm</h2>
        <div class="overflow-x-auto rounded-xl border border-gray-100 mb-8">
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Nội dung đánh giá</th>
                        <th>Ngày đánh giá</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($listBinhLuan)): ?>
                        <?php foreach ($listBinhLuan as $binhLuan): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="font-medium">
                                <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id_san_pham=' . $binhLuan['product_id'] ?>" class="text-blue-600 hover:underline">
                                    <?= $binhLuan['product_name'] ?>
                                </a>
                            </td>
                            <td class="max-w-xs italic text-gray-600">"<?= $binhLuan['content'] ?>"</td>
                            <td><?= date('d/m/Y', strtotime($binhLuan['review_date'])) ?></td>
                            <td>
                                <?= $binhLuan['status'] == 1 ? '<span class="badge badge-success">Hiển thị</span>' : '<span class="badge badge-danger">Đã ẩn</span>' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-4 text-gray-400">Chưa có bình luận nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>