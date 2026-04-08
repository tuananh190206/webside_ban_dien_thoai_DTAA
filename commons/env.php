<?php 

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

// URL gốc: tự suy ra từ DOCUMENT_ROOT để tránh 404 khi project nằm trong thư mục lồng nhau (vd: webise.../webside.../)
if (!defined('BASE_URL')) {
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
    $appRoot = realpath(__DIR__ . '/..');
    $basePath = '/';
    if ($docRoot && $appRoot && strpos($appRoot, $docRoot) === 0) {
        $rel = substr($appRoot, strlen($docRoot));
        $rel = str_replace('\\', '/', $rel);
        $basePath = '/' . trim($rel, '/') . '/';
    }
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (!empty($_SERVER['SERVER_PORT']) && (string) $_SERVER['SERVER_PORT'] === '443');
    $proto = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    define('BASE_URL', $proto . '://' . $host . $basePath);
    define('BASE_URL_ADMIN', $proto . '://' . $host . rtrim($basePath, '/') . '/admin/');
}

define('DB_HOST'    , 'localhost');
define('DB_PORT'    , 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME'    , 'duan1_dtaa');  // Tên database

define('PATH_ROOT'    , __DIR__ . '/../');



/** Phí vận chuyển cố định (đồng) — dùng chung giỏ hàng / thanh toán */
define('PHI_VAN_CHUYEN', 250000);
/** order_statuses.id — Hủy đơn (theo bảng order_statuses) */
define('TRANG_THAI_DON_HUY', 5);
/** order_statuses.id — Đã giao (hoàn thành), không cho hủy */
define('TRANG_THAI_DON_HOAN_THANH', 4);
/**
 * order_statuses.id — Cho phép khách hủy: Đang xử lý (1), Đã xác nhận (2). Trước khi Đang giao (3).
 */
define('TRANG_THAI_DUOC_HUY_BOI_KHACH', [1, 2]);
