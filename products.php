<?php
include("layout.php");
include("config.php");

session_start();
if(!isset($_SESSION['username'])){
	header('location: login.php');
}

if($_SESSION['type']=='admin'){
	include("menu_admin_2.php");
}else{
	include("menu_customer.php");
}

?>

<div class="container">
	<div class="row">
		<div class="panel panel-default">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Products</h3>
		    </div>
		    <div class="panel-body">
		    	<div class="row col-md-6">
		    		<!-- Trigger the modal with a button -->
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" 
						<?php if($_SESSION['type']=='customer') echo 'style='.'"display:none;"'?> >Add Product</button><br>

					<div class="alert alert-success" id="flash-success" hidden>
					    <strong>Product Added Successfully!</strong>
					</div>

					<div class="alert alert-danger" id="flash-error" hidden>
					    <strong>Opss.. There was an error! Try again with valid input</strong>
					</div>

					<div class="alert alert-success" id="flash-success-updated" hidden>
					    <strong>Product has been updated!</strong>
					</div>

					<div class="alert alert-info" id="flash-success-deleted" hidden>
					    <strong>Product has been Deleted!</strong>
					</div>

					<div class="alert alert-success" id="flash-product-ordered" hidden>
					    <strong>Product has been Ordered Successfully!</strong>
					</div>

					<!-- Modal -->
					<div id="myModal" class="modal fade " role="dialog">
					  <div class="modal-dialog">

					    <!-- Modal  for create form-->
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Add Product</h4>
					      </div>
					      <div class="modal-body">
					        <p>All fields are required.</p>
					        <form>
					        	<div class="form-group" hidden>
							    	<label>Product Id:</label>
							    	<input type="text" class="form-control" id="p_id" name="id">
							    </div>
					        	<div class="form-group">
							    	<label>Product Name:</label>
							    	<input type="text" class="form-control" id="p_name" name="name">
							    </div>
							    <div class="form-group">
							    	<label>Brand:</label>
							    	<input type="text" class="form-control" id="p_brand" name="brand">
							    </div>
							    <div class="form-group">
							    	<label>Price:</label>
							    	<input type="text" class="form-control" id="p_price" name="price">
							    </div>
							   
					        </form>
					      </div>
					      <div class="modal-footer">
					      	<button type="button" id="add_product" class="btn btn-success" data-dismiss="modal">Save</button>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					      </div>
					    </div>

					  </div>
					</div>



					<div id="myModal2" class="modal fade" role="dialog">
					  <div class="modal-dialog">

					    <!-- Modal for edit form-->
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Edit Product</h4>
					      </div>
					      <div class="modal-body">
					        <p>All fields are required.</p>
					        <form>
					        	<div class="form-group" hidden>
							    	<label>Product Id:</label>
							    	<input type="text" class="form-control" id="p_id_2" name="id_edit">
							    </div>
					        	<div class="form-group">
							    	<label>Product Name:</label>
							    	<input type="text" class="form-control" id="p_name_2" name="name_edit">
							    </div>
							    <div class="form-group">
							    	<label>Brand:</label>
							    	<input type="text" class="form-control" id="p_brand_2" name="brand_edit">
							    </div>
							    <div class="form-group">
							    	<label>Price:</label>
							    	<input type="text" class="form-control" id="p_price_2" name="price_edit">
							    </div>
							    <div class="form-group">
							    	<label>Available:</label>
							    	<select class="form-control" id="p_available_2" name="available_edit">
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select>
							    </div>
					        </form>
					      </div>
					      <div class="modal-footer">
					      	<button type="button" id="edit_product" class="btn btn-success" data-dismiss="modal">Save</button>
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					      </div>
					    </div>

					  </div>
					</div>


					<div id="myModal3" class="modal fade" role="dialog">
					    <div class="modal-dialog">

						    <!-- Modal for edit form-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Order Product Confirmation</h4>
						      </div>
						      <div class="modal-body">
						        <p>Please input the quantity.</p>
						        <form>
						        	<div class="form-group" hidden>
								    	<label>Product Id:</label>
								    	<input type="text" class="form-control" id="order_product_id" name="order_product_id">
								    </div>
						        	<div class="form-group">
								    	<label>Product Name:</label>
								    	<input disabled type="text" class="form-control" id="order_product_name" name="order_product_name">
								    </div>
								    <div class="form-group">
								    	<label>Brand:</label>
								    	<input disabled type="text" class="form-control" id="order_product_brand" name="order_product_brand">
								    </div>
								    <div class="form-group">
								    	<label>Price:</label>
								    	<input disabled type="text" class="form-control" id="order_product_price" name="order_product_price">
								    </div>
								    <div class="form-group">
								    	<label>Quantity:</label>
								    	<input type="text" class="form-control" id="order_quantity" name="order_quantity">
								    </div>
						        </form>
						      </div>
						      <div class="modal-footer">
						      	<button type="button" id="product_order_confirm" class="btn btn-success" data-dismiss="modal">Confirm</button>
						        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						      </div>
						    </div>

					    </div>
					</div>



		    	</div>

		    	

		    	<p><br><br></p>
		    	<table id="product_table" class="table table-striped table-bordered">
				    <tr><th>Id</th><th>Product Name</th><th>Brand</th><th>Price(BDT)</th><?php if($_SESSION['type']!='customer') echo "<th>Available</th>"?><th>Action</th></tr>
				    
				    <?php
				    	if($_SESSION['type']=='customer'){
				    		$stmt = $conn->prepare("SELECT * FROM product where available='yes'"); // view for customer
				    	}else{
				    		$stmt = $conn->prepare("SELECT * FROM product");	// view for admin
				    	}
				    	
						$stmt->execute();
						$rows = $stmt->fetchAll();
						//print_r($row);
						foreach ($rows as $row) {
							//echo $row['price']."<br>";
					?>
							<tr>
								<td><?php echo $row['id'];?></td>
								<td><?php echo $row['name'];?></td>
								<td><?php echo $row['brand'];?></td>
								<td><?php echo $row['price'];?></td>
								<?php 
									if($_SESSION['type']=='customer'){
								?>
								<td><a href="#" class="btn btn-info product_order">Order</a></td>
								<?php 
									}else{
								?>
								<td><?php echo $row['available'];?></td>
								<td>
									<a href="#" class="btn btn-warning product_edit">Edit</a>   
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

<script>

	$(document).ready(function(){

		//$('#myTable').dataTable();

		$("#add_product").click(function(){
			//alert("Clicked");

			var name = $('#p_name').val();
			var brand = $('#p_brand').val();
			var price = $('#p_price').val();
			var available = 'yes';
			

			if(!name|| !brand || !price){
				// do nothing
				$('#flash-error').show();
				setTimeout(function () {
			        window.location.reload();
			    }, 3000);

			}else{
				$.ajax({
					method: "POST",
				    url : "product_add.php",
				    data : {name:name, brand:brand, price:price, available:available},
				    dataType: 'html',
				    success: function(data, textStatus, jqXHR)
				    {
				        //data = response from server
				        console.log(data);
				        if(data=='valid'){
				        	$('#flash-success').show();
				        }else{
				        	$('#flash-error').show();
				        }
				        
				        setTimeout(function () {
					        window.location.reload();
					    }, 1000);
				    },
				    error: function (jqXHR, textStatus, errorThrown)
				    {
				 		//alert('Error');
				 		$('#flash-error').show();
				        setTimeout(function () {
					        window.location.reload();
					    }, 1000);
				    }
				});	
			} 

			
		});


	    $(".product_edit").click(function(){
	        var id = $(this).parent().prev().prev().prev().prev().prev().text();
	        var name = $(this).parent().prev().prev().prev().prev().text();
	        var brand = $(this).parent().prev().prev().prev().text();
	        var price = $(this).parent().prev().prev().text();
	        var available = $(this).parent().prev().text();
	        //alert(name+brand+price);

	        $('#p_id_2').val(id);
	        $('#p_name_2').val(name);
	        $('#p_brand_2').val(brand);
	        $('#p_price_2').val(price);
	        $('#p_available_2').val(available);
	        $('#myModal2').modal('show');
		});


	    $("#edit_product").click(function(){
			//alert("Clicked");

			var id = $('#p_id_2').val();
			var name = $('#p_name_2').val();
			var brand = $('#p_brand_2').val();
			var price = $('#p_price_2').val();
			var available = $('#p_available_2').val();

			if(!name|| !brand || !price){
				// do nothing
				$('#flash-error').show();
				setTimeout(function () {
			        window.location.reload();
			    }, 3000);

			}else{

				//alert("Submitted");

				$.ajax({
					method: "POST",
				    url : "product_edit.php",
				    data : {id:id, name:name, brand:brand, price:price, available:available},
				    dataType: 'html',
				    success: function(data, textStatus, jqXHR)
				    {
				        //data = response from server
				        console.log(data);
				        if(data=='valid'){
				        	//$('#flash-success').show();
				        	$('#flash-success-updated').show();

				        }else{
				        	$('#flash-error').show();
				        }
				        
				        setTimeout(function () {
					        window.location.reload();
					    }, 1000);
				    },
				    error: function (jqXHR, textStatus, errorThrown)
				    {
				 		//alert('Error');
				 		$('#flash-error').show();
				        setTimeout(function () {
					        window.location.reload();
					    }, 1000);
				    }
				});	



			} 

			
		});


		
		$(".product_delete").click(function(){
	        var id = $(this).parent().prev().prev().prev().prev().text();
	        //alert(id);
	        $.ajax({
					method: "POST",
				    url : "product_delete.php",
				    data : {id:id},
				    dataType: 'html',
				    success: function(data, textStatus, jqXHR)
				    {
				        //data = response from server
				        console.log(data);
				        if(data=='valid'){
				        	//$('#flash-success').show();
				        	$('#flash-success-deleted').show();

				        }else{
				        	$('#flash-error').show();
				        }
				        
				        setTimeout(function () {
					        window.location.reload();
					    }, 1000);
				    },
				    error: function (jqXHR, textStatus, errorThrown)
				    {
				 		//alert('Error');
				 		$('#flash-error').show();
				        setTimeout(function () {
					        window.location.reload();
					    }, 1000);
				    }
				});	

		});

		$(".product_order").click(function(){
	        var id = $(this).parent().prev().prev().prev().prev().text();
	        var name = $(this).parent().prev().prev().prev().text();
	        var brand = $(this).parent().prev().prev().text();
	        var price = $(this).parent().prev().text();
	        //alert(id);

	        $('#order_product_id').val(id);
	        $('#order_product_name').val(name);
	        $('#order_product_brand').val(brand);
	        $('#order_product_price').val(price);
	        $('#order_quantity').val("1");

	        $('#myModal3').modal('show');

		});

		$("#product_order_confirm").click(function(){
	        var p_id = $('#order_product_id').val();
	        var quantity = $('#order_quantity').val();
	        //alert(quantity);

	        $.ajax({
				method: "POST",
			    url : "product_order.php",
			    data : {p_id:p_id, quantity:quantity},
			    dataType: 'html',
			    success: function(data, textStatus, jqXHR)
			    {
			        //data = response from server
			        console.log(data);
			        if(data=='valid'){
			    
			        	$('#flash-product-ordered').show();

			        }else{
			        	$('#flash-error').show();
			        }
			        
			        setTimeout(function () {
				        window.location.reload();
				    }, 1000);
			    },
			    error: function (jqXHR, textStatus, errorThrown)
			    {
			 		//alert('Error');
			 		$('#flash-error').show();
			        setTimeout(function () {
				        window.location.reload();
				    }, 1000);
			    }
			});	

		});


	});
	
</script>