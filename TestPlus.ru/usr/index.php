<?php
session_start();
//if(!isset($_SESSION['usr']))
//	header("Location: http://testplus.ru/index.html");
include("../db_fns.php");
include("../funcs.php");
CheckUser("usr");
$db=db_connect();
if(!$db)
 echo "error db connect <br>";

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
<li><a href="#">Персональные данные </a></li>
<li><a href="#">Контроль успеваемости </a></li>
</ul>
</div>
</body>
</html>