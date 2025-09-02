<?php  

include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php';
if(!isset($_SESSION['loggedin']) && empty($_SESSION['cust']) ){
    header('Location: ' . SITEURL . 'pages/account.php');
}

 
if(!isset($_SESSION['custid'])){
	echo '<script>window.location.href = "' . BASE_URL . 'account.php";</script>';

}

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
 

$alert  = '';
$_POST['agree'] = 'false';

if(isset($_POST['submit'])){
	 
	 
	$orderid = $_POST['orderid'];
    $reason = $_POST['reason'];
    $status = 'Cancelled';

 
    $insertCancel = "INSERT INTO ordertracking (orderid, status, reason )
	VALUES ('$orderid', '$status', '$reason')";  

	if(mysqli_query($conn, $insertCancel)){
    $up_sql = "UPDATE orders SET orderstatus='Cancelled'  WHERE id=$orderid";
 mysqli_query($conn, $up_sql);
 header('Location: ' . SITEURL . 'myaccount.php');

    }
//   update query
// $up_sql = "UPDATE user_data SET firstname='$fname', lastname='$lname', company='$companyName', address1='$addr1', address2='$addr2', city='$city', country='$country', zip='$Postcode', mobile='$Phone'  WHERE userid=$cid";

// $Updated = mysqli_query($conn, $up_sql);
     
 

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



if(isset($_SESSION['cart'])){
	$total = 0;
	foreach($cart as $key => $value){
	 // echo $key ." : ". $value['quantity'] . "<br>";
	 
	 $sql_cart = "SELECT * FROM product where id = $key";
	$result_cart = mysqli_query($conn, $sql_cart);
	$row_cart = mysqli_fetch_assoc($result_cart);
	$total = $total +  ($row_cart['price'] * $value['quantity']);
}
}



?>
   <a href="<?= BASE_URL ?>pages/myaccount.php"><h2 class='heading'>My Account</h2></a>


	<h3 class="billing">Cancel your Order</h3>
	<h4 class="billing2">Full refund will only be given if the items are returned to us in their original condition with price tags attached.<h4>
							<br>
							<br>
							<br>
				
<form method='post'>
<?php echo $alert ?>
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
                        Rs. <?php echo  $row_orders['totalprice'] ?>
						</th>
                        <th></th>
						<th></th>
					</tr>
                    </tfooter>
			</table>		

		 	 
						<br>
						<br>
							<label>Your Reason:</label>
 						 <textarea class="form-control" name='reason' id="" cols="30" rows="10" required></textarea>
					 
			
        
    
                <input type="hidden" name='orderid' value='<?php echo $_GET['id'] ?>'>
                <input type='submit' name='submit' value='Cancel the Order' class="cancelbtn">
  

</form>





</div>

<?php include __DIR__ . '/../partials-front/footer.php';  ?>