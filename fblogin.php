<?php
	session_start();
	  include_once "fbconfig.php";
	   if($_SESSION["loggedin"] && file_exists("images/dp/$_SESSION[email].jpg"))
	  	echo "<img src=\"images/dp/$_SESSION[email].jpg\" width=\"100px\">";
	  
?>
<script type="text/javascript">top.location.href='<?php echo $loginUrl?>';</script>