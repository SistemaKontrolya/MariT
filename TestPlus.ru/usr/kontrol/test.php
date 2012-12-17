<?
session_start();
include ("../../link.php");
CheckUser('usr');
if(!isset($_GET['id'])){
	header("Location: index.php");
	exit();
	}
$current_date=date("Y-m-d");
$trial_id=$_GET['id'];
$select_trials=mysql_query("SELECT * FROM `trials` WHERE `ID`='$trial_id'");
$trial=mysql_fetch_array($select_trials);
if(!(($trial["Date_start"]<=$current_date)&&($trial["Date_end"]>=$current_date)&&($trial["Passed"]!=1))){
	header("Location: index.php");
	exit();
	}
MakeTesting($trial["Test_id"]);
//помещаем в сессию ид тестирования
$_SESSION['trial_id']=$trial_id;

header("Location: testing.php");

?>