<?php 
include('config.php');
$order_id = $_POST['order_id'];

if($order_id){
	$stmt = $conn->prepare("update orders set status='cancelled' where id=?");
	$stmt->bindParam(1, $order_id);
	if($stmt->execute()){
		echo "valid";
	}
}else 
	echo "invalid";
?>