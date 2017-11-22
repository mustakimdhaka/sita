<?php 
include('config.php');
$order_id = $_POST['order_id'];
$quantity = $_POST['quantity'];

if($order_id && $quantity){
	$stmt = $conn->prepare("update orders set quantity=? where id=?");
	$stmt->bindParam(1, $quantity);
	$stmt->bindParam(2, $order_id);
	if($stmt->execute()){
		echo "valid";
	}
}else 
	echo "invalid";
?>