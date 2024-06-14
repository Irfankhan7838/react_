<?php

function validation(){
	$_SESSION['error'] = array();

	if($_POST['Change_Profile']=='Change_Profile')
	{
		if(isset($_POST['Name'])  && $_POST['Name']!="")
		{
			if(!preg_match ("/^[a-zA-Z\s]+(?: [a-zA-Z\s]+)*$/",$_POST['Name']))
			{
				$_SESSION['error']['Name']= 'Please enter name correctly.';
			}
		}
		if(isset($_POST['phone_number']) && $_POST['phone_number']!="")
		{
			if(!preg_match("/^[6-9]{1}[0-9]{9}$/",$_POST['phone_number']))
			{
				$_SESSION['error']['phone_number']= 'Please enter phone number correctly.';
			}
		}
		if(isset($_POST['City']) && $_POST['City']!="")
		{
			if(!preg_match ("/^[a-zA-Z\s]+$/",$_POST['City']))
			{
				$_SESSION['error']['City']= 'Please enter city correctly.';
			}
		}
		if(isset($_POST['State']) && $_POST['State']!="")
		{
			if(!preg_match ("/^[a-zA-Z\s]+$/",$_POST['State']))
			{
				$_SESSION['error']['State']= 'Please enter state correctly.';
			}
		}
		if(isset($_POST['ZipCode']) && $_POST['ZipCode']!="")
		{
			if(!($_POST['ZipCode']>100000 and $_POST['ZipCode']<999999))
			{
				$_SESSION['error']['ZipCode']= 'Please enter ZipCode correctly.';
			}
		}
		if(isset($_POST['Insurance_Experience']) && $_POST['Insurance_Experience']!="")
		{
			if(!preg_match ("/^[a-zA-Z\s]+$/",$_POST['Insurance_Experience']))
			{
				$_SESSION['error']['Insurance_Experience']= 'Please enter Insurance Experience correctly.';
			}
		}
	}




	
	return $_SESSION['error'];
	
}

?>