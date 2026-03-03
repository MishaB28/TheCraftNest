<?php include __DIR__ . '/../partials-front/menu.php';?>
<?php include __DIR__ . '/contactmail.php';
require_once __DIR__ . '/../connection.php';
?>

<!--alert messages start-->
<?php echo $alert;


?>
  <h2 class="contactheading">Contact Us</h2>

<!--alert messages end-->
<div class="contact-section">
  <div class="contactinfo">
    <div><img src="<?= BASE_URL ?>Images/message.png" class="message">MAIL_ID</div>
    <div><img src="<?= BASE_URL ?>Images/phone.png" class="phone">PHONE_NUMBER</div>
    <div><img src="<?= BASE_URL ?>Images/clock.png" class="clock">Mon - Fri 10:00 AM to 6:00 PM</div>
  </div>
  <div class="contactform">
 <span id="submit-error"></span><br>
    <form class="contact" name="form" method="POST">
      <div class="inputgroup">
      <label for="name">Name:</label>
        <input type="text" name="name" id="name" class="textbox" placeholder="Your name" onkeyup="validateName()">
        <span id="correct"></span>
        
      </div>
    <div class="msg">  <span id="name-error"></span></div>
      <div class="inputgroup">  
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" class="textbox" placeholder="Your email" onkeyup="validateEmail()">
      <span id="correct"></span>
    
      </div>
      <div class="msg"> <span id="email-error"></span></div>
      <div class="inputgroup">
      <label for="subject">Subject:</label>
      <input type="text" name="subject" id="subject" class="textbox" placeholder="Subject" onkeyup="validateSubject()"><br>
      <span id="correct"></span>
      <span id="subject-error"></span>
      </div>
    
      <div class="inputgroup">
      <label for="message">Message:</label>
      <textarea name="message" id="message" row="5" cols="80" placeholder="Your message" onkeyup="validateMessage()"></textarea>
      <span id="correct"></span>
      <span id="message-error"></span>
      </div>
        

   <input type="submit" name="submit" class="send-btn" onclick="return validateForm()" value="Send"></a>
    
    
    </form>
  </div>
</div>
<?php
if (!empty($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $query = "INSERT INTO contactus (name, email, subject, message) VALUES ( '$name','$email', '$subject', '$message')";
  if (mysqli_query($conn, $query)) {
    $alert = '<div class="alert alertsuccess">
        <span>We have recieved you mail.</span>
       </div>';
  } else {
    $alert = "<div class='alert alerterror'>
        <span>We are so sorry :( we didn't recieve your mail. Please try again.</span>
      </div>";
  }
}
?>
<script src="<?= BASE_URL ?>js/validate.js"></script>
<script type="text/javascript">
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

<?php include __DIR__ . '/../partials-front/footer.php'; ?>