<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'biblioteka');

// View Root
define('VIEWROOT', APPROOT . '/views');

// URL Root
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$script = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . '://' . $host . $script);

define('SITENAME', 'System Biblioteczny');

define('APPVERSION', '1.0.0');

define('DEBUG_MODE', true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', APPROOT . '/logs/error.log');

session_start(); 