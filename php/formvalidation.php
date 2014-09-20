<?php
//name
function name() {
	global $err;
	$x = $_POST["name"];
	$regex="/^[A-Za-z][A-Za-z\-\_. ]+$/";
	if(!preg_match($regex, $x)) {
		$err["name"]= "Invalid Value";
		return false;
	}
	return true;
}

//Orgname
function orgname() {
	global $err;
	$x = $_POST["orgname"];
	$regex="/^[A-Za-z0-9][A-Za-z0-9\-\_. ]+$/";
	if(!preg_match($regex, $x)) {
		$err["orgname"]= "Invalid Value";
		return false;
	}
	else
		return true;
}

//contact name
function contactname() {
global $err;
	$x = $_POST['contactname-1'];
	$regex = "/^[A-Za-z][A-Za-z\-\_. ]+$/";
	if(!preg_match($regex, $x)) {
		$err["contactname"]= "Invalid Contact Name";
		return false;
	}
	else
		return true;
}

//website
function website() {
	global $err;
	$x = $_POST["website"];
	$regex = "/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[A-Za-z0-9]+([\-\.]{1}[A-Za-z0-9]+)*\.[A-Za-z]{2,5}(:[0-9]{1,5})?(\/.*)?/";
	if(!preg_match($regex, $x)) {
		$err["website"]= "Invalid URL";
		return false;
	}
	else
		return true;
}
//url
function url() {
	global $err;
	$x = $_POST["url"];
	$regex = "/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[A-Za-z0-9]+([\-\.]{1}[A-Za-z0-9]+)*\.[A-Za-z]{2,5}(:[0-9]{1,5})?(\/.*)?/";
	if(!preg_match($regex, $x)) {
		$err["url"]= "Invalid URL";
		return false;
	}
	else
		return true;
}
//email 
function email() {
	global $err;
	$x=$_POST['email'];
	if(!filter_var($x, FILTER_VALIDATE_EMAIL)) {
		$err['email'] = "Enter a valid E-mail address.";
		return false;
	}
	return true;
}
//duplicate email
function duplicate() {
	global $err;
	$check = mysql_fetch_array(mysql_query("SELECT email FROM users WHERE email = '$_POST[email]'"));
	if($check['email']) {
		$err['email']="Email already registered";
		return false;
	}
	return true;
}
//contactemail
function contactemail() {
	global $err;
	$x=$_POST['contactemail-1'];
	if(!filter_var($x, FILTER_VALIDATE_EMAIL)) {
		$err['contactemail'] = "Enter a valid E-mail address.";
		return false;
	}
	return true;
}

//password
function password() {
	global $err;
	$regex="/^.{5,20}$/";
	$x=$_POST['password'];
	if (!preg_match($regex,$x)) {
		$err['password']= "Password should be 5-20 characters long.";
		return false;
	}
	return true;
}
//Mobile No
function mobile() {
	global $err;
	$x=$_POST['mobile'];
	$regex = "/^[789]\d{9}$/";
	if(!preg_match($regex,$x)) {
		$err['mobile']= "Enter a valid 10-digit mobile number.";
		return false;
	}
	return true;
}

//contact mobile
function contactmobile() {
	global $err;
	$x=$_POST['contactmobile-1'];
	$regex = "/^[789]\d{9}$/";
	if(!preg_match($regex,$x)) {
		$err['contactmobile']= "Enter a valid 10-digit mobile number.";
		return false;
	}
	return true;
}

//pincode
function pincode() {
	global $err;
	$x=$_POST['pincode'];
	$regex = "/^\d{6}$/";
	if(!preg_match($regex,$x)) {
		$err['pincode']= "Pincode entered is invalid.";
		return false;
	}
	return true;
}
//sector name
function sector() {
	global $err;
	$x = $_POST['sector'];
	if($x == null || $x == "") {
		$err['sector']= "Invalid Sector name";
		return false;
	}
	else
		return true;
}

//title name
function title() {
	global $err;
	$x = $_POST['title'];
	if($x == null || $x == "") {
		$err['title']= "Invalid Title";
		return false;
	}
	else
		return true;
}
//venue
function venue() {
	global $err;
	$x = $_POST['venue'];
	if($x == null || $x == "") {
		$err['venue']= "Invalid Venue";
		return false;
	}
	else
		return true;
}
//area
function area() {
	global $err;
	$x = $_POST['area'];
	if ($x == 0)
	{
		$err['area']= "Select an Area";
		return false;
	}
	else 
	   return true;
	
}
function fromdate() {
	global $err;
	$from = $_POST['from'];
	$regex = "/^(0?[1-9]|[12][0-9]|3[01])[\-](0?[1-9]|1[012])[\-](20\d{2})$/";
	if(!preg_match($regex,$from)) {
		$err['from']= "Date invalid. Use dd-mm-yyyy format.";
		return false;
	}
	$today = date("Y-m-d");  
	$pieces = explode("-", $from);
	$day = $pieces[0];
	$month = $pieces[1];
	$year = $pieces[2];
	$fromdate = "$year-$month-$day";
	if( $fromdate < $today)
	{
		$err['from'] ="Enter a valid Date and not a past date";
  		return false;
  	}
  	else
  	   return true;
}

function todate() {
	global $err;
	$from = $_POST['from'];
	$to = $_POST['to'];  
	$regex = "/^(0?[1-9]|[12][0-9]|3[01])[\-](0?[1-9]|1[012])[\-](20\d{2})$/";
	if(!preg_match($regex,$to) && $to) {
		$err['to']= "Date invalid. Use dd-mm-yyyy format.";
		return false;
	}
	else
	{
		$pieces = explode("-", $from);
		$day = $pieces[0];
		$month = $pieces[1];
		$year = $pieces[2];
		$fromdate = "$year-$month-$day";
	
		$pieces = explode("-", $to);
		$today = $pieces[0];
		$tomonth = $pieces[1];
		$toyear = $pieces[2];
		$todate = "$toyear-$tomonth-$today";

		if( $todate < $fromdate)
		{
			//$err['to'] = "$todate-$fromdate";
			$err['to'] ="To Date should be greater than From date";
  			return false;
  		}
  		else
  		  return true;
  	}
}




//category
function category() {
	$x = $_POST['Area'];
	if ($x == "others")
	{
		$y = $_POST['category-other'];
		if ($y==null || $x=="")
  		{
  			$err['Category must be filled out'];
  			return false;
  		}
  		else
  		  return true;
  		
  	}
}

//

//required field
function required($fieldname) {
	global $err;
	$x=$_POST[$fieldname];
	if(!$x){
		$err["$fieldname"]= "Enter value for field: ".$fieldname;
		return false;
	}
	return true;
}

function signup() {
	global $err;
	name();
	email();
	duplicate();
	password();
	//mobile();
}

function profileupdate() {
	global $err;
	mobile();
	pincode();
}

function signin() {
	email();
	password();
}

function addeventcheck() {
global $err;
	if (!isset($_SESSION['loggedin']))
	{
		signup();
	}
	orgname();
	contactname();
	website();
	url();
	contactemail();
	contactmobile();
	//sector();
	title();
	venue();
	area();
	fromdate();
	todate();
	category();
}
?>
