<?php
require_once("php/connect.php");
session_start();
include_once("php/cookielogin.php");
//if(!isset($_SESSION["loggedin"]))
//	header("Location: index.php?action=login");
$err = array();
//include("templates/include/header.php");
if(isset($_POST['updateprofile'])){
	global $err;
	include_once("php/formvalidation.php");
	profileupdate();
	if(empty($err)) { //updating database
		mysql_query("UPDATE users SET description='$_POST[description]', mobile='$_POST[mobile]', availability='$_POST[availability]' WHERE user_id='$_SESSION[user_id]'");
		mysql_query("UPDATE address SET address='$_POST[address]', area='$_POST[area]', pincode= '$_POST[pincode]' WHERE user_id='$_SESSION[user_id]'");
		$_SESSION['mobile']=$_POST['mobile'];
		//uploading pic
		if($_FILES['dp']['tmp_name']!="" && getimagesize($_FILES['dp']['tmp_name'])) {
			$uploaddir = "images/dp/".$_SESSION['email'].".jpg";
			move_uploaded_file($_FILES['dp']['tmp_name'], $uploaddir);
		}
	}
}
if(!isset($_POST['updateprofile']))
{
	$addinfo = mysql_fetch_array(mysql_query("SELECT description, availability FROM users WHERE user_id='$_SESSION[user_id]'"));
	$_SESSION['description']=$addinfo['description'];
	$_SESSION['availability']=$addinfo['availability'];
	$address = mysql_fetch_array(mysql_query("SELECT * FROM address WHERE user_id='$_SESSION[user_id]'"));
	$_SESSION['address'] = $address['address'];
	$_SESSION['area'] = $address['area'];
	$_SESSION['pincode']=$address['pincode'];
}
if(!isset($_POST['updateprofile']) || !empty($err))
{
?>
<script type="text/javascript" src="js/formvalidation.js">
</script>
<form name="form" action="<?php echo $PHP_SELF;?>" enctype="multipart/form-data" method="post" onsubmit="return jsprofile()" style="width: 70%;">
    <ul>
	<li>
		Name: <?php echo $_SESSION['name']; ?>
	</li>
        <li>
		Email: <?php echo $_SESSION['email']; ?>
        </li>
        <li>
        	<label id="label-description" for="description" title="About Me" >About Me:</label>
		<input id="description" type="text" name="description" title="Tell us about yourself" placeholder="About Me" value="<?php echo isset($_POST['description'])? $_POST['description']:$_SESSION['description'] ?>" />
		<span class="error" id="err-description"><?php echo $err['description']; ?></span>
        </li>
        <li>
        	<label id="label-mobile" for="mobile" title="Mobile Number" >Mobile:</label>
		<input id="mobile" type="phone" name="mobile" maxlength="10" title="Enter your 10-digit mobile number" placeholder="Mobile Number" value="<?php echo isset($_POST['mobile'])? $_POST['mobile']:$_SESSION['mobile'] ?>" onchange="jsmobile()" pattern="^[789]\d{9}$" required/>
		<span class="error" id="err-mobile"><?php echo $err['mobile']; ?></span>
        </li>
        <li>
        	<label id="label-availability" for="availability" title="Availability" >Availability(Hours per week):</label>
		<input id="availability" type="number" name="availability" title="Hours per week" placeholder="Hours per week" value="<?php echo isset($_POST['availability'])? $_POST['availability']:$_SESSION['availability'] ?>" onchange="jsavailability()" min="1" max="21" required/>
		<span class="error" id="err-availability"><?php echo $err['availability']; ?></span>
        </li>
        <li>
        	<label id="label-address" for="address" title="Full Address">Address:</label>
			<textarea id="address" name="address" rows="4" resizable required placeholder="Complete Address" value="<?php echo isset($_POST['address'])? $_POST['address']:$_SESSION['address'] ?>"></textarea>
			<small>(Maximum 255 characters)</small>
			<span class="error" id="err-address"><?php echo $err['address']; ?></span>
        </li>
        <li>
        	<label id="label-area" for="area" title="Area" >Area:</label>
		<select name="area" id="Area"><?php include("php/areas.php");?></select>
		<span class="error" id="err-area"><?php echo $err['area']; ?></span>
        </li>
        <li>
        	<label id="label-city" for="city" title="City" >City:</label>
		<input id="city" type="text" name="city" title="City" placeholder="City" value="Bangalore" disabled/>
		<span class="error" id="err-city"><?php echo $err['city']; ?></span>
        </li>
        <li>
        	<label id="label-pincode" for="pincode" title="6 digit Pincode">Pincode:</label>
		<input id="pincode" type="text" name="pincode" title="6 digit Pincode" placeholder="e.g. 620015" value="<?php echo isset($_POST['pincode'])? $_POST['pincode']:$_SESSION['pincode'] ?>" onchange="jspincode()" maxlength="6" pattern="^\d{6}$" required />
		<span class="error" id="err-pincode"><?php echo $err['pincode']; ?></span>
        </li>
	<li>
		<label id="label-dp" for="dp" title="Display Picture" >Photo:</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
		<input id="dp" type="file" name="dp" accept="image/*"/>
		<span class="error" id="err-dp"><?php echo $err['dp']; ?></span>
	</li>
    </ul>
		<input type="submit" name="submit" value="Submit" />
</form>
<?php
}
?>
<?php include "templates/include/footer.php" ?>