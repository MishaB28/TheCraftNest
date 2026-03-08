<?php
require_once __DIR__ . '/../configs/constants.php';
require_once __DIR__ . '/../connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Craft Nest</title>
  <link rel="shortcut icon" href="<?= BASE_URL ?>images/Logo.png" />
  <link href="<?= BASE_URL ?>css/style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/menu.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/footer.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/home.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/singleprod.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/contact.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/cart.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/checkout.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Neucha&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <nav class="navbar">
    <div class="nav">
      <img src="<?= BASE_URL ?>images/Logo.png" class="brand-logo" alt="">
      <div class="nav-items">
        <form action="<?= BASE_URL ?>pages/product-search.php" method="POST">
          <div class="search">
            <input type="search" name="search" class="search-box" placeholder="Search..." required autocomplete="off">
            <input type="submit" name="submit" class="search-btn" value="Search!">
          </div>
        </form>
        <a href="<?= BASE_URL ?>pages/myaccount.php"><img src="<?= BASE_URL ?>images/user.png" alt=""></a>
        <div class="dropdown"><a href="<?= BASE_URL ?>pages/cart.php" class="cart"><img src="<?= BASE_URL ?>images/cart.png" alt="">
            <?php
            if (isset($_SESSION['cart'])) {
              $count = count($_SESSION['cart']);
            } else {
              $count = 0;
            }
            ?>
            <span class="itemcount"> <?php echo $count; ?></span>
          </a>
          <div class="dropdown-content">
            <h2 class="title-cart">Your cart items:</h2>
            <?php
            if (isset($_SESSION['cart'])) {
              $total = 0;
              $totalitems = 0;
              foreach ($_SESSION['cart'] as $key => $value) {
                // echo $key ." : ". $value['quantity'] . "<br>";
                $sql = "SELECT * FROM product where id = $key";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result)
            ?>
                <div class="cart-info-menu">
                  <img src="<?= BASE_URL ?>images/product/<?php echo $row['image_name']; ?>" height="80px" />
                  <div class="title-menu">
                    <a href="<?= BASE_URL ?>pages/singleproduct.php?id=<?php echo $row['id'] ?>"><?php echo $row['title'] ?></a>
                    <div class="price-menu">₹ <?php echo $row['price'] ?></div>
                    <div class="quantity-menu">Quantity: <?php echo $value['quantity'] ?>
                    </div>
                  </div>
                <?php
                $total = $total +  ($row['price'] * $value['quantity']);
                $totalitems = $totalitems + $value['quantity'];
              }
                ?>
                <div class="checkout-menu">
                  <div class="total-menu">
                    <div>
                      <div class="Subtotal-menu">Total Amount:</div>
                    </div>
                    <div class="total-amount-menu">₹ <?php echo $total; ?>.00</div>
                  </div>
                </div>
                <a href="<?= BASE_URL ?>pages/cart.php"> <button class="button-menu">View Cart</button></a>
                </div>
              <?php
            } else {
              echo ("No items in your cart.");
            }
              ?>
          </div>
        </div>
      </div>
    </div>
    </div>
  </nav>
  <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  ?>
    <div class="links">
      <ul class="links-container">
        <li class="link-item"><a href="<?= BASE_URL ?>index.php" class="link">Home</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/categories.php" class="link">Categories</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/products.php" class="link">Products</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/contact.php" class="link">Contact</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/about.php" class="link">About Us</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/logout.php" class="link">Logout</a></li>
      </ul>
    </div>
  <?php
  } else { ?>
    <div class="links">
      <ul class="links-container">
        <li class="link-item"><a href="<?= BASE_URL ?>index.php" class="link">Home</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/categories.php" class="link">Categories</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/products.php" class="link">Products</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/contact.php" class="link">Contact</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/about.php" class="link">About Us</a></li>
        <li class="link-item"><a href="<?= BASE_URL ?>pages/account.php" class="link">Login/ Sign up</a></li>
      </ul>
    </div>

  <?php
  }
  ?>