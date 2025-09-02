<?php
ob_start();
include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/../config.cashfree.php';

$orderId = $_GET['order_id'] ?? '';
if ($orderId === '') {
  echo "<center><h2>Missing order_id</h2></center>";
  include __DIR__ . '/../partials-front/footer.php';
  ob_end_flush();
  exit;
}

// Verify payment with Cashfree
$ch = curl_init(CF_BASE . "/orders/" . urlencode($orderId));
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER     => [
    "x-api-version: 2025-01-01",
    "x-client-id: " . CF_APP_ID,
    "x-client-secret: " . CF_SECRET_KEY
  ]
]);
$res  = curl_exec($ch);
$err  = curl_error($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo '<center><br><br><br>';

if ($err || $code >= 400) {
  echo "<h1 class='heading'>We couldn't verify the payment right now.</h1>";
  echo "<pre style='text-align:left;max-width:800px;overflow:auto;padding:12px;border:1px solid #eee;border-radius:8px;'>"
       . htmlspecialchars($res ?: $err) . "</pre>";
  echo '</center>';
  include __DIR__ . '/../partials-front/footer.php';
  ob_end_flush();
  exit;
}

$data   = json_decode($res, true);
$status = $data['order_status'] ?? '';
$paidAmount = $data['order_amount'] ?? 0;

if ($status === 'PAID') {
  // Compute total from session cart
  $total = 0;
  $cart  = $_SESSION['cart'] ?? [];
  foreach ($cart as $pid => $val) {
    $pid = (int)$pid;
    $rs  = mysqli_query($conn, "SELECT price FROM product WHERE id = $pid");
    if ($row = mysqli_fetch_assoc($rs)) {
      $total += ((float)$row['price'] * (int)$val['quantity']);
    }
  }

  // Optional: compare paid amount vs computed total
  // if ((float)$paidAmount != (float)$total) { /* flag mismatch */ }

  // Insert order + items (moved from checkout.php)
  $custid = $_SESSION['custid'] ?? 0;
  $insOrder = "INSERT INTO orders (custid, totalprice, orderstatus)
             VALUES ('".$custid."', '".$total."', 'Order Placed')";

  if (mysqli_query($conn, $insOrder)) {
    $orderDbId = mysqli_insert_id($conn);

    foreach ($cart as $pid => $val) {
      $pid = (int)$pid;
      $q   = (int)$val['quantity'];
      $rs  = mysqli_query($conn, "SELECT price FROM product WHERE id = $pid");
      if ($row = mysqli_fetch_assoc($rs)) {
        $p = (float)$row['price'];
        mysqli_query(
          $conn,
          "INSERT INTO orderitems (productid, quantity, orderid, productprice)
           VALUES ('".$pid."', '".$q."', '".$orderDbId."', '".$p."')"
        );
      }
    }
    unset($_SESSION['cart']); // clear cart
  }

  echo '<h1 class="heading">Payment Successful!</h1>';
  echo '<h4>Your order has been placed. Check your email for details.</h4>';
  echo '<h4 class="billing">Thank you for purchasing from our store! 😉</h4>';

} else {
  echo '<h1 class="heading">Payment not completed</h1>';
  echo '<pre style="text-align:left;max-width:800px;overflow:auto;padding:12px;border:1px solid #eee;border-radius:8px;">'
       . htmlspecialchars($res) . '</pre>';
}

echo '</center>';

include __DIR__ . '/../partials-front/footer.php';
ob_end_flush();
