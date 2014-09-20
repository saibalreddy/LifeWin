<?php
require_once("../php/connect.php");
session_start();
include_once("../php/cookielogin.php");
if($_SESSION["loggedin"]=="yes")
	header("Location: index.php");
$err = array();

//PHP Code for SignIn
if(isset($_POST['signin'])) {
	include("../php/formvalidation.php");
	signin();
	global $err;
	if(empty($err)) {
		$email=$_POST['email'];
		$row = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE email = '$email'"));
		if($row['email']) {
				$tryhash = md5($_POST['password']);
				$real = mysql_fetch_array(mysql_query("SELECT password FROM password WHERE id in (SELECT MAX(id) FROM password WHERE user_id='$row[user_id]')"));
				$realhash = $real['password'];
				if ($realhash == $tryhash) {
					include("../php/loginsession.php");
					header("Location: ../index.php");
				}
				else
					$err['login'] = "Username and Password do not match. Forgot password?";
		}
		else
			$err['login'] = "User not found. Are you trying to register?";
	}
}

//PHP Code for SignUp
if(isset($_POST['register'])){
	global $err;
	include_once("../php/formvalidation.php");
	signup();
	if(empty($err)) { //inserting in database
		$pass= md5($_POST[password]);
		//echo "<script>alert('".$_POST[mobile]."');</script>"
		$name= ucwords(strtolower($_POST['name']));
		//nothing to subscribe for now
		//if(isset($_POST['subscribe']))
			//include("templates/subscribe.php");
		$query = "INSERT INTO users (name, email) VALUES ('$name', '$_POST[email]')";
		if(mysql_query($query)) {
			$user_id = mysql_insert_id();
			mysql_query("INSERT INTO password (user_id, password, method) VALUES ('$user_id', '$pass', 'first')");
			mysql_query("INSERT into meta (user_id) VALUES ('$user_id')");
			$_SESSION['loggedin']="yes";
			$_SESSION['user_id']=$user_id;
			$_SESSION['name']=$_POST['name'];
			$_SESSION['email']=$_POST['email'];
			$_SESSION['mobile']=$_POST['mobile'];
			$_SESSION['cookietime'] = time()+(60*24*60*60); //2 month time
			setcookie("_ui", $user_id['user_id'], $_SESSION['cookietime']);
			setcookie("_pedh", md5(sha1($pass.$_POST['email'])), $_SESSION['cookietime']);
			//send email-verification email
			$code = md5($_POST['email'].date("Y-m-d"));
			$link = "lifew.in/emailverification.php?action=emailverification&email=$_POST[email]&code=$code";
			$subject = "Email Verification Link";
			$message = "<div style=\"font-family:verdana;color:#333;background-color:#5f5f5f;font-size:14px\">
			<p style=\"font-size:22px;font-weight:bold;color:F8FFF3;margin:0 0 10px 10px\">Tasks</p>
       			 <div style=\"padding:5px 10px 20px;background-color:#dedede;color:#333\">
            		<p>Hello,</p>
            		<p>&nbsp;&nbsp;We received a user registration request for this email account.</p>
            		<p>You can verify your email address by clicking on this link </p>
            		<p><a style=\"font-family:monospace\" href=".$link." target=\"_blank\"></a>".$link."</p>
           		 <p>If you havent requested for user registration then we appologize for this email. You can ignore this email and that will be just fine. We wont bug you any more.</p>
            		<p style=\"margin-bottom:2px\">Thanks,</p>
            		<p style=\"font-size:15px;margin-top:3px\">Tasks Team</p>
       			</div>
        		<p style=\"color:#f8fff3;font-size:13px;padding:0px 10px\">Please do not reply to this message; it was sent from an unmonitored email address.  This message is a service email related to your use of Tasks.  For general inquiries or to request support with your Tasks account, please mail us at <a style=\"color:#fff\" href=\"mailto:support@Tasks.com\" target=\"_blank\">support@tasks.com</a> or call us at +91 9092024765.</p><div class=\"yj6qo\"></div>
        		</div>";
			$headers  = "From: noreply@borebandar.com\r\n"; 
    			$headers .= "Content-type: text/html\r\n"; 
			mail($_POST['email'],$subject,$message, $headers);
			header("Location: ../index.php?action=profile");
		}
		else
					echo "Unable to register User at the moment. Please try again later.";
	}
}
if(!isset($_POST['register']) || !empty($err)) 
{
//include("../fbaccess.php");
if($user){
	$row = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE email='$user_info[email]'"));
	if($row['email']){
		include("../php/loginsession.php");
		$fbid=$user_profile['id'];
		$pic = file_get_contents("https://graph.facebook.com/$fbid/picture?type=large");
		$path="images/dp/$_SESSION[email].jpg";
		file_put_contents($path, $pic);
		header("Location: ../index.php");
	}
	$_POST['name']=$user_info['name'];
 	$_POST['email']=$user_info['email'];
}

//header.php contains the starting of each page
//include("templates/include/header.php");
?>
<style>
/*Toast Notification */
div.message {
    position: fixed;
    top: 0;
    left: 20px;
    right: 20px;
    padding: 3px;
    background: teal;
    border-radius: 0 0 3px 3px;
    display: none;
}
/*Clickable Text*/
.pointer {
cursor: pointer;
color: #2e92cf;
}
/*Clickable Text when Hovered over*/
.pointer:hover {
color: rgba(45, 173, 237, 0.8);
}

</style>
<script src="../js/formvalidation.js" ></script>
<script src="../js/jquery-2.0.3.min.js" ></script>
<script>
function forgot() {
	$(".message").fadeIn();
	setTimeout(function () {
    	$(".message").fadeOut();
	}, 1000);
	var emailval = document.getElementById("email").value;
	if (!emailval)
		alert("Enter your email-id");
	else if(!jsemail())
		alert("Invalid entry in the field: Email");
	else {
		var xmlhttp;
		if(window.XMLHttpRequest)// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		else	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4  && xmlhttp.status==200)
			alert(xmlhttp.responseText);
		}
		xmlhttp.open("GET","../php/forgot.php?email="+emailval,true);
		xmlhttp.send();
	}
}
</script>
<!--Facebook Login JavaScript SDK-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=834481703238074&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--Facebook Login Javascript SDK ENDED-->



