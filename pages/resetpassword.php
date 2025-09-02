<?php include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php';
include __DIR__ . '/login_register.php';
include __DIR__ . '/forgotpassword.php';
?>

<!--alert messages start-->
<?php echo $alert;
?>

<div class="form">
  <div class="form-box forgotpassword">
    <h2>Reset your password:</h2>
    <form action="" method="POST" action="<?= BASE_URL ?>pages/forgotpassword.php">
      <div class="field">
        <i class="uil uil-at"></i>
        <input type="email" placeholder="Email Id" required name="emailid">
      </div>
      <input class="pwd-btn" type="submit" value="Send the Link!" name="send-reset-link">
    </form>
  </div>
</div>
<script type="text/javascript">
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

<?php include __DIR__ . '/../partials-front/footer.php'; ?>