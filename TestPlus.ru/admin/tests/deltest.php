<?php
session_start();
include "admin_header.php";
$id=$_GET['id'];
if(isset($id))
	DeleteTest($id);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Удаление Теста</title>
</head>
<body>
</body></html>
