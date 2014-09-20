<?php
require_once("connect.php");
$query = mysql_fetch_array(mysql_query("SELECT email FROM users WHERE email='$_POST[value]'"));
if(!empty($query)){
	$err["email"] = "Email already registered";
	echo $err["email"];
}
?>