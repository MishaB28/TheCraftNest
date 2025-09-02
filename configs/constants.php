<?php
//start session

    //create constants to store non repeating values
    define('BASE_URL', '/TheCraftNest/');
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    define('SITEURL', rtrim($scheme . '://' . $host, '/') . BASE_URL);
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'USERNAME');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'DBNAME');
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn)); //DB connection
    $db_select=mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
?>
