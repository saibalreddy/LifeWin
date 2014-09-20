<?php
require_once("php/connect.php");
session_start();
include("php/cookielogin.php");
if($_SESSION["loggedin"]!="yes")
	header("Location: index.php");
//include("templates/include/header.php");
if(isset($_POST['change'])){
	if($_POST['password'] == $_POST['repassword']) {
		$lastpass = mysql_fetch_array(mysql_query("SELECT password FROM password WHERE id in (SELECT MAX(id) FROM password WHERE user_id = $_SESSION[user_id])"));
		$pass = md5($_POST[password]);
		if($lastpass[password] == md5($_POST[oldpassword])){
			if(mysql_query("INSERT INTO password (user_id, password, method) VALUES ('$_SESSION[user_id]', '$pass', 'change')")){
				$succ = "Password changed successfully!!! You can now login with your new password.";
				echo $succ;
			}
			else 
				$err = "Failed to reset your password. Try again after some time.";
		}
		else
			$err = "Incorrect Password";
	}
	else
		$err = "Passwords Don't match!!!";
}
if(!isset($succ)) {
?>
<script src="js/formvalidation.js"></script>
<form name="form"  action="<?php echo $PHP_SELF; ?>" method="post">
<fieldset>
<legend>
Change Password
</legend>
<div>
	<label id="label-oldpassword" for="oldpassword" title="Enter Old Password" >Old Password:</label>
	<input id="oldpassword" type="password" name="oldpassword" title="Enter Old Password" value="<?php echo $_POST['oldpassword']?>" onchange="jspassword()" maxlength="20" pattern="^.{5,20}$" required />
</div>
<div>
	<label id="label-password" for="password" title="Enter new Password" >New Password:</label>
	<input id="password" type="password" name="password" title="Enter new Password" value="<?php echo $_POST['password']?>" onchange="jspassword()" maxlength="20" pattern="^.{5,20}$" required />
</div>
<div>
	<label id="label-repassword" for="repassword" title="Retype Password" >Retype Password:</label>
	<input id="repassword" type="password" name="repassword" title="Retype Password" value="<?php echo $_POST['repassword']?>" onchange="jsrepassword()" maxlength="20" pattern="^.{5,20}$" required />
	<span class="error" id="err-repassword"><?php echo $err; ?></span>
</div>
<input type="submit" name="change" value="Change"/>
</fieldset>
</form>
<?php
}
?>