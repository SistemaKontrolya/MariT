<?php
session_start();
include ("../../link.php");
$submit=$_POST['save'];
if(isset($submit))
	SaveSubject($_POST['id'], $_POST['name']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Сохранение Темы</title>
</head>
<body>
</body></html>
