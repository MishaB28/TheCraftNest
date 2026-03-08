<?php include('../configs/constants.php');
?>

<html>

<head>

    <title>Login - The Craft Nest</title>
    <link rel="stylesheet" href="css2/admin.css">
</head>

<body>

    <div class="login">

        <h1 class="text-center">Log in</h1>
        <br><br>

        <?php

        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['login'])){
            echo '<script> alert("Logged in!");
                window.location.replace("' . BASE_URL . 'admin/");
                </script>';
                die();
            }

        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <!--login form starts here-->

        <form action="" method="POST" class="text-center">

            Username:&nbsp;<input type="text" name="username" placeholder="Enter Username">
            <br>
            <br>
            Password:&nbsp;<input type="password" name="password" placeholder="Enter Password">
            <br>
            <br>
            <br>
            <div class="forgot-link">
                    <a href="resetpasswordadmin.php">Forgot your password?</a>
                </div>
            <br><br><input type="submit" name="submit" value="Log in" class="btn-primary">
        </form>
        <!--login form ends here-->


    </div>

</body>

</html>

<?php


if (isset($_POST['submit'])) {


    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT * FROM admin_users WHERE username='$username' AND password='$password'";

    $res = mysqli_query($conn, $sql);


    $count = mysqli_num_rows($res);

    if ($count == 1) {

        $_SESSION['login']=true;

        header('location:'.SITEURL.'admin/');
    } else {

        echo '<script> alert("Username and Password do not match!");
            window.location.replace("' . BASE_URL . 'admin/login.php");
        </script>';

    
    }

}



?>