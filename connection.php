<?php

if ($_SERVER['SERVER_NAME'] === 'localhost') {

    // ===== LOCAL (XAMPP) =====
    $db_host = "localhost";
    $db_user = "DB_USERNAME";
    $db_pass = "";
    $db_name = "DB_NAME";

} else {
    $db_host = getenv('DB_HOST');
    $db_user = getenv('DB_USER');
    $db_pass = getenv('DB_PASS');
    $db_name = getenv('DB_NAME');
}

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Database connection failed");
}

?>