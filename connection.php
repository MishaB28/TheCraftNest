<?php

if ($_SERVER['SERVER_NAME'] === 'localhost') {

    // LOCAL (XAMPP)
    $db_host = "DB_HOST";
    $db_user = "DB_USER";
    $db_pass = "DB_PASS";
    $db_name = "DB_NAME";

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

} else {

    // Render environment variables
    $db_host = getenv('DB_HOST');
    $db_user = getenv('DB_USER');
    $db_pass = getenv('DB_PASS');
    $db_name = getenv('DB_NAME');

    // initialize connection
    $conn = mysqli_init();

    // enable SSL using TiDB CA certificate
    mysqli_ssl_set(
        $conn,
        NULL,
        NULL,
        __DIR__ . "/configs/certs/isrgrootx1.pem",
        NULL,
        NULL
    );

    // connect securely
    mysqli_real_connect(
        $conn,
        $db_host,
        $db_user,
        $db_pass,
        $db_name,
        4000,
        NULL,
        MYSQLI_CLIENT_SSL
    );

}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>