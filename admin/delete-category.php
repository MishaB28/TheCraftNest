<?php
include('../configs/constants.php');
if(isset($_GET['id']) AND isset($_GET['image_name'])){
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    if($image_name != ""){
        $path="../images/Category/".$image_name;
        $remove=unlink($path);
        if($remove==false){
            $_SESSION['remove']="<div class='error>Failed to remove Category Image.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
            die();
        }
    }
    $sql="DELETE FROM categories WHERE id=$id";

    $res=mysqli_query($conn, $sql);
    
    if($res==TRUE){
        $_SESSION['delete'] = "<div class='success'>Category deleted successfully!</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else{
        $_SESSION['delete'] = "<div class='error'>Failed to delete Category. Try again later.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
}
else{
    header('location:'.SITEURL.'admin/manage-category.php');
}
?>