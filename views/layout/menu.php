<!-- Start Header Area -->
<header class="header-area header-wide">


    <!-- header middle area start -->
    <div class="header-main-area sticky">
        <div class="container">
            <div class="row align-items-center position-relative">

                <!-- start logo area -->
                <div class="col-lg-2">
                    <div class="logo">
                        <a href="index.html">
                            <img src="assets/img/logo/LOGO.png" alt="Brand Logo">
                        </a>
                    </div>
                </div>
                <!-- start logo area -->

                <!-- main menu area start -->
                <div class="col-lg-6 position-static">
                    <div class="main-menu-area">
                        <div class="main-menu">
                            <!-- main menu navbar start -->
                            <nav class="desktop-menu">
                                <ul>
                                    <li><a href="index.html">Trang chủ</a>

                                    </li>

                                    <li><a href="#">Sản phẩm <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="blog-left-sidebar.html">blog left sidebar</a></li>
                                            <li><a href="blog-list-left-sidebar.html">blog list left sidebar</a></li>
                                            <li><a href="blog-right-sidebar.html">blog right sidebar</a></li>
                                            <li><a href="blog-list-right-sidebar.html">blog list right sidebar</a></li>
                                            <li><a href="blog-grid-full-width.html">blog grid full width</a></li>
                                            <li><a href="blog-details.html">blog details</a></li>
                                            <li><a href="blog-details-left-sidebar.html">blog details left sidebar</a>
                                            </li>
                                            <li><a href="blog-details-audio.html">blog details audio</a></li>
                                            <li><a href="blog-details-video.html">blog details video</a></li>
                                            <li><a href="blog-details-image.html">blog details image</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Giới thiệu</a></li>
                                    <li><a href="#">Liên lệ</a></li>
                                </ul>
                            </nav>
                            <!-- main menu navbar end -->
                        </div>
                    </div>
                </div>
                <!-- main menu area end -->

                <!-- mini cart area start -->
                <div class="col-lg-4">
                    <div
                        class="header-right d-flex align-items-center justify-content-xl-between justify-content-lg-end">
                        <div class="header-search-container">
                            <button class="search-trigger d-xl-none d-lg-block"><i class="pe-7s-search"></i></button>
                            <form class="header-search-box d-lg-none d-xl-block">
                                <input type="text" placeholder="Nhập tên sản phẩm" class="header-search-field">
                                <button class="header-search-btn"><i class="pe-7s-search"></i></button>
                            </form>
                        </div>
                        <div class="header-configure-area">
                            <ul class="nav justify-content-end">
                                <label for="">
                                    <?php
                                    if (isset($_SESSION['user_client']['email'])) {
                                        echo $_SESSION['user_client']['email'];
                                    } ?>
                                </label>
                                </label>
                                <li class="user-hover">
                                    <a href="#">
                                        <i class="pe-7s-user"></i>
                                    </a>
                                    <ul class="dropdown-list">
                                        <?php
                                        if (!isset($_SESSION['user_client']['email'])) { ?>
                                            <li><a href="<?= BASE_URL . '?act=login' ?>">Đăng nhập</a></li>
                                        <?php } else { ?>
                                            <li><a href="my-account.html">Tài khoản</a></li>
                                            <li><a href="<?= BASE_URL . '?act=lich-su-mua-hang' ?>">Đơn hàng</a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li>
                                    <a href="wishlist.html">
                                        <i class="pe-7s-like"></i>
                                        <div class="notification">0</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="minicart-btn">
                                        <i class="pe-7s-shopbag"></i>
                                        <div class="notification">2</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- mini cart area end -->

            </div>
        </div>
    </div>
    <!-- header middle area end -->
    </div>
    <!-- main header start -->


</header>
<!-- end Header Area -->