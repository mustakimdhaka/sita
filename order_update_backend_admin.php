<?php 
include('config.php');
$order_id = $_POST['order_id'];
$order_status = $_POST['order_status'];

if($order_id && $order_status){
	$stmt = $conn->prepare("update orders set status=? where id=?");
	$stmt->bindParam(1, $order_status);
	$stmt->bindParam(2, $order_id);
	if($stmt->execute()){
		echo "valid";
	}
}else 
	echo "invalid";
?>