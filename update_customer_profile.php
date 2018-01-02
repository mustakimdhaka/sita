<?php 
include('config.php');
$user_id = $_POST['user_id'];
$name = $_POST['name'];
$sex = $_POST['sex'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];

if($user_id && $name && $sex && $dob && $address && $phone && $email){
	$stmt = $conn->prepare("update customer set name=?, sex=?, date_of_birth=?, address=?, phone=?,
	email=? where user_id=?");
	$stmt->bindParam(1, $name);
	$stmt->bindParam(2, $sex);
	$stmt->bindParam(3, $dob);
	$stmt->bindParam(4, $address);
	$stmt->bindParam(5, $phone);
	$stmt->bindParam(6, $email);
	$stmt->bindParam(7, $user_id);
	if($stmt->execute()){
		echo "valid";
	}
}else 
	echo "invalid";
?>