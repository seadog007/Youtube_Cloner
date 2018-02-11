<?php
session_start();

define('FB_API', '');
define('FB_SECRET', '');
define('FB_PAGE', '');

define('DB_HOST', '');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_TIMEZONE', 'Asia/Taipei');

$connection_string = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
$db = new PDO($connection_string, DB_USER, DB_PASS);

