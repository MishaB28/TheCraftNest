<?php
require_once __DIR__ . '/../connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$alert = '';
function sendMail($emailid, $reset_token)
{
    require_once __DIR__ . '/../phpmailer/PHPMailer.php';
    require_once __DIR__ . '/../phpmailer/SMTP.php';
    require_once __DIR__ . '/../phpmailer/Exception.php';

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp-relay.brevo.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
        $mail->Timeout    = 10;
        $mail->Username   = $_SERVER['SERVER_NAME'] === 'localhost'
                              ? 'MAIL_ID'
                              : getenv('MAIL_ID'); //SMTP username
        $mail->Password   = $_SERVER['SERVER_NAME'] === 'localhost'
                              ? 'MAIL_APP_PASSWORD'
                              : getenv('MAIL_PASSWORD'); //SMTP password
        $fromEmail = $_SERVER['SERVER_NAME'] === 'localhost'
                                 ? 'MAIL_ID'
                                 : getenv('MAIL_ID');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($fromEmail, 'The Craft Nest');

        $mail->addAddress($emailid);     //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Password reset link - The Craft Nest';
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $resetLink = $protocol . $host . BASE_URL . "pages/updatepassword.php?emailid="
            . urlencode($emailid) . "&reset_token=" . urlencode($reset_token);
        $mail->Body = "We got a password reset request from you.<br>
        Please click on the link below to reset your password!<br><br>
        <a href='$resetLink'>Reset your password</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
          error_log("Mailer Error: " . $mail->ErrorInfo);
          return false;
      }
}

if (isset($_POST['send-reset-link'])) {
    $query = "SELECT * FROM `reg_users` WHERE `emailid`='$_POST[emailid]'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/Kolkata');
            $date = date("Y-m-d");
            $query = "UPDATE `reg_users` SET `resettoken`='$reset_token', `resettokenexpire`='$date' WHERE `emailid`='$_POST[emailid]'";
            if (mysqli_query($conn, $query) && sendMail($_POST['emailid'], $reset_token)) {
                $alert = '<div class="alert alertsuccess">
                <span>Password reset link has been sent to your mail! :)</span>
                <p>In case you have not received the mail, please check the spam folder.</p>
               </div>';
            } else {
                $alert = '<div class="alert alerterror">
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
        <span>User not found:( Please register first!</span>
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