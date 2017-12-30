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
		var dataTable = $('#order_admin_delivered').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax":{
				url :"data_order_admin_delivered.php", // json datasource
				type: "post",  // method  , by default get
				
				error: function(){  // error handling
					$(".order_admin_delivered-error").html("");
					$("#order_admin_delivered").append('<tbody class="order_admin_delivered-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#order_admin_delivered_processing").css("display","none");
					
				}
			},
			
		} );
		
		$("#order_admin_delivered_filter").css("display","none");  // hiding global search box
		$('.search-input-text').on( 'keyup', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			dataTable.columns(i).search(v).draw();
		} );
		
		$("#order_admin_delivered").on("click", "td button", function(e) {
			
			
		});

		$("#order_update_confirm").on("click", function(e) {
			

		});
		
		
	} );
</script>

		
<?php
	include('link_bootstrap.php'); 
?>
		
		
<div class="container">
		
	<div style="text-align: center"><h3>Delivered Orders</h3></div>
	<table id="order_admin_delivered" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Order Id</th>
				<th>Product</th>
				<th>Customer</th>
				<th>Date of Order</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<thead>
			<tr>
				<td><input type="text" data-column="0"  class="search-input-text"></td>
				<td><input type="text" data-column="1"  class="search-input-text" hidden></td>
				<td><input type="text" data-column="2"  class="search-input-text" hidden></td>
				<td><input type="text" data-column="3"  class="search-input-text" ></td>
				<td><input type="text" data-column="4"  class="search-input-text"></td>
				
			</tr>
		</thead>
	</table>
	<p><br><br><br><br></p>
</div>

<?php include('footer.php')?>