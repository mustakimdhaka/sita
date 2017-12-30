<?php
include("layout.php");
include("config.php");
include('link_datatable.php');

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


<script>
	$(document).ready(function() {
		var dataTable = $('#order_customer_pending').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax":{
				url :"data_order_customer_pending.php", // json datasource
				type: "post",  // method  , by default get
				
				error: function(){  // error handling
					$(".order_customer_pending-error").html("");
					$("#order_customer_pending").append('<tbody class="order_customer_pending-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#order_customer_pending_processing").css("display","none");
					
				}
			},
			
		} );
		
		$("#order_customer_pending_filter").css("display","none");  // hiding global search box
		$('.search-input-text').on( 'keyup', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			dataTable.columns(i).search(v).draw();
		} );
		
		$("#order_customer_pending").on("click", "td button", function(e) {
			
			var value = $(this).text();
			//alert(value);
			if(value == 'Update'){
				// code for updating order quantity
				var quantity = $(this).parent().prev().text();
				var date_of_order = $(this).parent().prev().prev().text();
				var product = $(this).parent().prev().prev().prev().text();
				var order_id = $(this).parent().prev().prev().prev().prev().text();
				//alert(order_id);

				$('#order_id').val(order_id);
				$('#order_product_name').val(product);
				$('#date_of_order').val(date_of_order);
				$('#order_quantity').val(quantity);

				$('#modal_order_update').modal('show');

			}else{
				// code for cancelling order
				var ans = confirm("Are you sure to cancel your order?");
				if (ans == true) {
				    //alert('Order cancelled');
				    var order_id = $(this).parent().prev().prev().prev().prev().text();
				    //alert(id);

				    $.ajax({
						method: "POST",
					    url : "order_cancel_backend_customer.php",
					    data : {order_id:order_id},
					    dataType: 'html',
					    success: function(data, textStatus, jqXHR)
					    {
					        //data = response from server
					        console.log(data);
					        if(data=='valid'){
					        	//$('#flash-success').show();
					        	$('#flash-order-cancel').show();
					        	dataTable.ajax.reload(null, false);
					        }else{
					        	//nothin to do
					        }
					        
					        setTimeout(function () {
						        //window.location.reload();
						        $('#flash-order-cancel').hide();
						    }, 3000);
					    },
					    error: function (jqXHR, textStatus, errorThrown)
					    {
					 		//alert('Error');
					 		$('#flash-error').show();
					        setTimeout(function () {
						        //window.location.reload();
						        $('#flash-error').hide();
						    }, 3000);
					    }
					});


				} else {
				    // do nothing 
				}
			}

		});

		$("#order_update_confirm").on("click", function(e) {
			//alert('clicked');
			var order_id = $('#order_id').val();
			var quantity = $('#order_quantity').val();
			$.ajax({
				method: "POST",
			    url : "order_update_backend_customer.php",
			    data : {order_id:order_id, quantity:quantity},
			    dataType: 'html',
			    success: function(data, textStatus, jqXHR)
			    {
			        //data = response from server
			        console.log(data);
			        if(data=='valid'){
			        	//$('#flash-success').show();
			        	$('#flash-order-update').show();
			        	dataTable.ajax.reload(null, false);
			        }else{
			        	//nothin to do
			        	$('#flash-error').show();
			        }
			        
			        setTimeout(function () {
				        //window.location.reload();
				        $('#flash-order-update').hide();
				        $('#flash-error').hide();
				    }, 3000);
			    },
			    error: function (jqXHR, textStatus, errorThrown)
			    {
			 		//alert('Error');
			 		$('#flash-error').show();
			        setTimeout(function () {
				        //window.location.reload();
				        $('#flash-error').hide();
				    }, 3000);
			    }
			});
		});
		
		
	} );
</script>

		
<?php
	//include('link_bootstrap.php'); 
?>
		
		
<div class="container">
		
	<div class="alert alert-danger" id="flash-error" hidden>
		<strong>Opss.. There was an error! Try again with valid input</strong>
	</div>
	<div class="alert alert-success" id="flash-product-ordered" hidden>
	    <strong>Product has been Ordered Successfully!</strong>
	</div>
	<div class="alert alert-danger" id="flash-order-cancel" hidden>
	    <strong>Order has been cancelled!</strong>
	</div>
	<div class="alert alert-success" id="flash-order-update" hidden>
	    <strong>Order has been Updated!</strong>
	</div>
	

	<div id="modal_order_update" class="modal fade" role="dialog">
	    <div class="modal-dialog">

		    <!-- Modal for updating order quantity-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Update Order</h4>
		      </div>
		      <div class="modal-body">
		        <p>Please input the quantity.</p>
		        <form>
		        	<div class="form-group">
				    	<label>Order Id:</label>
				    	<input disabled type="text" class="form-control" id="order_id" name="order_id">
				    </div>
		        	<div class="form-group">
				    	<label>Product:</label>
				    	<input disabled type="text" class="form-control" id="order_product_name" name="order_product_name">
				    </div>
				    <div class="form-group">
				    	<label>Date of Order:</label>
				    	<input disabled type="text" class="form-control" id="date_of_order" name="date_of_order">
				    </div>
				    <div class="form-group">
				    	<label>Quantity:</label>
				    	<input type="text" class="form-control" id="order_quantity" name="order_quantity">
				    </div>
		        </form>
		      </div>
		      <div class="modal-footer">
		      	<button type="button" id="order_update_confirm" class="btn btn-success" data-dismiss="modal">Update</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		      </div>
		    </div>

	    </div>
	</div>


	
	<div style="text-align: center"><h3>My Pending Orders</h3></div>
	<table id="order_customer_pending" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Order Id</th>
				<th>Product</th>
				<th>Date of Order</th>
				<th>Quantity</th>
				
				<th>Action</th>
			</tr>
		</thead>
		<thead>
			<tr>
				<td><input type="text" data-column="0"  class="search-input-text"></td>
				<td><input type="text" data-column="1"  class="search-input-text" hidden></td>
				<td><input type="text" data-column="2"  class="search-input-text"></td>
				<td><input type="text" data-column="3"  class="search-input-text"></td>
				
			</tr>
		</thead>
	</table>
	<p><br><br><br><br></p>
</div>

<?php include('footer.php')?>