<?php
require_once __DIR__ . '/../connection.php';

$alert = '';

#for login
if (isset($_POST['login'])) {
    $query = "SELECT * FROM `reg_users` WHERE `emailid`='$_POST[emailid]'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);
            if (password_verify($_POST['password'], $result_fetch['password'])) {
                #password matches
                $_SESSION['loggedin'] = true;
                $_SESSION['emailid'] = $result_fetch['emailid'];
                $_SESSION['custid'] = $result_fetch['id'];
                header('Location: ' . SITEURL . 'index.php');
            } else {
                #password does not match
                $alert = '<div class="alert alerterror">
            <span>Incorrect Password!</span>
           </div>';
            }
        } else {
            $alert = '<div class="alert alerterror">
            <span>This email was not found! Please sign up to login. :)</span>
           </div>';
        }
    } else {
        $alert = '<div class="alert alerterror">
        <span>Cannot run query!</span>
       </div>';
    }
}

#for registration
if (isset($_POST['register'])) {
    $user_exist_query = "SELECT * FROM reg_users WHERE `emailid`='$_POST[emailid]'";
    $result = mysqli_query($conn, $user_exist_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) { #if email already registered
            $result_fetch = mysqli_fetch_assoc($result);
            #chk if email registered already
            if ($result_fetch['emailid'] == $_POST['emailid']) {
                $alert = '<div class="alert alertsuccess">
                <span>This email is already registered! Please log in. :)</span>
               </div>';
            } else {
                $alert = '<div class="alert alerterror">
                <span>Please enter your email correctly. The email does not match! :(</span>
               </div>';
            }
        } else { #exec if no one has taken email
            if ($_POST['password'] === $_POST['confirmpassword']) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $confirmpassword = password_hash($_POST['confirmpassword'], PASSWORD_BCRYPT);
                $query = "INSERT INTO reg_users(`fullname`, `emailid`, `password`, `confirmpassword`) VALUES ('$_POST[fullname]','$_POST[emailid]','$password','$confirmpassword')";
                if (mysqli_query($conn, $query)) {
                    #if data inserted 

                    $alert = '<div class="alert alertsuccess">
                <span>Thank you for registering! :)</span>
               </div>';
                    $result = mysqli_query($conn, $user_exist_query);
                    $result_fetch = mysqli_fetch_assoc($result);
                    $_SESSION['loggedin'] = true;
                    $_SESSION['emailid'] = $result_fetch['emailid'];
                    $_SESSION['custid'] = mysqli_insert_id($conn);
          
                } else {
                    #if data cannot be inserted
                    $alert = '<div class="alert alerterror">
                <span>Cannot run query!</span>
               </div>';
                }
            } else {
                $alert = '<div class="alert alerterror">
            <span>Passwords did not match :( Please try again! </span>
           </div>';
            }
        }
    } else {
        $alert = '<div class="alert alerterror">
        <span>Cannot run query!</span>
       </div>';
    }
}

?>

<script>
    setTimeout(function() {
        let alert = document.querySelector(".alert");
        alert.remove();
    }, 6000);
</script>