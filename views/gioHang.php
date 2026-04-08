<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/menu.php'; ?>
<main>
<?php if (isset($_SESSION['flash_gio_hang'])) { ?>
        <div class="container mt-3">
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['flash_gio_hang']) ?>
            </div>
        </div>
        <?php unset($_SESSION['flash_gio_hang']); ?>
    <?php } ?>
    <?php if (isset($_SESSION['flash_loi_gio_hang'])) { ?>
        <div class="container mt-3">
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['flash_loi_gio_hang']) ?>
            </div>
        </div>
        <?php unset($_SESSION['flash_loi_gio_hang']); ?>
    <?php } ?>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">cart</li>
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
                        <!-- Cart Table Area -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Ảnh sản phẩm</th>
                                        <th class="pro-title">Tên sản phẩm</th>
                                        <th class="pro-price">Giá</th>
                                        <th class="pro-quantity">Số lượng</th>
                                        <th class="pro-subtotal">Tổng tiền</th>
                                        <th class="pro-remove">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                     $tongGioHang=0;
                                     if(empty($chiTietGioHang)) :?>
                                        <tr>
                                        <td colspan="6" class="text-center py-5">Giỏ hàng của bạn đang trống. <a href="<?= BASE_URL ?>">Tiếp tục mua sắm</a></td>
                                        </tr>
                                        <?php else: 
                                    foreach ($chiTietGioHang as $key => $row): 
                                        ?>
                                        <tr>
                                            <td class="pro-thumbnail"><a href="<?= BASE_URL ?>?act=chi-tiet-san-pham&id_san_pham=<?= (int) $row['product_id'] ?>"><img class="img-fluid"
                                                        src="<?= BASE_URL . $row['image'] ?>" alt="Product" /></a></td>
                                            <td class="pro-title"><a href="<?= BASE_URL ?>?act=chi-tiet-san-pham&id_san_pham=<?= (int) $row['product_id'] ?>"><?= htmlspecialchars($row['name']) ?></a></td>
                                            <td class="pro-price"><span>
                                                    <?php if ($row['discount_price']) { ?>
                                                        <?= formatPrice($row['discount_price']) ?>
                                                    <?php }else{ ?>
                                                        <?= formatPrice($row['price']) ?>
                                                    <?php }?>    
                                                </span></td>
                                                <?php 
                                                 $stock = max(0, (int) ($row['stock'] ?? 0));
                                                 $currentQty = (int) $row['quantity'];
                                                 ?>
                                            <td class="pro-quantity">
                                                <form action="<?= BASE_URL ?>?act=cap-nhat-gio-hang" method="post">
                                                    <input type="hidden" name="san_pham_id" value="<?= (int) $row['product_id'] ?>">
                                                    <div class="input-group input-group-sm mx-auto" style="width: 100px;">
                                                        <button class="btn btn-outline-secondary btn-minus" type="button">-</button>
                                                        <input type="text" name="so_luong" class="form-control text-center" value="<?= $currentQty ?>" readonly style="background-color: #fff;">
                                                        <button class="btn btn-outline-secondary btn-plus" type="button">+</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="pro-subtotal"><span>
                                                        <?php
                                                        $price = $row['discount_price'] ? $row['discount_price'] : $row['price'];
                                                        $subtotal = $price * $row['quantity'];
                                                        $tongGioHang += $subtotal;
                                                        echo formatPrice($subtotal);
                                                        ?>
                                            </span></td>
                                            <td class="pro-remove"><a href="<?= BASE_URL ?>?act=xoa-gio-hang&san_pham_id=<?= (int) $row['product_id'] ?>" onclick="return confirm('Xóa sản phẩm khỏi giỏ?');"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Update Option -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 ml-auto">
                        <!-- Cart Calculation Area -->
                        <div class="cart-calculator-wrapper">
                            <div class="cart-calculate-items">
                                <h6>Cart Totals</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Tổng tiền sản phẩm</td>
                                            <td><?=formatPrice($tongGioHang)?></td>
                                        </tr>
                                        <tr>
                                            <td>Phí vận chuyển</td>
                                            <td>250000</td>
                                        </tr>
                                        <tr class="total">
                                            <td>Tổng thanh toán</td>
                                            <td class="total-amount">
                                                <?php
                                                $tong_tien=$tongGioHang + 250000;
                                                echo formatPrice($tong_tien);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <a href="<?=BASE_URL . '?act=thanh-toan'?>" class="btn btn-sqr d-block <?= empty($chiTietGioHang) ?'disabled' : '' ?>" <?= empty($chiTietGioHang)? 'onclick="return false;" style="pointer-events:none;opacity:0.5"' : ''  ?>>Tiến hành đặt hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart main wrapper end -->
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý nút tăng
        document.querySelectorAll('.btn-plus').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = this.closest('.input-group').querySelector('input[name="so_luong"]');
                var val = parseInt(input.value);
                if (!isNaN(val)) {
                    input.value = val + 1;
                    this.closest('form').submit();
                }
            });
        });

        // Xử lý nút giảm
        document.querySelectorAll('.btn-minus').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = this.closest('.input-group').querySelector('input[name="so_luong"]');
                var val = parseInt(input.value);
                if (!isNaN(val)) {
                    if (val > 1) {
                        input.value = val - 1;
                        this.closest('form').submit();
                    } else if (val === 1) {
                        if (confirm('Bạn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                            input.value = 0;
                            this.closest('form').submit();
                        }
                    }
                }
            });
        });
    });
</script>

<?php require_once __DIR__ . '/miniCart.php'; ?>

<?php require_once 'layout/footer.php'; ?>