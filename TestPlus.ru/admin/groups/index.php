<?php
session_start();
include "admin_header.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Группы</title>
</head>
<body>
<header>ТЕСТИРОВАНИЕ +
<div><a href="/admin">На главную</a></div>
<div class="greeting">
<?php Greeting($usr_name)?>

<form name="logout" method="GET" action="../../Auth.php">
<button type="submit" name="logout">Выйти</button>
</form>
</div>
</header>
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