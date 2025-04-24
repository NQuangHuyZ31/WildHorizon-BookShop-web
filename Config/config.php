<?php

define('BASE_PATH', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . BASE_PATH, '/'));
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/WildHorizon-BookShop/views/');
define('VIEW_PATH_USER_LAYOUT', $_SERVER['DOCUMENT_ROOT'] . '/WildHorizon-BookShop/views/user/layout/');
define('BASE_URL_NAME', '/WildHorizon-BookShop');
// database
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
define("DB_PASS", '');
define("DB_NAME", 'whr_bookshop');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/WildHorizon-BookShop/Public/upload/');

define('KEY', 'wildhorizonbookshopwiburomax');

define('OTP_HASH_KEY', 'wildhorizon@@');
define('PAYMENT_KEY', 'wildhorizonpaymentVNPAY');

define('SERECT_KEY_VNPAY', 'GDOM6F49SA65N5MHQELXEOKP6VQH61I4');
define('SERECT_APP_VNPAY', 'YNFMLF2Q');
