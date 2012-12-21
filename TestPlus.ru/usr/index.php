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

</head>
<body>
<header>ТЕСТИРОВАНИЕ +</header>
<div class="greeting">
<?php Greeting($usr_name)?>
<form name="lout" method="GET" action="../Auth.php"><button name="logout" type="submit">Выйти</button></form>
</div>
<div>
<ul class="nav">
<li><a href="personal_data">Персональные данные </a></li>
<li><a href="kontrol">Контроль успеваемости </a></li>
</ul>
</div>
</body>
</html>