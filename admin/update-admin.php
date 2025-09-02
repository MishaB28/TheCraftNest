<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>
        <?php
        
            $id=$_GET['id'];
            $sql="SELECT * FROM admin_users WHERE id=$id";

            $res=mysqli_query($conn, $sql);
            if($res==TRUE){
                $count = mysqli_num_rows($res);
                if($count==1)
                {
                    $row=mysqli_fetch_assoc($res);

                    $name=$row['name'];
                    $username=$row['username'];
                    $email=$row['email'];
                }
                else{
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        ?>
        <form action="" method="POST">
         <table class="tbl-30">
            <tr>
                <td>Name:</td>
             <td>
                <input type="text" name="name" value="<?php echo $name; ?>">
             </td>
            </tr>
            <tr>
                <td>Username:</td>
             <td>
                <input type="text" name="username" value="<?php echo $username; ?>">
             </td>
            </tr>
            <tr>
                <td>Email:</td>
             <td>
                <input type="email" name="email" value="<?php echo $email; ?>">
             </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                     <input type="submit" name="submit" class="btn-secondary" value="Update Admin">
                </td>
            </tr>
         </table>

</form>
    </div>
</div>

<?php
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $sql="UPDATE admin_users SET
    name='$name',
    username='$username',
   email='$email'
    WHERE id='$id'
    ";

    $res = mysqli_query($conn, $sql);
    if($res==TRUE)
    {
        $_SESSION['update']="<div class='success'>Admin is updated successfully!</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else{
        $_SESSION['update']="<div class='error'>Failed to update Admin. Try again later!</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
}

?>
<?php include('partials/footer.php'); ?>