<html>

<head>
    <title>The Craft Nest - Home Page</title>
    <link rel="stylesheet" href="css2/admin.css">
</head>


<body>
    <!--Menu Section starts-->
    <?php include('partials/menu.php') ?>

    <!--Menu Section ends-->

    <!--Main content Section starts-->

    <div class="main-content">
        <div class="wrapper">
            <h1>DASHBOARD</h1>
            <br>
            <br>
       
            <br>
            <br>
          
            <div class="headings text-center">
            <?php $sql="SELECT * FROM admin_users";

            $res=mysqli_query($conn, $sql);
            $count=mysqli_num_rows($res);
            ?>
                <h1><?php echo $count; ?></h1><br>
               Admins
            </div>
          
            <div class="headings text-center">
            <?php $sql1="SELECT * FROM categories";

            $res1=mysqli_query($conn, $sql1);
            $count1=mysqli_num_rows($res1);
            ?>
                <h1><?php echo $count1; ?></h1><br>
                Categories
            </div>
            <div class="headings text-center">
            <?php $sql2="SELECT * FROM product";

            $res2=mysqli_query($conn, $sql2);
            $count2=mysqli_num_rows($res2);
            ?>
                <h1><?php echo $count2; ?></h1><br>
                Products
            </div>
            <div class="headings text-center">
            <?php $sql3="SELECT * FROM orders";

            $res3=mysqli_query($conn, $sql3);
            $count3=mysqli_num_rows($res3);
            ?>
                <h1><?php echo $count3; ?></h1><br>
                Orders
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!--Main content Section ends-->

    <!--Footer Section starts-->

    <?php include('partials/footer.php') ?>
    <!--Footer Section ends-->
</body>

</html>