<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'lifewafb');    // DB username
define('DB_PASSWORD', '1password');    // DB password
define('DB_DATABASE', 'lifewafb_app');      // DB name
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die( "Unable to connect");
$database = mysql_select_db(DB_DATABASE) or die( "Unable to select database");
?>