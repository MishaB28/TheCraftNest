<?php
ob_start();
include __DIR__ . '/../partials-front/menu.php';
$alert = '';
?>

<?php
if (isset($_POST['submit'])) {
    $product_id = $_GET['id'];
    $custid = $_SESSION['custid'];
    // $name  = $_POST['name']; 
    // $email  = $_POST['email']; 
    $review  = $_POST['review'];
    $insertReview = "INSERT INTO reviews (pid, uid, review)
	VALUES ('$product_id','$custid' ,'$review' )";
    if (mysqli_query($conn, $insertReview)) {
        $message = 'Your Review has been submitted.';
    }
}

?>

<section class="product-details">
    <?php
    if (isset($_GET['id'])) {
        //get id
        $id = $_GET['id'];
        //sql query
        $sql = "SELECT * FROM product WHERE id=$id";

        $res = mysqli_query($conn, $sql);
        //check query executes
        //check if data available
        $count = mysqli_num_rows($res);
        //getting products from db active and featured
        if ($count == 1) {
            //get details
            $row = mysqli_fetch_assoc($res);
            //get values
            $id = $row['id'];
            $title = $row['title'];
            $price = $row['price'];
            $description = $row['description'];
            $image_name = $row['image_name'];
    ?>
            <div class="image">
                <?php
                if ($image_name == "") {
                    echo "<div class='error'>Image not available.</div>";
                } else {
                    //image thr
                ?>
                    <img src="<?= BASE_URL ?>images/product/<?php echo $image_name; ?>" alt="">
                <?php
                }
                ?>
            </div>
            <div class="details">
                <h2 class="product-brand"><?php echo $title; ?></h2>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-o"></i>
                </div>
                <p>₹ <?php echo $price; ?></p>
                <h3>Product Details:</h3>
                <p><?php echo $description; ?></p>
                <h3>Quantity:</h3>
                <form action="<?= BASE_URL ?>pages/addtocart.php">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="number" value="1" name="quantity" min="1"><br>
                    <br><input type="submit" class="button" value="Add to Cart!">
            </div>
            </form>
    <?php
        }
    } else {
        echo "<div class='error'>Product not available.</div>";
    }

    ?>
    <div class="clearfix"></div>
</section>

<section class="review-menu">
    <div class="container">
        <h2 class="product-heading">Reviews:</h2>
        <ul class="comment-list">
            <?php
            $proid = $_GET['id'];
            $sql_allReview = "SELECT * FROM reviews JOIN user_data ON user_data.custid=reviews.uid WHERE pid='$proid'";
            $result_allReview = mysqli_query($conn, $sql_allReview);
            if (mysqli_num_rows($result_allReview) > 0) {
                while ($row_nameEmail = mysqli_fetch_assoc($result_allReview)) {
            ?>
                    <li>
                        <div class="comment-meta">
                            <?php echo $row_nameEmail['name'] ?>
                            <span>
                                <em><?php echo $row_nameEmail['timestamp'] ?></em>
                            </span>
                            <p><?php echo $row_nameEmail['review'] ?></p>
                        </div>
                    </li>
            <?php
                }
            }
            else{
                echo "No reviews yet!";
            }
            ?>
        </ul>
        <?php
        $proid = $_GET['id'];
        if (isset($_SESSION['custid'])) {
            $custid = $_SESSION['custid'];
            $sql_count = "SELECT * FROM reviews where pid='$proid' AND uid='$custid'";
            $result_count = mysqli_query($conn, $sql_count);
            if (mysqli_num_rows($result_count) > 0) {
                echo '<center><h4 class="billing">You have already submitted a review for this product.</h4></center>';
            } else {
        ?>
                <br>
                <br>
                <h3>Give a review:</h3>
                <form id="form" class="review-form" method="post">
                    <?php
                    $name  = '';
                    $email  = '';
                    if (isset($_SESSION['custid'])) {
                        $custid = $_SESSION['custid'];
                        $sql_nameEmail = "SELECT reg_users.emailid, user_data.name FROM reg_users JOIN user_data ON reg_users.id=user_data.custid AND user_data.custid = '$custid'";
                        $result_nameEmail = mysqli_query($conn, $sql_nameEmail);
                        if (mysqli_num_rows($result_nameEmail) > 0) {
                            $row_nameEmail = mysqli_fetch_assoc($result_nameEmail);
                            $name = $row_nameEmail['name'];
                            $email = $row_nameEmail['emailid'];
                        }
                    }
                    ?>

                    <input class="details" name="name" value='<?php echo  $name ?>' class="form-control" placeholder="Name" required="" type="text" <?php if ($name != '') {
                                                                                                                                        echo 'disabled';
                                                                                                                                    } else {
                                                                                                                                        echo " ";
                                                                                                                                    }    ?>>
                    <input class="details" name="email" value='<?php echo  $email ?>' class="form-control" placeholder="Emailid" required="" type="email" <?php if ($email != '') {
                                                                                                                                                echo 'disabled';
                                                                                                                                            } else {
                                                                                                                                                echo " ";
                                                                                                                                            }  ?>>
                    <textarea class="details" name="review" id="text" class="form-control" required rows="6" placeholder="Add a review." maxlength="400"></textarea>
                    <br>
                    <button type="submit" name='submit' class="button">
                        Submit your Review!
                    </button>
                    <?php echo $alert;  ?>
                </form>
        <?php
            }
        }
else{
    echo '<center><h4 class="billing">Please register/ log-in to give a review.</h4></center>';
           
}
        ?>
    </div>
</section>
<section class="product-menu">
    <div class="container">
        <h2 class="product-heading">More Products:</h2>
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

<?php include __DIR__ . '/../partials-front/footer.php'; ?>