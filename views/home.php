<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>

<div class="product-area section-padding">
    <div class="container">
        <div class="row">
            <?php foreach ($listSanPham as $sanPham): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="product-thumb">
                            <a href="?act=chi-tiet-san-pham&id=<?= $sanPham['id'] ?>">
                                <img src="<?= BASE_URL . $sanPham['image'] ?>" alt="Sản phẩm">
                            </a>
                        </div>
                        <div class="product-content">
                            <h6><a href="?act=chi-tiet-san-pham&id=<?= $sanPham['id'] ?>"><?= $sanPham['name'] ?></a></h6>
                            <div class="price-box">
                                <span class="price-old"><?= number_format($sanPham['price'], 0, ',', '.') ?> VNĐ</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once 'layout/footer.php'; ?>