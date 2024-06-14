<!doctype html>
<html lang="en">
<head>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <?php include 'head.php';?>

  	<?php include 'header.php';?> 	

	<title>Add patient</title>
	<style>
.centered-form {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f1f1f1;
}

#add_patient_form {
  background-color: #fff;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

.form-group {
  margin-bottom: 20px;
}

.form-control {
  height: 40px;
  font-size: 16px;
  border-radius: 5px;
  border: none;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
}

.error-msg {
  margin: 0;
  font-size: 14px;
  color: red;
}

.success-msg {
  margin: 0;
  font-size: 16px;
  color: green;
}

	</style>
</head>
<body>


<div class="centered-form">
  <form id="add_patient_form" class="send_user_email">
    <div class="form-group">
      <input type="text" name="Name" class="form-control" placeholder="First Name" id="name">        
      <p id="NameError" class="error-msg"></p>
    </div>
    <div class="form-group">
      <input type="email" name="Email" placeholder="Email" id="email" class="form-control">
      <p id="EmailError" class="error-msg"></p>
    </div>
    <div class="form-group">
      <input type="phone" name="phone_number" class="form-control" placeholder="Phone Number" id="phone_number" maxlength="10">     
      <p id="PhoneError" class="error-msg"></p>       
    </div>
    <div class="form-group">
      <input type="date" class="form-control" name="dob" placeholder="DOB" id="dob">
      <p id="DOBError" class="error-msg"></p>
    </div>
    <div class="form-group">
      <input type="text" name="Address" placeholder="Address" id="address" class="form-control">
      <p id="AddressError" class="error-msg"></p>
    </div>
    <div class="form-group">
      <textarea name="comment" class="form-control" placeholder="Comment"></textarea>             
    </div>
    <input type="hidden" name="action" value="add_patient">			
    <input type="submit" name="add_patient" class="btn btn-primary mt-2" id="add_patient">
    <p id="patient_error" class="error-msg"></p>
    <p class="success-msg" id="msg1"></p>
  </form>
</div>



</body>
</html>


    <?php include 'footer.php';?>
<script type="text/javascript">
	$(document).ready(function(){

		$('#add_patient').click(function(event){
			event.preventDefault();

			var name = $('#name').val();
			var nameRegex = /^[a-zA-Z\s]+(?: [a-zA-Z\s]+)*$/;
		    if (!nameRegex.test(name)) {
		        $('#NameError').text('Please enter a valid name.').show();
		    } else {
		        $('#NameError').hide();		      
		    }


		    var email = $('#email').val();
		    var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
		    if (!emailRegex.test(email)) {
		        $('#EmailError').text('Please enter a valid email address.').show();
		    } else {
		        $('#EmailError').hide();
		    }
	    
		    var dob = $('#dob').val();
		    var dobRegex = /^\d{4}-\d{2}-\d{2}$/;
		    if (!dobRegex.test(dob)) {
		        $('#DOBError').text('Please enter a valid date of birth in the format YYYY-MM-DD.').show();
		    } else {
		        $('#DOBError').hide();
		    }
	    
		    var phone = $('#phone_number').val();
		    var phoneRegex = /^\d{10}$/;
		    if (!phoneRegex.test(phone)) {
		        $('#PhoneError').text('Please enter a valid 10-digit phone number.').show();
		    } else {
		        $('#PhoneError').hide();
		    }
	    
		    var address = $('#Address').val();
		    var addressRegex = /^[a-zA-Z0-9\s,'-]*$/;
		    if (address.length < 3 ) {
		        $('#AddressError').text('Please enter a valid address.').show();
		    } else {
		        $('#AddressError').hide();
		    }
    
		    // continue with form submission if there are no errors
		    if ($('#NameError').is(':hidden') && $('#EmailError').is(':hidden') && $('#DOBError').is(':hidden') && $('#PhoneError').is(':hidden') && $('#AddressError').is(':hidden')) {
		    	var formdata = new FormData($('#add_patient_form')[0]);			
				$.ajax({
					url:"patient_webservice.php",
					type:"post",
					processData: false,
			      	contentType: false,
			      	data: formdata,					
					success:function(res){

					}
				})
		       
		    }
						
		})
	})
</script>
