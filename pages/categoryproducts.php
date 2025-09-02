<?php include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php'; ?>

<section class="product-menu">
    <div class="container">
        <?php
         if (isset($_GET['id'])) {
            //get 

            $catid = $_GET['id'];
            //sql query
            $sql="SELECT title FROM categories WHERE id=$catid";
            $res=mysqli_query($conn, $sql);
            $row=mysqli_fetch_assoc($res);
            $category_title=$row['title'];
         }
         else{
             header('location:'.SITEURL);
         }
        
        ?>
     <h2 class="product-heading">Products on the Category: <a href="#"><?php echo $category_title; ?></a></h2>

        <?php
        if (isset($_GET['id'])) {
            //get 

            $catid = $_GET['id'];
            //sql query

            //sql query
            $sql2 = "SELECT * FROM product WHERE category_id=$catid";

            $res2 = mysqli_query($conn, $sql2);
            //check query executes
            //check if data available
            $count2 = mysqli_num_rows($res2);
            //getting products from db active and featured

            if ($count2 > 0) {
                //get details
                while ($row2 = mysqli_fetch_assoc($res2)) {

                    //get values
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $category_id = $row2['category_id'];
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
                                <p class="product-price">Rs. <?php echo $price; ?> INR</p>
                                <br>
                            </div>
                        </a>
                    </div>
        <?php
                }
            } else {
                echo "<div class='error'>Product not available.</div>";
            }
        } else {
            echo "<div class='error'>Product not available.</div>";
        }
        ?>
        <div class="clearfix"></div>
    </div>
</section>

<?php include __DIR__ . '/../partials-front/footer.php'; ?>