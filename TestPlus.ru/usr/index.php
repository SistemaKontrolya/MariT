<?php
session_start();
include("../link.php");
CheckUser("usr");
$name=$_SESSION['login'];
if(isset($_SESSION['login']))
	$usr_name=CheckName($name);
else 
	SessionOff();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Пользовательский раздел</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<header>ТЕСТИРОВАНИЕ +</header>
<div class="greeting">
<?php Greeting($usr_name)?>
<form name="lout" method="GET" action="../Auth.php"><button name="logout" type="submit">Выйти</button></form>
</div>
<ul class="topmenu"><li>Главная</li></ul>
<div>
<ul class="nav">
<li><a href="personal_data">Персональные данные </a></li>
<li><a href="kontrol">Контроль успеваемости </a></li>
<li><a href="mail">Связь с администратором</a></li>
</ul>
</div>
</body>
</html>