<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
	header('location:login.php');
die();
}
include_once '../security-check.php';
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
************************************************************/

include '../include/connection.php';
include '../include/global-function.php';
include_once("server_validation.php");
// page_protect();


$err = array();
$msg = array();
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	// Filter POST data for harmful code (sanitize)
	foreach($_POST as $key => $value) 
	{
		$data[$key] = filter($value);
	}
}

if($data['doUpdate'] == 'Updt')  
{
	function decriptpwd($str)
	{
		$str = strrev($str);
		$str = substr($str, 5);
		$str = substr($str, 0, -5);
		$new= "";
		for($i=0; $i<=strlen($str); $i++)
		{
			if($i%2 != 0)
			{
				$new .= $str[$i];
				
			}			
		}
		return $new;
	}

	$data['pwd_new'] = decriptpwd($data["pwd_new"]);
	$data['pwd_old'] = decriptpwd($data["pwd_old"]);
################# Start Check Server Side Paassword and confirm password ####	
	
	$data['confirmPass'] = decriptpwd($data["cnf_pwd_new"]);

	if($data['pwd_new'] == $data['confirmPass'])
	{
					$errPass=	"";
					$resultset = PasswordChange($data['pwd_old'],$data['pwd_new']);
					//print_r($resultset);die;
					if($result['status'] == 1){
						$errPass = '<p class="errText">'.$resultset['msg'].'</p>';
					}else{
						$errPass = '<p class="errText">'.$resultset['msg'].'</p>';
					}

	}
	else
	{
		$err[] = "New password and confirm password should be same";
	}
	
	
	
	
}

