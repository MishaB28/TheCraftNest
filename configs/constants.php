<?php
ob_start();
// start session

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';

if ($_SERVER['SERVER_NAME'] === 'localhost') {

    define('BASE_URL', '/TheCraftNest/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'DB_USERNAME');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'DB_NAME');

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

} else {

    define('BASE_URL', '/');

    define('LOCALHOST', getenv('DB_HOST'));
    define('DB_USERNAME', getenv('DB_USER'));
    define('DB_PASSWORD', getenv('DB_PASS'));
    define('DB_NAME', getenv('DB_NAME'));

    // create connection
    $conn = mysqli_init();

    mysqli_ssl_set(
        $conn,
        NULL,
        NULL,
        __DIR__ . "/certs/isrgrootx1.pem",
        NULL,
        NULL
    );

    mysqli_real_connect(
        $conn,
        LOCALHOST,
        DB_USERNAME,
        DB_PASSWORD,
        DB_NAME,
        4000,
        NULL,
        MYSQLI_CLIENT_SSL
    );
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

define('SITEURL', rtrim($scheme . '://' . $host, '/') . BASE_URL);