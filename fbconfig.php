<?php
require 'src/facebook.php';  // Include facebook SDK file
require 'functions.php';  // Include functions
$facebook = new Facebook(array(
  'appId'  => '834481703238074',   // Facebook App ID 
  'secret' => '347633e603fd132fd38abaca14034e01',  // Facebook App Secret
  'cookie' => true,	
));

// $app_id   = "834481703238074";
// $app_secret = "347633e603fd132fd38abaca14034e01";
$loginUrl = "http://www.lifewin.co/app.php";

$user = $facebook->getUser();

if ($user) {

  try {
    $user_profile = $facebook->api('/me');
  	  $fbid = $user_profile['id'];                 // To Get Facebook ID
 	    $fbuname = $user_profile['username'];  // To Get Facebook Username
      if(empty($fbuname))
 	    $fbuname = $user_profile['name']; // To Get Facebook full name
	    $femail = $user_profile['email'];    // To Get Facebook email ID
      checkuser($fbid,$fbuname,$femail,'fb');    // To update local DB
      $_SESSION['userId'] = $fbuname;
  } catch (FacebookApiException $e) {
    error_log($e);
   $user = null;
  }
}

if ($user) {
  $logoutUrl = $facebook->getLogoutUrl(array(
		 'next' => 'http://lifewin.co/logout.php',  // Logout URL full path
		));
} else {
 $loginUrl = $facebook->getLoginUrl(array(
    'req_perms' => 'publish_stream',
    'next' => 'http://'.$_SERVER['SERVER_NAME'].'/app.php',
    'cancel_url' => 'http://'.$_SERVER['SERVER_NAME'].'/index.php'
));
header('Location: ' . $loginUrl);
}
?>
