<?php
// config/config.php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'topup_game');

// Application configuration
define('APP_NAME', 'TopUp Game');
define('APP_URL', 'http://localhost/web-topup-games');
define('APP_ROOT', dirname(dirname(__FILE__)));

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>