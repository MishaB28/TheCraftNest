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
		// echo $key ." : ". $value['quantity'] . "<br>";
		$sql_cart = "SELECT * FROM product where id = $key";
		$result_cart = mysqli_query($conn, $sql_cart);
		$row_cart = mysqli_fetch_assoc($result_cart);
		$total = $total +  ($row_cart['price'] * $value['quantity']);
	}
}
$alert  = '';
$_POST['agree'] = 'false';
if (isset($_POST['submit'])) {
	if ($_POST['agree'] == true) {
		$country = $_POST['country'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$state = $_POST['state'];
		$postcode = $_POST['postcode'];
		$email = '';
		$phone = $_POST['phone'];
		$agree = $_POST['agree'];
		$custid = $_SESSION['custid'];
		$sql = "SELECT * FROM user_data WHERE custid = $custid";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) == 1) {
			//   update query
			$up_sql = "UPDATE `user_data` SET `name`='$name',`address`='$address',`state`='$state',`country`='$country',`postcode`='$postcode',`phone`='$phone' WHERE custid=$custid";
			$Updated = mysqli_query($conn, $up_sql);
			if ($Updated) {
				if (isset($_SESSION['cart'])) {
					$total = 0;
					foreach ($cart as $key => $value) {
						// echo $key ." : ". $value['quantity'] . "<br>";
						$sql_cart = "SELECT * FROM product where id = $key";
						$result_cart = mysqli_query($conn, $sql_cart);
						$row_cart = mysqli_fetch_assoc($result_cart);
						$total = $total +  ($row_cart['price'] * $value['quantity']);
					}
				}
				$insertOrder = "INSERT INTO orders (custid, totalprice, orderstatus)
		VALUES ('$custid', '$total', 'Order Placed')";
				if (mysqli_query($conn, $insertOrder)) {
					$orderid = mysqli_insert_id($conn);
					foreach ($cart as $key => $value) {
						$sql_cart = "SELECT * FROM product where id = $key";
						$result_cart = mysqli_query($conn, $sql_cart);
						$row_cart = mysqli_fetch_assoc($result_cart);
						$price_product = $row_cart["price"];
						$q  = $value["quantity"];
						$insertordersItems = "INSERT INTO orderitems (productid, quantity, orderid, productprice) 
				VALUES ('$key', '$q', '$orderid', '$price_product')";
						if (mysqli_query($conn, $insertordersItems)) {
							//    echo 'inserted on both table orders and ordersItems';
							unset($_SESSION['cart']);
							// header("location:myaccount.php");
						}
					}
				}
			}
		} else {
			// insert 
			$ins_sql = "INSERT INTO user_data (custid, name, address, state, country, postcode, phone)
	  VALUES ('$custid', '$name', '$address', '$state', '$country', '$postcode', '$phone')";
			$inserted = mysqli_query($conn, $ins_sql);
			if ($inserted) {
				// echo 'order table and order items - inserted';
				if (isset($_SESSION['cart'])) {
					$total = 0;
					foreach ($cart as $key => $value) {
						// echo $key ." : ". $value['quantity'] . "<br>";
						$sql_cart = "SELECT * FROM product where id = $key";
						$result_cart = mysqli_query($conn, $sql_cart);
						$row_cart = mysqli_fetch_assoc($result_cart);
						$total = $total +  ($row_cart['price'] * $value['quantity']);
					}
				}
				$insertOrder = "INSERT INTO orders (custid, totalprice, orderstatus)
		VALUES ('$custid', '$total', 'Order Placed')";
				if (mysqli_query($conn, $insertOrder)) {
					$orderid = mysqli_insert_id($conn);
					foreach ($cart as $key => $value) {
						$sql_cart = "SELECT * FROM product where id = $key";
						$result_cart = mysqli_query($conn, $sql_cart);
						$row_cart = mysqli_fetch_assoc($result_cart);
						$price_product = $row_cart["price"];
						$q  = $value["quantity"];
						$insertordersItems = "INSERT INTO orderitems (productid, quantity, orderid, productprice) 
				VALUES ('$key', '$q', '$orderid', '$price_product')";
						if (mysqli_query($conn, $insertordersItems)) {
							//    echo 'inserted on both table orders and ordersItems';
							unset($_SESSION['cart']);
							// header("location:myaccount.php");
						}
					}
				}
			}
		}
	} else {
		$alert = '<div class="alert alerterror">
		<span>Please agree to the Terms and Conditions.</span>
	   </div>';
	}
}
$custid = $_SESSION['custid'];
$sql = "SELECT * FROM user_data where custid = $custid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<div class="cartcontainer">
	<?php
	if (isset($_SESSION['cart'])) {
		$total = 0;
		foreach ($cart as $key => $value) {
			// echo $key ." : ". $value['quantity'] . "<br>";
			$sql_cart = "SELECT * FROM product where id = $key";
			$result_cart = mysqli_query($conn, $sql_cart);
			$row_cart = mysqli_fetch_assoc($result_cart);
			$total = $total +  ($row_cart['price'] * $value['quantity']);
		}
	}
	?>
	<h2 class="heading">Checkout</h2>
	<div class="billing-details">
		<h3 class="billing">Billing Details:</h3>
            <form id="checkoutForm">

			<?php echo $alert; ?>

			<label>Full Name:</label>
			<div class="field2">
				<input class="form-control" id="name" name="name" placeholder="" value="<?php if (isset($row['name'])) {
																							echo $row['name'];
																						} ?>" type="text" onkeyup="validateName()">
				<span id="correct"></span>
			</div>
			<div class="msg"> <span id="name-error"></span></div><br>
			<label>Email Address:</label>
			<div class="field2">
				<input class="form-control" id="regemail" name="email" placeholder="" value="<?php echo $_SESSION['emailid']; ?>" type="email" onkeyup="validateRegEmail()">
				<span id="regemailcorrect"></span>
			</div>
			<div class="msg"> <span id="regemail-error"></span></div><br>
			<label>Phone:</label>
			<div class="field2">
				<input class="form-control" name="phone" id="phone" placeholder="" value="<?php if (isset($row['phone'])) {
																								echo $row['phone'];
																							} ?>" type="number" onkeyup="validatePhone()">
				<span id="pcorrect"></span>
			</div>
			<div class="msg"><span id="phone-error"></span> </div><br>
			<label>Address:
			</label>
			<div class="field2">
				<textarea class="form-control" id="address" name="address" placeholder="Street address, Apartment, Suite, Unit etc." onkeyup="validateAddress()" row="5" cols="20"><?php if (isset($row['address'])) {
																																														echo $row['address'];
																																													} ?></textarea>
				<span id="acorrect"></span>

			</div>
			<div class="msg"><span id="address-error"></span> </div>
			<br>
			<br>
			<label class="form-control">Country:
			</label>
			<div class="field2">
				<select class="form-control" name="country" id="country" required>
					<option value="" disabled="disabled">Select Country</option>
					<option value="India" selected>India</option>
				</select>

			</div>
			<br>
			<label class="form-control" required>State:</label>
			<div class="field2">
				<select class="form-control" name="state">
					<option value="" disabled="disabled">Select State</option>
					<option value="Andhra Pradesh">Andhra Pradesh</option>
					<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
					<option value="Arunachal Pradesh">Arunachal Pradesh</option>
					<option value="Assam">Assam</option>
					<option value="Bihar">Bihar</option>
					<option value="Chandigarh">Chandigarh</option>
					<option value="Chhattisgarh">Chhattisgarh</option>
					<option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
					<option value="Daman and Diu">Daman and Diu</option>
					<option value="Delhi">Delhi</option>
					<option value="Lakshadweep">Lakshadweep</option>
					<option value="Puducherry">Puducherry</option>
					<option value="Goa">Goa</option>
					<option value="Gujarat">Gujarat</option>
					<option value="Haryana">Haryana</option>
					<option value="Himachal Pradesh">Himachal Pradesh</option>
					<option value="Jammu and Kashmir">Jammu and Kashmir</option>
					<option value="Jharkhand">Jharkhand</option>
					<option value="Karnataka">Karnataka</option>
					<option value="Kerala">Kerala</option>
					<option value="Madhya Pradesh">Madhya Pradesh</option>
					<option value="Maharashtra">Maharashtra</option>
					<option value="Manipur">Manipur</option>
					<option value="Meghalaya">Meghalaya</option>
					<option value="Mizoram">Mizoram</option>
					<option value="Nagaland">Nagaland</option>
					<option value="Odisha">Odisha</option>
					<option value="Punjab">Punjab</option>
					<option value="Rajasthan">Rajasthan</option>
					<option value="Sikkim">Sikkim</option>
					<option value="Tamil Nadu">Tamil Nadu</option>
					<option value="Telangana" selected>Telangana</option>
					<option value="Tripura">Tripura</option>
					<option value="Uttar Pradesh">Uttar Pradesh</option>
					<option value="Uttarakhand">Uttarakhand</option>
					<option value="West Bengal">West Bengal</option>
				</select>
			</div><br>
			<label>Postcode:</label>
			<div class="field2">
				<input class="form-control" name="postcode" id="pincode" onkeyup="validatePincode()" placeholder="Postcode / Zip" value="<?php if (isset($row['postcode'])) {
																																				echo $row['postcode'];
																																			} ?>" type="text">

				<span id="pincorrect"></span>

			</div>
			<div class="msg"><span id="pin-error"></span> </div>
	</div>
	<h3 class="billing">Your Order</h3>
	<table class="amt">
		<tbody>
			<tr>
				<th>Cart Subtotal:</th>
				<td><span class="total-amount"> INR <?php echo $total; ?>.00/-</span></td>
				<input type="hidden" class="form-control" name="amount" Value="<?php echo $total; ?>" readonly>
			</tr>
			<tr>
				<th>Shipping and Handling:</th>
				<td>
					Free Shipping!
				</td>
			</tr>
		</tbody>
	</table><br>
	<br>
	<label>
		<input type="checkbox" required checked>
		&nbsp &nbspI've read and I accept the &nbsp <a href="<?= BASE_URL ?>pages/terms&conditions.php"> terms &amp; conditions.</a>
	</label>
	<br>
	<br><br>
	<center>
		<span id="submit-error"></span>
        <button type="button" id="payBtn" class="chkoutbtn">Pay Now</button>


	</center>
	</form>
