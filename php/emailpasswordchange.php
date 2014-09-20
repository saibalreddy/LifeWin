<?php
include("php/connect.php");
include("php/formvalidation.php");
$action = $_GET['action'];
$uid = $_GET['uid'];
$code = $_GET['code'];
if(isset($_POST['password'])){
	global $err;
	include_once("php/formvalidation.php");
	password();
	if(empty($err)){ //inserting into database
		$pass= md5($_POST[password]);
		$query = "INSERT INTO password (user_id, password, method) VALUES ('$uid', '$pass', '$method')";
		if(mysql_query($query)){
		$_SESSION['loggedin']="yes";
			$_SESSION['user_id']=$user_id;
			$_SESSION['name']=$_POST['name'];
			$_SESSION['email']=$_POST['email'];
			$_SESSION['mobile']=$_POST['mobile'];
			$_SESSION['cookietime'] = time()+(60*24*60*60); //2 month time
			setcookie("_ui", $user_id['user_id'], $_SESSION['cookietime']);
			setcookie("_pedh", md5(sha1($pass.$_POST['email'])), $_SESSION['cookietime']);
			header("Location: index.php?action=profile");
		}
		else
			echo "Unable to change password now, Please try again later.";
	}
}
if (!isset($_POST['password']) || !empty($err)){ 
$row = mysql_fetch_array(mysql_query("SELECT user_id, email FROM users WHERE user_id = '$uid'"));
if($row['email']) {
	$password = mysql_fetch_array(mysql_query("SELECT password from password WHERE user_id = '$row[user_id]'"));
	$realcode = md5($password['password'].$row['email'].date("Y-m-d"));
	if($code == $realcode){
	?>
	<form name="form" action="<?php echo $PHP_SELF; ?>" method="post" style="width: 70%;">
	<ul>
		<li>
			<input id="password" type="password" name="password" title="Minimum 5 char long" placeholder="Password" value="<?php echo $_POST['password']?>" onchange="jspassword()" maxlength="20" pattern="^.{5,20}$" required />
			<span class="error" id="err-password"><?php echo $err['password']; ?></span>
		</li>
	</ul>
	<input type="submit" name="register" value="Register" />
	</form>
	<?php
	
	}
}
}
?>