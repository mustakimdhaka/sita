<?php
include('config.php');

$id = $_POST['id'];
$name = $_POST['name'];
$brand = $_POST['brand'];
$price = $_POST['price'];

if($id && $name && $brand && $price){

	$stmt = $conn->prepare("update product set name=?, brand=?, price=? where id=?");
	$stmt->bindParam(1, $name);
	$stmt->bindParam(2, $brand);
	$stmt->bindParam(3, $price);
	$stmt->bindParam(4, $id);
	if($stmt->execute()){
		echo "valid";
	}

}else{
	echo "invalid";
} 
//echo $price;
?>