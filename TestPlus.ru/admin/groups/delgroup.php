<?php
session_start();
include ("../../link.php");
$id=$_GET['id'];
if(isset($id))
	DeleteGroup($id);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Удаление Группы</title>
</head>
<body>
</body></html>
