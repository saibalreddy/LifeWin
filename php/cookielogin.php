<?php
if(!isset($_SESSION['loggedin']))
	if(isset($_COOKIE['_ui']) && isset($_COOKIE['_pedh']))
	{
		require_once("connect.php");
		$row = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE user_id = '$_COOKIE[_ui]'"));
		if($_COOKIE['_pedh'] == md5(sha1("$row[password]$row[email]")))
		{
			$_SESSION['loggedin']="yes";
			$_SESSION['user_id']=$row['user_id'];
			$_SESSION['name']=$row['name'];
			$_SESSION['email']=$row['email'];
			$_SESSION['mobile']=$row['mobile'];
			$org = mysql_query("SELECT organisation_id, name FROM organisations WHERE organisation_id IN (SELECT organisation_id FROM user_organisation WHERE user_id='$row[user_id]')");
			$_SESSION['organisation'] = array();
			while ($orga = mysql_fetch_array($org))
				$_SESSION['organisation']["$org[organisation_id]"]=$org['name'];
			mysql_query("UPDATE users SET lastlogin = now() WHERE user_id = '$row[user_id]'");
		}
	}
?>