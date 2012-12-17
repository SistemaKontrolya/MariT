<?php
session_start();
include ("../../link.php");
$submit=$_POST['save'];
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
