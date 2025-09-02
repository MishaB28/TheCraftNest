<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
    <h1>Manage Products:</h1>
    <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['unauthorize'])){
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if(isset($_SESSION['remove-failed'])){
            echo $_SESSION['remove-failed'];
            unset($_SESSION['remove-failed']);
        }
        ?>
       <br><br><br>

    <!--Button to Add Admin-->
    <a href="<?= BASE_URL ?>admin/add-product.php" class="btn-primary">Add Product</a>
    <br><br><br>

    <table class="tbl-full">
        <tr>
            <th>S.No.</th>
            <th>Title</th>
            <th>Price</th>
            <th>Image</th>
            <th>Featured</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        <?php
          $sql="SELECT * FROM product";
           query
          $res = mysqli_query($conn, $sql);

              $count = mysqli_num_rows($res);
              $sn=1;
              if($count>0)
              {
                  while($row=mysqli_fetch_assoc($res)){

                     $id=$row['id'];
                     $title=$row['title'];
                     $price=$row['price'];
                     $image_name=$row['image_name'];
                     $featured=$row['featured'];
                     $active=$row['active'];

                     ?>
                        <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $price; ?></td>

                            <td>

                                <?php 
                                    if($image_name!=""){
                                        ?>
                                        <img src="<?= BASE_URL ?>images/product/<?php echo $image_name; ?>" width="150px">
                                        
                                        <?php
                                    }
                                    else{
                                        echo "<div class='error'>No image uploaded.</div>";
                                    }
                                ?>

                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>admin/update-product.php?id=<?php echo $id; ?>" class="btn-secondary">Update Product</a>
                                <a href="<?= BASE_URL ?>admin/delete-product.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Product</a>
                            </td>
                        </tr>

                     <?php
                  }
                }
                else{
                    //no data in db
                
                    echo "<tr><td colspan='7'><div class='error'>No Products added yet.</div></td></tr>";
                    ?>




                    <?php
                }
                     ?>
                    
        
    </table>
    </div>
 
</div>


<?php include('partials/footer.php') ?>