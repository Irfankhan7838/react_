<?php

	include_once("../include/connection.php");
	include_once("../include/global-function.php");
	$_SESSION['captcha'] = GenKey();
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="en">
<head>
	<!-- bootstrap 4.3.1 CSS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- bootstrap 4.3.1 CSS end-->
	<!-- jquery CSS -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- jquery CSS end-->

	<!-- jquery 3.4.1 -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<!-- jquery 3.4.1 end-->
</head>
<style>

.tab-tag {
    color: #000;
    font-weight: 500;
    border-bottom: 2px solid;
    padding-bottom: 7px;
    font-size: 20px;
    text-align: center;
}
.captcha:focus{outline:none;}
.forgot_container {
	width: 100%;
    min-height: 100vh;
    height: auto;
    background-image: url(images/login_bg_2.jpg);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
}
.forgot_container::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    opacity: 0.7;
    background: linear-gradient(to bottom, #000, transparent);
  }
  .forgot_container input {
    width: 100% !important;
    height: 38px;
    border: 1px solid #80808057;
    padding: 0px 0px 0px 10px;
    border-radius: 5px;
 }
 .heading {
 	background: #1196CC;
 }
 .heading h4 {
 	font-size: 19px;
 	font-weight: 600;
 	color: #fff;
 }
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

<div class="container-fluid forgot_container">
	<div class="row m-0 mb-2">
        <div class="col-lg-4"></div>
		 <div class="col-lg-4 my-3 pt-2" style="background: #fff; border-radius: 5px;">
            <h1 class="tab-tag mb-3">Forgot Password ?</h1>

	         <form action="#" id="login-form" method="post" name="logForm" style="background: #fff;">

		    <div class="row m-0">
				<div class="col-lg-12 p-2 mb-2 text-white text-center heading"><h4>Enter Your Registered Email Id</h4></div>
				<div class="col-lg-12 my-2 p-0">
				<div class="form-label">
					Email Id
				</div>
				<div class="field form-field margin-bottom-0">							
					<input type="text" name="email" id="email" class="w-100 pl-2" value="">
				</div>	
				</div>	
				<div class="col-lg-12 my-2 pl-0">
					<img src="../phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br> 
					<label for='message'>Enter the code above here :</label> 
					<br>
					Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
				</div>
				<div class="col-lg-12 my-2 form-field px-0"><input name="captcha" id="captcha" placeholder="Enter Captcha" type="text" class="required captcha"  title="captcha" value=""  maxlength="10" autocomplete="off" /></div>
				<div class="col-lg-12 my-2 form-field pl-0">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<button type="button" class="btn btn-success w-100" id="submitEmail" value="Submit">Submit</button>
						</div>
						<div class="col-lg-3"></div>
					</div>
				</div>
				
				
		</div>							

	</form>
	</div>
	 <div class="col-lg-4"></div>
										
	</div>
</div>
</body>

</html>