<?php

// start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';

if ($_SERVER['SERVER_NAME'] === 'localhost') {

    // LOCAL PROJECT FOLDER
    define('BASE_URL', '/TheCraftNest/');

} else {

    // Render domain root
    define('BASE_URL', '/');

}

define('SITEURL', rtrim($scheme . '://' . $host, '/') . BASE_URL);


// DATABASE CONSTANTS
if ($_SERVER['SERVER_NAME'] === 'localhost') {

    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'DB_USERNAME');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'DB_NAME');

} else {

    define('LOCALHOST', getenv('DB_HOST'));
    define('DB_USERNAME', getenv('DB_USER'));
    define('DB_PASSWORD', getenv('DB_PASS'));
    define('DB_NAME', getenv('DB_NAME'));

}

$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME, 4000)
        or die("Database connection failed");

?>