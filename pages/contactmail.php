<?php
$alert = '';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $apiKey = getenv('MAIL_API');
    $fromEmail = getenv('MAIL_ID');
    $toEmail = getenv('MAIL_ID'); // where messages should go
    $fromName = 'The Craft Nest';

    $body = [
        "sender" => ["name" => $fromName, "email" => $fromEmail],
        "to" => [["email" => $toEmail]],
        "subject" => "Message Received (Contact Page), Issue: $subject",
        "htmlContent" => "<h3>Name : $name <br>Email: $email <br>Message : $message</h3>"
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
        $alert = '<div class="alert alerterror">
                    <span>We are so sorry :(  There was a problem. Please try again later!</span>
                  </div>';
    } else {
        $res = json_decode($response, true);
        if (isset($res['messageId'])) {
            $alert = '<div class="alert alertsuccess">
                         <span>Your Message has been sent! Thank you for contacting us. We will get back to you as soon as we can! :)</span>
                      </div>';
        } else {
            error_log("Mailer Error: " . $response);
            $alert = '<div class="alert alerterror">
                        <span>We are so sorry :(  There was a problem. Please try again later!</span>
                      </div>';
        }
    }
}
?>
<script>
   setTimeout(function() {
      let alert = document.querySelector(".alert");
      if (alert) alert.remove();
   }, 8000);
</script>