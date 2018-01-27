<?php 
session_start();
include("config.php");

if(isset($_POST['full_name'])&&
	isset($_POST['sex'])&&
	isset($_POST['dob'])&&
	isset($_POST['password'])&&
	isset($_POST['phone'])&&
	isset($_POST['email'])&&
	isset($_POST['username'])&&
	isset($_POST['password2'])){

	$flag = true; // used for validation before sent to Database 
	// check if email exists already  
	$email = $_POST['email'];
	$stmt = $conn->prepare("SELECT email FROM customer where email=?");
	$stmt->bindParam(1, $email);
	$stmt->execute();
	$row = $stmt->fetch();
	if($row==null){
		// email is valid. do nothing 
	}else{
		$flag = false;
		header('Location: signup.php');	
	}

	// check if username exists already  
	$username = $_POST['username'];
	$stmt = $conn->prepare("SELECT username FROM user where username=?");
	$stmt->bindParam(1, $username);
	$stmt->execute();
	$row = $stmt->fetch();
	if($row==null){
		// username is valid. do nothing 
	}else{
		$flag = false;
		header('Location: signup.php');	
	}	

	
	// username and email is unique and valid let's save the data
	// data into user table 
	$username = $_POST['username'];
	$password = $_POST['password'];
	$type = 'customer';
	$stmt = $conn->prepare("insert into user values('',?,?,?)");
	$stmt->bindParam(1, $username);
	$stmt->bindParam(2, $password);
	$stmt->bindParam(3, $type);
	if($stmt->execute()){
		echo "User Created Successfully<br>";
	}else{
		$flag = false;
		header('Location: signup.php');
	}

	// find id of last entry into user table using that username just given 
	$stmt = $conn->prepare("SELECT * FROM user where username=?");
	$stmt->bindParam(1, $username);
	$stmt->execute();
	$row = $stmt->fetch();
	if($row!=null){
		$user_id = $row['id']; // found id for 'user_id' column in customer table
	}else{
		// no username found (impractical scenario for now)
	}

	//insert data into customer table 
	$name = $_POST['full_name'];
	$sex = $_POST['sex'];
	$address = $_POST['address'];
	$dob = $_POST['dob'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$stmt = $conn->prepare("INSERT into customer values('',?,?,?,?,?,?,?)");
	$stmt->bindParam(1, $user_id);
	$stmt->bindParam(2, $name);
	$stmt->bindParam(3, $sex);
	$stmt->bindParam(4, $address);
	$stmt->bindParam(5, $dob);
	$stmt->bindParam(6, $phone);
	$stmt->bindParam(7, $email);
	if($stmt->execute()){
		//echo "Customer profile created successfully!<br>";
		$_SESSION['new_profile'] = true;
		header('location: login.php');
	}else{
		$flag = false;
		header('Location: signup.php');
	}
	
	//echo "Full Name: ".$_POST['full_name'];

}


?>