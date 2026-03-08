<?php
header('Content-Type: application/json');

$payload = json_decode(file_get_contents('php://input'), true);
$items = $payload['items'] ?? [];

if (!is_array($items)) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Invalid payload']);
  exit;
}

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

foreach ($items as $id => $qty) {
  $id  = (int)$id;
  $qty = (int)$qty;

  if ($qty > 0) {
    $_SESSION['cart'][$id]['quantity'] = $qty;
  } else {
    unset($_SESSION['cart'][$id]);
  }
}

echo json_encode(['ok' => true, 'cart' => $_SESSION['cart']]);