if($data['doSave'] == 'Save')  
{
	$error= validation($_POST);	
	if(!empty($error))
	{
		$error_string=implode('<br>',$error);
	}
	else
	{
		sqlQuery("UPDATE users SET
			`name` = '".$data['Name']."',
			`phone_number`= '".$data['phone_number']."',
			`address` = '".$data['Address']."',
			`City` = '".$data['City']."',
			`State` = '".$data['State']."',
			`ZipCode` = '".$data['ZipCode']."',
			user_email = '".$data['usr_email']."',
			`Insurance_Experience` = '".$data['Insurance_Experience']."' 
			
			 WHERE id='".$_SESSION['user_id']."'
			","update");

			//header("Location: mysettings.php?msg=Profile Sucessfully saved");
		$msg[] = "<span style='color:green;'>Profile Sucessfully saved</span";
	}
}
$rs_settings = sqlQuery("select * from users where id='".$_SESSION['user_id']."'","select"); 
?>
<?php
include_once 'head.php';
?>
<!-- custom css -->

<!-- CONTENT -->
<div class="content-wrapper" style="min-height: 270px;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 pl-0">
				<h2 class="m-0 text-dark mb-2">A/c Settings</h2>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
	<section class="content mb-1">
		<div class="container-fluid">
			<div class="container card card-primary card-outline" id="content">
				<div class="row mb-2 top_border">
					<div class="col-md-12 col-sm-12">
						<h4 style="color:red;">
							<?php	
								if (!empty($msg)) {
									echo "$msg[0]";
								}else {
									echo "$err[0]";
								}
								if($errPass!="")
								{
									echo $errPass; 
								} 
								if($error_string!="")
								{
									echo $error_string; 
								} 
							?> 
						</h4>
						<?php 
							while ($row_settings = mysqli_fetch_array($rs_settings)) {
						?>
								<form action="mysettings.php" method="post" name="myform" id="myform">
									<input type="hidden" name="Change_Profile" id="Change_Profile" value="Change_Profile" >
									<h4 style="color:red;">
										Change Profile
										<div class="tooltip">
											<i class="fa fa-info-circle" aria-hidden="true"></i>
											<span class="tooltiptext">
												<p>Here you can make changes to your profile. Please note that you will not be able to change your email which has already been registered</p>
											</span>
										</div>
									</h4>

									<div class="row mt-3">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="user_name">Username<span class="required"><font color="#CC0000">*</font></span></label>
												<input name="user_name" type="text" id="user_name" class="form-control required username" minlength="5" value="<?php echo $row_settings['user_name']; ?>" disabled>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="Agent_ID">Your ID<span class="required"><font color="#CC0000">*</font></span></label>
												<input name="Agent_ID" type="text" id="Agent_ID" class="form-control required" value="<?php echo $row_settings['id']; ?>" disabled>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="Agent_ID">Name:</label>
												<input name="Name" type="text" id="Name" size="40px" class="form-control required" value="<?php echo $row_settings['name']; ?>"/>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="phone_number">Mobile Number:</label>
												<input name="phone_number" type="text" id="phone_number" size="40px" class="form-control required phone_number" value="<?php echo $row_settings['phone_number']; ?>"/>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="usr_email">Your Email<span class="required"><font color="#CC0000">*</font></label>
												<input name="usr_email" type="text" id="usr_email" class="form-control required email" value="<?php echo $row_settings['user_email']; ?>">
											</div>
										</div>
										<div class="col-sm-9">
											<div class="form-group">
												<label for="Address">Address:<span class="required"><font color="#CC0000">*</font></label>
												<input name="Address" type="text" id="Address" size="82px" class="form-control required" value="<?php echo $row_settings['address']; ?>"/>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="City">City:<span class="required"><font color="#CC0000">*</font></label>
												<input name="City" type="text" id="City" size="20px" class="form-control required" value="<?php echo $row_settings['city']; ?>" />
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="State">State:<span class="required"><font color="#CC0000">*</font></label>
												<input type="text"  name="State" id="State" size="20px" class="form-control required" value="<?php echo $row_settings['state']; ?>" />
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="State">Zip Code:<span class="required"><font color="#CC0000">*</font></label>
												<input name="ZipCode" type="text" id="ZipCode" size="20px" class="form-control required" value="<?php echo $row_settings['ZipCode']; ?>" maxlength="6"/>
											</div>
										</div>
										<!-- <div class="col-sm-3">
											<div class="form-group">
												<label for="State">Experience:<span class="required"><font color="#CC0000">*</font></label>
												<textarea name="Insurance_Experience" cols="130" rows="5" wrap="soft"  class="form-control required" id="Insurance_Experience" > <?php echo $row_settings['Insurance_Experience'];?></textarea>
											</div>
										</div> -->
									</div>
									<div class="row">
										<div class="col-sm-12">
											<button type="submit" class="btn btn-success btn-sm" name="doSave" id="doSave" value="Save" >
												Save Profile >>
											</button> 
										</div>
									</div>
								</form>
						<?php 
							} 
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="content mt-4">
		<div class="container-fluid">
			<div class="container card card-primary card-outline" id="content">
				<div class="row mb-2 top_border">
					<div class="col-md-12 col-sm-12">
						<div id="form-container">
							<h4 class="mt-2" style="color:red;">
								Change Password
								<div class="tooltip">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
									<span class="tooltiptext">
										<p>If you want to change your password, please input your old and new password to make changes.</p>
									</span>
								</div>
							</h4>
							
							<form name="pform" id="pform" method="post" action="">
								<div class="row mt-3">
									<div class="col-sm-3">
										<div class="form-group">
											<label for="password">Old Password:<span class="required"><font color="#CC0000">*</font></label>
											<input name="pwd_old" type="password" class="form-control required password"  id="pwd_old" autocomplete="off">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="pwd_new">New Password:<span class="required"><font color="#CC0000">*</font></label>
											<input name="pwd_new" type="password" id="pwd_new" class="form-control required password"  autocomplete="off">
											<input name="doUpdate" type="hidden" id="doUpdate" value="Updt"  >
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="cnf_pwd_new">Confirm Password:<span class="required"><font color="#CC0000">*</font></label>
											<input name="cnf_pwd_new" type="password" id="cnf_pwd_new" class="form-control required password"  autocomplete="off">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<button type="button" class="btn btn-success positive btn-sm" name="button" id="button" onclick="update_id()" value="Updt" >
											Change Password >>
										</button>
									</div>
								</div>
							</form>			
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>



<script type="text/javascript">
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('t w(){e($("#f").2()==""){j("o n N 8.");$("#f").h();g l}e($("#d").2()==""){j("o n K 8.");$("#d").h();g l}e($("#7").2()==""){j("o n p 8.");$("#7").h();g l}e($("#f").2()!=""||$("#d").2()!=""||$("#7").2()!=""){r=$("#d").2();s=$("#7").2();e(r==s){e(p(\'J u A u z y x F 8?\')){3="";6 a=$("#d").2();k(6 i=0,9=a.m;i<9;i++){3=a[i]+4(1)+3}$("#d").2(4(5)+3+4(5));3="";6 a=$("#f").2();k(6 i=0,9=a.m;i<9;i++){3=a[i]+4(1)+3}$("#f").2(4(5)+3+4(5));3="";6 a=$("#7").2();k(6 i=0,9=a.m;i<9;i++){3=a[i]+4(1)+3}$("#7").2(4(5)+3+4(5));$("#B").C()}}D{j("E 8 v p 8 G H I.");$("#7").h();g l}}}t 4(a){6 b="";6 c="L";k(6 i=0;i<a;i++)b+=c.M(q.O(q.P()*c.m));g b}',52,52,'||val|newstr|makeid||var|cnf_pwd_new|password|len||||pwd_new|if|pwd_old|return|focus||alert|for|false|length|enter|Please|confirm|Math|newPass|confirmPass|function|you|and|update_id|update|to|want|sure|pform|submit|else|New|your|should|be|same|Are|new|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789|charAt|old|floor|random'.split('|'),0,{}))

</script>