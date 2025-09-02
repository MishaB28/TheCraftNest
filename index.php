<?php include __DIR__ . '/partials-front/menu.php'; ?>

<header class="pencil-section">
    <video src="<?= BASE_URL ?>images/Vid1.mov" muted loop autoplay></video>
</header>
<div class="content">
    <center>
        <h2>Find your passion!</h2>
        <strong>
            <br>
            <p>"Being creative is not a hobby, it is a way of life."</p>
        </strong>
        <br>
        <a href="<?= BASE_URL ?>pages/products.php" class="btn">Explore Now! </a>
    </center>
</div>
<section class="categories">
    <div class="container">
        <h2 class="category-heading2">Categories</h2>
        <?php
        $sql = "SELECT * FROM categories WHERE active='Yes' AND featured='Yes'";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
        ?>
               <a href="<?= BASE_URL ?>pages/categoryproducts.php?id=<?php echo $row['id'] ?>">
                         <div class="box-3 float-container">
                        <?php
                        if ($image_name == "") {
                            echo "<div class='error'>Image not available.</div>";
                        } else {
                        ?>
                            <img src="<?= BASE_URL ?>images/Category/<?php echo $image_name; ?>"  class="img-responsive img-curve">

                        <?php
                        }
                        ?>
                        <h3 class="float-text text-white"><?php echo $title ?></h3>
                    </div>
                </a>
        <?php
            }
        } else {
            echo "<div class='error'>Category not added.</div>";
        }
        ?>
        <div class="clearfix"></div>
    </div>
    </div>
</section>
<section class="product-menu">
    <div class="container">
        <h2 class="product-heading">Our Best Selling Products</h2>
        <?php
        $sql2 = "SELECT * from product WHERE active='Yes' AND featured='Yes'";
        $res2 = mysqli_query($conn, $sql2);
        $count2 = mysqli_num_rows($res2);
        if ($count2 > 0) {
            while ($row2 = mysqli_fetch_assoc($res2)) {
                //get values
                $id = $row2['id'];
                $title = $row2['title'];
                $price = $row2['price'];
                $description = $row2['description'];
                $image_name = $row2['image_name'];
        ?>
                <div class="product-menu-box">
                    <a href="<?= BASE_URL ?>pages/singleproduct.php?id=<?php echo $row2['id'] ?>">
                        <div class="product-menu-img">
                            <?php
                            if ($image_name == "") {
                                echo "<div class='error'>Image not available.</div>";
                            } else {
                            ?>
                                <img src="<?= BASE_URL ?>images/product/<?php echo $image_name; ?>" alt="" class="img-responsive">
                            <?php
                            }
                            ?>
                        </div>
                        <ul class="action">
                            <li>
                                <a href="<?= BASE_URL ?>pages/addtocart.php?id=<?php echo $row2['id'] ?>">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span>Add to Cart</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>pages/singleproduct.php?id=<?php echo $row2['id'] ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    <span>View Details</span>
                                </a>
                            </li>
                        </ul>
                        <div class="product-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                            </div>
                            <p class="product-price">₹ <?php echo $price; ?></p>
                            <br>
                        </div>
                    </a>
                </div>
        <?php
            }
        } else {
            echo "<div class='error'>Product not available.</div>";
        }
        ?>
        <div class="clearfix"></div>
    </div>
</section>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<?php include __DIR__ . '/partials-front/footer.php'; ?>