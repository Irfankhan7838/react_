<?php

	include_once("../include/connection.php");
	include_once("../include/global-function.php");
	$_SESSION['captcha'] = GenKey();
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="en">


<style>

.tab-tag {
    color: #65b034;
    font-weight: 500;
    border-bottom: 2px solid;
    padding-bottom: 7px;
    font-size: 20px;
}
.captcha:focus{outline:none;}

</style>
<script>
	$(document).ready(function(){
		$("#submitEmail").click(function(){
			var email = $("#email").val();
			var captcha = $("#captcha").val();
			if( !validateEmail(email)) 
			{ 	
				alert('Invalid email id'); 
			} 
			else 
			{
				$.ajax({ type: "POST", url: "password-forgot-email.php", data: "email="+email+"&captcha="+captcha,  dataType:'json',
				success: function(responce)
				{
					alert(responce.message);
				}/*,
				error: function(jqXHR, textStatus, errorThrown) {
					$(document).ajaxStop($.unblockUI);
					$('.formError').show().text("Error in getting city list");
				}*/
			});		
			};
		});	
	});
	function validateEmail($email) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test( $email );
	}
</script>

<!-- php captcha -->
<script type='text/javascript'>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<!-- php captcha -->

<body id="page2">



<!-- HEADER -->

	<?php 
	// include_once 'head.php';
	 ?>

<!-- CONTENT -->
<div class="row m-0 mb-2">
        <div class="col-sm-4"></div>
		 <div class="col-sm-4 my-3 pt-2" style="background: rgb(241, 240, 240);">
 <h1 class="tab-tag mb-3">Forgot Password ?</h1>

 <form action="#" id="login-form" method="post" name="logForm" style="background: rgb(241, 240, 240);">

	<div class="row m-0">
			<div class="col-sm-12 p-2 mb-2 bg-info  text-white text-center"><strong>Enter Your Registered Email Id</strong></div>
			<div class="col-sm-12 my-2 p-0">
			<div class="form-label">
				Email Id
			</div>
			<div class="field form-field margin-bottom-0">							
				<input type="text" name="email" id="email" class="w-100 pl-2" value="">
			</div>	
			</div>	
			<div class="col-sm-12 my-2 pl-0">
				<img src="../phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br> 
				<label for='message'>Enter the code above here :</label> 
				<br>
				Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
			</div>
			<div class="col-sm-12 my-2 form-field"><input name="captcha" id="captcha" placeholder="Enter Captcha" type="text" class="required captcha"  title="captcha" value=""  maxlength="10" autocomplete="off" /></div>
			<div class="col-sm-12 my-2"><button type="button" class="btn btn-success w-100" id="submitEmail" value="Submit">Submit</button></div>
			
	</div>							

</form>
</div>
 <div class="col-sm-4"></div>
									
</div>





</body>

</html>