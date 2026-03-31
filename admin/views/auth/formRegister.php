<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$loginUrl = BASE_URL_ADMIN . '?act=login-admin';
$registerUrl = BASE_URL_ADMIN . '?act=dang-ky-admin';
$errRaw = $_SESSION['error'] ?? null;
$errMsg = is_array($errRaw) ? implode(' ', $errRaw) : (string) ($errRaw ?? '');
$old = $_SESSION['old_register_admin'] ?? [];
?><!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng ký quản trị — Phone Store</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/auth-split.css">
</head>
<body class="auth-split-body">
<div class="auth-split-wrap">
  <div class="auth-split-inner">
    <aside class="auth-aside">
      <div class="auth-brand">
        <i class="fas fa-mobile-alt" aria-hidden="true"></i>
        <span>Phone Store</span>
      </div>
      <h1>Tạo tài khoản quản trị hôm nay</h1>
      <p class="auth-lead">Một tài khoản để điều hành cửa hàng điện thoại: nhanh hơn, rõ ràng hơn.</p>
      <ul class="auth-features">
        <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Quản lý sản phẩm &amp; khuyến mãi</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Theo dõi đơn hàng &amp; khách hàng</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Hỗ trợ nhanh qua tài khoản</span></li>
      </ul>
    </aside>

    <div class="auth-main">
      <div class="auth-tabs">
        <a href="<?= htmlspecialchars($loginUrl) ?>" class="auth-tab">Đăng nhập</a>
        <a href="<?= htmlspecialchars($registerUrl) ?>" class="auth-tab is-active">Đăng ký</a>
      </div>

      <h2 class="auth-title">Đăng ký tài khoản</h2>
      <p class="auth-sub">Điền thông tin bên dưới — chỉ mất khoảng một phút.</p>

      <?php if ($errMsg !== '') { ?>
        <div class="auth-alert auth-alert--danger"><?= htmlspecialchars($errMsg) ?></div>
      <?php } ?>

      <form action="<?= BASE_URL_ADMIN ?>?act=check-dang-ky-admin" method="post" novalidate>
        <div class="auth-field">
          <label for="reg-name">Họ và tên</label>
          <div class="auth-input-wrap">
            <span class="auth-input-icon"><i class="fas fa-user" aria-hidden="true"></i></span>
            <input id="reg-name" type="text" name="ho_ten" required maxlength="120" placeholder="Nguyễn Văn A"
              value="<?= htmlspecialchars($old['ho_ten'] ?? '') ?>">
          </div>
        </div>

        <div class="auth-field">
          <label for="reg-email">Email</label>
          <div class="auth-input-wrap">
            <span class="auth-input-icon"><i class="fas fa-envelope" aria-hidden="true"></i></span>
            <input id="reg-email" type="email" name="email" autocomplete="email" required placeholder="your@email.com"
              value="<?= htmlspecialchars($old['email'] ?? '') ?>">
          </div>
        </div>

        <div class="auth-field">
          <label for="reg-phone">Số điện thoại</label>
          <div class="auth-input-wrap">
            <span class="auth-input-icon"><i class="fas fa-phone" aria-hidden="true"></i></span>
            <input id="reg-phone" type="tel" name="so_dien_thoai" autocomplete="tel" required placeholder="0123 456 789"
              value="<?= htmlspecialchars($old['so_dien_thoai'] ?? '') ?>">
          </div>
        </div>

        <div class="auth-row-2">
          <div class="auth-field">
            <label for="reg-pass">Mật khẩu</label>
            <div class="auth-input-wrap">
              <span class="auth-input-icon"><i class="fas fa-lock" aria-hidden="true"></i></span>
              <input id="reg-pass" type="password" name="password" autocomplete="new-password" required minlength="6" placeholder="Tối thiểu 6 ký tự">
            </div>
          </div>
          <div class="auth-field">
            <label for="reg-pass2">Xác nhận mật khẩu</label>
            <div class="auth-input-wrap">
              <span class="auth-input-icon"><i class="fas fa-lock" aria-hidden="true"></i></span>
              <input id="reg-pass2" type="password" name="password_confirm" autocomplete="new-password" required placeholder="Nhập lại mật khẩu">
            </div>
          </div>
        </div>

        <button type="submit" class="auth-submit">
          <i class="fas fa-user-plus" aria-hidden="true"></i>
          Đăng ký
        </button>
      </form>

      <p class="auth-footer-link">
        Đã có tài khoản? <a href="<?= htmlspecialchars($loginUrl) ?>">Đăng nhập</a>
      </p>
    </div>
  </div>
</div>
</body>
</html>
