<?php 
/*
if(!(substr($_SERVER['HTTP_REFERER'],0,32) == "http://www.directpolicyindia.com" or substr($_SERVER['HTTP_REFERER'],0,28) == "http://directpolicyindia.com")) { 

header("location:http://www.directpolicyindia.com/index.php"); 
die;


}

*/


if(!(substr($_SERVER['HTTP_REFERER'],0,26) == "http://www.fab32dental.com" or substr($_SERVER['HTTP_REFERER'],0,22) == "http://fab32dental.com" or substr($_SERVER['HTTP_REFERER'],0,27) == "https://www.fab32dental.com" or substr($_SERVER['HTTP_REFERER'],0,23) == "https://fab32dental.com")) 
{ 

header("location:https://fab32dental.com");
die;

 }


//if(substr($_SERVER['HTTP_REFERER'],0,19) != "http://localhost/dp") { header("location:../index.php"); }

?>
