<?php  

include __DIR__ . '/../partials-front/menu.php';

require_once __DIR__ . '/../connection.php';


 
if(!isset($_SESSION['custid']) && empty($_SESSION['custid']) ){
 header('Location: ' . SITEURL . 'pages/account.php');
}

 
if(!isset($_SESSION['custid'])){
	echo '<script>
        window.location.href = "' . BASE_URL . 'pages/account.php";
    </script>';

}

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
 


$alert  = '';

if(isset($_POST['submit'])){
	 

	$country = $_POST['country'];
	$name = $_POST['name'];
	$address = $_POST['address'];
	$state = $_POST['state'];
	$postcode = $_POST['postcode'];
	$email = '';
	$phone = $_POST['phone'];

	$custid = $_SESSION['custid']; 

	$sql = "SELECT * FROM user_data WHERE custid = $custid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


if (mysqli_num_rows($result) == 1) {
	//   update query
	$up_sql = "UPDATE `user_data` SET `name`='$name',`address`='$address',`state`='$state',`country`='$country',`postcode`='$postcode',`phone`='$phone' WHERE custid=$custid";
	$Updated = mysqli_query($conn, $up_sql);

	header('Location: ' . SITEURL . 'pages/myaccount.php');
	 
}

}
 

 


$custid =$_SESSION['custid'];

$sql = "SELECT * FROM user_data where custid = $custid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


 ?>



 
 

<div class="cartcontainer">

<?php
// echo "<pre>";
// print_r($_SESSION['cart']);
// echo "</pre>";




?>

<a href="<?= BASE_URL ?>pages/myaccount.php"><h2 class='heading'>My Account</h2></a>


						<h3 class="billing">Update your Address</h3>
						 
				


<div class="billing-details">

		<form  method="POST">
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

		 
	
			<input type='submit' name='submit' onclick="return validateForm3()" value='Update the Address' class="cancelbtn"><span id="submit-error"></span>  
			  </form>
</div>
</div><script src="<?= BASE_URL ?>js/validate.js"></script>
<?php include __DIR__ . '/../partials-front/footer.php';?>


