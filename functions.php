<?php
require 'dbconfig.php';
function checkuser($id,$uname,$email, $ltype){

	// Set session of username
	$_SESSION['username'] = $uname;
	// Using FB
	if($ltype == 'fb') {
		$sql = mysql_query("select * from users where fb_id=". $id);
		$check = mysql_num_rows($sql);
		// print_r($check); die();
		if (empty($check)) { // if new user . Insert a new record		
			$query = "INSERT INTO users (fb_id,name,email,reg_type,verified) VALUES ('".$id."','$uname','$email', 'fb', '1')";
			$res = mysql_query($query);
			$_SESSION['userId'] = mysql_insert_id();
		} else {   // If Returned user . update the user record
			$row = mysql_fetch_object($sql);
			$query = "UPDATE users SET name='$uname', email='$email' where fb_id='$id'";
			mysql_query($query);
			$_SESSION['userId'] = $row->user_id;
		}

	// Using GMAIL	
	} elseif ($ltype == 'gmail') {
		$sql = mysql_query("select * from users where gmail_id='". $id."'");
		$check = mysql_num_rows($sql);
		// print_r($check); die();
		if (empty($check)) { // if new user . Insert a new record		
			$query = "INSERT INTO users (gmail_id,name,email,reg_type,verified) VALUES ('".$id."','$uname','$email', 'gmail', '1')";
			$res = mysql_query($query);
			$_SESSION['userId'] = mysql_insert_id();
		} else {   // If Returned user . update the user record
			$row = mysql_fetch_object($sql);
			$query = "UPDATE users SET name='$uname', email='$email' where gmail_id='$id'";
			mysql_query($query);
			$_SESSION['userId'] = $row->user_id;
		}
	}
}
?>
