<?php
include('config.php');

$id = $_POST['id'];

if($id){

	//echo "valid";

	$stmt = $conn->prepare("delete from product where id=?");
	$stmt->bindParam(1, $id);
	if($stmt->execute()){
		echo "valid";
	}

}else{
	echo "invalid";
} 
//echo $price;
?>