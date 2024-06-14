<?php


    include_once("../include/connection.php");
    include_once("../include/global-function.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if($_REQUEST['captcha'] !== $_SESSION['captcha_code'])
        {
            $jsonResponce = array( "status" => "Fail", "code" => "0", "message" => "Enter the text as in captcha."  );
            echo json_encode($jsonResponce);
            die;
        }
        else
		{
			unset($_SESSION['captcha_code']);
		} 
        
        foreach($_POST as $key => $value) 
	{
            $data[$key] = filter($value);
	}
        
        if(isset($data['phone']) && $data['phone']!="")
	{
            $select_user_details	=	"select * from users where phone_number='".$data['phone']."'";
            $select_user_details_get	=	sqlQuery($select_user_details,"select");
            $split_details	=	mysqli_fetch_assoc($select_user_details_get);
            if($split_details > 0)
            {
                    if($split_details['approved'] == 1 and $split_details['pwd'] != "")
                    {
                        include_once("../global_php_function/send_sms_global.php");    
                        $response = send_sms_global(0,0,0,"forgot_username",$split_details);
                        
                        $jsonResponce = array( "status" => "Success", "code" => "1", "message" => "Username sent to your registered mobile number.");
                        echo json_encode($jsonResponce);
                        die;

                    }
                    else
                    {
                        $jsonResponce = array( "status" => "Fail", "code" => "0", "message" => "User is blocked. Please contact us at helpdesk@PolicyX.com.");
                        echo json_encode($jsonResponce);
                        die;
                    }
            }
            else
            {
                $jsonResponce = array( "status" => "Fail", "code" => "0", "message" => "Mobile number is not registered with us. Please contact us at helpdesk@PolicyX.com.");
                echo json_encode($jsonResponce);
                die; 
            }
        }
    }else{
        $_SESSION['captcha'] = GenKey();
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<?php include ("../head-main.php"); ?>
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
			var phone = $("#phone").val();
			var captcha = $("#captcha").val();
			if( phone === '') 
			{ 	
				alert('Invalid mobile no.'); 
			} 
			else 
			{
				$.ajax({ type: "POST", url: "username-forgot.php", data: "phone="+phone+"&captcha="+captcha,  dataType:'json',
				success: function(responce)
				{
					alert(responce.message);
				}/*,
				error: function(jqXHR, textStatus, errorThrown) {
					$(document).ajaxStop($.unblockUI);
					//$('.formError').show().text("Error in getting city list");
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


<!-- CONTENT -->
<div class="row m-0 mb-2">
        <div class="col-sm-4"></div>
		 <div class="col-sm-4 my-3 pt-2" style="background: rgb(241, 240, 240);">
 <h1 class="tab-tag mb-3">Recover Username</h1>

 <form action="#" id="login-form" method="post" name="logForm" style="background: rgb(241, 240, 240);">

	<div class="row m-0">
			<div class="col-sm-12 p-2 mb-2 bg-info  text-white text-center"><strong>Enter Your Registered Mobile No.</strong></div>
			<div class="col-sm-12 my-2 p-0">
			<div class="form-label">
				Mobile No.
			</div>
			<div class="field form-field margin-bottom-0">							
				<input type="text" name="text" id="phone" class="w-100 pl-2" placeholder="9871641230">
			</div>	
			</div>	
			<div class="col-sm-12 my-2 pl-0">
				<img src="../phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br> 
				<label for='message'>Enter the code above here :</label> 
				<br>
				Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
			</div>
			<div class="col-sm-12 my-2 form-field"><input name="captcha" id="captcha" placeholder="Captcha" type="text" class="required captcha"  title="captcha" value=""  maxlength="10" autocomplete="off" /></div>
			<div class="col-sm-12 my-2"><button type="button" class="btn btn-success w-100" id="submitEmail" value="Submit">Submit</button></div>
			
	</div>							

</form>
</div>
 <div class="col-sm-4"></div>
									
</div>




</body>

</html>