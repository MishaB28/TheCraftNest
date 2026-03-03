<?php
//start session

    //create constants to store non repeating values
    define('BASE_URL', '/TheCraftNest/');
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    define('SITEURL', rtrim($scheme . '://' . $host, '/') . BASE_URL);

    if ($_SERVER['SERVER_NAME'] === 'localhost') {

        // Local
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

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME)
            or die("Database connection failed");
 ?>