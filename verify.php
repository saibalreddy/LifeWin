<?php
session_start();
require 'dbconfig.php';

if($_GET && $_GET['code']) {
	// echo '<pre>';
	// print_r($_POST);
	$code = base64_decode($_GET['code']);

	$query = mysql_query("SELECT * FROM users WHERE user_id = '$code'");
	if($row = mysql_fetch_object($query)) {
		if($row->verified == '0') {

			$query = "UPDATE users SET verified='1' where user_id='$code'";
			mysql_query($query);

			$_SESSION['success'] = 'Email verification successfully. You may login now.';
			header("Location: index.php");
			die();
		} else {
			$_SESSION['error'] = 'Email already verified. Please login';
		}
	} else {
		$_SESSION['error'] = 'Invalid url.';
	}

} else {
	$_SESSION["error"] = 'Access Denied';
}

header("Location: index.php");
die();
?>
