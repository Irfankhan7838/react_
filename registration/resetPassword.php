<?php
//include_once("../security-check.php");

include '../include/connection.php';
include '../include/global-function.php';

foreach($_GET as $key => $value) 
{
	$data[$key] = filter($value);
}
foreach($_POST as $key => $value) 
{
	$data[$key] = filter($value);
}
$error ="";
if(isset($data['varify']) and $data['varify'] == 'yes')
{
	if($data['password_1'] == $data['password_2'])
	{
		if($data['password_1'] != "" && $data['password_2'] != "" )
		{
			//if(!preg_match("/^.(?=.{8,})[a-zA-Z0-9\s]+(?:\d+)*+$/", $data['password_1']))
			if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#\-_$%^&+=!])[0-9A-Za-z@#\-_$%^&+=!\?]{8,50}$/',$data['password_1']))
			{
				$error = 'Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter, one number and at least one special sign of @#\-_$%^&+=! <b> ( ex: Alpha+123@m )</b>';
			}
			else
			{
				$new_password = $data['password_1'];
				$select_user_details	=	"select * from users where user_email='".$data['useremail']."'";
				$select_user_details_get	=	sqlQuery($select_user_details,"select");
				$split_details	=	mysqli_fetch_assoc($select_user_details_get);
				
						
				if($data['userkey'] == md5($split_details['id'].$split_details['user_name'].$split_details['pwd']).md5($split_details['phone_number']))
				{
					$old_salt1 = substr($split_details['pwd'],0,9);
					$old_salt2 = substr($split_details['pwd2'],0,9);
					$old_salt3 = substr($split_details['pwd3'],0,9);
					
					if($split_details['pwd'] === PwdHash($new_password,$old_salt1) || $split_details['pwd2'] === PwdHash($new_password,$old_salt2) || $split_details['pwd3'] === PwdHash($new_password,$old_salt3)){
						$error = "New password must not be same as last 3 password";
					}else{
						$date = date('Y-m-d H:i:s');
						$pwd3 = $split_details['pwd2'];
						$pwd2 = $split_details['pwd'];
						$newsha1 = PwdHash($data['password_1']);
						sqlQuery("update users set pwd='$newsha1' ,`password_timestamp` = '$date',`pwd2` = '$pwd2',`pwd3` = '$pwd3' where id='$split_details[id]'","update");
						$error = "Your new password is updated";
					}
				}
				else
				{
					$error = "Invalid User.";
				}
							
			}
		}
		else
		{
			$error = "New Password and Confirm Password field must not be blank.";
		}
	}
	else
	{
		$error = "New Password and Confirm Password must be same.";
	}
}

if($data['userkey'] == "" or $data['useremail'] == "")
{
	$error = "Athentication fails";
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">



<body id="page2">



<!-- HEADER -->


<!-- CONTENT -->

	<div id="form_life_wrapper" class="row border">

		<div class="box">

			<div class="border-bot">

				<div class="right-bot-corner">

					<div class="left-bot-corner">

						<div class="inner">

							<div class="box1 alt">

								<div class="inner">

									<h4><b><?php echo $error; ?></b></h4>
									<?php 
									if($data['userkey'] != "" and $data['useremail'] !="")
									{ 
									if($error != 'Your new password is updated'){ ?>
										<h4><b>Enter new password.</b></h4>
										<form name="resetpwdform" id="resetpwdform" action="resetPassword.php" method="post">
										<p><input type="hidden" name="userkey" id="userkey" value="<?php echo $data['userkey']; ?>"></p>
										<p><input type="hidden" name="useremail" id="useremail" value="<?php echo $data['useremail']; ?>"></p>
										<p><input type="hidden" name="varify" id="varify" value="yes"></p>
										<p><input type="password" name="password_1" id="password_1" value="" placeholder="New Password"></p>
										<p><input type="password" name="password_2" id="password_2" value="" placeholder="Confirm Password"></p>
                                                                                <p><input type="submit" id="submitPassword" value="Submit" style="color: #000 !important;"></p>
										</form>
										<?php	
										}else{ ?>
											<a href="login.php">Login</a>
										<?php }
									
									} ?>
									
								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		</div>

<!-- FOOTER -->





</body>

</html>