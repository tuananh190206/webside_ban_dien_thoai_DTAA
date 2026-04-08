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
                                    foreach ($chiTietGioHang as $key => $sanPham): 
                                        ?>
                                        <tr>
                                            <td class="pro-thumbnail"><a href="<?= BASE_URL ?>?act=chi-tiet-san-pham&id_san_pham=<?= (int) $sanPham['san_pham_id'] ?>"><img class="img-fluid"
                                                        src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="Product" /></a></td>
                                            <td class="pro-title"><a href="<?= BASE_URL ?>?act=chi-tiet-san-pham&id_san_pham=<?= (int) $sanPham['san_pham_id'] ?>"><?= htmlspecialchars($sanPham['ten_san_pham']) ?></a></td>
                                            <td class="pro-price"><span>
                                                    <?php if ($sanPham['gia_khuyen_mai']) { ?>
                                                        <?= formatPrice($sanPham['gia_khuyen_mai']) ?>
                                                    <?php }else{ ?>
                                                        <?= formatPrice($sanPham['gia_san_pham']) ?>
                                                    <?php }?>    
                                                </span></td>
                                                <?php 
                                                 $tonMax = max(0, (int) ($sanPham['ton_kho_san_pham'] ?? 0));
                                                 $slHienTai = (int) $sanPham['so_luong'];
                                                 $gioiHanTang = max($tonMax, $slHienTai);
                                                  ?>
                                            <td class="pro-quantity">
                                                <form action="<?= BASE_URL ?>?act=cap-nhat-gio-hang" method="post" class="cart-qty-form m-0">
                                                    <input type="hidden" name="san_pham_id" value="<?= (int) $sanPham['san_pham_id'] ?>">
                                                    <div class="pro-qty">
                                                        <input type="text" name="so_luong" value="<?= $slHienTai ?>" class="qty-input">
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="pro-subtotal"><span>
                                                        <?php
                                                        if($sanPham['gia_khuyen_mai']) {
                                                           $tong_tien=$sanPham['gia_khuyen_mai'] * $sanPham['so_luong'];
                                                        } else {
                                                            $tong_tien=$sanPham['gia_san_pham'] * $sanPham['so_luong'];
                                                        }
                                                          $tongGioHang += $tong_tien;
                                                         echo formatPrice($tong_tien);
                                                        ?>
                                            </span></td>
                                            <td class="pro-remove"><a href="<?= BASE_URL ?>?act=xoa-gio-hang&san_pham_id=<?= (int) $sanPham['san_pham_id'] ?>" onclick="return confirm('Xóa sản phẩm khỏi giỏ?');"><i class="fa fa-trash-o"></i></a></td>
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
                                            <td>Tổng tiền sản phâm</td>
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
    (function() {
        // Chờ template main.js xử lý thêm các nút +/- xong
        setTimeout(function() {
            var forms = document.querySelectorAll('.cart-qty-form');
            forms.forEach(function(form) {
                var input = form.querySelector('.qty-input');
                var buttons = form.querySelectorAll('.qtybtn');

                // Khi click nút +/- của template
                buttons.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        // Delay một chút để main.js cập nhật xong value của input
                        setTimeout(function() {
                            form.submit();
                        }, 100);
                    });
                });

                // Khi thay đổi trực tiếp trong input
                input.addEventListener('change', function() {
                    form.submit();
                });
            });
        }, 500);
    })();
</script>

<?php require_once __DIR__ . '/miniCart.php'; ?>

<?php require_once 'layout/footer.php'; ?>