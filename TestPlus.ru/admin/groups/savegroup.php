<?php
session_start();
include ("../../link.php");
$submit=$_POST;
if($submit)
	SaveGroup($_POST['id'], $_POST['name'], $_POST['superv'], $_POST['dept'], $_POST['commt']);
header("Location: index.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Сохранение Группы</title>
</head>
<body>
Если вы видите эту страницу, что-то пошло не так...
</body></html>
