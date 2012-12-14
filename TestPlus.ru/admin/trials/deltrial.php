<?php
session_start();
include "admin_header.php";
$id=$_GET['id'];
if(isset($id))
	if(DeleteTrial($id)) $_SESSION['msg']='Удалено';
header("Location: index.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Удаление Теста</title>
</head>
<body>
</body></html>
