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
<div>
<?
if(isset($_SESSION['msg']))
		echo '<div class="service">'.$_SESSION['msg'].'</div>';
	$_SESSION['msg']='';
ShowGroups();
$edit=$_GET['edit'];
$showmembers=$_GET['showmembers'];
$id=$_GET['id'];
$new=$_GET['new'];
if(isset($showmembers))
	ShowMembers($id);
if(isset($edit)){
	EditGroups($id);
	}
if(isset($new)){
	$id=NULL;
	EditGroups($id);
}
?>
</div>
</body>
</html>