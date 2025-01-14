<?php

define('BASE_PATH', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . BASE_PATH, '/'));
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/WildHorizon-BookShop/views/');
define('BASE_URL_NAME','/WildHorizon-BookShop');
// database
define("DB_HOST", 'localhost');
define("DB_USER", 'hieu');
define("DB_PASS", '123456');
define("DB_NAME", 'hnshop-main');