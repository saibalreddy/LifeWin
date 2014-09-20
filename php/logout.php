<?php
session_start();
setcookie("_ui", "", $_SESSION['cookietime']);
setcookie("_pedh", "", $_SESSION['cookietime']);
session_destroy();
unset($_SESSION);
header("Location: index.php");
?>