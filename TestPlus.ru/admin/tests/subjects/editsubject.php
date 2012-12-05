<?php
session_start();
include "admin_header.php";
//$id=$_GET[$id];
$submit=$_POST['save'];
//$id=$_POST['id'];
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
