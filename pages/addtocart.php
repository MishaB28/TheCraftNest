<?php
include('../configs/constants.php');
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

    // If already in cart, increase quantity
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = array('quantity' => $quantity);
    }

    $redirect = $_SERVER['HTTP_REFERER'] ?? SITEURL;
    header('Location: ' . $redirect);
    exit;
}
?>
