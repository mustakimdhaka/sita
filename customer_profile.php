<?php
include("layout.php");
include("config.php");

session_start();
if(!isset($_SESSION['username'])){
	header('location: login.php');
}

if($_SESSION['type']=='admin'){
	include("menu_admin_2.php");
	//echo "<h2>Hello Admin</h2>";
}else{
	include("menu_customer.php");
	//echo "<h2>Hello Customer. This is your profile page. Its under construction</h2>";
}

// collect customer information from DB
$stmt = $conn->prepare("select * from customer where user_id=?");
$stmt->bindParam(1, $_SESSION['id']);
$result = $stmt->execute();
$row = $stmt->fetch();
?>

<script>
	$(document).ready(function() {

		// ********* Code for date picker *****************
		// note: Modal enforces to focus on itself instead of datepicker thats why 
		// this code is needed to resolve month and year dropdown issue in Datepicker 
		// when you put it in a modal 
		$.fn.modal.Constructor.prototype.enforceFocus = function () {
		$(document)
		  .off('focusin.bs.modal') // guard against infinite focus loop
		  .on('focusin.bs.modal', $.proxy(function (e) {
		    if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
		      this.$element.focus()
		    }
		  }, this))
		}
		
		$( function() {
		    $( "#modal_user_dob" ).datepicker({
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
		
		$("#button_edit_profile").on("click", function(e) {
			//alert('hi');
			var user_id = $('#user_id').val();
			var name = $('#name').text();
			var sex = $('#sex').text();
			var dob = $('#dob').text();
			var address = $('#address').text();
			var phone = $('#phone').text();
			var email = $('#email').text();
			//alert(user_id);
			$('#modal_user_id').val(user_id);
			$('#modal_user_name').val(name);
			$('#modal_user_sex').val(sex);
			$('#modal_user_dob').val(dob);
			$('#modal_user_address').val(address);
			$('#modal_user_phone').val(phone);
			$('#modal_user_email').val(email);
			$('#modal_profile_update').modal('show');
			
		});

		
		$("#profile_edit_confirm").on("click", function(e) {
			
			var user_id = $('#modal_user_id').val();
			var name = $('#modal_user_name').val();
			var sex = $('#modal_user_sex').val();
			var dob = $('#modal_user_dob').val();
			var address = $('#modal_user_address').val();
			var phone = $('#modal_user_phone').val();
			var email = $('#modal_user_email').val();

			
			// email validation 
			function validateEmail(email) {
				var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
				if (filter.test(email)) {
					return true;
				}else{
					return false;
				}
			}
			
			if ($.trim(email).length == 0) {
				alert('Please enter valid email address');
				e.preventDefault();
			}else{
				if (!validateEmail(email)) {
					alert('Invalid Email Address');
					e.preventDefault();
				}else{
					// sending data to server 
					$.ajax({
						method: "POST",
					    url : "update_customer_profile.php",
					    data : {
					    	user_id:user_id,
					    	name:name,
					    	sex:sex,
					    	dob:dob,
					    	address:address,
					    	phone:phone,
					    	email:email
					    },
					    dataType: 'html',
					    success: function(data, textStatus, jqXHR)
					    {
					        console.log(data);
					        if(data=='valid'){
					        	$('#flash-customer-update').show();
					        }else{
					        	$('#flash-error').show();
					        }
					        
					        setTimeout(function () {
						        $('#flash-customer-update').hide();
						        $('#flash-error').hide();
						        window.location.reload();
						    }, 3000);
					    },
					    error: function (jqXHR, textStatus, errorThrown)
					    {
					 		$('#flash-error').show();
					        setTimeout(function () {
						        //window.location.reload();
						        $('#flash-error').hide();
						    }, 3000);
					    }
					});
					
				}
			}
		});
		
	} );
</script>

<div class="container">

	<div class="alert alert-danger" id="flash-error" hidden>
		<strong>Opss.. There was an error! Try again with valid input</strong>
	</div>
	<div class="alert alert-success" id="flash-customer-update" hidden>
	    <strong>Your Personal Information has been Updated!</strong>
	</div>

	<div id="modal_profile_update" class="modal fade" role="dialog">
	    <div class="modal-dialog">

		    <!-- Modal for updating Customer profile-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Update Personal Information</h4>
		      </div>
		      
		      <div class="modal-body">
		        <p>Please provide correct input.</p>
		        <form action=''>
		        	<div class="form-group" hidden>
				    	<label>User Id:</label>
				    	<input disabled type="text" class="form-control" id="modal_user_id" name="modal_user_id">
				    </div>
		        	<div class="form-group">
				    	<label>Name:</label>
				    	<input type="text" class="form-control" id="modal_user_name" name="modal_user_name">
				    </div>
				    <div class="form-group">
				    	<label>Sex:</label>
				    	<select class="form-control" id='modal_user_sex'>
							<option value="M">Male</option>
							<option value="F">Female</option>
						</select>
				    </div>
				    <div class="form-group">
				    	<label>Date of Birth:</label>
				    	<input type="text" class="form-control" id="modal_user_dob" name="modal_user_dob">
				    </div>
				    <div class="form-group">
				    	<label>Address:</label>
				    	<textarea class="form-control" id="modal_user_address" name="modal_user_address"></textarea>
				    </div>
				    <div class="form-group">
				    	<label>Phone:</label>
				    	<input type="text" class="form-control" id="modal_user_phone" name="modal_user_phone">
				    </div>
				    <div class="form-group">
				    	<label>Email:</label>
				    	<input type="text" class="form-control" id="modal_user_email" name="modal_user_email">
				    </div>
		        </form>
		      </div>

		      <div class="modal-footer">
		      	<button type="button" id="profile_edit_confirm" class="btn btn-success" data-dismiss="modal">Update</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		      </div>
		    </div>

	    </div>
	</div>


	<div class="row">
		<div class="panel panel-default">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Personal Information</h3>
		    </div>
		    <div class="panel-body">
		    	 <!-- List group -->
			    <ul class="list-group col-md-6">
			    	<input type="hidden" id="user_id" value="<?php echo $_SESSION['id'];?>">
			    	</input>
				    <li class="list-group-item"><strong>Full Name:</strong>
				    	<span id='name'><?php echo $row['name'];?>	</span>
				    </li>
				    <li class="list-group-item" ><strong>Sex:</strong>
				    	<span id='sex'><?php echo $row['sex'];?></span>	
				    </li>
				    <li class="list-group-item"><strong>Date of Birth:</strong>
				    	<span id='dob'><?php echo $row['date_of_birth'];?></span>
				    </li>
				    <li class="list-group-item"><strong>Address:</strong>
				    	<span id='address'><?php echo $row['address'];?></span>
				    </li>
				    <li class="list-group-item"><strong>Phone:</strong>
				    	<span id='phone'><?php echo $row['phone'];?></span>
				    </li>
				    <li class="list-group-item"><strong>Email:</strong>
				    	<span id='email'><?php echo $row['email'];?></span>
				    </li>
				    <br>
				    <button class='btn btn-info' id='button_edit_profile'>Edit Profile</button>
			    </ul>

		    </div>
		    
		</div>
	</div>
</div>

<?php include('footer.php');?>