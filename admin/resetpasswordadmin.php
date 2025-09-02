
<?php
include('forgotpasswordadmin.php');
?>

<!--alert messages start-->
<?php echo $alert;
?>

<html>

<head>

    <title>Login - The Craft Nest</title>
    <link rel="stylesheet" href="css2/admin.css">
</head>

<body>
  
<div class="login">

<h1 class="text-center">Reset your password</h1>
<br><br>
<div class="form">
  <div class="form-box forgotpassword">

    <form action="" method="POST" class="text-center">
      <div class="field">
        <i class="uil uil-at"></i>
        <input type="email" placeholder="Email-id" required name="emailid">
      </div><br>
      <input class="btn-primary" type="submit" name="send-reset-link" onClick="forgotpasswordadmin.php" value="Send the Link!" >
    </form>
  </div>
</div>
<script type="text/javascript">
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>



