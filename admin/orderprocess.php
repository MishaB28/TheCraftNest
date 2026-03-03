<?php include('partials/menu.php'); ?>
<div class="main-content">
<?php
if(isset($_POST['submit'])){
	 
	 
     $orderid = $_POST['orderid'];
     $reason = $_POST['reason'];
     $status = $_POST['status'];
     $insertCancel = "INSERT INTO ordertracking (orderid, status, reason )
     VALUES ('$orderid', '$status', '$reason')";  
  
     if(mysqli_query($conn, $insertCancel)){
         $up_sql = "UPDATE orders SET orderstatus='$status'  WHERE id=$orderid";
     mysqli_query($conn, $up_sql);
  header('location:manage-orders.php');
 
     }
  
 
 }
  ?>

    <div class="wrapper">
        <h1>Order Status</h1>
        <br><br>

        <table class="tbl-full">
        <tr>
        <th>Product</th>
						<th>Total Price</th>
					
						<th>Status</th>
						
				
        </tr>
        
        <?php

if(isset($_GET['id']))
{
    $id = $_GET['id'];
}
$current_status = "";
$sql = "SELECT * FROM orders WHERE id='$id'";
$res = mysqli_query($conn, $sql);
if($res==TRUE)
{
    $count = mysqli_num_rows($res);
 
    if($count>0)
    {
        while($row=mysqli_fetch_assoc($res))
        {
            $current_status = $row["orderstatus"];
            ?>
        

        <tr>
						<td>
                        <?php 
                        $sql_proID = "SELECT * FROM orderitems WHERE orderid='$id'";
                        $result_proID = mysqli_query($conn, $sql_proID);
                        if($result_proID ==TRUE)
{    
    $count = mysqli_num_rows($result_proID);
    if($count>0)
    {
        while($row_prodID=mysqli_fetch_assoc($result_proID))
        {
                     
                        $p_id =  $row_prodID['productid'];

                        $sql_ProName = "SELECT * FROM product WHERE id='$p_id'";
                        $result_ProName = mysqli_query($conn, $sql_ProName);
                        if($result_ProName ==TRUE){    
                            $count = mysqli_num_rows($result_ProName);
                            if($count>0)  {
                                while( $row_ProName = mysqli_fetch_assoc($result_ProName))
                                {
                    
                        echo  $row_ProName['title'];?><br><?php
                                }
                            }
                        }
                  
        }
    }
}
                        ?>
    
						</td>
                      
						<td>
						Rs. <?php echo $row["totalprice"] ?>
						</td>
						<td>
						<?php echo $row["orderstatus"] ?>		
						</td>
                        
					
					 
					</tr>
                           

                       
                      

                     <?php
                  
                }
            }
        
    
        }
      
                else{
                    //no data in db
                    ?>
                    
                    <tr>
                        <td colspan="6"><div class='error'>No Orders.</div></td>
                    </tr>





                    <?php
                }
            
                     ?>
                         </table>

                       <form action="" method="POST">
         <table class="tbl-30">
             <br>
         <div class="form-group"><label for="sel1">Change Status:</label>
  <select class="form-control" name="status">
    <option value="In Progress" <?php if($current_status=="In Progress") echo "selected"; ?>>In Progress</option>
    <option value="Dispatched" <?php if($current_status=="Dispatched") echo "selected"; ?>>Dispatched</option>
    <option value="Delivered" <?php if($current_status=="Delivered") echo "selected"; ?>>Delivered</option>
    <option value="Cancelled" <?php if($current_status=="Cancelled") echo "selected"; ?>>Cancelled</option>
  </select>
  <br>
  <label>Reason:
	</label>
	
	<textarea class="form-control" name="reason" placeholder="" rows="2" cols="20"></textarea>
		
                          <td colspan="2">
                <input type="hidden" name='orderid' value='<?php echo $_GET['id'] ?>'>
          
                  
                     <input type="submit" name="submit" class="btn-secondary" value="Change Status">
                </td>
              
         </table>
         </form>
        










         </div>
</div>

</div>

<?php include('partials/footer.php'); ?>