<?php include __DIR__ . '/../partials-front/menu.php';
?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="category-heading2">Categories</h2>
        <?php
        //display all categpries that are active
        //query
        $sql = "SELECT * FROM categories WHERE active='Yes'";

        $res = mysqli_query($conn, $sql);
        //count rows to chk if cat thr or not
        $count = mysqli_num_rows($res);
        //chk if cat available
        if ($count > 0) {
            //cat thr
            while ($row = mysqli_fetch_assoc($res)) {
                //get values
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
                            //image thr
                        ?>
                            <img src="<?= BASE_URL ?>images/Category/<?php echo $image_name; ?>" class="img-responsive img-curve">
                        <?php
                        }
                        ?>
                        <h3 class="float-text text-white"><?php echo $title ?></h3>
                    </div>
                </a>
        <?php
            }
        } else {
            //cat not thr
            echo "<div class='error'>Category not found.</div>";
        }

        ?>

        <div class="clearfix"></div>
    </div>
    </div>
</section>

<section class="product-menu">
    <div class="container">
        <h2 class="product-heading">Our Products</h2>
        <?php
        //getting products from db active and featured
        $sql2 = "SELECT * from product WHERE active='Yes'";
        $res2 = mysqli_query($conn, $sql2);
        //count rows to chk if cat thr or not
        $count2 = mysqli_num_rows($res2);
        if ($count2 > 0) {
            //cat thr
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
                                //image thr
                            ?>
                                <img src="<?= BASE_URL ?>images/product/<?php echo $image_name; ?>" alt="" class="img-responsive">
                            <?php
                            }
                            ?>
                        </div>
                        <ul class="action">
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

<?php include __DIR__ . '/../partials-front/footer.php'; ?>