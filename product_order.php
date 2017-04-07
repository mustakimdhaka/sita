<?php
include('config.php');

session_start();

$product_id = $_POST['p_id'];
$quantity = $_POST['quantity'];

//echo $product_id." ".$quantity; exit;

if($product_id && $quantity){

	//echo "valid";
	date_default_timezone_set("Asia/Dhaka");

	$customer_id = $_SESSION['id'];
	$date_of_order = date("Y-m-d");
	$status = 'pending';

	//echo $product_id." ".$customer_id." ".$date_of_order." ".$quantity." ".$status; exit;

	$stmt = $conn->prepare("insert into orders values('',?,?,?,?,?)");
	$stmt->bindParam(1, $product_id);
	$stmt->bindParam(2, $customer_id);
	$stmt->bindParam(3, $date_of_order);
	$stmt->bindParam(4, $quantity);
	$stmt->bindParam(5, $status);
	
	try{
		$stmt->execute();
		echo "valid";
	}catch(PDOException $e){
		echo "Database error: " . $e->getMessage();
	}

}else{
	echo "invalid";
} 
//echo $price;
?>