<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
    <h1>Manage Categories:</h1>
    <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['remove'])){
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['no-category-found'])){
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['failed-remove'])){
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        ?>
       <br><br><br>
    <!--Button to Add Admin-->
    <a href="<?= BASE_URL ?>admin/add-category.php" class="btn-primary">Add Category</a>
    <br><br><br>

    <table class="tbl-full">
        <tr>
            <th>S.No.</th>
            <th>Title</th>
            <th>Image</th>
            <th>Featured</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        <?php
        //query to get all admins 
          $sql="SELECT * FROM categories"; 
           query
          $res = mysqli_query($conn, $sql);
          //check if executed
       
              //count rows to check whether data is in db or not
              $count = mysqli_num_rows($res);
              $sn=1; //create variable and assign value
              //check number of rows
              if($count>0)
              {
                  //we have data in db
                  while($rows=mysqli_fetch_assoc($res)){
                     //use while loop to get all data from db and while loop runs as long as data in db
                     //get individual data
                     $id=$rows['id'];
                     $title=$rows['title'];
                     $image_name=$rows['image_name'];
                     $featured=$rows['featured'];
                     $active=$rows['active'];
                     //display values in table

                     ?>
                        <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $title; ?></td>

                            <td>

                                <?php 
                                    //chk if img name is available or not
                                    if($image_name!=""){
                                        //display image
                                        ?>
                                        <img src="<?= BASE_URL ?>images/Category/<?php echo $image_name; ?>" width="150px">
                                        
                                        <?php
                                    }
                                    else{
                                        //display msg
                                        echo "<div class='error'>No image uploaded.</div>";
                                    }
                                ?>

                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                <a href="<?= BASE_URL ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                            </td>
                        </tr>

                     <?php
                  }
                }
                else{
                    //no data in db
                    ?>
                    
                    <tr>
                        <td colspan="6"><div class='error'>No Category added.</div></td>
                    </tr>





                    <?php
                }
                     ?>
                    
        
    </table>
    </div>
 
</div>


<?php include('partials/footer.php') ?>