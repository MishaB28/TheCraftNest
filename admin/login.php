<?php
include('../configs/constants.php');
session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header('Location: ' . BASE_URL . 'admin/');
    exit;
}

if (isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // or password_hash if you update DB

    $sql = "SELECT * FROM admin_users WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);

        // Set session variables
        $_SESSION['login'] = true;
        $_SESSION['admin_username'] = $row['username'];
        $_SESSION['admin_email'] = $row['email'];

        header('Location: ' . BASE_URL . 'admin/');
        exit;
    } else {
        $alert = '<div class="alert error">
                    <span>Username and Password do not match!</span>
                  </div>';
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
    <h1 class="text-center">Log in</h1>
    <br><br>

    <?php
        if (isset($alert)) echo $alert;
    ?>

    <form action="" method="POST" class="text-center">
        Username:&nbsp;<input type="text" name="username" placeholder="Enter Username" required>
        <br><br>
        Password:&nbsp;<input type="password" name="password" placeholder="Enter Password" required>
        <br><br>
        <div class="forgot-link">
            <a href="resetpasswordadmin.php">Forgot your password?</a>
        </div>
        <br><br>
        <input type="submit" name="submit" value="Log in" class="btn-primary">
    </form>
</div>
</body>
</html>