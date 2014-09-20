<?php
session_start();
// ini_set('display_errors',1);
require 'dbconfig.php';

if($_POST && $_POST['signup']) {
	// echo '<pre>';
	// print_r($_POST);
	$uname = $_POST['fname'].' '.$_POST['lname'];
	$email = $_POST['email'];
	$password = base64_encode($_POST['password']);
	$verified = '1';

	$query = mysql_query("SELECT * FROM users WHERE email = '$_POST[email]' and reg_type='direct'");

	if(!$row = mysql_fetch_array($query)) {
		$query = "INSERT INTO users (name,email,password,verified) VALUES ('$uname','$email', '$password', '0')";
		if(mysql_query($query)) {
			$lastId = mysql_insert_id();

			$link = 'http://lifewin.co/verify.php?code='. base64_encode($lastId);
			/// Sent mail of registration
			$to = $_POST['email'];
			$from = 'donotreply@lifewin.co';
		    $subject = 'Lifewin registration';
		    $message = "
		    	<table>
		    		<tr>
		    			<td>Hello ".$_POST['fname'].",</td>
		    		</tr>
		    		<tr>
		    			<td>&nbsp;</td>
		    		</tr>
		    		<tr>
		    			<td>Thank you for register with us. You are successfully register and now you have to verify your email using click below link.</td>
		    		</tr>
		    		<tr>
		    			<td>&nbsp;</td>
		    		</tr>
		    		<tr>
		    			<td><a href='".$link."'>Click Here</a></td>
		    		</tr>
		    		<tr>
		    			<td>&nbsp;</td>
		    		</tr>
		    		<tr>
		    			<td>Regards,</td>
		    		</tr>
		    		<tr>
		    			<td>Lifewin Team</td>
		    		</tr>
		    	</table>
		    	";
		    // message lines should not exceed 70 characters (PHP rule), so wrap it
		    $message = wordwrap($message, 70);
		    // send mail

		    $headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= 'From: Lifewin <donotreply@lifewin.co>';
		    mail($to, $subject, $message, $headers);

			$_SESSION["success"] = 'Register successfully. You can login now.';
		} else {
			$_SESSION['error'] = 'Something went wrong. Please try again.';
		}
	} else {
		$_SESSION['error'] = 'Email already register. Please use another email.';
	}

} else {
	$_SESSION["error"] = 'Access Denied';
}

header("Location: index.php");
die();
?>
