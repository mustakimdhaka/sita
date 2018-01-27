<?php 

include("config.php");

$username = $_POST['username'];

$stmt = $conn->prepare("SELECT username FROM user where username=?");
$stmt->bindParam(1, $username);
$stmt->execute();
$row = $stmt->fetch();
if($row==null){
	echo "valid";
}else{
	echo "invalid";
}

?>