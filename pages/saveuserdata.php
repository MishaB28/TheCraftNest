<?php
session_start();
require_once __DIR__ . '/../connection.php';

$custid = $_SESSION['custid'] ?? 0;
$response = ['success'=>false];

if ($custid && !empty($_POST['name']) && !empty($_POST['address'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $postcode = $_POST['postcode'];
    $phone = $_POST['phone'];

    $check_sql = "SELECT * FROM user_data WHERE custid = $custid";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) == 1) {
        $update_sql = "UPDATE user_data SET
            name='$name',
            address='$address',
            state='$state',
            country='$country',
            postcode='$postcode',
            phone='$phone'
            WHERE custid=$custid";
        mysqli_query($conn, $update_sql);
    } else {
        $insert_sql = "INSERT INTO user_data (custid,name,address,state,country,postcode,phone)
            VALUES ('$custid','$name','$address','$state','$country','$postcode','$phone')";
        mysqli_query($conn, $insert_sql);
    }

    $response['success'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
exit;