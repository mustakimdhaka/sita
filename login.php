<?php
include("layout.php");
include("config.php");
session_start();
?>

<div class="container"><br><br>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="panel panel-default">
		    <div class="panel-body">
			    <h2 align="center">Order Tracking System</h2>
			    <?php
			    	if(isset($_SESSION['new_profile'])){
			    		echo "<h4 style='color:green'>Profile has been created successfully!</h4><br>";
			    		session_unset();
			    	}  
			    ?>
			    <form method="POST">
				    <div class="form-group">
				    	<label for="user">Username:</label>
				    	<input type="text" class="form-control" id="user" name="username">
				    </div>
				    <div class="form-group">
				    	<label for="pass">Password:</label>
				    	<input type="password" class="form-control" id="pass" name="password">
				    </div>
			    	<!-- <button type="submit" class="btn btn-default">Submit</button><br><br> -->

			    	<div class="row">
			    		<div class="col-md-4">
			    			<button type="submit" class="btn btn-primary">Login</button>
			    		</div>
			    		<div class="col-md-8">
			    			<a href="signup.php">New Customer? Sign Up!</a>
			    		</div>
			    	</div>

			    	<?php 
			    		if(isset($_POST['username']) && isset($_POST['password']) ){
			    			//echo "<h3>Invalid username or password</h3>";
			    			$stmt = $conn->prepare("SELECT * FROM user where username=? and password=?");
			    			$stmt->bindParam(1, $_POST['username']);
							$stmt->bindParam(2, $_POST['password']);
							$stmt->execute();
							$row = $stmt->fetch();
							if($row!=null){
								//session_start();
								$_SESSION['id'] = $row['id'];
								$_SESSION['username'] = $row['username'];
								$_SESSION['password'] = $row['password'];
								$_SESSION['type'] = $row['type'];

								if($_SESSION['type'] == 'customer'){
									header('location: index.php');
								}elseif($_SESSION['type'] == 'admin'){
									header('location: admin.php');
								}else{
									// do nothing
								}
								//echo "Session started for user: ".$_SESSION['username'];
								//print_r($row);
							}else{
								echo"Invalid username or password!";
							}
			    		} 
			    		
			    	?>
				</form>
		    </div>
		</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>

<?php 
	include('footer.php')
?>