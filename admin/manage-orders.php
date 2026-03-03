<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
    <h1>Manage Orders:</h1>
   
       <br>

    <table class="tbl-full">
        <tr>
            <th>S.No.</th>
            <th>Customer Name</th>
						<th>Total Price</th>
						<th>Order Status</th>
					
                        <th>Order Placed On</th>
                        <th>Actions</th> 
        </tr>
        
        <?php

$sql = "SELECT orders.id, orders.totalprice, orders.orderstatus, orders.timestamp, user_data.name FROM orders JOIN user_data ON orders.custid=user_data.custid ORDER BY `orders`.`id` DESC    ";
   
$res = mysqli_query($conn, $sql);
if($res==TRUE)
{
    $count = mysqli_num_rows($res);
    $sn=1;
    if($count>0)
    {
        while($row=mysqli_fetch_assoc($res)){

      
            ?>
        

                        <tr>
                            <td><?php echo $sn++ ?></td>
                          
            <td><?php echo $row["name"] ?></td>
            <td><?php echo $row["totalprice"] ?></td>
            <td><?php echo $row["orderstatus"] ?></td>
          
            <td><?php echo date('M j g:i A', strtotime($row["timestamp"]));  ?>		</td>
            <td> <a href="<?= BASE_URL ?>admin/orderprocess.php?id=<?php echo $row['id']; ?>" class="btn-secondary">Change Order Status</a>
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
    </div>
 
</div>


<?php include('partials/footer.php') ?>