<?php 
include("layout.php");
include("config_2.php");

session_start();
if(!isset($_SESSION['username'])){
	header('location: login.php');
}

//echo "Hello admin";
?>

<?php 
//include("menu_admin.php"); 
include("menu_customer.php");
?>

<div class="container">
	<div class="row">
		<div class="panel panel-default">
		    <div class="panel-heading">
		    	<h3 class="panel-title"><?php if($_SESSION['type']=='admin') echo "Admin Portal"; else echo "Customer Portal"?></h3>
		    </div>
		    <div class="panel-body">
		    	Welcome <?php echo $_SESSION['username'];?>! You have Succesfully logged in... 
		    </div>
		</div>
	</div>
</div>

<?php include('footer.php');?>