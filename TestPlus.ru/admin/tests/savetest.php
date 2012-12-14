<?php
session_start();
include "admin_header.php";
$submit=$_POST['save'];
if(isset($submit))
	SaveTest($_POST['id'], $_POST['name'], $_POST['select_subject'], $_POST['quest_amount'], $_POST['ans_amount'], $_POST['commt']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Сохранение Теста</title>
</head>
<body>
</body></html>