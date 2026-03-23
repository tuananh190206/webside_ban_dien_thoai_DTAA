<?php 

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

define('BASE_URL'       , 'http://localhost/shop-thu-cung/shop_thu_cung/'); // Đường dẫn gốc của ứng dụng

//đường dẫn vào đường admin
define('BASE_URL_ADMIN'       , 'http://localhost/shop-thu-cung/shop_thu_cung/admin/');

define('DB_HOST'    , 'localhost');
define('DB_PORT'    , 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME'    , 'shop_thu_cung');  // Tên database

define('PATH_ROOT'    , __DIR__ . '/../');
