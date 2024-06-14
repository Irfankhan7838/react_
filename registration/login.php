<?php  
include '../include/connection.php'; 
include '../include/global-function.php'; 
$_SESSION['captcha'] = GenKey(); 

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	 <meta http-equiv="refresh" content="1800"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">




	<!-- bootstrap 4.3.1 CSS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- bootstrap 4.3.1 CSS end-->

	<!-- fontawesome -->
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- fontawesome end-->

	<!-- jquery CSS -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- jquery CSS end-->

	<!-- jquery 3.4.1 -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<!-- jquery 3.4.1 end-->



	<!-- fancy box CSS-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.css"/>
	<!-- fancy box CSS end-->



</head>
<?php include ("../head-main.php");?>
<script type="text/javascript">
	if (self === top) {
		var antiClickjack = document.getElementById("antiClickjack");
		antiClickjack.parentNode.removeChild(antiClickjack);
	} else {
		top.location = self.location;
	}
</script>
<body id="page2">

<style>
	.tab-tag {
		color: #000;
		font-weight: 500;
		border-bottom: 2px solid;
		padding-bottom: 7px;
		font-size: 20px;
	}
	.h-38{height:38px;}
	.captcha:focus{outline:none;} 

    #login-forms input {
    width: 100%;
    height: 42px;
    padding: 0px 0px 0px 10px;
    color: #000;
    border: 1px solid #8080804d;
   }
   #login-forms input:focus {
    border: #2a80b9;
   }
   #login-forms input:focus-visible {
    border: #2a80b9;
   }
   #login-forms .form-label {
    font-size: 16px;
    font-weight: 500;
    margin: 0px 0px 6px 0px;
   }
   .login_here {
    font-size: 18px;
    background: #2a80b9;
    letter-spacing: 0.3px;
   }
   .btn_scsess {
   	background: #4caf50;
   	color: #fff;
   	font-size: 17px;
   }
   .btn_scsess:hover {
   	color: #fff;
   }
   .login_bg_img {
   	width: 100%;
   	min-height: 100vh;
   	height: auto;
   	background-image: url(images/login_bg_2.jpg);
   	background-size: cover;
   	background-position: center;
   	background-repeat: no-repeat;
   	display: flex;
   	align-items: center;
   }
   .login_bg_img::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    opacity: 0.7;
    background: linear-gradient(to bottom, #000, transparent);
  }
</style>

<!-- php captcha -->
<script type='text/javascript'>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<!-- php captcha -->

<!-- CONTENT -->
<script>
	/*eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 3(a){2 b="";2 c="p";f(2 i=0;i<a;i++)b+=c.o(9.g(9.m()*c.7));j b}$(h).n(6(){4="";$("#k").l(6(){2 a=$("#e").d();f(2 i=0,8=a.7;i<8;i++){4=a[i]+3(1)+4}$("#e").d(3(5)+4+3(5));$("#q-r").s()})});',29,29,'||var|makeid|newstr||function|length|len|Math||||val|pwd|for|floor|document||return|doLogins|click|random|ready|charAt|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789|login|form|submit'.split('|'),0,{}))*/

	eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 3(a){2 7="";2 8="h";b(2 i=0;i<a;i++)7+=8.j(c.k(c.l()*8.d));m 7}$(n).o(6(){$("#p").q(6(){4="";2 9=$("#e").f();b(2 i=0,g=9.d;i<g;i++){4=9[i]+3(1)+4}$("#e").f(3(5)+4+3(5));$("#r-s").t()})});',30,30,'||var|makeid|newstr||function|text|possible|str|cnt|for|Math|length|pwd|val|len|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789||charAt|floor|random|return|document|ready|doLogins|click|login|form|submit'.split('|'),0,{}))
</script>

