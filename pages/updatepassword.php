<?php include __DIR__ . '/../partials-front/menu.php';
?>

<?php
$alert = '';
if (isset($_POST['updatepassword'])) {
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $update = "UPDATE `reg_users` SET `password`='$pass', `resettoken`=NULL, `resettokenexpire`=NULL WHERE `emailid`='$_POST[emailid]'";
    if (mysqli_query($conn, $update)) {
        echo '<script> alert("Your password has been changed! Thank you :)");
       window.location.href = "' . BASE_URL . 'pages/account.php";
       </script>';
    } else {
        $alert = '<div class="alert alerterror">
        <span>Server is down :( Please try again later!</span>
       </div>';
        echo $alert;
    }
}
?>

<?php
require_once __DIR__ . '/../connection.php';
if (isset($_GET['emailid']) && isset($_GET['reset_token'])) {
    date_default_timezone_set('Asia/Kolkata');
    $date = date("Y-m-d");
    $query = "SELECT * FROM `reg_users` WHERE `emailid`='$_GET[emailid]' AND `resettoken`='$_GET[reset_token]' AND `resettokenexpire`='$date'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            echo " 
            <div class='form'>
            <div class='form-box forgotpassword'>
            <form action='' method='POST'>
            <h2>Create a new password:</h2>
            <div class='field'>
            <i class='uil uil-lock-alt'></i>
                        <input type='password' placeholder='New Password' required name='password'>
                    </div>
                    <input class='update-btn' type='submit' value='Change your password!' name='updatepassword'>
                    <input type='hidden' name='emailid' value='$_GET[emailid]'>
                    </form>
            </div>
        </div>
        
     ";
        } else {
            $alert = '<div class="alert alerterror">
        <span>This is an invalid or expired link.</span>
       </div>';
        }
    } else {
        $alert = '<div class="alert alerterror">
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
        window.location.replace("' . BASE_URL . 'pages/account.php");
    }, 6000);
</script>

<script type="text/javascript">
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<?php include __DIR__ . '/../partials-front/footer.php'; ?>