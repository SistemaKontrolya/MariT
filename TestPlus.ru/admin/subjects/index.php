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
<div>
<?php
ShowSubjects();
?>
</div>
</body>
</html>