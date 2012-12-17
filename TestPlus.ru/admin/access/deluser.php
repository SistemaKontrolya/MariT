<?php
session_start();
include ("../../link.php");
$id=$_GET['id'];
if(isset($id))
	DeleteUser($id);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Удаление Пользователя</title>
</head>
<body>
</body></html>
