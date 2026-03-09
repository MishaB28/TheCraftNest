<?php
ob_start();
include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php';

if (!isset($_SESSION['loggedin']) || empty($_SESSION['emailid'])) {
    echo '<script>alert("Please Log-in/ Register to Checkout.");
        window.location.replace("' . BASE_URL . 'pages/account.php");</script>';
    exit;
}
if (!isset($_SESSION['custid'])) {
    echo '<script>window.location.href = "' . BASE_URL . 'pages/account.php";</script>';
    exit;
}

$total = 0;
$cart = $_SESSION['cart'] ?? [];
foreach ($cart as $key => $value) {
    $sql_cart = "SELECT * FROM product WHERE id = $key";
    $result_cart = mysqli_query($conn, $sql_cart);
    $row_cart = mysqli_fetch_assoc($result_cart);
    $total += ($row_cart['price'] * $value['quantity']);
}

$custid = $_SESSION['custid'];
$sql = "SELECT * FROM user_data WHERE custid = $custid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<div class="cartcontainer">
    <h2 class="heading">Checkout</h2>
    <div class="billing-details">
        <h3 class="billing">Billing Details:</h3>

        <form id="checkoutForm">

            <label>Full Name:</label>
            <div class="field2">
            <input type="text" id="name" name="name" required value="<?php echo $row['name'] ?? ''; ?>">
            </div>

            <label>Email Address:</label>
            <div class="field2">
            <input type="email" id="regemail" name="email" required value="<?php echo $_SESSION['emailid']; ?>">
            </div>

            <label>Phone:</label>
            <div class="field2">
            <input type="text" name="phone" id="phone" required value="<?php echo $row['phone'] ?? ''; ?>">
            </div>

            <label>Address:</label>
            <div class="field2">
            <textarea id="address" name="address" required><?php echo $row['address'] ?? ''; ?></textarea>
            </div>

            <label>Country:</label>
            <div class="field2">
            <select name="country" required>
            <option value="India" selected>India</option>
            </select>
            </div>

            <label>State:</label>
            <div class="field2">
            <select class="form-control" name="state" required>

            <option value="">Select State / UT</option>

            <option value="Andhra Pradesh" <?php if(($row['state'] ?? '')=='Andhra Pradesh') echo 'selected'; ?>>Andhra Pradesh</option>

            <option value="Arunachal Pradesh" <?php if(($row['state'] ?? '')=='Arunachal Pradesh') echo 'selected'; ?>>Arunachal Pradesh</option>

            <option value="Assam" <?php if(($row['state'] ?? '')=='Assam') echo 'selected'; ?>>Assam</option>

            <option value="Bihar" <?php if(($row['state'] ?? '')=='Bihar') echo 'selected'; ?>>Bihar</option>

            <option value="Chhattisgarh" <?php if(($row['state'] ?? '')=='Chhattisgarh') echo 'selected'; ?>>Chhattisgarh</option>

            <option value="Goa" <?php if(($row['state'] ?? '')=='Goa') echo 'selected'; ?>>Goa</option>

            <option value="Gujarat" <?php if(($row['state'] ?? '')=='Gujarat') echo 'selected'; ?>>Gujarat</option>

            <option value="Haryana" <?php if(($row['state'] ?? '')=='Haryana') echo 'selected'; ?>>Haryana</option>

            <option value="Himachal Pradesh" <?php if(($row['state'] ?? '')=='Himachal Pradesh') echo 'selected'; ?>>Himachal Pradesh</option>

            <option value="Jharkhand" <?php if(($row['state'] ?? '')=='Jharkhand') echo 'selected'; ?>>Jharkhand</option>

            <option value="Karnataka" <?php if(($row['state'] ?? '')=='Karnataka') echo 'selected'; ?>>Karnataka</option>

            <option value="Kerala" <?php if(($row['state'] ?? '')=='Kerala') echo 'selected'; ?>>Kerala</option>

            <option value="Madhya Pradesh" <?php if(($row['state'] ?? '')=='Madhya Pradesh') echo 'selected'; ?>>Madhya Pradesh</option>

            <option value="Maharashtra" <?php if(($row['state'] ?? '')=='Maharashtra') echo 'selected'; ?>>Maharashtra</option>

            <option value="Manipur" <?php if(($row['state'] ?? '')=='Manipur') echo 'selected'; ?>>Manipur</option>

            <option value="Meghalaya" <?php if(($row['state'] ?? '')=='Meghalaya') echo 'selected'; ?>>Meghalaya</option>

            <option value="Mizoram" <?php if(($row['state'] ?? '')=='Mizoram') echo 'selected'; ?>>Mizoram</option>

            <option value="Nagaland" <?php if(($row['state'] ?? '')=='Nagaland') echo 'selected'; ?>>Nagaland</option>

            <option value="Odisha" <?php if(($row['state'] ?? '')=='Odisha') echo 'selected'; ?>>Odisha</option>

            <option value="Punjab" <?php if(($row['state'] ?? '')=='Punjab') echo 'selected'; ?>>Punjab</option>

            <option value="Rajasthan" <?php if(($row['state'] ?? '')=='Rajasthan') echo 'selected'; ?>>Rajasthan</option>

            <option value="Sikkim" <?php if(($row['state'] ?? '')=='Sikkim') echo 'selected'; ?>>Sikkim</option>

            <option value="Tamil Nadu" <?php if(($row['state'] ?? '')=='Tamil Nadu') echo 'selected'; ?>>Tamil Nadu</option>

            <option value="Telangana" <?php if(($row['state'] ?? '')=='Telangana') echo 'selected'; ?>>Telangana</option>

            <option value="Tripura" <?php if(($row['state'] ?? '')=='Tripura') echo 'selected'; ?>>Tripura</option>

            <option value="Uttar Pradesh" <?php if(($row['state'] ?? '')=='Uttar Pradesh') echo 'selected'; ?>>Uttar Pradesh</option>

            <option value="Uttarakhand" <?php if(($row['state'] ?? '')=='Uttarakhand') echo 'selected'; ?>>Uttarakhand</option>

            <option value="West Bengal" <?php if(($row['state'] ?? '')=='West Bengal') echo 'selected'; ?>>West Bengal</option>

            <option value="Andaman and Nicobar Islands" <?php if(($row['state'] ?? '')=='Andaman and Nicobar Islands') echo 'selected'; ?>>Andaman and Nicobar Islands</option>

            <option value="Chandigarh" <?php if(($row['state'] ?? '')=='Chandigarh') echo 'selected'; ?>>Chandigarh</option>

            <option value="Dadra and Nagar Haveli and Daman and Diu" <?php if(($row['state'] ?? '')=='Dadra and Nagar Haveli and Daman and Diu') echo 'selected'; ?>>Dadra and Nagar Haveli and Daman and Diu</option>

            <option value="Delhi" <?php if(($row['state'] ?? '')=='Delhi') echo 'selected'; ?>>Delhi</option>

            <option value="Jammu and Kashmir" <?php if(($row['state'] ?? '')=='Jammu and Kashmir') echo 'selected'; ?>>Jammu and Kashmir</option>

            <option value="Ladakh" <?php if(($row['state'] ?? '')=='Ladakh') echo 'selected'; ?>>Ladakh</option>

            <option value="Lakshadweep" <?php if(($row['state'] ?? '')=='Lakshadweep') echo 'selected'; ?>>Lakshadweep</option>

            <option value="Puducherry" <?php if(($row['state'] ?? '')=='Puducherry') echo 'selected'; ?>>Puducherry</option>

            </select>
            </div>

            <label>Postcode:</label>
            <div class="field2">
            <input type="text" name="postcode" required value="<?php echo $row['postcode'] ?? ''; ?>">
            </div>

            <div class="field2">
                 <h3 class="billing">Your Order</h3>
            </div>
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
            <input type="checkbox" name="agree" value="true" required>
            &nbsp &nbspI accept the &nbsp <a href="<?= BASE_URL ?>pages/terms&conditions.php">Terms & Conditions</a>
            </label>

            <br><br>

            <center>
            <button type="button" id="payBtn" class="chkoutbtn">Pay Now</button>
            </center>

        </form>
    </div>
</div>

<script src="<?= BASE_URL ?>js/validate.js"></script>
<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
<script>
(async function () {
    const cashfree = await Cashfree({ mode: "sandbox" });

    document.getElementById('payBtn').addEventListener('click', async function () {
        const form = document.getElementById('checkoutForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }

        const formData = new FormData(form);

        try {
            const saveRes = await fetch('<?= BASE_URL ?>pages/saveuserdata.php', {
                method: 'POST',
                body: formData
            });
            const saveData = await saveRes.json();
            if (!saveData.success) {
                alert('Could not save address. Please try again.');
                return;
            }
        } catch (e) {
            console.error(e);
            alert('Network error saving address.');
            return;
        }

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

            cashfree.checkout({ paymentSessionId: data.payment_session_id, redirectTarget: "_self" });
        } catch (e) {
            console.error(e);
            alert('Network error starting payment.');
        }
    });
})();
</script>