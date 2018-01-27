<?php 

include("config.php");

$email = $_POST['email'];

$stmt = $conn->prepare("SELECT email FROM customer where email=?");
$stmt->bindParam(1, $email);
$stmt->execute();
$row = $stmt->fetch();
if($row==null){
	echo "valid";
}else{
	echo "invalid";
}

?>