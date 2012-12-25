<?php
session_start();
include ("../../link.php");
include ("../admin_header.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Темы тестирования</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<?include ("../cap.php");?>
<div class="service">
<?if(isset($_SESSION['msg']))
	echo $_SESSION['msg'];
 $_SESSION['msg']='';
?>
</div>
<div>
<?php
ShowSubjects();
?>
</div>
</body>
</html>