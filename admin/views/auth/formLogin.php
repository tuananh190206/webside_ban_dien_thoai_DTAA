<?php
// Kiểm tra session nếu chưa có mới khởi tạo (thường index.php đã làm việc này)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loginUrl    = BASE_URL_ADMIN . '?act=login-admin';
$registerUrl = BASE_URL_ADMIN . '?act=dang-ky-admin';

// Lấy thông báo lỗi từ Session (do Controller gửi sang)
$errMsg = $_SESSION['error'] ?? null;
// Xóa lỗi ngay sau khi lấy ra để không hiện lại khi F5
unset($_SESSION['error']); 

$registeredOk = isset($_GET['registered']) && $_GET['registered'] === '1';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng nhập quản trị — Phone Store</title>
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
      <h1>Đăng nhập khu vực quản trị</h1>
      <p class="auth-lead">Truy cập an toàn để quản lý sản phẩm, đơn hàng và hỗ trợ khách hàng.</p>
      <ul class="auth-features">
        <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Bảo mật phiên đăng nhập</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Quản lý đơn &amp; kho nhanh chóng</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Hỗ trợ vận hành 24/7</span></li>
      </ul>
    </aside>

    <div class="auth-main">
      <div class="auth-tabs">
        <a href="<?= htmlspecialchars($loginUrl) ?>" class="auth-tab is-active">Đăng nhập</a>
        <a href="<?= htmlspecialchars($registerUrl) ?>" class="auth-tab">Đăng ký</a>
      </div>

      <h2 class="auth-title">Đăng nhập tài khoản</h2>
      <p class="auth-sub">Nhập email quản trị để tiếp tục công việc.</p>

      <?php if ($registeredOk): ?>
        <div class="auth-alert auth-alert--success" style="color: green; margin-bottom: 15px;">
             Đăng ký thành công. Vui lòng đăng nhập.
        </div>
      <?php endif; ?>

      <?php if ($errMsg): ?>
        <div class="auth-alert auth-alert--danger" style="color: red; margin-bottom: 15px;">
            <?= htmlspecialchars($errMsg) ?>
        </div>
      <?php endif; ?>

      <form action="<?= BASE_URL_ADMIN ?>?act=check-login-admin" method="post" autocomplete="off">
        <div class="auth-field">
          <label for="login-email">Email quản trị</label>
          <div class="auth-input-wrap">
            <span class="auth-input-icon"><i class="fas fa-user" aria-hidden="true"></i></span>
            <input id="login-email" type="email" name="email" required 
                   placeholder="admin@example.com"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>
        </div>
        <div class="auth-field">
          <label for="login-password">Mật khẩu</label>
          <div class="auth-input-wrap">
            <span class="auth-input-icon"><i class="fas fa-lock" aria-hidden="true"></i></span>
            <input id="login-password" type="password" name="password" required 
                   placeholder="Nhập mật khẩu">
          </div>
        </div>
        <button type="submit" class="auth-submit" style="cursor: pointer;">
          <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
          Đăng nhập hệ thống
        </button>
      </form>

      <p class="auth-footer-link">
        Quên mật khẩu? Vui lòng liên hệ quản trị viên cấp cao.
      </p>
    </div>
  </div>
</div>
</body>
</html>