<!-- Toast Notification Message-->
<div class="message">
    Sucess! An email with instructions to reset your password has been sent.
</div>
<!--FB Login Butoon-->
<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>
<!--Form to SignIn-->
<form name="form"  action="<?php echo $PHP_SELF;?>" method="post" onsubmit="return jslogin()" >
<fieldset>
<legend>
Sign In
</legend>
<div>
	<input id="email" type="text" name="email" title="Enter Email" placeholder="Email" value="<?php echo $_POST['email']?>" onchange="jsemail()" pattern="([a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)*)" required autofocus/> 
	<span style="color:#e11" id="err-email"><?php echo $err['email']; ?></span>
</div>
<div>
	<input id="password" type="password" name="password" title="Password - Minimum 5 char" placeholder="Password" value="<?php echo $_POST['password']?>" maxlength="20" pattern="^.{5,20}$"  required/>
</div>
<div style="color:#e11" id="err-login"><?php echo $err['login']; ?></div>
<input type="submit" name="signin" value="Log In"/>
<span class="pointer" id="forgot" onclick="forgot()">Forgot Password?</span>
</fieldset>
</form>

<!--Form to SignUp-->
<form name="form" action="<?php echo $PHP_SELF; ?>" method="post" onsubmit="return jssignup()" style="width: 70%;">
<?php
include("../registerform.php");
?>
<input type="submit" name="register" value="Register" />
</form>
<?php
}
//footer.php to contain the footer portion of all pages
//include "templates/include/footer.php";
?>