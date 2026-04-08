<?php require_once './views/layout/header.php'; ?>
<link rel="stylesheet" href="assets/css/client-auth.css">
<?php require_once './views/layout/menu.php'; ?>

<?php
$old = $_SESSION['old_register'] ?? [];
?>

<main class="client-auth-page">
    <div class="container">
        <div class="client-auth-card client-auth-card--wide">
            <div class="client-auth-card__accent" aria-hidden="true"></div>
            <div class="client-auth-card__top">
                <a href="<?= BASE_URL ?>" class="client-auth-home-btn">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Về trang chủ
                </a>
            </div>
            <h1 class="client-auth-title">Đăng ký tài khoản</h1>
            <p class="client-auth-sub">Tạo tài khoản để mua hàng nhanh hơn.</p>

            <?php if (isset($_SESSION['error'])) { ?>
                <div class="client-auth-alert client-auth-alert--err"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php } ?>

            <form action="<?= BASE_URL . '?act=check-register' ?>" method="post" novalidate>
                <div class="client-auth-field">
                    <label for="reg-name">Họ và tên</label>
                    <input id="reg-name" type="text" name="ho_ten" required maxlength="120"
                           placeholder="Nguyễn Văn A"
                           value="<?= htmlspecialchars($old['ho_ten'] ?? '') ?>">
                </div>
                <div class="client-auth-field">
                    <label for="reg-email">Email</label>
                    <input id="reg-email" type="email" name="email" required autocomplete="email"
                           placeholder="your@email.com"
                           value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                </div>
                <div class="client-auth-field">
                    <label for="reg-phone">Số điện thoại <span class="optional">(tùy chọn)</span></label>
                    <input id="reg-phone" type="tel" name="so_dien_thoai" autocomplete="tel"
                           placeholder="0123 456 789"
                           value="<?= htmlspecialchars($old['so_dien_thoai'] ?? '') ?>">
                </div>
                <div class="client-auth-field">
                    <label for="reg-pass">Mật khẩu</label>
                    <input id="reg-pass" type="password" name="password" required minlength="6" autocomplete="new-password"
                           placeholder="Tối thiểu 6 ký tự">
                </div>
                <div class="client-auth-field">
                    <label for="reg-pass2">Xác nhận mật khẩu</label>
                    <input id="reg-pass2" type="password" name="password_confirm" required minlength="6" autocomplete="new-password"
                           placeholder="Nhập lại mật khẩu">
                </div>

                <label class="client-auth-terms">
                    <input type="checkbox" name="dieu_khoan" value="1" required>
                    <span>Tôi đồng ý với <a href="<?= BASE_URL . '?act=gioi-thieu' ?>" class="client-auth-link">Điều khoản dịch vụ</a> và <a href="<?= BASE_URL . '?act=lien-he' ?>" class="client-auth-link">Chính sách bảo mật</a>.</span>
                </label>

                <button type="submit" class="client-auth-btn">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    Đăng ký
                </button>
            </form>

            <p class="client-auth-footer">
                Đã có tài khoản? <a href="<?= BASE_URL . '?act=login' ?>" class="client-auth-link">Đăng nhập</a>
            </p>
        </div>
    </div>
</main>

<?php require_once './views/layout/footer.php'; ?>
