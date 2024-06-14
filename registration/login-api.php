<?php 


include_once '../security-check.php';
include '../include/connection.php';
include '../include/global-function.php';
include '../global_php_function/encrypt.php';

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	// Filter POST data for harmful code (sanitize)
	foreach($_POST as $key => $value) 
	{
		$data[$key] = filter($value);
	}
}

$data['pwd'] = decrypt_data($data['pwd']);

function validation(){
	$_SESSION['error'] = array();
	
	if(!preg_match('^[A-Za-z0-9._-]$^',$_POST['pwd']))
	{
		$_SESSION['error']['pwd']= 'Please Enter your password';
	}
	
	if(!preg_match("^[a-zA-Z0-9._-]+[@]{0,1}$^",$_POST['usr_email']))
	{
		$_SESSION['error']['email']= 'Please Enter Correct Email Address';
	}
	return $_SESSION['error'];
}

if ($_POST['doLogin']=='Login')
{
	// starting session for time out other code is in page_protect
	$_SESSION['LAST_ACTIVITY'] = time();
	$err= validation($_POST);		
	if(!empty($err)){ $val=implode(',',$err); }
	else{
		if($data['captcha'] !== $_SESSION['captcha_code']) 
		{ 
		    $err['status'] = 0;
			$err['msg'] = "Enter the text as in captcha.";
			echo json_encode($err);die;
		}
		else
		{
			unset($_SESSION['captcha_code']);
		} 

		$user_email = $data['usr_email'];
		$pass = $data['pwd'];
		if (strpos($user_email,'@') === false) {
		    $user_cond = "user_name='$user_email' AND pos = 0";
		} else {
		    $user_cond = "user_email='$user_email' AND pos = 0";
		    
		}
		$result = Login($user_cond,$pass);
		//print_r($result);die;
		if($result['status'] == 0){
			$err['status'] = 0;
			$err['msg'] = $result['msg'];
		}else if($result['status'] == 1){
			$err['status'] = 1;
			$err['msg'] = "success";
		}else if($result['status'] == 2){
		    $url_link = $result['link']; 
		    $err['status'] = 2;
		    $err['url'] = $result['link'];
		}

		echo json_encode($err);
	}	
}