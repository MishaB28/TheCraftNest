<?php
 include __DIR__ . '/../configs/constants.php';
 session_start();

 if(isset($_GET['id'])){
     $id = $_GET['id'];
     unset($_SESSION['cart'][$id]);
     header('Location: ' . SITEURL . 'pages/cart.php');

 }

 ?>