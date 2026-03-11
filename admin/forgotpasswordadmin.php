<?php
require('../configs/constants.php');
require_once __DIR__ . '/../connection.php';
$alert = '';

function sendMail($emailid, $reset_token)
{
    $apiKey = getenv('MAIL_API');
    $fromEmail = getenv('MAIL_ID');
    $fromName = 'The Craft Nest';

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $resetLink = $protocol . $host . BASE_URL . "admin/updatepasswordadmin.php?emailid="
                 . urlencode($emailid) . "&reset_token=" . urlencode($reset_token);

    $body = [
        "sender" => ["name" => $fromName, "email" => $fromEmail],
        "to" => [["email" => $emailid]],
        "subject" => "Password reset link - The Craft Nest",
        "htmlContent" => "
            We got a password reset request from you.<br>
            Please click on the link below to reset your password!<br><br>
            <a href='$resetLink'>Reset your password</a>
        "
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.brevo.com/v3/smtp/email");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "accept: application/json",
        "api-key: $apiKey",
        "content-type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        error_log("Mailer Error: " . $err);
        return false;
    }

    $res = json_decode($response, true);
    if (isset($res['messageId'])) {
        return true;
    } else {
        error_log("Mailer Error: " . $response);
        return false;
    }
}

if (isset($_POST['send-reset-link'])) {
    $query = "SELECT * FROM `admin_users` WHERE `email`='$_POST[emailid]'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/Kolkata');
            $date = date("Y-m-d");
            $query = "UPDATE `admin_users` SET `resettoken`='$reset_token', `resettokenexpire`='$date' WHERE `email`='$_POST[emailid]'";
            if (mysqli_query($conn, $query) && sendMail($_POST['emailid'], $reset_token)) {
                $alert = '<div class="alert success">
                <span>Password reset link has been sent to your mail! :)</span>
                <p>In case you have not received the mail, please check the spam folder.</p>
               </div>';
            } else {
                $alert = '<div class="alert error">
                <span>Server is down :( Please try again later!</span>
               </div>';
            }
        } else {
            $alert = '<div class="alert alerterror">
        <span>This email was not found! Please sign up to login. :)</span>
       </div>';
        }
    } else {
        $alert = '<div class="alert alerterror">
        <span>Cannot run query.</span>
    </div>';
    }
}
?>
<script>
    setTimeout(function() {
        let alert = document.querySelector(".alert");
        if (alert) alert.remove();
    }, 6000);
</script>