<?php 
if (!isset($_SESSION['user_id'])) {?>

					
	<div class="row_section w-100 login_bg_img">
		<div class="container-fluid">
			<div class="row m-0 div_margin">
				<div class="col-lg-4"></div>
				<div class="col-lg-4 my-3 pt-2" style="background: #fff;border-radius: 6px;z-index: 9999;">
					<h1 class="tab-tag mb-4 text-center">Login-Partner/Employees/Affiliates </h1>
					<?php	
					if (isset($_GET['msg'])) {
						echo '<div class="error" style="color: red;text-align: center;">'.$_GET['msg'].'</div>';
					}
					?> 
					<div id="error-id" class="error" style="color: red;text-align: center;"></div>
					<form action="" id="login-forms" method="post" name="logForm" style="background: #fff;">
						<div class="row m-0 mb-2">
							<div class="col-lg-12 p-2 mb-2 login_here  text-white text-center"><strong>Login Here...</strong></div>
							<div class="col-lg-12 my-2 p-0">
								<div class="form-label">
									Username
								</div>
								<div class="field form-field margin-bottom-0">							
									<input name="usr_email" placeholder="Username" class="required" title="Username" value=""  maxlength="2048" autocomplete="off"/>
								</div>	
							</div>	
							
							<div class="col-lg-12 my-2 p-0">
								<div class="form-label">
									Password
								</div>
								<div class="field form-field margin-bottom-0">							
									<input name="pwd" id="pwd" placeholder="Password" type="password" class="required"  title="Password" value=""  maxlength="2048" autocomplete="off"/>
								</div>	
							</div>
							<div class="col-lg-12 my-2 my-2 p-0" id="frame0">
								<?php //include("captcha.php"); ?> 
								<!-- <img src="../phptextcaptcha/captcha.php" id='captchaimg'><br> 
								<label for='message'>Enter the code above here :</label>  -->
								<img src="../phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br> 
								<label for='message' class="mt-2">Enter the code above here</label> 
							</div> 
							<div class="col-lg-12 my-2 p-0 h-38">
								<input style="border: 1px solid #0a4567;" name="captcha" id="captcha_id" placeholder="Captcha" type="text" class="required captcha"  title="captcha" value="" maxlength="10" autocomplete="off" /> 
							</div>
							<div class="col-lg-12">
								<!-- <br>
								Can't read the image? click <a href="">here</a> to refresh. -->
								<br>
								Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh
							</div>
							<div class="col-lg-12 my-2">
								<button type="submit" class="btn btn_scsess w-100" name='doLogins' id='doLogins'  value="Login" lt='Rechercher'>Submit</button>
								<input type='hidden' name='doLogin' value="Login">
							</div>
							<div class="col-lg-12 my-2">
								<!-- <a href="<?=LMS_ROOT_URI;?>/username-forgot.php">Forgot your username?</a> -->
							</div>
							<div class="col-lg-12 my-2">
								<a href="<?=LMS_ROOT_URI;?>/password-forgot.php">Forgot your password?</a>
							</div>
						</div>							
					</form>

					<script type="text/javascript">
						$(function () {
							$('#login-forms').on('submit', function (e) {
								e.preventDefault();

								$.ajax({
									type: 'post',
									url: 'login-api.php',
									data: $('form').serialize(),
									success: function (res) {
										res = JSON.parse(res);

										if(res.status == 0){
											$("#pwd").val('');
											refreshCaptcha();
											// window.location.href = "user-login.php?msg="+res.msg;
											$("#error-id").html(res.msg);
										}
										else if(res.status == 1){
											window.location.href = "dashboard.php";
										}
										else if(res.status == 2){
											window.location.href = res.url;
										}
										else{
											$("#error-id").text("Something went wrong, please try again.");
											location.reload(true);
										}
									}
								});
							});
						});
					</script>
				</div>
				<div class="col-lg-4"></div>
			</div>
		</div>
	</div>
<?php 
}else{ ?>
	<div class="row m-0">
	<div class="col-sm-3"></div>
	<div class="col-sm-6 my-3 pt-2" style="background: rgb(241, 240, 240);">
		<h3 class="tab-tag mb-3">Welcome <?php  echo $_SESSION['user_name']; ?></h3>
		<div class="row m-0">
		
			<div class="col-sm-4"><a href="mysettings.php" ><button type="submit" class="btn btn-success w-100 mb-2">Settings</button></a></div>
			<div class="col-sm-4"><a href="logout.php" ><button type="submit" class="btn btn-success w-100 mb-2">Logout </button></a></div>
			<div class="col-sm-4">
			</div>
		</div>
	</div>
	<div class="col-sm-3"></div>								
</div>
<?php }

?> 



</body>

</html>
