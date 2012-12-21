<?php
session_start();
include ("../../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Управление доступом</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<?include ("../admin_header.php");?>
<div>
<?php
ShowSubjects();
?>
</div>
</body>
</html>