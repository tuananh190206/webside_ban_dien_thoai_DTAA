<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Bill detail</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- cart main wrapper start -->
    <div class="cart-main-wrapper section-padding">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Thông tin sản phẩm của đơn hàng -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                   <tr>
                                    <th colspan="5">Sản phẩm trong đơn</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                    <?php foreach($chiTietDonHang ?? [] as $item) : ?>
                                        <tr>
                                            <td><img class="img-fluid" src="<?= BASE_URL . $item['hinh_anh'] ?>" alt="Product" width="100px" alt=""></td>
                                            <td><?=$item['ten_san_pham']?></td>
                                            <td><?=formatPrice($item['don_gia'])?></td>
                                            <td><?=$item['so_luong']?></td>
                                            <td><?=formatPrice($item['thanh_tien'])?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Update Option -->
                    </div>
                    <div class="col-lg-12">
                        <!-- Thông tin sản phẩm của đơn hàng -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                   <tr>
                                    <th colspan="3">Thông tin giao hàng &amp; thanh toán</th>
                                   </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th colspan="2">Người nhận</th>
                                    <td><?= htmlspecialchars($donHang['receiver_name'] ?? '') ?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Email</th>
                                    <td><?= htmlspecialchars($donHang['receiver_email'] ?? '') ?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Số điện thoại</th>
                                    <td><?= htmlspecialchars($donHang['receiver_phone'] ?? '') ?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Địa chỉ</th>
                                    <td><?= htmlspecialchars($donHang['receiver_address'] ?? '') ?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Ngày đặt</th>
                                    <td><?= htmlspecialchars($donHang['order_date'] ?? '') ?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Ghi chú</th>
                                    <td><?= htmlspecialchars($donHang['note'] ?? '') ?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Tổng tiền</th>
                                    <td><?= formatPrice($donHang['total_amount'] ?? 0) ?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Phương thức thanh toán</th>
                                    <td><?= htmlspecialchars($phuongThucThanhToan[$donHang['payment_method_id'] ?? 0] ?? '') ?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Trạng thái đơn hàng</th>
                                    <td><?= htmlspecialchars($trangThaiDonHang[$donHang['status_id'] ?? 0] ?? '') ?></td>
                                   </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php if (donHangCoTheHuy($donHang['status_id'] ?? 0)) : ?>
                        <div class="mt-3">
                            <a href="<?= BASE_URL ?>?act=huy-don-hang&id=<?= (int) $donHang['id'] ?>" class="btn btn-sqr" onclick="return confirm('Xác nhận hủy đơn hàng?')">Hủy đơn</a>
                        </div>
                        <?php endif; ?>
                        <!-- Cart Update Option -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart main wrapper end -->
</main>
<?php require_once 'views/miniCart.php'; ?>

<?php require_once 'layout/footer.php'; ?>