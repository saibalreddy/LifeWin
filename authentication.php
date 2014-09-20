<?php
session_start();
if(isset($_SESSION['userId']) and $_SERVER["PHP_SELF"] != '/app.php') {
    header('location: app.php');
    die();
}

?>
