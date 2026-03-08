<?php
$appId = getenv("CF_APP_ID");
$secretKey = getenv("CF_SECRET_KEY");

$url = "https://sandbox.cashfree.com/pg/orders";

$data = [
    "order_id" => "order_" . time(),
    "order_amount" => $_POST['amount'],
    "order_currency" => "INR",
    "customer_details" => [
        "customer_id" => "cust_" . time(),
        "customer_name" => $_POST['name'],
        "customer_email" => $_POST['email'],
        "customer_phone" => $_POST['phone']
    ],
    "order_meta" => [
       "return_url" => SITEURL . "pages/thankyou.php?order_id={order_id}"
    ]
];

$payload = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "x-client-id: $appId",
    "x-client-secret: $secretKey",
    "x-api-version: 2022-09-01"
]);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

$response = curl_exec($ch);
if ($response === false) {
    echo json_encode(["error" => curl_error($ch)]);
    exit;
}
curl_close($ch);

// Return JSON to frontend
header('Content-Type: application/json');
echo $response;
