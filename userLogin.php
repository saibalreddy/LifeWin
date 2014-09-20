<?php
session_start();
require 'dbconfig.php';

/// Code for Login
if($_POST && $_POST['login']) {
	// echo '<pre>';
	// print_r($_POST);
	$password = base64_encode($_POST['password']);

	$query = mysql_query("SELECT * FROM users WHERE email = '$_POST[email]' and reg_type = 'direct'");
	if($row = mysql_fetch_object($query)) {
		if($row->verified == '1') {
			if($row->password == $password) {
				$_SESSION['username'] = $row->name;
				$_SESSION['userId'] = $row->user_id;

				header("Location: app.php");
				die();
			} else {
				$_SESSION['error'] = 'Invalid credentials.';
			}
		} else {
			$_SESSION['error'] = 'Email is not verified yet. Please verify it.';
		}	
	} else {
		$_SESSION['error'] = 'Invalid credentials.';
	}

//// Code for Reset password
} elseif ($_POST && $_POST['resetpass']) {
	
	$query = mysql_query("SELECT * FROM users WHERE email = '$_POST[email]' and reg_type = 'direct'");
	if($row = mysql_fetch_object($query)) {
		if($row->verified == '1') {
			
			$pass = base64_decode($row->password);
			$to = $_POST['email'];
			$from = 'donotreply@lifewin.co';
		    $subject = 'Reset Password';
		    $message = "
		    	<table>
		    		<tr>
		    			<td>Hello ".$_POST['fname'].",</td>
		    		</tr>
		    		<tr>
		    			<td>&nbsp;</td>
		    		</tr>
		    		<tr>
		    			<td>Your account login password is: ".$pass."</td>
		    		</tr>
		    		<tr>
		    			<td>&nbsp;</td>
		    		</tr>
		    		<tr>
		    			<td>You can now login and access your account.</td>
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

			$_SESSION["success"] = 'Your reset password sent on your register email. Please check email.';

		} else {
			$_SESSION['error'] = 'Email is not verified yet. Please verify it.';
		}	
	} else {
		$_SESSION['error'] = 'Email is not found in our database. Please register first.';
	}

} else {
	$_SESSION["error"] = 'Access Denied';
}

header("Location: index.php");
die();
?>
