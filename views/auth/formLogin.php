<?php require_once './views/layout/header.php'; ?>
<link rel="stylesheet" href="assets/css/client-auth.css">
<?php require_once './views/layout/menu.php'; ?>

<?php
$rememberVal = $_COOKIE['client_remember_email'] ?? '';
?>

<main class="client-auth-page">
    <div class="container">
        <div class="client-auth-card">
            <div class="client-auth-card__accent" aria-hidden="true"></div>
            <div class="client-auth-card__top">
                <a href="<?= BASE_URL ?>" class="client-auth-home-btn">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Về trang chủ
                </a>
            </div>

            <h1 class="client-auth-title">Đăng nhập</h1>
            <p class="client-auth-sub">Chào mừng bạn quay trở lại!</p>

            <?php if (!empty($_GET['registered']) && $_GET['registered'] === '1') { ?>
                <div class="client-auth-alert client-auth-alert--ok">Đăng ký thành công. Vui lòng đăng nhập.</div>
            <?php } ?>
            <?php if (!empty($_SESSION['error'])) { ?>
    <div class="client-auth-alert client-auth-alert--err">
        <?php if (is_array($_SESSION['error'])): ?>
            <?php foreach ($_SESSION['error'] as $err): ?>
                <p><?= htmlspecialchars($err) ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <?= htmlspecialchars($_SESSION['error']) ?>
        <?php endif; ?>
    </div>
<?php } ?>

            <form action="<?= BASE_URL . '?act=check-login' ?>" method="post" autocomplete="on">
                <div class="client-auth-field">
                    <label for="auth-email">Email hoặc số điện thoại</label>
                    <input id="auth-email" type="text" name="email" required autocomplete="username"
                           placeholder="your@email.com hoặc số điện thoại"
                           value="<?= htmlspecialchars($rememberVal) ?>">
                </div>
                <div class="client-auth-field">
                    <label for="auth-password">Mật khẩu</label>
                    <input id="auth-password" type="password" name="password" required autocomplete="current-password"
                           placeholder="••••••••">
                </div>
                <div class="client-auth-row">
                    <label class="client-auth-remember">
                        <input type="checkbox" name="remember" value="1" <?= $rememberVal !== '' ? ' checked' : '' ?>>
                        Ghi nhớ đăng nhập
                    </label>
                    <a href="#" class="client-auth-link" onclick="return false;" title="Liên hệ hỗ trợ">Quên mật khẩu?</a>
                </div>
                <button type="submit" class="client-auth-btn">
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                    Đăng nhập
                </button>
            </form>

            <p class="client-auth-footer">
                Chưa có tài khoản? <a href="<?= BASE_URL . '?act=dang-ky' ?>" class="client-auth-link">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</main>

<?php require_once './views/layout/footer.php'; ?>
