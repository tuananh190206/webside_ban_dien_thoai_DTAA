<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>

<main>
    


    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <?php if (isset($_SESSION['flash_loi_gio_hang'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Lỗi: </strong> <?= $_SESSION['flash_loi_gio_hang']; ?>
                <?php unset($_SESSION['flash_loi_gio_hang']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="shop-main-wrapper section-padding pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider">
                                    <?php foreach ($listAnhSanPham as $anhSanPham): ?>
                                        <div class="pro-large-img img-zoom">
                                            <img src="<?= BASE_URL . $anhSanPham['image_url'] ?>" alt="product-details" />
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="pro-nav slick-row-10 slick-arrow-style">
                                    <?php foreach ($listAnhSanPham as $anhSanPham): ?>
                                        <div class="pro-nav-thumb">
                                            <img src="<?= BASE_URL . $anhSanPham['image_url'] ?>" alt="product-details">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des">
                                    <div class="manufacturer-name">
                                        <a href="#" style="color: #333; font-weight: bold; font-size: 24px;">Danh mục: <?= $sanPham['category_name'] ?></a>
                                    </div>
                                    <h3 class="product-name"><?= $sanPham['name'] ?></h3>
                                    
                                    <div class="ratings d-flex">
                                        <div class="pro-review">
                                            <?php $countComment = count($listBinhLuan); ?>
                                            <span><?= $countComment . ' bình luận' ?></span>
                                        </div>
                                    </div>

                                    <div class="product-variant">
                                            <h3 class="price">
                                                <span id="variant-price"><?= number_format($variants[0]['discount_price']) ?> đ</span>
                                            </h3>
                                                <p>Chọn dung lượng & màu sắc:</p>
                                                <div class="variant-list" style="display: flex; gap: 10px;">
                                                    <?php foreach ($variants as $key => $variant): ?>
                                                        <label class="variant-option">
                                                            <input type="radio" name="product_variant_id" 
                                                                value="<?= $variant['id'] ?>" 
                                                                data-price="<?= number_format($variant['price']) ?> đ"
                                                                data-image="<?= $variant['image'] ?>"
                                                                <?= $key == 0 ? 'checked' : '' ?>
                                                                class="variant-input">
                                                            <span class="variant-label">
                                                                <?= $variant['capacity'] ?> - <?= $variant['color'] ?>
                                                            </span>
                                                        </label>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                    <!-- <div class="price-box">
                                        <?php if ($sanPham['discount_price']) : ?>
                                            <span class="price-regular"><?= formatPrice($sanPham['discount_price']) . ' VNĐ'; ?></span>
                                            <span class="price-old"><del><?= formatPrice($sanPham['price']) . ' VNĐ'; ?></del></span>
                                        <?php else : ?>
                                            <span class="price-regular"><?= formatPrice($sanPham['price']) . ' VNĐ'; ?></span>
                                        <?php endif; ?>
                                    </div> -->

                                    <div class="availability">
                                        <i class="fa <?= $sanPham['quantity'] > 0 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' ?>"></i>
                                        <span class="<?= $sanPham['quantity'] > 0 ? '' : 'text-danger fw-bold' ?>">
                                            <?= $sanPham['quantity'] > 0 ? ($sanPham['quantity'] . ' sản phẩm trong kho') : 'Hết hàng' ?>
                                        </span>
                                    </div>

                                    <p class="pro-desc"><?= $sanPham['description'] ?></p>

                                    <form action="<?= BASE_URL . '?act=them-gio-hang' ?>" method="POST">
                                        <div class="quantity-cart-box d-flex align-items-center">
                                            <h6 class="option-title">Số lượng:</h6>
                                            <div class="quantity">
                                                <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                                                <div class="pro-qty">
                                                    <input type="text" value="<?= $sanPham['quantity'] > 0 ? 1 : 0 ?>" name="so_luong">
                                                </div>
                                            </div>
                                            <div class="action_link">
                                                <?php if ($sanPham['quantity'] > 0) : ?>
                                                    <button class="btn btn-cart2" type="submit">Thêm vào giỏ hàng</button>
                                                <?php else : ?>
                                                    <button class="btn btn-cart2 bg-secondary border-secondary" type="button" disabled>Hết hàng</button>
                                                <?php endif; ?>
                                                <a href="<?= BASE_URL ?>" class="btn btn-cart2 bg-dark border-dark ml-2">Quay lại</a>
                                            </div>
                                        </div>
                                        
                                        <?php if ($sanPham['quantity'] <= 0) : ?>
                                            <p class="text-danger mt-2"><i>* Sản phẩm này hiện đã hết hàng, vui lòng quay lại sau.</i></p>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-details-reviews section-padding pb-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-review-info">
                                    <ul class="nav review-tab">
                                        <li>
                                            <a class="active" data-bs-toggle="tab" href="#tab_three">Bình luận (<?= $countComment ?>)</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content reviews-tab">
                                        <div class="tab-pane fade show active" id="tab_three">
                                            <?php foreach ($listBinhLuan as $binhLuan): ?>
                                                <div class="total-reviews">
                                                    <div class="rev-avatar">
                                                        <img src="<?= $binhLuan['avatar'] ?>" alt="Avatar">
                                                    </div>
                                                    <div class="review-box">
                                                        <div class="post-author">
                                                            <p><span><?= $binhLuan['full_name'] ?? 'Khách hàng' ?> - </span><?= $binhLuan['content'] ?></p>
                                                        </div>
                                                        <p><?= $binhLuan['content'] ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            
                                            <form action="#" class="review-form">
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span> Bình luận của bạn</label>
                                                        <textarea class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="buttons">
                                                    <button class="btn btn-sqr" type="submit">Gửi bình luận</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="related-products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm liên quan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                        <?php foreach ($listSanPhamCungDanhMuc as $spLienQuan): ?>
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $spLienQuan['id']; ?>">
                                        <img class="pri-img" src="<?= $spLienQuan['image'] ?>" alt="product">
                                        <img class="sec-img" src="<?= $spLienQuan['image'] ?>" alt="product">
                                    </a>
                                    <div class="cart-hover">
                                        <button class="btn btn-cart">Xem chi tiết</button>
                                    </div>
                                </figure>
                                <div class="product-caption text-center">
                                    <h6 class="product-name">
                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $spLienQuan['id']; ?>"><?= $spLienQuan['name'] ?></a>
                                    </h6>
                                    <div class="price-box">
                                        <span class="price-regular"><?= formatPrice($spLienQuan['discount_price'] ?: $spLienQuan['price']) ?> VNĐ</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy tất cả các radio button của biến thể
        const variantInputs = document.querySelectorAll('.variant-input');
        const priceDisplay = document.getElementById('variant-price');

        variantInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Lấy giá từ attribute data-price
                const newPrice = this.getAttribute('data-price');
                // Cập nhật lên màn hình
                priceDisplay.innerText = newPrice + ' đ';
                
                console.log("Đã chọn biến thể ID:", this.value);
            });
        });
    });
</script>
<style>
.variant-option {
    cursor: pointer;
}
.variant-input {
    display: none; /* Ẩn nút tròn radio mặc định */
}
.variant-label {
    display: inline-block;
    padding: 8px 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: all 0.3s;
}
/* Khi được chọn sẽ đổi màu */
.variant-input:checked + .variant-label {
    border-color: #ff2d20;
    color: #ff2d20;
    background-color: #fff5f5;
    font-weight: bold;
}
</style>
<?php require_once 'layout/footer.php'; ?>