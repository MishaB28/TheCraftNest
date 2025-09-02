<?php include('partials/menu.php') ?>

    <!--Main content Section starts-->

    <div class="main-content">
    <div class="wrapper">
    <h1>Manage Admins:</h1>
    
    
    <?php
    if(isset($_SESSION['add'])){
       
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }

    if(isset($_SESSION['delete'])){
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
   
    }
    if(isset($_SESSION['update'])){
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }
    if(isset($_SESSION['user-not-found'])){
        echo $_SESSION['user-not-found'];
        unset($_SESSION['user-not-found']);
    }
    if(isset($_SESSION['pwd-not-match'])){
        echo $_SESSION['pwd-not-match'];
        unset($_SESSION['pwd-not-match']);
    }
    if(isset($_SESSION['chng-pwd'])){
        echo $_SESSION['chng-pwd'];
        unset($_SESSION['chng-pwd']);
    }
    ?>

    <br><br><br>

    <!--Button to Add Admin-->
    <a href="add-admin.php" class="btn-primary">Add Admin</a>
    <br><br><br>

    <table class="tbl-full">
        <tr>
            <th>S.No.</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email-id</th>
            <th>Actions</th>
        </tr>

        <?php
          $sql="SELECT * FROM admin_users";
           query
          $res = mysqli_query($conn, $sql);
          if($res==TRUE)
          {
              $count = mysqli_num_rows($res);
              $sn=1;
              if($count>0)
              {
                  while($rows=mysqli_fetch_assoc($res)){

                     $id=$rows['id'];
                     $name=$rows['name'];
                     $username=$rows['username'];
                     $email=$rows['email'];
                     ?>
                    
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $username; ?></td>
                        <td><?php echo $email; ?></td>
                        <td>
                        <a href="<?= BASE_URL ?>admin/updatepassword.php?id=<?php echo $id?>" class="btn-primary">Change Password</a>
                        <a href="<?= BASE_URL ?>admin/update-admin.php?id=<?php echo $id?>" class="btn-secondary">Update Admin</a>
                        <a href="<?= BASE_URL ?>admin/delete-admin.php?id=<?php echo $id?>" class="btn-danger">Delete Admin</a>
            </td>
        </tr>
                     <?php
                  }
              }
              else{
                  //no data in db
              }
          }       
        ?>
    </table>
</div>
</div>

<?php include('partials/footer.php') ?>