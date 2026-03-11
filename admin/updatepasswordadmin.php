<?php include('../configs/constants.php');  ?>
<?php
$alert = '';
if (isset($_POST['updatepassword'])) {
    $pass = md5($_POST['password']);

    if (!empty($_POST['emailid']) && !empty($_POST['reset_token'])) {
        $email = $_POST['emailid'];
        $token = $_POST['reset_token'];

        // Make sure token is valid before updating
        $check = "SELECT * FROM `admin_users` WHERE `email`='$email' AND `resettoken`='$token'";
        $res = mysqli_query($conn, $check);
        if ($res && mysqli_num_rows($res) == 1) {
          $update = "UPDATE `admin_users`
                     SET `password`='$pass', `resettoken`='', `resettokenexpire`=''
                     WHERE `email`='$email' AND `resettoken`='$token'";
            if (mysqli_query($conn, $update)) {
                echo '<script> alert("Your password has been changed! Thank you :)");
                     window.location.href = "' . BASE_URL . 'admin/login.php";
               </script>';
                exit;
            } else {
                $alert = '<div class="alert error">
                <span>Server is down :( Please try again later!</span>
               </div>';
            }
        } else {
            $alert = '<div class="alert error">
            <span>Invalid or expired token.</span>
           </div>';
        }
    } else {
        $alert = '<div class="alert error">
        <span>Missing email or token.</span>
       </div>';
    }
}

if (isset($_GET['emailid']) && isset($_GET['reset_token'])) {
    $email = $_GET['emailid'];
    $token = $_GET['reset_token'];

    $query = "SELECT * FROM `admin_users` WHERE `email`='$email' AND `resettoken`='$token'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) == 1) {
        echo "
        <div class='login'>
        <h1 class='text-center'>Create a new password</h1>
        <br><br>
        <div class='form'>
        <div class='form-box forgotpassword'>
            <form action='' method='POST' class='text-center'>
                <div class='field'>
                    <i class='uil uil-lock-alt'></i>
                    <input type='password' placeholder='New Password' required name='password'>
                </div>
                <input class='btn-primary' type='submit' value='Change your password!' name='updatepassword'>
                <input type='hidden' name='emailid' value='$email'>
                <input type='hidden' name='reset_token' value='$token'>
            </form>
        </div>
        </div>";
    } else {
        $alert = '<div class="alert error">
        <span>Invalid or expired link.</span>
       </div>';
    }
}
echo $alert;
?>
<script>
    setTimeout(function() {
        let alert = document.querySelector(".alert");
        if(alert) alert.remove();
    }, 4000);
</script>