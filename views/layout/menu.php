<!-- Start Header Area -->
<?php
$soLuongGioHangHeader = 0;
if (isset($chiTietGioHang) && is_array($chiTietGioHang)) {
    foreach ($chiTietGioHang as $r) {
        $soLuongGioHangHeader += (int) ($r['so_luong'] ?? 0);
    }
}
$showClientAuthPills = !isset($_SESSION['user_client']['email']) && !isset($_SESSION['user_admin']);
$showAdminStorefrontMenu = isset($_SESSION['user_admin']) && !isset($_SESSION['user_client']['email']);
$headerUserEmail = $_SESSION['user_client']['email'] ?? ($_SESSION['user_admin']['email'] ?? '');
?>
<header class="header-area header-wide">


    <!-- header middle area start -->
    <div class="header-main-area sticky">
        <div class="container">
            <div class="row align-items-center position-relative">

                <!-- start logo area -->
                <div class="col-lg-2">
                    <div class="logo">

                        <a href="<?= BASE_URL ?>">
                            <img src="assets/img/logo/image.png" alt="Brand Logo">
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

                                    <li><a href="<?= BASE_URL . '?act=/' ?>">Trang chủ</a>

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
                                    <li><a href="<?= BASE_URL . '?act=gioi-thieu' ?>">Giới thiệu</a></li>
                                    <li><a href="<?= BASE_URL . '?act=lien-he' ?>">Liên lệ</a></li>
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
                            <ul class="nav justify-content-end align-items-center flex-nowrap client-header-toolbar">
                                <?php if ($showClientAuthPills) { ?>
                                <li class="d-none d-sm-flex align-items-center client-header-auth-pills flex-shrink-0">
                                    <a class="client-pill-login" href="<?= BASE_URL . '?act=login' ?>"><i class="fa fa-user" aria-hidden="true"></i> <span class="label">Đăng nhập</span></a>
                                    <a class="client-pill-register" href="<?= BASE_URL . '?act=dang-ky' ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="label">Đăng ký</span></a>
                                </li>
                                <?php } ?>
                                <?php if ($headerUserEmail !== '') { ?>
                                <li class="mr-2 d-none d-md-block">
                                    <span class="small text-muted text-truncate d-inline-block" style="max-width:140px;"><?= htmlspecialchars($headerUserEmail) ?></span>
                                </li>
                                <?php } ?>
                                <?php if (isset($_SESSION['user_client']['email'])) { ?>
                                <li class="user-hover">
                                    <a href="#" aria-label="Tài khoản">
                                        <i class="pe-7s-user"></i>
                                    </a>
                                    <ul class="dropdown-list dropdown-list--account">
                                        <?php if (isset($_SESSION['user_admin'])) { ?>
                                        <li><a class="dropdown-user-link" href="<?= BASE_URL_ADMIN ?>"><i class="fa fa-shield dropdown-account-icon" aria-hidden="true"></i><span>Quản trị</span></a></li>
                                        <?php } ?>
                                        <li><a class="dropdown-user-link" href="<?= BASE_URL ?>?act=tai-khoan"><i class="fa fa-user-circle dropdown-account-icon" aria-hidden="true"></i><span>Tài khoản khách hàng</span></a></li>
                                        <li><a class="dropdown-user-link" href="<?= BASE_URL . '?act=lich-su-mua-hang' ?>"><i class="fa fa-list-alt dropdown-account-icon" aria-hidden="true"></i><span>Đơn hàng của tôi</span></a></li>
                                        <li><a class="dropdown-user-link" href="<?= BASE_URL ?>?act=dang-xuat"><i class="fa fa-sign-out dropdown-account-icon" aria-hidden="true"></i><span>Đăng xuất</span></a></li>
                                    </ul>
                                </li>
                                <?php } elseif ($showAdminStorefrontMenu) { ?>
                                <li class="user-hover">
                                    <a href="#" aria-label="Quản trị viên">
                                        <i class="pe-7s-user"></i>
                                    </a>
                                    <ul class="dropdown-list dropdown-list--account">
                                        <li><a class="dropdown-user-link" href="<?= BASE_URL_ADMIN ?>"><i class="fa fa-shield dropdown-account-icon" aria-hidden="true"></i><span>Quản trị</span></a></li>
                                        <li><a class="dropdown-user-link" href="<?= BASE_URL_ADMIN ?>?act=logout-admin"><i class="fa fa-sign-out dropdown-account-icon" aria-hidden="true"></i><span>Đăng xuất</span></a></li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <li>
                                    <a href="wishlist.html">
                                        <i class="pe-7s-like"></i>
                                        <div class="notification">0</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= BASE_URL ?>?act=gio-hang" class="minicart-btn" title="Giỏ hàng">
                                        <i class="pe-7s-shopbag"></i>
                                        <div class="notification"><?= $soLuongGioHangHeader > 0 ? (int) $soLuongGioHangHeader : '0' ?></div>
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