<?php
include("layout.php");
include("config.php");

session_start();
if(!isset($_SESSION['username'])){
	header('location: login.php');
}

if($_SESSION['type']=='customer'){
	header('location: login.php');
}
else{
	include("menu_admin_2.php");
	//include("menu_customer.php");
	//echo "<h2>Hello Customer</h2>";
}

?>

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Product Orders</h3>
		    </div>
		    <div class="panel-body">
		    	<div class="row col-md-12">
		    		<div class="alert alert-success" id="flash-success" hidden>
					    <strong>Ordered Added Successfully!</strong>
					</div>

					<div id="Modal_change_status" class="modal fade" role="dialog">
					  <div class="modal-dialog">

					    <!-- Modal for change order status-->
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Change order status</h4>
					      </div>
					      <div class="modal-body">
					        <p>All fields are required.</p>
					        <form>
					        	<div class="form-group" hidden>
							    	<label>Order Id:</label>
							    	<input disabled type="text" class="form-control" id="o_id" name="o_id_edit">
							    </div>
					        	<div class="form-group">
							    	<label>Product Ordered:</label>
							    	<input disabled type="text" class="form-control" id="o_p_name" name="o_p_name_edit">
							    </div>
							    <div class="form-group">
							    	<label>Customer Name:</label>
							    	<input disabled type="text" class="form-control" id="o_c_name" name="o_c_name_edit">
							    </div>
							    <div class="form-group">
							    	<label>Date of order:</label>
							    	<input disabled type="text" class="form-control" id="o_date" name="o_date_edit">
							    </div>
							    <div class="form-group">
							    	<label>Quantity:</label>
							    	<input disabled type="text" class="form-control" id="o_quantity" name="o_quantity_edit">
							    </div>
							    <div class="form-group">
							    	<label>Order Status:</label>
							    	<select class="form-control" id="o_status" name="o_status_edit">
										<option value="pending">Pending</option>
										<option value="delivered">Delivered</option>
										<option value="canccelled">Canccelled</option>
									</select>
							    </div>
					        </form>
					      </div>
					      <div class="modal-footer">
					      	<button type="button" id="edit_order_status" class="btn btn-success" data-dismiss="modal">Save</button>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					      </div>
					    </div>

					  </div>
					</div>

					<p><br></p>
			    	<table class="table table-striped table-bordered">
					    <tr><th>Order Id</th><th>Product Ordered</th><th>Customer Name</th><th>Date of Order</th><th>Quantity</th><th>Order Status</th><th>Action</th></tr>
					    
					    <?php 
					    	$stmt = $conn->prepare("SELECT * FROM orders");
					    	//$stmt->bindParam(1, $_SESSION['id']);    // id of customer
							$stmt->execute();
							$rows = $stmt->fetchAll();
							//print_r($row);
							foreach ($rows as $row) {
								//echo $row['price']."<br>";
						?>
								<tr>
									<td><?php echo $row['id'];?></td>
									<td>
										<?php 

											//echo $row['product_id'];
											$stmt_find_product_name = $conn->prepare("SELECT name FROM product where id=?");
											$stmt_find_product_name->bindParam(1, $row['product_id']);
											$stmt_find_product_name->execute();
											$row_product = $stmt_find_product_name->fetch();
											echo $row_product['name'];
										?>
									</td>
									<td>
										<?php 

											//echo $row['product_id'];
											$stmt_find_customer_name = $conn->prepare("SELECT name FROM customer where id=?");
											$stmt_find_customer_name->bindParam(1, $row['customer_id']);
											$stmt_find_customer_name->execute();
											$row_customer = $stmt_find_customer_name->fetch();
											echo $row_customer['name'];
										?>
									</td>
									<td><?php echo $row['date_of_order'];?></td>
									<td><?php echo $row['quantity'];?></td>
									<td><?php echo $row['status'];?></td>
									<?php 
										if($_SESSION['type']=='customer' && $row['status']=='pending'){
									?>
									<td><a href="#" class="btn btn-info cancel_order">Cancel Order</a></td>
									<?php 
										}elseif($_SESSION['type']=='admin'){
									?>
									<td>
										<a href="#" class="btn btn-warning order_edit" id="change_status">Change Status</a>   
									</td>
									<?php 
										}
									?>
								</tr>
						<?php
							}
					    ?>

					</table>

		    	</div>
		    </div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".order_edit").click(function(){
			//alert("Hi");
			$('#Modal_change_status').modal('show');
		});
	});
</script>