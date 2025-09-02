<?php
include('../configs/constants.php');

$id = $_GET['id'];
$sql="DELETE FROM admin_users WHERE id=$id";

 query
$res=mysqli_query($conn, $sql);

if($res==TRUE){
    $_SESSION['delete'] = "<div class='success'>Admin deleted successfully!</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else{
    $_SESSION['delete'] = "<div class='error'>Failed to delete Admin. Try again later.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
}
?>