<!DOCTYPE html>
<html>
	<title>Datatable Demo2 | CoderExample</title>
	<head>
		<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		<script type="text/javascript" language="javascript" src="/../datatable/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="/../datatable/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#employee-grid').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"employee-grid-data.php", // json datasource
						type: "post",  // method  , by default get
						
						error: function(){  // error handling
							$(".employee-grid-error").html("");
							$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#employee-grid_processing").css("display","none");
							
						}
					},
					
				} );
				
				$("#my-example_filter").css("display","none");  // hiding global search box
				$('.search-input-text').on( 'keyup', function () {   // for text boxes
					var i =$(this).attr('data-column');  // getting column index
					var v =$(this).val();  // getting search input value
					dataTable.columns(i).search(v).draw();
				} );
				$('.search-input-select').on( 'change', function () {   // for select box
					var i =$(this).attr('data-column');  
					var v =$(this).val();  
					dataTable.columns(i).search(v).draw();
				} );
				
				
				
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
	</head>
	<body>
		<div class="header"><h1>DataTable (Server side) Custom Column Search </h1></div>
		<div class="container">
			<table id="employee-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
				<thead>
        <tr>
            <th>Employee name</th>
            <th>Salary</th>
            <th>Age</th>
			<th>Action</th>
        </tr>
    </thead>
    <thead>
        <tr>
            <td><input type="text" data-column="0"  class="search-input-text"></td>
            <td><input type="text" data-column="1"  class="search-input-text"></td>
            <td>
                <select data-column="2"  class="search-input-select">
                    <option value="">(Select a range)</option>
                    <option value="19-30">19 - 30</option>
                    <option value="31-66">31 - 66</option>
                </select>
            </td>
			
        </tr>
    </thead>
			</table>
		</div>
	</body>
</html>
