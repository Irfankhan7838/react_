<?php
//include_once("../security-check.php");
include '../include/connection.php';
include '../include/global-function.php';
//include '../email/send_email.php';

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

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	foreach($_POST as $key => $value) 
	{
		$data[$key] = filter($value);
	}
	
	# if action is get_freeze_data then enter this section ###
	if(isset($data['email']) && $data['email']!="")
	{
		$select_user_details	=	"select * from users where user_email='".$data['email']."'";
		$select_user_details_get	=	sqlQuery($select_user_details,"select");
		$split_details	=	mysqli_fetch_assoc($select_user_details_get);
		if($split_details > 0)
		{
			if($split_details['approved'] == 1 and $split_details['pwd'] != "")
			{
				$user_key = md5($split_details['id'].$split_details['user_name'].$split_details['pwd']).md5($split_details['phone_number']);
				$url_link = LMS_ROOT_URI."/resetPassword.php?userkey=$user_key&useremail=".$split_details['user_email'];
				$message = "Dear ".$split_details['user_name'].",<br><br> Please use below link to reset your password. <br>".$url_link."<br><br>";
	
				//send_email($split_details['user_email'],$split_details['user_name'],'helpdesk@policyx.com','PolicyX','PolicyX- Reset Password',$message,0,$priority=0,$date=0,$time=0,$reply_to);
				$email = array('to' => $split_details['user_email'],'toName' => $split_details['user_name'],'from' => SEND_EMAIL,'fromName' => 'PolicyX Team','subject' => 'PolicyX- Reset Password','message' => $message,'vendor' => '0','reply_to' => 'no-reply@pxemails.in','campaign_id' => '8');
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,"https://www.policyx.com/email/send_transaction_email.php");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($email));
				// receive server response ...
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$email_sent_output = curl_exec ($ch);
				curl_close ($ch);
				
				$jsonResponce = array( "status" => "Success", "code" => "1", "message" => "Mail sent to your registered email id. Please reset your password from there.");
				echo json_encode($jsonResponce);
				die;
			
			}
			else
			{
				$jsonResponce = array( "status" => "Fail", "code" => "0", "message" => "This email id is blocked. Please contact us at helpdesk@PolicyX.com.");
				echo json_encode($jsonResponce);
				die;
			}
		}
		else
		{
			$jsonResponce = array( "status" => "Fail", "code" => "0", "message" => "Invalid email id. Please contact us at helpdesk@PolicyX.com.");
			echo json_encode($jsonResponce);
			die; 
		}
		
	}
}
?>