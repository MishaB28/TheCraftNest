<?php include('../configs/constants.php');  ?>
<?php


if (isset($_POST['updatepassword'])) {
    $pass = md5($_POST['password']);

    $update = "UPDATE `admin_users` SET `password`='$pass', `resettoken`=NULL, `resettokenexpire`=NULL WHERE `email`='$_POST[emailid]'";
    if (mysqli_query($conn, $update)) {
        echo '<script> alert("Your password has been changed! Thank you :)");
             window.location.href = "' . BASE_URL . 'admin/login.php";
       </script>';
    } else {
        $alert = '<div class="alert error">
        <span>Server is down :( Please try again later!</span>
       </div>';
        echo $alert;
    }
}
?>
<html>

<head>

    <title>Login - The Craft Nest</title>
    <link rel="stylesheet" href="css2/admin.css">
</head>

<body>

<div class="login">
<h1 class="text-center">Create a new password</h1>
<br><br>
<div class="form">
  <div class="form-box forgotpassword">


<?php

$alert = '';
if (isset($_GET['emailid']) && isset($_GET['reset_token'])) {
    date_default_timezone_set('Asia/Kolkata');
    $date = date("Y-m-d");
    $query = "SELECT * FROM `admin_users` WHERE `email`='$_GET[emailid]' AND `resettoken`='$_GET[reset_token]' AND `resettokenexpire`='$date'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            echo " 
            <form action='' method='POST' class='text-center'>
        
            <div class='field'>
            <i class='uil uil-lock-alt'></i>
                        <input type='password' placeholder='New Password' required name='password'>
                    </div>
                
                    <input class='btn-primary' type='submit' value='Change your password!' name='updatepassword'>
                   
                    <input type='hidden' name='emailid' value='$_GET[emailid]'>
                    </form>
                    </div>
                    </div>
                    
                 ";
                 

                    }


            else {
            $alert = '<div class="alert error">
        <span>Invalid or expired link.</span>
        
       </div>';
       
        }
    } else {
        $alert = '<div class="alert error">
        <span>Server is down :( Please try again later!</span>
       </div>';
    }
}
echo $alert;

?>

<script>
    setTimeout(function() {
        let alert = document.querySelector(".alert");
        alert.remove();
        window.location.replace("' . BASE_URL . 'admin/login.php");
    }, 4000);
</script>

<script type="text/javascript">
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

