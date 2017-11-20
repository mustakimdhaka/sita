<!DOCTYPE html>
<html>
	<title>Datatable Demo2 | CoderExample</title>
	<head>
		<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#employee-grid').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"data_2.php", // json datasource
						type: "post",  // method  , by default get
						
						error: function(){  // error handling
							$(".employee-grid-error").html("");
							$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#employee-grid_processing").css("display","none");
							
						}
					},
					
				} );
				
				$("#employee-grid_filter").css("display","none");  // hiding global search box
				$('.search-input-text').on( 'keyup', function () {   // for text boxes
					var i =$(this).attr('data-column');  // getting column index
					var v =$(this).val();  // getting search input value
					dataTable.columns(i).search(v).draw();
				} );
				
				$("#employee-grid").on("click", "td button", function(e) {
					
					var available = $(this).parent().prev().text();
					var price = $(this).parent().prev().prev().text();
					var brand = $(this).parent().prev().prev().prev().text();
					var name = $(this).parent().prev().prev().prev().prev().text();
					var id = $(this).parent().prev().prev().prev().prev().prev().text();
					
					$('#p_id_2').val(id);
					$('#p_name_2').val(name);
					$('#p_brand_2').val(brand);
					$('#p_price_2').val(price);
					$('#p_available_2').val(available);
					$('#myModal2').modal('show');
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
									
									$('#flash-success-updated').hide();
									$('#flash-error').hide();
								}, 3000);
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								//alert('Error');
								$('#flash-error').show();
								setTimeout(function () {
									
									$('#flash-error').hide();
								}, 3000);
							}
						});	



					} 

					
				});
				
			} );
		</script>
		<style>
			div.container {
			    margin: 0 auto;
			    max-width:760px;
			}
			div.header {
			    margin: 100px auto;
			    line-height:30px;
			    max-width:760px;
			}
			body {
			    background: #f7f7f7;
			    color: #333;
			    font: 90%/1.45em "Helvetica Neue",HelveticaNeue,Verdana,Arial,Helvetica,sans-serif;
			}
		</style>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		
	</head>
	<body>
		<div class="header"><h2>Products</h2></div>
		<div class="container">
		
			<div class="alert alert-danger" id="flash-error" hidden>
				<strong>Opss.. There was an error! Try again with valid input</strong>
			</div>

			<div class="alert alert-success" id="flash-success-updated" hidden>
				<strong>Product has been updated!</strong>
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
		
			<table id="employee-grid" class="table table-striped table-bordered">
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
		</div>
	</body>
</html>
