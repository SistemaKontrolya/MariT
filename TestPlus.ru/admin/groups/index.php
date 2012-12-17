<?php
session_start();
include ("../../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Группы</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<?include ("../admin_header.php");?>
<? ShowGroups();
$edit=$_GET['edit'];
$showmembers=$_GET['showmembers'];
$id=$_GET['id'];
$new=$_GET['new'];
if(isset($showmembers))
	ShowMembers($id);
if(isset($edit))
	EditGroups($id);
if(isset($new)){
	$id=NULL;
	EditGroups($id);
}
if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	$_SESSION['msg']=NULL;}
?>
</body>
</html>