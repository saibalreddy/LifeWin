<?php
$_SESSION['loggedin']="yes";
$_SESSION['user_id']=$row['user_id'];
$_SESSION['name']=$row['name'];
$_SESSION['email']=$row['email'];
$_SESSION['mobile']=$row['mobile'];
$_SESSION['cookietime'] = time()+(60*24*60*60); //2 month time
/*No organizations field present in our project
$org = mysql_query("SELECT organisation_id, name FROM organisations WHERE organisation_id IN (SELECT organisation_id FROM user_organisation WHERE user_id='$row[user_id]')");
$_SESSION['organisation'] = array();
while ($orga = mysql_fetch_array($org))
	$_SESSION['organisation']["$org[organisation_id]"]=$org['name'];
*/
setcookie("_ui", $row['user_id'], $_SESSION['cookietime']);
setcookie("_pedh", md5(sha1($realhash.$row['email'])), $_SESSION['cookietime']);
//not able to execute this state, may be need permissions for update command
//mysql_query("UPDATE users SET loggedin = loggedin+1, lastlogin = now() WHERE user_id = '$row[user_id]'");
?>