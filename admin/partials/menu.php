<?php include('../configs/constants.php'); 
session_start(); 
if (empty($_SESSION['login'])){

  
      echo '<script> alert("Not logged in!");
  window.location.replace("login.php");
  </script>';
  die();
  
  }
?>
<html>
   <head>
       <title>The Craft Nest - Home Page</title>
       <link rel="stylesheet" href="css2/admin.css">
   </head>
</html>
<body>  
    <!--Menu Section starts-->
    <div class="menu text-center">
<div class="wrapper">
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="manage-admin.php">Admin</a></li>
    <li><a href="manage-category.php">Categories</a></li>
    <li><a href="manage-product.php">Products</a></li>
    <li><a href="manage-orders.php">Orders</a></li>
    <li><a href="logout.php">Log out</a></li>
  </ul>
</div>
    </div>
    <!--Menu Section ends-->