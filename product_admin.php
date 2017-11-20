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
		var dataTable = $('#product_list').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax":{
				url :"data_product_admin.php", // json datasource
				type: "post",  // method  , by default get
				
				error: function(){  // error handling
					$(".product_list-error").html("");
					$("#product_list").append('<tbody class="product_list-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#product_list_processing").css("display","none");
					
				}
			},
			
		} );
		
		$("#product_list_filter").css("display","none");  // hiding global search box
		$('.search-input-text').on( 'keyup', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			dataTable.columns(i).search(v).draw();
		} );
		
		$("#product_list").on("click", "td button", function(e) {
			
			var available = $(this).parent().prev().text();
			var price = $(this).parent().prev().prev().text();
			var brand = $(this).parent().prev().prev().prev().text();
			var name = $(this).parent().prev().prev().prev().prev().text();
			var id = $(this).parent().prev().prev().prev().prev().prev().text();
			//alert(price);
			$('#p_id_2').val(id);
			$('#p_name_2').val(name);
			$('#p_brand_2').val(brand);
			$('#p_price_2').val(price);
			$('#p_available_2').val(available);

			$('#modal_product_edit').modal('show');
			//dataTable.ajax.reload(null, false);
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
			        //window.location.reload();
			        $('#flash-error').hide();
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
				        	dataTable.ajax.reload(null, false);
				        }else{
				        	$('#flash-error').show();
				        }
				        
				        setTimeout(function () {
					        //window.location.reload();
					        $('#flash-success-updated').hide();
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
			} 
		});


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
			        //window.location.reload();
			        $('#flash-error').hide();
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
				        	dataTable.ajax.reload(null, false);
				        }else{
				        	$('#flash-error').show();
				        }
				        
				        setTimeout(function () {
					        //window.location.reload();
					        $('#flash-success').hide();
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
			} 
			
		});
		
		
	} );
</script>

		
<?php
	include('link_bootstrap.php'); 
?>
		
		
<div class="container">
		
	<div class="alert alert-danger" id="flash-error" hidden>
		<strong>Error! Try again with valid input</strong>
	</div>
	<div class="alert alert-success" id="flash-success" hidden>
	    <strong>Product Added Successfully!</strong>
	</div>
	<div class="alert alert-success" id="flash-success-updated" hidden>
	    <strong>Product has been updated!</strong>
	</div>
	<div class="alert alert-info" id="flash-success-deleted" hidden>
	    <strong>Product has been Deleted!</strong>
	</div>
	

	<!-- Modal -->
	<div id="modal_product_add" class="modal fade " role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal  for Add Product-->
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
	      	<button type="button" id="add_product" class="btn btn-success" data-dismiss="modal">Add</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	      </div>
	    </div>

	  </div>
	</div>

	<div id="modal_product_edit" class="modal fade" role="dialog">
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


	
	<div style="text-align: center"><h3>All Products</h3> </div>
	<div align="right">
		<button id="add_product" class="btn btn-info" data-toggle="modal" data-target="#modal_product_add">Add Product</button>
	</div>
	<table id="product_list" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Brand</th>
				<th>Price</th>
				<th>Available</th>
				<th>Action</th>
			</tr>
		</thead>
		<thead>
			<tr>
				<td><input type="text" data-column="0"  class="search-input-text"></td>
				<td><input type="text" data-column="1"  class="search-input-text"></td>
				<td><input type="text" data-column="2"  class="search-input-text"></td>
				<td><input type="text" data-column="3"  class="search-input-text"></td>
				<td><input type="text" data-column="4"  class="search-input-text"></td>
				
			</tr>
		</thead>
	</table>
	<p><br><br><br><br></p>
</div>

<?php include('footer.php')?>