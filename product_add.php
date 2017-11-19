<?php
include('config.php');

$name = $_POST['name'];
$brand = $_POST['brand'];
$price = $_POST['price'];
$available = $_POST['available'];

if($name && $brand && $price){

	$stmt = $conn->prepare("insert into product values('',?,?,?,?)");
	$stmt->bindParam(1, $name);
	$stmt->bindParam(2, $brand);
	$stmt->bindParam(3, $price);
	$stmt->bindParam(4, $available);
	if($stmt->execute()){
		echo "valid";
	}

}else{
	echo "invalid";
} 
//echo $price;
?>