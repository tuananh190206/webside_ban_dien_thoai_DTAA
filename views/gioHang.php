<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/menu.php'; ?>

<main>

<!-- ===== FLASH MESSAGE ===== -->
<?php if (isset($_SESSION['flash_gio_hang'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle"></i>
            <strong>Thành công!</strong>
            <?= htmlspecialchars($_SESSION['flash_gio_hang']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['flash_gio_hang']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['flash_loi_gio_hang'])): ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Lỗi!</strong>
            <?= htmlspecialchars($_SESSION['flash_loi_gio_hang']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['flash_loi_gio_hang']); ?>
<?php endif; ?>

<!-- ===== BREADCRUMB (GIỮ NGUYÊN) ===== -->
<div class="breadcrumb-area">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?= BASE_URL ?>">Shop</a></li>
            <li class="active">Giỏ hàng</li>
        </ul>
    </div>
</div>

<!-- ===== CART ===== -->
<div class="cart-main-wrapper section-padding">
    <div class="container">
        <div class="section-bg-color">

            <div class="cart-table table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tạm tính</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $tongGioHang = 0;

                        if (empty($chiTietGioHang)): ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    🛒 Giỏ hàng của bạn đang trống
                                </td>
                            </tr>

                        <?php else:
                        foreach ($chiTietGioHang as $row):

                            $price = $row['discount_price'] ?: $row['price'];
                            $subtotal = $price * $row['quantity'];
                            $tongGioHang += $subtotal;

                            $stock = (int)($row['stock'] ?? 0);
                            $qty   = (int)$row['quantity'];
                        ?>

                        <!-- 🔴 highlight nếu vượt tồn -->
                        <tr class="<?= ($qty > $stock) ? 'table-danger' : '' ?>">

                            <td>
                                <img src="<?= BASE_URL . $row['image'] ?>" width="70">
                            </td>

                            <td>
                                <a href="<?= BASE_URL ?>?act=chi-tiet-san-pham&id_san_pham=<?= $row['product_id'] ?>">
                                    <?= htmlspecialchars($row['name']) ?>
                                </a>

                                <!-- ⚠️ cảnh báo tồn kho -->
                                <?php if ($qty > $stock): ?>
                                    <div style="color:red; font-size:13px;">
                                        ⚠️ Chỉ còn <?= $stock ?> sản phẩm trong kho
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td><?= formatPrice($price) ?></td>

                            <td>
                                <form action="<?= BASE_URL ?>?act=cap-nhat-gio-hang" method="post">
                                    <input type="hidden" name="san_pham_id" value="<?= $row['product_id'] ?>">

                                    <div class="input-group input-group-sm" style="width:110px">
                                        <button class="btn btn-outline-secondary btn-minus" type="button">-</button>

                                        <input type="text" name="so_luong"
                                               value="<?= $qty ?>"
                                               class="form-control text-center"
                                               readonly>

                                        <button class="btn btn-outline-secondary btn-plus" type="button">+</button>
                                    </div>
                                </form>
                            </td>

                            <td><?= formatPrice($subtotal) ?></td>

                            <td>
                                <a href="<?= BASE_URL ?>?act=xoa-gio-hang&san_pham_id=<?= $row['product_id'] ?>"
                                   onclick="return confirm('Xóa sản phẩm này?')">
                                   <i class="fa fa-trash text-danger"></i>
                                </a>
                            </td>

                        </tr>

                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- ===== TOTAL (GIỮ NGUYÊN) ===== -->
            <div class="row">
                <div class="col-lg-5 ml-auto">
                    <div class="cart-calculator-wrapper">
                        <h6>Tổng thanh toán</h6>

                        <table class="table">
                            <tr>
                                <td>Tạm tính</td>
                                <td><?= formatPrice($tongGioHang) ?></td>
                            </tr>
                            <tr>
                                <td>Phí vận chuyển</td>
                                <td>250.000đ</td>
                            </tr>
                            <tr>
                                <td><strong>Tổng</strong></td>
                                <td><strong><?= formatPrice($tongGioHang + 250000) ?></strong></td>
                            </tr>
                        </table>

                        <a href="<?= BASE_URL ?>?act=thanh-toan"
                           class="btn btn-sqr">
                            Tiến hành thanh toán
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</main>

<!-- ===== JS giữ nguyên logic ===== -->
<script>
document.querySelectorAll('.btn-plus').forEach(btn => {
    btn.onclick = function () {
        let input = this.parentElement.querySelector('input');
        input.value = parseInt(input.value) + 1;
        this.closest('form').submit();
    }
});

document.querySelectorAll('.btn-minus').forEach(btn => {
    btn.onclick = function () {
        let input = this.parentElement.querySelector('input');
        let val = parseInt(input.value);

        if (val > 1) {
            input.value = val - 1;
            this.closest('form').submit();
        } else if (confirm("Xóa sản phẩm khỏi giỏ?")) {
            input.value = 0;
            this.closest('form').submit();
        }
    }
});
</script>

<?php require_once __DIR__ . '/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>