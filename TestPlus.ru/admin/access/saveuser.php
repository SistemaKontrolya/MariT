<?php
session_start();
include "admin_header.php";
$submit=$_POST['save'];
if(isset($submit))
	SaveUser($_POST['id'], $_POST['name'], $_POST['login'], $_POST['password'], $_POST['email'], $_POST['select_group'], $_POST['adm'], $_POST['usr']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Сохранение Группы</title>
</head>
<body>
</body></html>
