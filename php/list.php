<?php
require_once("php/connect.php");
$categories = mysql_query("SELECT * FROM categories");
$arr = array();

while ($row = mysql_fetch_assoc($categories))
{
    $arr[] = $row;
}
echo json_encode($arr);
?>