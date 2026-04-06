<?php require 'views/layout/master.php' ?>

<!-- <section class="slider-area">
    <div class="slider-active slick-arrow-style slick-dot-style">
        <div class="single-slider d-flex align-items-center" 
     style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('uploads/1754805552iphone_16_pro_max_bda3030b4b.png'); 
            height: 600px; 
            background-size: cover; 
            background-position: center center; 
            background-repeat: no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="slider-content text-left">
                    <h2 class="text-white display-4 font-weight-bold animated fadeInUp">Flagship Smartphone 2026</h2>
                    <p class="text-white lead animated fadeInUp" style="animation-delay: 0.5s;">Sở hữu ngay siêu phẩm công nghệ hàng đầu với ưu đãi độc quyền tại ShopDTAA.</p>
                    <div class="slide-btn animated fadeInUp" style="animation-delay: 0.8s;">
                        <a href="?act=danh-sach-san-pham" class="btn btn-primary btn-lg mt-3 rounded-pill shadow">Khám Phá Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</section> -->

<section class="service-policy-area py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="service-policy-item d-flex align-items-center p-4 bg-white shadow-sm rounded mb-4">
                    <div class="service-icon mr-3">
                        <i class="fa fa-truck fa-2x text-primary"></i>
                    </div>
                    <div class="service-content">
                        <h5 class="mb-0">Giao hàng hỏa tốc</h5>
                        <p class="mb-0 text-muted">Miễn phí nội thành trong 2h</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="service-policy-item d-flex align-items-center p-4 bg-white shadow-sm rounded mb-4">
                    <div class="service-icon mr-3">
                        <i class="fa fa-shield fa-2x text-primary"></i>
                    </div>
                    <div class="service-content">
                        <h5 class="mb-0">Bảo hành 12 tháng</h5>
                        <p class="mb-0 text-muted">Cam kết hàng chính hãng 100%</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="service-policy-item d-flex align-items-center p-4 bg-white shadow-sm rounded mb-4">
                    <div class="service-icon mr-3">
                        <i class="fa fa-headphones fa-2x text-primary"></i>
                    </div>
                    <div class="service-content">
                        <h5 class="mb-0">Hỗ trợ 24/7</h5>
                        <p class="mb-0 text-muted">Kỹ thuật viên chuyên nghiệp</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-area py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="font-weight-bold">Sản Phẩm</h2>
            <p class="text-muted">Những mẫu điện thoại dẫn đầu xu hướng thị trường</p>
        </div>
        
        <div class="row">
            <?php foreach ($listSanPham as $sanPham) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card border rounded p-3 text-center h-100 shadow-hover">
                        <div class="product-image mb-3">
                            <a href="?act=chi-tiet-san-pham&id_san_pham=<?= $sanPham['id'] ?>">
                                <img src="<?= $sanPham['image'] ?>" alt="<?= $sanPham['name'] ?>" class="img-fluid rounded">
                            </a>
                        </div>
                        <div class="product-content">
                            <h6 class="font-weight-bold mb-2">
                                <a href="?act=chi-tiet-san-pham&id_san_pham=<?= $sanPham['id'] ?>" class="text-dark">
                                    <?= $sanPham['name'] ?>
                                </a>
                            </h6>
                            <div class="price-box mb-3">
                                <?php if ($sanPham['discount_price']) : ?>
                                    <span class="text-danger font-weight-bold"><?= number_format($sanPham['discount_price']) ?>đ</span>
                                    <del class="text-muted ml-2 small"><?= number_format($sanPham['price']) ?>đ</del>
                                <?php else : ?>
                                    <span class="text-primary font-weight-bold"><?= number_format($sanPham['price']) ?>đ</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-action">
                                <a href="?act=them-gio-hang&id_san_pham=<?= $sanPham['id'] ?>" class="btn btn-outline-primary btn-sm btn-block rounded-pill">
                                    <i class="fa fa-shopping-cart mr-1"></i> Thêm vào giỏ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- <section class="brand-area py-5 border-top">
    <div class="container">
        <div class="brand-active slick-padding-15">
            <div class="brand-item text-center">
                <img src="assets/img/brand/1.png" alt="Brand 1" class="img-fluid opacity-50 grayscale">
            </div>
            <div class="brand-item text-center">
                <img src="assets/img/brand/2.png" alt="Brand 2" class="img-fluid opacity-50 grayscale">
            </div>
            <div class="brand-item text-center">
                <img src="assets/img/brand/3.png" alt="Brand 3" class="img-fluid opacity-50 grayscale">
            </div>
            <div class="brand-item text-center">
                <img src="assets/img/brand/4.png" alt="Brand 4" class="img-fluid opacity-50 grayscale">
            </div>
            <div class="brand-item text-center">
                <img src="assets/img/brand/5.png" alt="Brand 5" class="img-fluid opacity-50 grayscale">
            </div>
        </div>
    </div>
</section> -->

<style>
    .shadow-hover {
        transition: all 0.3s ease;
    }
    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .grayscale {
        filter: grayscale(100%);
        transition: 0.3s;
    }
    .grayscale:hover {
        filter: grayscale(0%);
    }
</style>
<style>
    .slider-area {
        position: relative;
        overflow: hidden;
    }
    .slider-content h1 {
        text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
    }
    .slider-content p {
        text-shadow: 1px 1px 5px rgba(0,0,0,0.5);
    }
    /* Tùy chỉnh các nút điều hướng slide */
    .slick-prev, .slick-next {
        position: absolute;
        top: 50%;
        z-index: 5;
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        transform: translateY(-50%);
    }
    .slick-prev { left: 30px; }
    .slick-next { right: 30px; }
    .slick-prev:hover, .slick-next:hover {
        background: #007bff;
    }
</style>
<script>
    $(document).ready(function() {
        $('.hero-slider-active').slick({
            autoplay: true,
            autoplaySpeed: 5000,
            dots: true,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
            fade: true, // Hiệu ứng mờ dần (sang trọng hơn cho Corporate)
            cssEase: 'linear'
        });
    });
</script>
<?php require 'views/layout/footer.php' ?>

