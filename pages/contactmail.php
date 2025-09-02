<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once __DIR__ . '/../phpmailer/Exception.php';
require_once __DIR__ . '/../phpmailer/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/SMTP.php';

$mail = new PHPMailer(true);
$alert = '';
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'MAIL_ID'; // Gmail address which you want to use as SMTP server
    $mail->Password = 'PASSWORD'; // Gmail address Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';
    $mail->setFrom('MAIL_ID'); // Gmail address which you used as SMTP server
    $mail->addAddress('MAIL_ID'); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)
    $mail->isHTML(true);
    $mail->Subject = "Message Received (Contact Page), Issue : $subject";
    $mail->Body = "<h3>Name : $name <br>Email: $email <br>Message : $message</h3>";
    $mail->send();
    $alert = '<div class="alert alertsuccess">
                 <span>Your Message has been sent! Thank you for contacting us. We will get back to you as soon as we can! :)</span>
                </div>';
  } catch (Exception $e) {
    $alert = '<div class="alert alerterror">
                <span>We are so sorry :(  There was a problem. Please try again later!' . $e->getMessage() . '</span>
              </div>';
  }
}
?>
<script>
  setTimeout(function() {
    let alert = document.querySelector(".alert");
    alert.remove();
  }, 8000);
</script>