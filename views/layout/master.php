<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tên Doanh Nghiệp - Giải Pháp Công Nghệ</title>
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6));
            background-size: cover;
            color: white;
            padding: 100px 0;
        }
        .service-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .service-card:hover {
            transform: translateY(-10px);
        }
        .btn-corporate {
            background-color: #0056b3;
            color: white;
            border-radius: 25px;
            padding: 10px 25px;
        }
    </style>
</head>
<body>

    <?php include 'views/layout/header.php'; ?>
    <?php include 'views/layout/menu.php'; ?>

    <main>
        <section class="slider-area">
    <div class="hero-slider-active slick-arrow-style slick-dot-style">
        
        <div class="single-slider d-flex align-items-center" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1551650975-87de79764a7e?q=80&w=1920&auto=format&fit=crop'); background-size: cover; background-position: center; height: 600px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="slider-content">
                            <h1 class="display-4 font-weight-bold text-white animated fadeInUp">Hệ Sinh Thái Công Nghệ 2026</h1>
                            <p class="lead text-white animated fadeInUp" style="animation-delay: 0.5s;">Trải nghiệm sức mạnh tuyệt đối từ những dòng Smartphone Flagship hàng đầu thế giới.</p>
                            <div class="slide-btn animated fadeInUp" style="animation-delay: 0.8s;">
                                <a href="index.php?act=danh-sach-san-pham" class="btn btn-primary btn-lg mt-3 rounded-pill shadow">Xem Bộ Sưu Tập</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
</section>

        <section class="py-5 bg-light">
            <div class="container text-center">
                <h2 class="mb-5">Dịch Vụ Của Chúng Tôi</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card service-card p-4 h-100">
                            <i class="fa fa-mobile fa-3x mb-3 text-primary"></i>
                            <h3>Phân Phối Sỉ</h3>
                            <p>Cung cấp nguồn hàng điện thoại chính hãng số lượng lớn với chiết khấu tốt nhất.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card service-card p-4 h-100">
                            <i class="fa fa-gears fa-3x mb-3 text-primary"></i>
                            <h3>Bảo Hành Doanh Nghiệp</h3>
                            <p>Chế độ bảo hành tận nơi và hỗ trợ kỹ thuật 24/7 cho các đối tác chiến lược.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card service-card p-4 h-100">
                            <i class="fa fa-rocket fa-3x mb-3 text-primary"></i>
                            <h3>Giải Pháp Quản Lý</h3>
                            <p>Tích hợp phần mềm quản lý bán hàng hiện đại giúp tối ưu hóa doanh thu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- <div class="content-wrapper">
            <?php echo $content; ?>
        </div> -->
    </main>

    

    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- <?php include 'views/layout/footer.php'; ?> -->
</body>
</html>