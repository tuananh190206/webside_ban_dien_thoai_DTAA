<?php
// Set timezone cho Việt Nam - tránh lỗi PHP
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Load sidebar layout
require dirname(__DIR__) . '/layout/sidebar.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Sản Phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="margin:0; font-family:Arial,sans-serif; background:#f3f4f6; min-height:100vh;">

    <div style="max-width:1400px; margin:30px auto; background:#fff; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); overflow:hidden;">

        <!-- HEADER -->
        <div style="background:linear-gradient(135deg,#667eea,#764ba2); padding:30px; color:#fff;">
            <h1 style="margin:0; font-size:28px; font-weight:bold;">
                <i class="fas fa-chart-bar"></i> Thống Kê Sản Phẩm
            </h1>
            <p style="margin:8px 0 0; opacity:0.9; font-size:14px;">
                Phân tích bán hàng &amp; tồn kho theo khoảng thời gian
            </p>
        </div>

        <div style="padding:30px;">

            <!-- FORM CHỌN NGÀY -->
            <div style="background:#f8f9fa; border:1px solid #e5e7eb; border-radius:10px; padding:24px; margin-bottom:24px;">
                <form method="GET" action="" style="display:flex; flex-wrap:wrap; gap:16px; align-items:flex-end;">
                    <input type="hidden" name="act" value="thong-ke-san-pham">
                    <div style="flex:1; min-width:180px;">
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                            <i class="fas fa-calendar"></i> Từ ngày
                        </label>
                        <input type="date" name="from" value="<?php echo htmlspecialchars($fromDate ?? date('Y-m-d')); ?>" 
                               style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; box-sizing:border-box;">
                    </div>
                    <div style="flex:1; min-width:180px;">
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                            <i class="fas fa-calendar"></i> Đến ngày
                        </label>
                        <input type="date" name="to" value="<?php echo htmlspecialchars($toDate ?? date('Y-m-d')); ?>" 
                               style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; box-sizing:border-box;">
                    </div>
                    <button type="submit" style="padding:10px 24px; background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer;">
                        <i class="fas fa-search"></i> Thống kê
                    </button>
                    <a href="?act=thong-ke-san-pham" style="padding:10px 24px; background:#e5e7eb; color:#374151; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none;">
                        <i class="fas fa-redo"></i> Làm mới
                    </a>
                </form>
            </div>

            <!-- TỔNG HỢP -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:20px; margin-bottom:30px;">
                <!-- Tổng đơn hàng -->
                <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:24px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <p style="font-size:13px; color:#6b7280; margin:0;">Tổng đơn hàng</p>
                            <h2 style="font-size:26px; font-weight:bold; color:#1f2937; margin:8px 0 0;">
                                <?php echo number_format($tongHop['tong_don'] ?? 0); ?>
                            </h2>
                        </div>
                        <div style="width:50px; height:50px; background:#dbeafe; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-shopping-cart" style="color:#3b82f6; font-size:20px;"></i>
                        </div>
                    </div>
                </div>
                <!-- Tổng doanh thu -->
                <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:24px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <p style="font-size:13px; color:#6b7280; margin:0;">Tổng doanh thu</p>
                            <h2 style="font-size:26px; font-weight:bold; color:#16a34a; margin:8px 0 0;">
                                <?php echo number_format($tongHop['tong_doanh_thu'] ?? 0, 0, ',', '.'); ?>đ
                            </h2>
                        </div>
                        <div style="width:50px; height:50px; background:#dcfce7; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-dollar-sign" style="color:#22c55e; font-size:20px;"></i>
                        </div>
                    </div>
                </div>
                <!-- Sản phẩm bán -->
                <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:24px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <p style="font-size:13px; color:#6b7280; margin:0;">Sản phẩm đã bán</p>
                            <h2 style="font-size:26px; font-weight:bold; color:#ea580c; margin:8px 0 0;">
                                <?php echo number_format($tongHop['tong_san_pham_ban'] ?? 0); ?>
                            </h2>
                        </div>
                        <div style="width:50px; height:50px; background:#ffedd5; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-boxes" style="color:#f97316; font-size:20px;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== TOP BÁN CHẠY ===================== -->
            <div style="border:1px solid #e5e7eb; border-radius:12px; margin-bottom:30px; overflow:hidden;">
                <div style="background:linear-gradient(135deg,#fff7ed,#fef2f2); padding:16px 24px; border-bottom:1px solid #e5e7eb;">
                    <h3 style="margin:0; font-size:15px; font-weight:bold; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="fas fa-fire" style="color:#f97316;"></i> TOP 10 SẢN PHẨM BÁN CHẠY
                        <span style="font-weight:normal; font-size:12px; color:#6b7280;">
                            (<?php echo htmlspecialchars($fromDate ?? ''); ?> → <?php echo htmlspecialchars($toDate ?? ''); ?>)
                        </span>
                    </h3>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:14px;">
                        <thead style="background:#f9fafb;">
                            <tr>
                                <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">#</th>
                                <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Sản phẩm</th>
                                <th style="padding:12px 16px; text-align:right; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Giá</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">SL Bán</th>
                                <th style="padding:12px 16px; text-align:right; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Doanh thu</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($topBanChay)): ?>
                                <?php 
                                $maxBan = $topBanChay[0]['tong_so_luong_ban'] ?? 1;
                                foreach ($topBanChay as $i => $sp): 
                                    $percent = round(($sp['tong_so_luong_ban'] / $maxBan) * 100, 1);
                                ?>
                                <tr style="border-bottom:1px solid #f3f4f6; transition:background 0.2s;" onmouseover="this.style.background='#fff7ed'" onmouseout="this.style.background=''">
                                    <td style="padding:14px 16px; font-weight:bold; color:#374151;">#<?php echo $i + 1; ?></td>
                                    <td style="padding:14px 16px;">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <?php if (!empty($sp['image'])): ?>
                                                <img src="<?php echo BASE_URL . $sp['image']; ?>" style="width:40px; height:40px; object-fit:cover; border-radius:8px;" alt="">
                                            <?php endif; ?>
                                            <div>
                                                <p style="font-weight:600; color:#1f2937; margin:0;"><?php echo htmlspecialchars($sp['name']); ?></p>
                                                <p style="font-size:12px; color:#9ca3af; margin:2px 0 0;">ID: <?php echo $sp['id']; ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px; text-align:right;">
                                        <?php if (!empty($sp['discount_price'])): ?>
                                            <span style="color:#dc2626; font-weight:bold;"><?php echo number_format($sp['discount_price'], 0, ',', '.'); ?>đ</span>
                                            <span style="color:#9ca3af; text-decoration:line-through; font-size:12px; margin-left:4px;"><?php echo number_format($sp['price'], 0, ',', '.'); ?>đ</span>
                                        <?php else: ?>
                                            <span style="font-weight:bold;"><?php echo number_format($sp['price'], 0, ',', '.'); ?>đ</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding:14px 16px; text-align:center;">
                                        <span style="display:inline-block; background:#ffedd5; color:#c2410c; padding:4px 12px; border-radius:20px; font-weight:bold; font-size:13px;">
                                            <?php echo number_format($sp['tong_so_luong_ban']); ?>
                                        </span>
                                    </td>
                                    <td style="padding:14px 16px; text-align:right; font-weight:bold; color:#16a34a;">
                                        <?php echo number_format($sp['tong_doanh_thu'], 0, ',', '.'); ?>đ
                                    </td>
                                    <td style="padding:14px 16px; text-align:center;">
                                        <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                            <div style="width:60px; background:#e5e7eb; border-radius:4px; height:8px;">
                                                <div style="width:<?php echo $percent; ?>%; height:8px; background:linear-gradient(90deg,#f97316,#ef4444); border-radius:4px;"></div>
                                            </div>
                                            <span style="font-size:12px; color:#6b7280;"><?php echo $percent; ?>%</span>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="padding:40px; text-align:center; color:#9ca3af;">
                                        <i class="fas fa-inbox" style="font-size:32px; display:block; margin-bottom:10px;"></i>
                                        Không có dữ liệu bán hàng trong khoảng thời gian này.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ===================== TOP BÁN Ế ===================== -->
            <div style="border:1px solid #e5e7eb; border-radius:12px; margin-bottom:30px; overflow:hidden;">
                <div style="background:linear-gradient(135deg,#eff6ff,#eef2ff); padding:16px 24px; border-bottom:1px solid #e5e7eb;">
                    <h3 style="margin:0; font-size:15px; font-weight:bold; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="fas fa-chart-line" style="color:#3b82f6;"></i> TOP 10 SẢN PHẨM BÁN Ế
                    </h3>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:14px;">
                        <thead style="background:#f9fafb;">
                            <tr>
                                <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">#</th>
                                <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Sản phẩm</th>
                                <th style="padding:12px 16px; text-align:right; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Giá</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">SL Bán</th>
                                <th style="padding:12px 16px; text-align:right; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($topBanE)): ?>
                                <?php foreach ($topBanE as $i => $sp): ?>
                                <tr style="border-bottom:1px solid #f3f4f6; transition:background 0.2s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background=''">
                                    <td style="padding:14px 16px; font-weight:bold; color:#374151;">#<?php echo $i + 1; ?></td>
                                    <td style="padding:14px 16px;">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <?php if (!empty($sp['image'])): ?>
                                                <img src="<?php echo BASE_URL . $sp['image']; ?>" style="width:40px; height:40px; object-fit:cover; border-radius:8px;" alt="">
                                            <?php endif; ?>
                                            <div>
                                                <p style="font-weight:600; color:#1f2937; margin:0;"><?php echo htmlspecialchars($sp['name']); ?></p>
                                                <p style="font-size:12px; color:#9ca3af; margin:2px 0 0;">ID: <?php echo $sp['id']; ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px; text-align:right;">
                                        <?php if (!empty($sp['discount_price'])): ?>
                                            <span style="color:#dc2626; font-weight:bold;"><?php echo number_format($sp['discount_price'], 0, ',', '.'); ?>đ</span>
                                            <span style="color:#9ca3af; text-decoration:line-through; font-size:12px; margin-left:4px;"><?php echo number_format($sp['price'], 0, ',', '.'); ?>đ</span>
                                        <?php else: ?>
                                            <span style="font-weight:bold;"><?php echo number_format($sp['price'], 0, ',', '.'); ?>đ</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding:14px 16px; text-align:center;">
                                        <span style="display:inline-block; background:#dbeafe; color:#1d4ed8; padding:4px 12px; border-radius:20px; font-weight:bold; font-size:13px;">
                                            <?php echo number_format($sp['tong_so_luong_ban']); ?>
                                        </span>
                                    </td>
                                    <td style="padding:14px 16px; text-align:right; font-weight:bold; color:#16a34a;">
                                        <?php echo number_format($sp['tong_doanh_thu'], 0, ',', '.'); ?>đ
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="padding:40px; text-align:center; color:#9ca3af;">
                                        <i class="fas fa-chart-area" style="font-size:32px; display:block; margin-bottom:10px;"></i>
                                        Không có sản phẩm bán ế trong khoảng thời gian này.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ===================== TỒN KHO ===================== -->
            <div style="border:1px solid #e5e7eb; border-radius:12px; margin-bottom:30px; overflow:hidden;">
                <div style="background:linear-gradient(135deg,#f0fdf4,#ecfdf5); padding:16px 24px; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center;">
                    <h3 style="margin:0; font-size:15px; font-weight:bold; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="fas fa-warehouse" style="color:#22c55e;"></i> BÁO CÁO TỒN KHO HIỆN TẠI
                    </h3>
                    <span style="font-size:11px; background:#fff; padding:4px 12px; border-radius:20px; color:#6b7280;">
                        <i class="fas fa-info-circle"></i> Tồn = Gốc - Đã bán + Đã hủy
                    </span>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:14px;">
                        <thead style="background:#f9fafb;">
                            <tr>
                                <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Sản phẩm</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Tồn gốc</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#dc2626; text-transform:uppercase;">Đã bán</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#3b82f6; text-transform:uppercase;">Đã hủy</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#16a34a; text-transform:uppercase;">Tồn thực</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tonKho)): ?>
                                <?php foreach ($tonKho as $sp): 
                                    $tonHienTai = (int)($sp['ton_kho_thuc_te'] ?? 0);
                                    if ($tonHienTai <= 5) {
                                        $badge = '<span style="background:#fef2f2; color:#dc2626; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">Sắp hết</span>';
                                    } elseif ($tonHienTai <= 20) {
                                        $badge = '<span style="background:#fef9c3; color:#ca8a04; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">Cảnh báo</span>';
                                    } else {
                                        $badge = '<span style="background:#f0fdf4; color:#16a34a; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">Tốt</span>';
                                    }
                                ?>
                                <tr style="border-bottom:1px solid #f3f4f6; transition:background 0.2s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background=''">
                                    <td style="padding:14px 16px;">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <?php if (!empty($sp['image'])): ?>
                                                <img src="<?php echo BASE_URL . $sp['image']; ?>" style="width:40px; height:40px; object-fit:cover; border-radius:8px;" alt="">
                                            <?php endif; ?>
                                            <div>
                                                <p style="font-weight:600; color:#1f2937; margin:0;"><?php echo htmlspecialchars($sp['name']); ?></p>
                                                <p style="font-size:12px; color:#9ca3af; margin:2px 0 0;">Giá: <?php echo number_format($sp['price'], 0, ',', '.'); ?>đ</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px; text-align:center; font-weight:bold; color:#6b7280;">
                                        <?php echo number_format($sp['so_luong_goc'] ?? 0); ?>
                                    </td>
                                    <td style="padding:14px 16px; text-align:center; font-weight:bold; color:#dc2626;">
                                        <?php echo number_format($sp['da_ban'] ?? 0); ?>
                                    </td>
                                    <td style="padding:14px 16px; text-align:center; font-weight:bold; color:#3b82f6;">
                                        <?php echo number_format($sp['da_huy'] ?? 0); ?>
                                    </td>
                                    <td style="padding:14px 16px; text-align:center;">
                                        <span style="display:inline-block; background:#dcfce7; color:#15803d; padding:6px 14px; border-radius:8px; font-weight:bold; font-size:15px;">
                                            <?php echo number_format($tonHienTai); ?>
                                        </span>
                                    </td>
                                    <td style="padding:14px 16px; text-align:center;">
                                        <?php echo $badge; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="padding:40px; text-align:center; color:#9ca3af;">
                                        <i class="fas fa-boxes" style="font-size:32px; display:block; margin-bottom:10px;"></i>
                                        Không có dữ liệu tồn kho.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ===================== THỐNG KÊ THEO NGÀY ===================== -->
            <div style="border:1px solid #e5e7eb; border-radius:12px; margin-bottom:30px; overflow:hidden;">
                <div style="background:linear-gradient(135deg,#eef2ff,#f5f3ff); padding:16px 24px; border-bottom:1px solid #e5e7eb;">
                    <h3 style="margin:0; font-size:15px; font-weight:bold; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="fas fa-calendar-alt" style="color:#7c3aed;"></i> THỐNG KÊ THEO NGÀY
                        <span style="font-weight:normal; font-size:12px; color:#6b7280;">
                            (<?php echo htmlspecialchars($fromDate ?? ''); ?> → <?php echo htmlspecialchars($toDate ?? ''); ?>)
                        </span>
                    </h3>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:14px;">
                        <thead style="background:#f9fafb;">
                            <tr>
                                <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Ngày</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Số đơn</th>
                                <th style="padding:12px 16px; text-align:right; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">Doanh thu</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">SP bán</th>
                                <th style="padding:12px 16px; text-align:center; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase;">TB/đơn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($thongKeTheoNgay)): ?>
                                <?php foreach ($thongKeTheoNgay as $row): 
                                    $avg = $row['so_don_hang'] > 0 ? $row['doanh_thu'] / $row['so_don_hang'] : 0;
                                ?>
                                <tr style="border-bottom:1px solid #f3f4f6; transition:background 0.2s;" onmouseover="this.style.background='#eef2ff'" onmouseout="this.style.background=''">
                                    <td style="padding:14px 16px; font-weight:600; color:#374151;">
                                        <?php echo date('d/m/Y', strtotime($row['order_date'])); ?>
                                    </td>
                                    <td style="padding:14px 16px; text-align:center;">
                                        <span style="display:inline-block; background:#ede9fe; color:#6d28d9; padding:4px 12px; border-radius:20px; font-weight:bold;">
                                            <?php echo number_format($row['so_don_hang']); ?>
                                        </span>
                                    </td>
                                    <td style="padding:14px 16px; text-align:right; font-weight:bold; color:#16a34a;">
                                        <?php echo number_format($row['doanh_thu'], 0, ',', '.'); ?>đ
                                    </td>
                                    <td style="padding:14px 16px; text-align:center; color:#6b7280;">
                                        <?php echo number_format($row['so_san_pham_ban']); ?>
                                    </td>
                                    <td style="padding:14px 16px; text-align:center; font-weight:bold; color:#7c3aed;">
                                        <?php echo number_format($avg, 0, ',', '.'); ?>đ
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="padding:40px; text-align:center; color:#9ca3af;">
                                        <i class="fas fa-calendar-times" style="font-size:32px; display:block; margin-bottom:10px;"></i>
                                        Không có dữ liệu trong khoảng thời gian này.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div style="text-align:center; color:#9ca3af; font-size:12px; margin-top:20px; margin-bottom:20px;">
        &copy; 2026 DTAA Store - Hệ thống quản trị bán điện thoại
    </div>

</body>
</html>
