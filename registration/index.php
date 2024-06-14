<?php 

if (isset($_SESSION['user_id'])) {
	header("location:dashboard.php");
	
}else{
	header("location:login.php");
}

