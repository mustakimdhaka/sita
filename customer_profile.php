<?php
include("layout.php");
include("config.php");

session_start();
if(!isset($_SESSION['username'])){
	header('location: login.php');
}

if($_SESSION['type']=='admin'){
	include("menu_admin_2.php");
	echo "<h2>Hello Admin</h2>";
}else{
	include("menu_customer.php");
	echo "<h2>Hello Customer. This is your profile page. Its under construction</h2>";
}

?>