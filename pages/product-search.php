<?php include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php'; ?>

<section class="product-menu">
    <div class="container">
        <?php
        
        $search = $_POST['search'];
        
        ?>
        <h2 class="product-heading">Products on your search: <a href="#"><?php echo $search; ?></a></h2>
        <?php
      
          
      //sql query to get products on search
      $sql4 = "SELECT * from categories WHERE title LIKE '%$search%'";

      $res4 = mysqli_query($conn, $sql4);
      $count4 = mysqli_num_rows($res4);
      //chk if available
      if ($count4 > 0) {
          //available
          while ($row4 = mysqli_fetch_assoc($res4)) {
              //get details
              $id = $row4['id'];
              $title = $row4['title'];
              $image_name = $row4['image_name'];
  ?>


                <a href="<?= BASE_URL ?>pages/categoryproducts.php?id=<?php echo $row4['id'] ?>">
                    <div class="box-3 float-container">
                        <?php
                        if ($image_name == "") {
                            echo "<div class='error'>Image not available.</div>";
                        } else {
                            //image thr
                        ?>
                            <img src="<?= BASE_URL ?>images/Category/<?php echo $row4['image_name']; ?>" class="img-responsive img-curve">
                        <?php
                        }
                        ?>
                        <h3 class="float-text text-white"><?php echo $row4['title'] ?></h3>
                    </div>
                </a>
        <?php
            }
        } 

        ?>

        <?php
      
          
            //sql query to get products on search
            $sql3 = "SELECT * from product WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            $res3 = mysqli_query($conn, $sql3);
            $count3 = mysqli_num_rows($res3);
            //chk if available
            if ($count3 > 0) {
                //available
                while ($row3 = mysqli_fetch_assoc($res3)) {
                    //get details
                    $id = $row3['id'];
                    $title = $row3['title'];
                    $price = $row3['price'];
                    $description = $row3['description'];
                    $image_name = $row3['image_name'];
        ?>


                    <div class="product-menu-box">
                        <a href="<?= BASE_URL ?>pages/singleproduct.php?id=<?php echo $row3['id'] ?>">
                            <div class="product-menu-img">
                                <?php
                                if ($image_name == "") {
                                    echo "<div class='error'>Image not available.</div>";
                                } else {
                                    //image thr
                                ?>
                                    <img src="<?= BASE_URL ?>images/product/<?php echo $row3['image_name']; ?>" alt="" class="img-responsive">
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
                                    <a href="<?= BASE_URL ?>pages/singleproduct.php?id=<?php echo $row3['id'] ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        <span>View Details</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="product-menu-desc">
                                <h4><?php echo $row3['title']; ?></h4>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                                <p class="product-price">Rs. <?php echo $row3['price']; ?> INR</p>
                                <br>
                            </div>
                        </a>
                    </div>


        <?php
                }
            } else {
                //not available
                echo "<div class='error'>Product/ Category not found.</div>";
            }
        
        ?>
     

        <div class="clearfix"></div>
    </div>
</section>


<?php include __DIR__ . '/../partials-front/footer.php'; ?>