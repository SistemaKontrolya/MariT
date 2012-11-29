<?php
session_start();
include "admin_header.php";
//$id=$_GET[$id];
$submit=$_POST['save'];
//$id=$_POST['id'];
if(isset($submit))
	SaveGroup($_POST['id'], $_POST['name'], $_POST['superv'], $_POST['dept'], $_POST['commt']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Сохранение Группы</title>
</head>
<body>
</body></html>
