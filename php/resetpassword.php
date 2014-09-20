<?php
require_once("php/connect.php");
session_start();
include("php/cookielogin.php");
if($_SESSION["loggedin"]=="yes")
	header("Location: index.php");
//header.php to contain the top part of every page
//include("templates/include/header.php");
if(isset($_POST['reset'])){
	if($_POST['password'] == $_POST['repassword']) {
		$pass = md5($_POST[password]);
		if(mysql_query("INSERT INTO password (user_id, password, method) VALUES ('$_GET[uid]', '$pass', 'reset')")){
			$succ = "Password reset Successfully!!! You can now login with your new password.";
			echo $succ;
		}
		else 
			$err = "Failed to reset your password. Try again after some time.";
	}
	else
		$err = "Passwords Don't match!!!";
}
if(!isset($succ)) {
if(!isset($_GET['uid']) || !isset($_GET['code']))
	echo "Link is invalid.";
else
{
	$row = mysql_fetch_array(mysql_query("SELECT email FROM users WHERE user_id = '$_GET[uid]'"));
	$real_code=md5($row['email'].date("Y-m-d"));
	if(!$row['email'])
		echo "Invalid Request. Check the link.";
	else if ($_GET['code'] == $real_code){
?>
<script src="js/formvalidation.js"></script>
<form name="form"  action="<?php echo $PHP_SELF; ?>" method="post">
<fieldset>
<legend>
Reset Password
</legend>
<div>
	<label id="label-password" for="password" title="Enter new Password" >New Password:</label>
	<input id="password" type="password" name="password" title="Enter new Password" value="<?php echo $_POST['password']?>" maxlength="20" pattern="^.{5,20}$" required />
</div>
<div>
	<label id="label-repassword" for="repassword" title="Retype Password" >Retype Password:</label>
	<input id="repassword" type="password" name="repassword" title="Retype Password" value="<?php echo $_POST['repassword']?>" maxlength="20" pattern="^.{5,20}$" required />
	<span class="error" id="err-repassword"><?php echo $err; ?></span>
</div>
<input type="submit" name="reset" value="Reset"/>
</fieldset>
</form>
<?php
	}
	else
		echo "Your Password reset link seems to be invalid/expired. Request a new one!<br/>$_GET[code]<br/>$real_code";
}
}
?>