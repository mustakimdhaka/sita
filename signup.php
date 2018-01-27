<?php
include("layout.php");
include("config.php");
?>

<script>
$(document).ready(function() {
	// ********* Code for date picker *****************
	// note: Modal enforces to focus on itself instead of datepicker thats why 
	// this code is needed to resolve month and year dropdown issue in Datepicker 
	// when you put it in a modal 
	
	$( function() {
	    $( "#dob" ).datepicker({
	    	beforeShow: function(input, inst) {
		        $(document).off('focusin.bs.modal');
		    },
		    onClose:function(){
		        $(document).on('focusin.bs.modal');
		    },
	    	changeMonth: true,
	    	changeYear: true,
	    	yearRange: "1901:2099",
	    	dateFormat: 'yy-mm-dd',
	    });
	});
	// ********* End of Date Picker **********************
	
});	

function validate(){
	var name = document.getElementById("full_name").value;
	var dob = document.getElementById("dob").value;
	var phone = document.getElementById("phone").value;
	var email = document.getElementById("email").value;
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var password2 = document.getElementById("password2").value;
	if(name==''){
		alert('Customer name should not be empty!');
		return false;
	}
	if(dob==''){
		alert('Date of Birth should not be empty!');
		return false;
	}
	if(phone==''){
		alert('Phone number should not be empty!');
		return false;
	}
	if(username==''){
		alert('Username should not be empty!');
		return false;
	}
	if(password==''){
		alert('Password is empty');
		return false;
	}
	if(password!=password2){
		alert('Passwords did not match');
		return false;
	}
	if(email==''){
		alert('Email address should not be empty!');
		return false;
	}else{
		if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
			return true;
		}else{
			alert('Email address is not valid!');
			return false;	
		}
	}
	
	return true;
}

function checkUsername(){ // check for username existence via ajax call 
	
	var username = document.getElementById("username").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	        if(this.responseText=='invalid'){
	        	jQuery("#messageSpan").text("Username already exists!");
	        }else{
	        	jQuery("#messageSpan").text("");
	        }
	    }
	};
	xhttp.open("POST", "validate_username.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("username="+username);

}

function checkEmail(){ // check if email exists already via ajax call 
	//alert('working!');
	var email = document.getElementById("email").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	        if(this.responseText=='invalid'){
	        	jQuery("#messageSpanEmail").text("Email already exists!");
	        }else{
	        	jQuery("#messageSpanEmail").text("");
	        }
	    }
	};
	xhttp.open("POST", "validate_email.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("email="+email);
}

function checkPassLength(){
	var pass = document.getElementById("password").value;
	var pass_len = pass.length;
	if(pass_len<8){
		jQuery("#msgPassLengthWeak").text("Weak!");
	}else{
		jQuery("#msgPassLengthStrong").text("Strong!");
	}
}

function checkPass2(){ // compare both passwords 
	var pass1 = document.getElementById("password").value;
	var pass2 = document.getElementById("password2").value;
	if(pass1!=pass2){
		jQuery("#messageSpanPass2Fail").text("Passwords didn't match!");
	}else{
		jQuery("#messageSpanPass2Success").text("Passwords matched!");
	}
}

</script>

<div class="container"><br><br>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="panel panel-default">
		    <div class="panel-body">
			    <h2 align="center">Order Tracking System</h2>
			    <h4 align="center">New Customer Registration</h4><br>
			    <form method="POST" action="signup_backend.php" onSubmit="return validate()">
			    	<div class="form-group">
				    	<label>
				    		<span style="color:red;font-weight:bold">*</span>
				    		Customer Name:
				    	</label>
				    	<input type="text" class="form-control" id="full_name" name="full_name">
				    </div>
				    <div class="form-group">
				    	<label>
				    		<span style="color:red;font-weight:bold">*</span>
				    		Sex:
				    	</label>
				    	<select class="form-control" id='sex' name='sex'>
							<option value="M">Male</option>
							<option value="F">Female</option>
						</select>
				    </div>
				    <div class="form-group">
				    	<label>
				    		<span style="color:red;font-weight:bold">*</span>
				    		Date of Birth:
				    	</label>
				    	<input type="text" class="form-control" id="dob" name="dob">
				    </div>
				    <div class="form-group">
				    	<label>Address:</label>
				    	<textarea class="form-control" id="address" name="address"></textarea>
				    </div>
				    <div class="form-group">
				    	<label>
				    		<span style="color:red;font-weight:bold">*</span>
				    		Phone:
				    	</label>
				    	<input type="text" class="form-control" id="phone" name="phone">
				    </div>
				    <div class="form-group">
				    	<label>
				    		<span style="color:red;font-weight:bold">*</span>
				    		Email:
				    	</label>
				    	<input onblur="checkEmail()" type="text" class="form-control" id="email" name="email">
				    	<span id="messageSpanEmail" style="color:red"><span>
				    </div>
				    <div class="form-group">
				    	<label for="user">
				    		<span style="color:red;font-weight:bold">*</span>
				    		Username:
				    	</label>
				    	<input onkeyup="checkUsername()" type="text" class="form-control" id="username" name="username">
				    	<span id="messageSpan" style="color:red"><span>
				    </div>
				    <div class="form-group">
				    	<label for="password">
				    		<span style="color:red;font-weight:bold">*</span>
				    		Password: 
				    	</label>
				    	<input onkeyup="checkPassLength()" type="password" class="form-control" id="password" name="password">
				    	<span id="msgPassLengthStrong" style="color:green"><span>
				    	<span id="msgPassLengthWeak" style="color:red"><span>
				    </div>
				    <div class="form-group">
				    	<label for="password2">
				    		<span style="color:red;font-weight:bold">*</span>
				    		Re-type Password:
				    	</label>
				    	<input onkeyup="checkPass2()" type="password" class="form-control" id="password2" name="password2">
				    	<span id="messageSpanPass2Success" style="color:green"><span>
				    	<span id="messageSpanPass2Fail" style="color:red"><span>
				    </div>
			    	<!-- <button type="submit" class="btn btn-default">Submit</button><br><br> -->

			    	<div class="row">
			    		<div class="col-md-4">
			    			<button type="submit" class="btn btn-success">Sign Up</button>
			    		</div>
			    	</div>
			    	
				</form>
		    </div>
		</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>
<br/><br/>
<?php 
	include('footer.php')
?>
