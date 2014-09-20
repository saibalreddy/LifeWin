<?php
include("php/connect.php");
include("php/formvalidation.php");
$email = $_GET['email'];
$code = $_GET['code'];
$realcode = md5($_GET['email'].date("Y-m-d"));
if($code == $realcode){
	$query = "UPDATE users SET verified=1 WHERE email='$email'";
	if(mysql_query($query)){
	$_SESSION['loggedin']="yes";
		$_SESSION['user_id']=$user_id;
		$_SESSION['name']=$_POST['name'];
		$_SESSION['email']=$_POST['email'];
		$_SESSION['mobile']=$_POST['mobile'];
		$_SESSION['cookietime'] = time()+(60*24*60*60); //2 month time
		setcookie("_ui", $user_id['user_id'], $_SESSION['cookietime']);
		setcookie("_pedh", md5(sha1($pass.$_POST['email'])), $_SESSION['cookietime']);
		header("Location: index.php");
	}
	else
		echo "Unable to verify email address, kindly check the link";
}
else
	echo "Unable to verify email address, kindly check the Link";