</div>

<script src="<?= BASE_URL ?>js/validate.js"></script>
<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
<script>
(async function () {
  const cashfree = await Cashfree({ mode: "sandbox" });

  document.getElementById('payBtn').addEventListener('click', async function () {
    const amount = document.querySelector('input[name="amount"]').value;
    const name   = document.getElementById('name')?.value || 'Test User';
    const email  = document.getElementById('regemail')?.value || 'test@test.com';
    const phone  = document.getElementById('phone')?.value || '9999999999';

    const formData = new FormData();
    formData.append('amount', amount);
    formData.append('name',   name);
    formData.append('email',  email);
    formData.append('phone',  phone);

    try {
      const res  = await fetch('cashfree_order.php', { method: 'POST', body: formData });
      const data = await res.json();
      console.log("Cashfree response:", data);

      if (!data.payment_session_id) {
        alert('Could not start payment. Please try again.');
        return;
      }

      // Open Cashfree checkout
      cashfree.checkout({
        paymentSessionId: data.payment_session_id,
        redirectTarget: "_self" // after payment goes to thankyou.php
      });
    } catch (e) {
      alert('Network error starting payment.');
      console.error(e);
    }
  });
})();
</script>


<?php include __DIR__ . '/../partials-front/footer.php';
ob_end_flush();
?>