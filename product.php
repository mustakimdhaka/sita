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
		var dataTable = $('#product_order').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax":{
				url :"data_product.php", // json datasource
				type: "post",  // method  , by default get
				
				error: function(){  // error handling
					$(".product_order-error").html("");
					$("#product_order").append('<tbody class="product_order-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#product_order_processing").css("display","none");
					
				}
			},
			
		} );
		
		$("#product_order_filter").css("display","none");  // hiding global search box
		$('.search-input-text').on( 'keyup', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			dataTable.columns(i).search(v).draw();
		} );
		
		$("#product_order").on("click", "td button", function(e) {
			
			//var available = $(this).parent().prev().text();
			var price = $(this).parent().prev().text();
			var brand = $(this).parent().prev().prev().text();
			var name = $(this).parent().prev().prev().prev().text();
			var id = $(this).parent().prev().prev().prev().prev().text();
			//alert(price);
			$('#order_product_id').val(id);
			$('#order_product_name').val(name);
			$('#order_product_brand').val(brand);
			$('#order_product_price').val(price);
			$('#order_quantity').val("1");
			$('#myModal3').modal('show');
			//dataTable.ajax.reload(null, false);
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
			        	dataTable.ajax.reload(null, false);

			        }else{
			        	$('#flash-error').show();
			        }
			        
			        setTimeout(function () {
				        //window.location.reload();
				        $('#flash-product-ordered').hide();
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
	

	<div id="myModal3" class="modal fade" role="dialog">
	    <div class="modal-dialog">

		    <!-- Modal for Product order Confirmation -->
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


	
	<div style="text-align: center"><h3>Available Products</h3></div>
	<table id="product_order" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Brand</th>
				<th>Price</th>
				
				<th>Action</th>
			</tr>
		</thead>
		<thead>
			<tr>
				<td><input type="text" data-column="0"  class="search-input-text"></td>
				<td><input type="text" data-column="1"  class="search-input-text"></td>
				<td><input type="text" data-column="2"  class="search-input-text"></td>
				<td><input type="text" data-column="3"  class="search-input-text"></td>
				
			</tr>
		</thead>
	</table>
	<p><br><br><br><br></p>
</div>

<?php include('footer.php')?>