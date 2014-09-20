<?php
require_once("php/connect.php");
session_start();
include_once("php/cookielogin.php");

$user_id = $_SESSION['user_id'];

//Get values by POST method
/* $meta = $_POST["meta"];
$DailyDetails = $_POST["DailyDetails"];
$DailyNames = $_POST["DailyNames"];
$GoalsDetails = $_POST["GoalsDetails"];
$GoalsNames = $_POST["GoalsNames"];
$TasksDetails = $_POST["TasksDetails"];
$TasksNames = $_POST["TasksNames"];
$WinstateDetails = $_POST["WinstateDetails"];
$WinstateNames = $_POST["WinstateNames"];
$scoreboard = $_POST["scoreboard"]; */
$log = $_POST["log"];

//Revoing all the \ symbols that are added while transmision.
/*$meta = str_replace("\\","",$meta);
$DailyDetails = str_replace("\\","",$DailyDetails);
$DailyNames = str_replace("\\","",$DailyNames);
$GoalsDetails = str_replace("\\","",$GoalsDetails);
$GoalsNames = str_replace("\\","",$GoalsNames);
$TasksDetails = str_replace("\\","",$TasksDetails);
$TasksNames = str_replace("\\","",$TasksNames);
$WinstateDetails = str_replace("\\","",$WinstateDetails);
$WinstateNames = str_replace("\\","",$WinstateNames);
$scoreboard = str_replace("\\","",$scoreboard); */

//Converting Strings to objects
/*$meta = json_decode($meta);
$DailyDetails = json_decode($DailyDetails);
$DailyNames = json_decode($DailyNames);
$GoalsDetails = json_decode($GoalsDetails);
$GoalsNames = json_decode($GoalsNames);
$TasksDetails = json_decode($TasksDetails);
$TasksNames = json_decode($TasksNames);
$WinstateDetails = json_decode($WinstateDetails);
$WinstateNames  = json_decode($WinstateNames);
$scoreboard = json_decode($scoreboard);*/
$log = json_decode($log);

$meta_query = "UPDATE meta set date='$meta->date', present='$meta->present', future='$meta->future', today='$meta->today', tomorrow='$meta->tomorrow', thisweek='$meta->thisweek', later='$meta->later', habits='$meta->habits', frequent='$meta->frequent', timer='$meta->timer', last_timer='$meta->last_timer', daily='$meta->daily', weekly='$meta->weekly' where user_id = '$_SESSION[user_id]'";
mysql_query($meta_query);

