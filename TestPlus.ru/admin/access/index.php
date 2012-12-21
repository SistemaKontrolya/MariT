<?php
session_start();
include ("../../link.php");
include ("../admin_header.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Управление доступом</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<?include ("../cap.php");?>
<div>
<?php
ShowUsers();
if(isset($_GET['show'])) EditUsers($_GET['id'],1);
if(isset($_GET['edit'])) EditUsers($_GET['id'],0);
if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	$_SESSION['msg']=NULL;}
?>
</div>
</body>
</html>