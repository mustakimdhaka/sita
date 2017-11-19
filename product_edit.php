<?php
include('config.php');
session_start();

$id = $_POST['id'];
$name = $_POST['name'];
$brand = $_POST['brand'];
$price = $_POST['price'];
$available = $_POST['available'];

if($id && $name && $brand && $price &&$available){

	$stmt = $conn->prepare("update product set name=?, brand=?, price=?, available=? where id=?");
	$stmt->bindParam(1, $name);
	$stmt->bindParam(2, $brand);
	$stmt->bindParam(3, $price);
	$stmt->bindParam(4, $available);
	$stmt->bindParam(5, $id);
	if($stmt->execute()){
		echo "valid";
	}

}else{
	echo "invalid";
} 
//echo $price;
?>