<?php 
include __DIR__ . '/../partials-front/menu.php';

require_once __DIR__ . '/../connection.php';
 
if (!isset($_SESSION['loggedin']) && empty($_SESSION['emailid'])) {
	header('Location: ' . SITEURL . 'pages/account.php');
}
if (!isset($_SESSION['custid'])) {
	echo '<script>
        window.location.href = "' . BASE_URL . 'pages/account.php";
    </script>';
}
?>

<div class="cartcontainer">
    <a href="<?= BASE_URL ?>pages/myaccount.php"><h2 class='heading'>My Account</h2></a>



			<h3 class="billing">View your Orders</h3>
			<br>
			<table>
				<thead>
					<tr>
						<th>Product</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Total Price</th>
					
						<th>Order Status</th>
						<th>Date and Time</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$custid = $_SESSION['custid'];

 if(isset($_GET['id'])){
    $id = $_GET['id'];
 }


 $sql_orders = "SELECT * FROM orders WHERE id='$id' AND custid='$custid'";
 $result_orders = mysqli_query($conn, $sql_orders);

 $row_orders = mysqli_fetch_assoc($result_orders);
  
				$sql = "SELECT * FROM orderitems WHERE orderid='$id'";
				$result = mysqli_query($conn, $sql);
			  
				if (mysqli_num_rows($result) > 0) {
			 
				 while($row = mysqli_fetch_assoc($result)) {
                  $prodID = $row["productid"]; 
 			?>
					<tr>
						<td>

                        <?php 
                        
                        $sql_product = "SELECT * FROM product WHERE id='$prodID'";
                        $result_prod = mysqli_query($conn, $sql_product);
                      
                     $row_prod = mysqli_fetch_assoc($result_prod);
                     
                      
                        
                        ?>


<a href="<?= BASE_URL ?>pages/singleproduct.php?id=<?php echo $prodID ;?>"><?php echo $row_prod['title'];?></a>
					 
						</td>
						<td>
						<?php echo $row["quantity"] ?>
						</td>
						<td>
                        Rs. <?php echo $row["productprice"] ?>		
						</td>
						<td>
						Rs. <?php echo $row["quantity"] * $row["productprice"] ?>		
						</td>
					 
					 	<td>
                         <?php echo  $row_orders['orderstatus'] ?>
						</td>
					 	<td>
                        <?php echo  $row_orders['timestamp'] ?>	
						</td>
					 
					</tr>
				 
			
			<?php
				}
			   } else {
				 echo "0 results";
			   }
			 
			 
			 ?>




				
				</tbody>
     
                <tfooter>
					<tr>
						<th></th>
						<th></th>
						<th>Grand Total</th>
						<th>
                        Rs.  <?php echo  $row_orders['totalprice'] ?>
						</th>
                        <th></th>
						<th></th>
					</tr>
                    </tfooter>
			</table>		

		 

            <br>
            <br>
    <h3 class="billing">My Address</h3>
    <p class="addressp">The following address will be used on the checkout page by default.</p>
    <h4 class="billingaddr">Billing Address:
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
        <?php
    $sql_add = "SELECT * FROM user_data  WHERE custid='$custid'";
    $result_add = mysqli_query($conn, $sql_add);

    $row_add = mysqli_fetch_assoc($result_add);
    ?>
    <tr>
    <td>
        <?php     echo $row_add['name']; ?>   </td>
        <td>    <?php        echo $row_add['address'];?>   </td>
        <td><?php        echo $row_add['state'] ; ?>   </td>
        <td>  <?php      echo $row_add['country']; ?>   </td>
        <td>  <?php        echo $row_add['postcode'] ; ?>   </td>
        <td> <?php         echo $row_add['phone']; ?>   </td>
 
    </td>
    </tbody>
    </table>
        </div>
   

</div>


        <?php include __DIR__ . '/../partials-front/footer.php';  ?>