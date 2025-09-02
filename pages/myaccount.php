<?php
include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php';
?>

<?php
if (!isset($_SESSION['loggedin']) && empty($_SESSION['emailid'])) {
    echo '<script> alert("Please Log-in/ Register to access your Account page.");
    window.location.replace("' . BASE_URL . 'pages/account.php");
    </script>';
}
if (!isset($_SESSION['custid'])) {
    echo '<script>
        window.location.href = "' . BASE_URL . 'pages/account.php";
    </script>';
}
?>

<div class="cartcontainer">
<h2 class="heading">My Account</h2>
<h3 class="billing">Recent Orders</h3>

<br> <?php
            $custid = $_SESSION['custid'];
            $sql = "SELECT * FROM orders WHERE custid='$custid'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
           ?>
    <table>
    
        <thead>
            <tr>
                <th>Grand Total</th>
                <th>Order Status</th>
                <th>Date and Time</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            
      <?php  while ($row = mysqli_fetch_assoc($result)) {
         ?>  
       
        <tr>
                        <td>
                            ₹ <?php echo $row["totalprice"] ?>
                        </td>
                        <td>
                            <?php echo $row["orderstatus"] ?>
                        </td>
                        <td>
                            <?php echo $row["timestamp"] ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>pages/vieworder.php?id=<?php echo $row["id"] ?>">View</a>
                            <?php if ($row["orderstatus"] != 'Cancelled') { ?>
                                | <a href="<?= BASE_URL ?>pages/cancelorder.php?id=<?php echo $row["id"] ?>">Cancel</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                }

                ?>
        </tbody>
    </table>
    

<?php } else {
                echo "<h4 class='billing2'>No orders found.</h4>";
            }
?>
   
<br>
<br>
  
 
<h3 class="billing">My Address</h3>
<?php
$sql_add = "SELECT * FROM user_data  WHERE custid='$custid'";
$result_add = mysqli_query($conn, $sql_add);


if (mysqli_num_rows($result_add) > 0) {
    while ($row_add = mysqli_fetch_assoc($result_add)) {
?>
        <p class="addressp">The following address will be used on the checkout page by default.</p>
        <h4 class="billingaddr">Billing Address:</h4>
        <a class="editlink" href="<?= BASE_URL ?>pages/updateaddress.php?id=<?php echo $custid ?>">Edit</a></h4>
        <div class="addrcontainer">
       
            <table>
           
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Postcode</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    
 

                <tr>
                        <td>
                            <?php echo $row_add['name']; ?> </td>
                        <td> <?php echo $row_add['address']; ?> </td>
                        <td><?php echo $row_add['state']; ?> </td>
                        <td> <?php echo $row_add['country']; ?> </td>
                        <td> <?php echo $row_add['postcode']; ?> </td>
                        <td> <?php echo $row_add['phone']; ?> </td>
                        </td>
                    </tr>
                </tbody>
              
            </table>
            <?php
                }

                    ?>
        <?php } else {
            ?>

        <h4 class="billingaddr">Billing Address:</h4>
        <a class="editlink" href="<?= BASE_URL ?>pages/addaddress.php?id=<?php echo $custid ?>">Add</a></h4>
        <br>
        <br>
        <h4 class='billing2'>No address found.</h4>
       <?php
    }
?>
      
        </div>
<div class="space"></div>
</div>
       
<?php include __DIR__ . '/../partials-front/footer.php';  ?>