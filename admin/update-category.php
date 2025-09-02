<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        <?php
            if(isset($_GET['id'])){
                    //get id
                    $id=$_GET['id'];
                    //sql query
                    $sql="SELECT * FROM categories WHERE id=$id";

                    $res=mysqli_query($conn, $sql);
                    //check query executes
                    //check if data available
                    $count = mysqli_num_rows($res);
                        
                    if($count==1)
                    {
                        //get details
                        $row=mysqli_fetch_assoc($res);
                        $title=$row['title'];
                        $current_image=$row['image_name'];
                        $featured=$row['featured'];
                        $active=$row['active'];
                    }
                    else{
                        $_SESSION['no-category-found']="<div class='error'>Category not found!</div>";
                        //redirect
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
            }
            else{
                //redirect to mng cat
                header('location:'.SITEURL.'admin/manage-category.php');
               
            }
              
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
         <table class="tbl-30">
            <tr>
                <td>Title:</td>
             <td>
                <input type="text" name="title" value="<?php echo $title; ?>">
             </td>
            </tr>
            <tr>
                <td>Current Image:</td>
             <td>
                <?php
                    if($current_image != ""){
                        //display img
                        ?>
                        <img src="<?= BASE_URL ?>images/Category/<?php echo $current_image; ?>" width="120px">
                   <?php
                }
                    else{
                        //display msg
                        echo "<div class='error'>Image not added.</div>";
                    }
                ?>
                </td>
            </tr>
            <tr>
                <td>New Image:</td>
             <td>
                <input type="file" name="image">
             </td>
            </tr>
            <tr>
                <td>Featured:</td>
            <td>
                <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
            </td>
            </tr>
            <tr>
                <td>Active:</td>
            <td>
                <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
            </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" class="btn-secondary" value="Update Category">
                </td>
            </tr>
         </table>

</form>


<?php
//check if submit clicked
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    //update img if selected
    if(isset($_FILES['image']['name'])){
        //get img details
        $image_name=$_FILES['image']['name'];
        //chk if image available
        if($image_name != "")
        {
            //image available
            //upload
            //auto rename image
            //get extension of img
            $ext = explode('.', $image_name);
            $file_ext = strtolower(end($ext));
            //rename
            $image_name="Product_Category_".rand(000, 999).'.'.$file_ext;

            $source_path=$_FILES['image']['tmp_name'];
            
            $destination_path="../images/Category/".$image_name;

            $upload=move_uploaded_file($source_path, $destination_path);
            //chk if uploaded
            if($upload==false)
            {
            $_SESSION['upload'] = "<div class='error'>Failed to upload image!</div>";
                //redirect
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop process
                die();
            }
            //remove old img if available
            if($current_image != ""){
                $remove_path="..images/Category/".$current_image;
                $remove=unlink($remove_path);
                //chk if removed
                if($remove==false){
                    //failed to remove
                    $_SESSION['failed-remove']="<div class'error'>Failed to remove current image.</div>";
                    header('location:'.SITEURL/'admin/manage-category.php');
                    die();
                }
            }
        }
        else{
            $image_name=$current_image;
        }
    }
    else{
        $image_name=$current_image;
    }


    //query to update
    $sql2="UPDATE categories SET 
    title='$title',
    image_name='$image_name',
    featured='$featured',
    active='$active'
    WHERE id=$id
    ";

    $res2 = mysqli_query($conn, $sql2);
    //check execution
    if($res2==TRUE)
    {
        //success
        $_SESSION['update']="<div class='success'>Category is updated successfully!</div>";
        //redirect
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else{
        //fail
        $_SESSION['update']="<div class='error'>Failed to update Category. Try again later!</div>";
        //redirect
        header('location:'.SITEURL.'admin/manage-category.php');
    }
}

?>
    </div>
</div>

<?php include('partials/footer.php'); ?>