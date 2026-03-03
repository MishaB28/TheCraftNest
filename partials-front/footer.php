<?php
require_once __DIR__ . '/../configs/constants.php';?>
<footer>
    <div class="extra"></div>
    <div class="footer-content">
        <img src="<?= BASE_URL ?>Images/Logo.png" class="logo" alt="">
        <div class="footer-ul-container">
            <center>
                <ul class="explore">
                    <li>
                        <h1 class="title">Explore</h1>
                    </li>
                    <li><a href="<?= BASE_URL ?>pages/about.php" class="footer-link">About us</a></li>
                    <li><a href="<?= BASE_URL ?>pages/products.php" class="footer-link">Our Products</a></li>
                    <li><a href="<?= BASE_URL ?>pages/shipping&handling.php" class="footer-link">Shipping & Handling</li></a></li>
              
                    <li><a href="<?= BASE_URL ?>pages/privacypolicy.php" class="footer-link">Privacy Policy</a></li>
                    <li><a href="<?= BASE_URL ?>pages/terms&conditions.php" class="footer-link">Terms & Conditions</a></li>
                    <li><a href="<?= BASE_URL ?>pages/contact.php" class="footer-link">Contact Us</a></li>
                </ul>
            </center>
        </div>
        <p class="footer-credit">Copyright 2026 - The Craft Nest</p>
    </div>
</footer>
<script>
  // Save scroll position before reload
  window.addEventListener("beforeunload", function () {
    localStorage.setItem("scrollPos", window.scrollY);
  });

  // Restore scroll position after reload
  window.addEventListener("load", function () {
    const scrollPos = localStorage.getItem("scrollPos");
    if (scrollPos) {
      window.scrollTo(0, parseInt(scrollPos));
      localStorage.removeItem("scrollPos");
    }
  });
</script>

</body>

</html>