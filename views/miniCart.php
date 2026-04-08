<?php
if (!isset($chiTietGioHang) || !is_array($chiTietGioHang)) {
    $chiTietGioHang = [];
}
$miniCartCount = 0;
$miniCartSubtotal = 0;
foreach ($chiTietGioHang as $row) {
    $miniCartCount += (int) ($row['so_luong'] ?? 0);
    $gia = !empty($row['gia_khuyen_mai']) ? (float) $row['gia_khuyen_mai'] : (float) ($row['gia_san_pham'] ?? 0);
    $miniCartSubtotal += $gia * (int) ($row['so_luong'] ?? 0);
}
?>
<!-- offcanvas mini cart start -->
<div class="offcanvas-minicart-wrapper">
    <div class="minicart-inner">
        <div class="offcanvas-overlay"></div>
        <div class="minicart-inner-content">
            <div class="minicart-close">
                <i class="pe-7s-close"></i>
            </div>
            <div class="minicart-content-box">
                <div class="minicart-item-wrapper">
                    <ul>
                        <?php if (empty($chiTietGioHang)) : ?>
                            <li class="minicart-item">
                                <p class="text-muted">Chưa có sản phẩm trong giỏ.</p>
                            </li>
                        <?php else :
                            foreach ($chiTietGioHang as $sanPham) :
                                $donGia = !empty($sanPham['gia_khuyen_mai']) ? (float) $sanPham['gia_khuyen_mai'] : (float) $sanPham['gia_san_pham'];
                                ?>
                        <li class="minicart-item">
                            <div class="minicart-thumb">
                                <a href="<?= BASE_URL ?>?act=chi-tiet-san-pham&id_san_pham=<?= (int) $sanPham['san_pham_id'] ?>">
                                    <img src="<?= BASE_URL . htmlspecialchars($sanPham['hinh_anh']) ?>" alt="">
                                </a>
                            </div>
                            <div class="minicart-content">
                                <h3 class="product-name">
                                    <a href="<?= BASE_URL ?>?act=chi-tiet-san-pham&id_san_pham=<?= (int) $sanPham['san_pham_id'] ?>"><?= htmlspecialchars($sanPham['ten_san_pham']) ?></a>
                                </h3>
                                <p>
                                    <span class="cart-quantity"> <?= (int) $sanPham['so_luong'] ?><strong>&times;</strong></span>
                                    <span class="cart-price"><?= formatPrice($donGia) ?></span>
                                </p>
                            </div>
                            <a href="<?= BASE_URL ?>?act=xoa-gio-hang&san_pham_id=<?= (int) $sanPham['san_pham_id'] ?>" class="minicart-remove" title="Xóa"><i class="pe-7s-close"></i></a>
                        </li>
                        <?php endforeach;
                        endif; ?>
                    </ul>
                </div>

                <?php if (!empty($chiTietGioHang)) : ?>
                <div class="minicart-pricing-box border-top pt-2">
                    <p><strong>Tạm tính:</strong> <?= formatPrice($miniCartSubtotal) ?></p>
                </div>
                <?php endif; ?>

                <div class="minicart-button">
                    <a href="<?= BASE_URL ?>?act=gio-hang"><i class="fa fa-shopping-cart"></i> Xem giỏ hàng</a>
                    <a href="<?= BASE_URL ?>?act=thanh-toan"><i class="fa fa-share"></i> Thanh toán</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- offcanvas mini cart end -->
