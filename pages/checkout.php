<?php
ob_start();

include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php';

if (!isset($_SESSION['loggedin']) && empty($_SESSION['emailid'])) {

       echo '<script>
             alert("Please Log-in/ Register to Checkout.");
             window.location.replace("' . BASE_URL . 'pages/account.php");
         </script>';

}
if (!isset($_SESSION['custid'])) {
    echo '<script>
            window.location.href = "' . BASE_URL . 'pages/account.php";
        </script>';
}

$total = 0;
if (isset($_SESSION['cart'])) {
	$cart =  $_SESSION['cart'];
	foreach ($cart as $key => $value) {
		$sql_cart = "SELECT * FROM product where id = $key";
		$result_cart = mysqli_query($conn, $sql_cart);
		$row_cart = mysqli_fetch_assoc($result_cart);
		$total = $total +  ($row_cart['price'] * $value['quantity']);
	}
}

$custid = $_SESSION['custid'];
$sql = "SELECT * FROM user_data where custid = $custid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<div class="cartcontainer">

<h2 class="heading">Checkout</h2>

<div class="billing-details">
<h3 class="billing">Billing Details:</h3>

<form id="checkoutForm" method="POST">

<label>Full Name:</label>
<input class="form-control" id="name" name="name" required
value="<?php if(isset($row['name'])) echo $row['name']; ?>">

<label>Email Address:</label>
<input class="form-control" id="regemail" name="email" required
value="<?php echo $_SESSION['emailid']; ?>">

<label>Phone:</label>
<input class="form-control" name="phone" id="phone" required
value="<?php if(isset($row['phone'])) echo $row['phone']; ?>">

<label>Address:</label>
<textarea class="form-control" id="address" name="address" required><?php if(isset($row['address'])) echo $row['address']; ?></textarea>

<label>Country:</label>
<select class="form-control" name="country" required>
<option value="India" selected>India</option>
</select>

<label>State:</label>
<select class="form-control" name="state" required>
<option value="">Select State</option>
<option value="Telangana">Telangana</option>
<option value="Andhra Pradesh">Andhra Pradesh</option>
</select>

<label>Postcode:</label>
<input class="form-control" name="postcode" required
value="<?php if(isset($row['postcode'])) echo $row['postcode']; ?>">

<input type="hidden" name="amount" value="<?php echo $total; ?>">
<input type="hidden" name="submit" value="1">

<h3 class="billing">Your Order</h3>

<p>Total: ₹ <?php echo $total; ?></p>

<label>
<input type="checkbox" name="agree" value="true" required>
I accept the <a href="<?= BASE_URL ?>pages/terms&conditions.php">Terms & Conditions</a>
</label>

<br><br>

<center>

<span id="submit-error"></span>

<button type="submit" id="payBtn" class="chkoutbtn">
Pay Now
</button>

</center>

</form>

</div>
</div>


<script src="<?= BASE_URL ?>js/validate.js"></script>
<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>

<script>

(async function () {

const cashfree = await Cashfree({ mode: "sandbox" });

document.getElementById('checkoutForm').addEventListener('submit', async function (e) {

e.preventDefault();

/* run validation first */
if (!this.checkValidity()) {
this.reportValidity();
return;
}

const formData = new FormData(this);

try {

const res = await fetch('<?= BASE_URL ?>pages/cashfree_order.php', {
method: 'POST',
body: formData
});

const data = await res.json();

console.log("Cashfree response:", data);

if (!data.payment_session_id) {
alert('Could not start payment. Please try again.');
return;
}

cashfree.checkout({
paymentSessionId: data.payment_session_id,
redirectTarget: "_self"
});

} catch (e) {

alert('Network error starting payment.');
console.error(e);

}

});

})();

</script>

<?php
include __DIR__ . '/../partials-front/footer.php';
ob_end_flush();
?>