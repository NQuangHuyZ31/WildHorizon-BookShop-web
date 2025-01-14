<?php

define('BASE_PATH', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . BASE_PATH, '/'));
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/WildHorizon/views/');
// database
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
define("DB_PASS", '');
define("DB_NAME", 'bookshop');
define('BASE_URL_NAME','/WildHorizon');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/WildHorizon/Public/upload/');