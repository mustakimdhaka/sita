<?php
/* Database connection start */
include('config_2.php');
/* Database connection end */
session_start();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'id', 
	1 =>'product_id',
	2=> 'user_id',
	3=> 'date_of_order',
	4=> 'quantity',
	5=> 'status',
);


// getting total number records without any search
$sql = "SELECT id, product_id, date_of_order, quantity, status ";
$sql.=" FROM orders WHERE ";
$sql.=" user_id = ".$_SESSION['id'];
$sql.=" AND status = 'pending'";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT id, product_id, date_of_order, quantity, status ";
$sql.=" FROM orders WHERE ";
$sql.=" user_id = ".$_SESSION['id'];
$sql.=" AND status = 'pending'";

// getting records as per search parameters
if( !empty($requestData['columns'][0]['search']['value']) ){   
	$sql.=" AND id LIKE '%".$requestData['columns'][0]['search']['value']."%' ";
}
if( !empty($requestData['columns'][1]['search']['value']) ){  
	$sql.=" AND product_id LIKE '%".$requestData['columns'][1]['search']['value']."%' ";
}
if( !empty($requestData['columns'][1]['search']['value']) ){  
	$sql.=" AND user_id LIKE '%".$requestData['columns'][1]['search']['value']."%' ";
}
if( !empty($requestData['columns'][2]['search']['value']) ){  
	$sql.=" AND date_of_order LIKE '%".$requestData['columns'][2]['search']['value']."%' ";
}
if( !empty($requestData['columns'][3]['search']['value']) ){  
	$sql.=" AND quantity LIKE '%".$requestData['columns'][3]['search']['value']."%' ";
}
if( !empty($requestData['columns'][4]['search']['value']) ){  
	$sql.=" AND status LIKE '%".$requestData['columns'][4]['search']['value']."%' ";
}


$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
	
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["id"];

	$sql_find_product_name = "SELECT name from product WHERE id= ";
	$sql_find_product_name .= $row["product_id"];;
	$query_find_product_name = mysqli_query($conn, $sql_find_product_name) or die("employee-grid-data.php: get employees");
	$row_find_product_name = mysqli_fetch_array($query_find_product_name);
	
	$nestedData[] = $row_find_product_name["name"];
	//$nestedData[] = $row["product_id"];
	$nestedData[] = $row["date_of_order"];
	$nestedData[] = $row["quantity"];
	$nestedData[] = '<button class="order_customer_pending_update btn btn-info">Update</button>
					<button class="order_customer_pending_cancel btn btn-warning">Cancel</button>';
	
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