foreach ($log as $entry){
	if($entry->key == "date"){
		$meta_date_query = "UPDATE meta SET date='$entry->today', daily='$entry->daily', weekly='$entry->weekly' WHERE user_id = '$user_id'";
		mysql_query($meta_date_query);
		$select_query = "SELECT * from scoreboard WHERE user_id='$user_id' and date='$entry->lastdate'";
		$result = mysql_query($select_query);
		$row = mysql_fetch_row($result);
		if($row[0] == 0)
			$scoreboard_query="INSERT INTO scoreboard (user_id,date,points) VALUES ('$user_id','$entry->lastdate','$entry->scoreboard_date_points')";
		else
			$scoreboard_query = "UPDATE scoreboard SET points='$entry->scoreboard_date_points' WHERE date='$entry->lastdate' and user_id='$user_id'";
		mysql_query($scoreboard_query);
	}
	else if($entry->key == "duedate"){
		$duedate_query = "UPDATE entryDetails set duedate='$entry->duedate', tag='$entry->tag' WHERE user_id='$user_id' and list='$entry->list' and pos='$entry->pos'";
		mysql_query($duedate_query);
	}
	else if($entry->key == "addpoints"){
		$select_query = "SELECT daily, weekly FROM meta WHERE user_id='$user_id'";
		$result = mysql_query($select_query);
		$row = mysql_fetch_row($result);
		$row[0] = intval($row[0])+intval($entry->points);
		$row[1] = intval($row[1])+intval($entry->points);
		if($row[0]<10) $row[0] = '0'+$row[0];
		if($row[1]<10) $row[1] = '0'+$row[1];
		$points_date_points_query = "UPDATE meta SET daily='$row[0]', weekly='$row[1]' where user_id='$user_id' and date='$entry->date'";
		mysql_query($points_date_points_query);
	}
	else if($entry->key == "tag"){
		$tag_query = "UPDATE entryDetails SET tag='$entry->tag' WHERE user_id='$user_id' and list='$entry->list' and pos='$entry->pos'";
		mysql_query($tag_query);
	}
	else if($entry->key == "addday"){
		$count_query = "UPDATE entryDetails SET count='$entry->count' where user_id='$user_id' and list='$entry->list' and pos='$entry->pos' and active=1";
		mysql_query($count_query);
		$select_query = "SELECT * from entryDates WHERE user_id='$user_id' and list='$entry->list' and pos='$entry->pos' and monthyearkey='$entry->monthyearkey' and day='$entry->day'";
		$result = mysql_query($select_query);
		$row = mysql_fetch_row($result);
		if($row[0] == 0)
			$addday_query="INSERT INTO entryDates (user_id, list, pos, monthyearkey, day) VALUES ('$user_id','$entry->list','$entry->pos','$entry->monthyearkey','$entry->day')";
		else
			$addday_query = "UPDATE entryDates SET active=IF(active=1, 0, 1) WHERE user_id='$user_id' and list='$entry->list' and monthyearkey='$entry->monthyearkey' and day='$entry->day'";
		mysql_query($addday_query);
	}
	else if($entry->key == "points"){
		$points_query = "UPDATE entryDetails set points='$entry->points' where user_id='$user_id' and list='$entry->list' and pos='$entry->pos'";
		mysql_query($points_query);
	}
	else if($entry->key == "pos"){
		//first the moved item's pos is set to a special number -2
		$pos_query = "UPDATE entryDetails SET pos=-2 where user_id='$user_id' and list='$entry->list' and active=1 and pos='$entry->initialPos'";
		mysql_query($pos_query);
		//Decrement or increment pos of inbetween entries depending upon the relative position of the initialPos and finalPos
		if($entry->initialPos<$entry->finalPos)
			$pos_query = "UPDATE entryDetails SET pos=pos-1 where user_id='$user_id' and list='$entry->list' and active=1 and pos>'$entry->initialPos' and pos<='$entry->finalPos'";
		else
			$pos_query = "UPDATE entryDetails SET pos=pos+1 where user_id='$user_id' and list='$entry->list' and active=1 and pos>='$entry->finalPos' and pos<'$entry->initialPos'";
		mysql_query($pos_query);
		//reset the pos of the moved item from -2 to finalPos
		$pos_query = "UPDATE entryDetails SET pos='$entry->finalPos' where user_id='$user_id' and list='$entry->list' and pos=-2 and active=1";
		mysql_query($pos_query);
		$tag_query = "UPDATE entryDetails set tag='$entry->finalTag' where user_id='$user_id' and list='$entry->list' and pos='$entry->finalPos'";
		mysql_query($tag_query);
		$finalTag_query = "UPDATE meta set ".$entry->finalTag."=".$entry->finalTag."+1 where user_id='$user_id'";
		mysql_query($finalTag_query);
		$initialTag_query = "UPDATE meta set ".$entry->initialTag."=".$entry->initialTag."-1 where user_id='$user_id'";
		mysql_query($initialTag_query);
	}
	else if($entry->key == "add"){
		$pos_query = "UPDATE entryDetails SET pos=pos+1 where user_id='$user_id' and list='$entry->list' and pos>=0 and active=1";
		mysql_query($pos_query);
		$add_query = "INSERT into entryDetails (user_id, list, entry_name, duedate, tag, pos) VALUES ('$user_id','$entry->list','$entry->name', '$entry->duedate', '$entry->tag', 0)";
		mysql_query($add_query);
		$tag_query = "UPDATE meta SET ".$entry->tag."=".$entry->tag."+1 where user_id='$user_id'";
		mysql_query($tag_query);
	}
	else if($entry->key == "edit"){
		$edit_query = "UPDATE entryDetails SET entry_name='$entry->newName' where user_id='$user_id' and list='$entry->list' and pos='$entry->pos' and entry_name='$entry->oldName'";
		mysql_query($edit_query);
	}
	else if($entry->key == "del"){
		$tagcount_query = "UPDATE meta SET ".$entry->tag."=".$entry->tag."-1 where user_id='$user_id'";
		mysql_query($tagcount_query);
		$del_query = "UPDATE entryDetails SET pos=-1, active=0 WHERE user_id='$user_id' and list='$entry->list' and pos='$entry->pos'";
		mysql_query($del_query);
		$pos_query = "UPDATE entryDetails SET pos=pos-1 WHERE user_id='$user_id' and list='$entry->list' and pos >= '$entry->pos'";
		mysql_query($pos_query);
	}
	else if($entry->key == "timer"){
		$entry->timer = intval($entry->timer);
		$entry->lastTimer = intval($entry->lastTimer);
		$timer_query = "UPDATE meta SET timer='$entry->timer', lastTimer='$entry->lastTimer' WHERE user_id='$user_id'";
		mysql_query($timer_query);
	}
}

$meta_query = json_encode(mysql_fetch_assoc(mysql_query("SELECT * from meta WHERE user_id='$user_id'")));

$rows = array();
$scoreboard_query = mysql_query("SELECT * from scoreboard WHERE user_id='$user_id'");
if($scoreboard_query){
	while($row = mysql_fetch_assoc($scoreboard_query)){
		array_push($rows,$row);
	}
}
$scoreboard_query = json_encode($rows);

$rows = array();
$GoalsDetails_query = mysql_query("SELECT * from entryDetails WHERE user_id='$user_id' and list='Goals' and active=1");
if($GoalsDetails_query){
	while($row = mysql_fetch_assoc($GoalsDetails_query)){
		array_push($rows,$row);
	}
}
$GoalsDetails_query = json_encode($rows);

$rows = array();
$TasksDetails_query = mysql_query("SELECT * from entryDetails WHERE user_id='$user_id' and list='Tasks' and active=1");
if($TasksDetails_query){
	while($row = mysql_fetch_assoc($TasksDetails_query)){
		array_push($rows,$row);
	}
}
$TasksDetails_query = json_encode($rows);

echo '{"meta":'.$meta_query.',"scoreboard":'.$scoreboard_query.', "GoalsDetails":'.$GoalsDetails_query.',"TasksDetails":'.$TasksDetails_query.'}';
?>