<?php
session_start();
include "admin_header.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Администрирование</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<header><div class="shapka">ТЕСТИРОВАНИЕ +</div>
<div class="greeting">
<?php Greeting($usr_name)?>

<form name="logout" method="GET" action="../Auth.php">
<button type="submit" name="logout">Выйти</button>
</form>
</div>
</header>
<div class="fon">
<ul class="spisok">
<li><a href="javascript://" onMouseDown="spoiler('access')">Управление пользователями и доступом</a>
	<ul id="access">
		<li><a href="groups">Группы пользователей</a></li>
		<li><a href="access">Управление доступом</a></li>
	</ul>
</li>
<li><a href="#" onClick="spoiler('tests')">Редактирование тестовых испытаний</a>
	<ul id="tests">
		<li><a href="subjects">Темы тестирования</a></li>
		<li><a href="tests">Редактирование тестов</a></li>
		<li><a href="trials">Назначить тестирование</a></li>
	</ul>
</li>
<li><a href="kontrol">Контроль успеваемости</a></li>
<li><a href="#" onClick="spoiler('service')">Сервис</a>
	<ul id="service">
		<li><a href="service/mail.php">Электронная рассылка</a></li>
		<li><a href="service/addition.php">Дополнительно</a></li>
	</ul>
</li>
</ul>
</div>
<script>
	function spoiler(id){
var obj = "";
 //Проверить совместимость браузера
if(document.getElementById)
obj = document.getElementById(id).style;
else if(document.all)
obj = document.all[id];
else if(document.layers)
obj = document.layers[id];
else
return 1;
// Пошла магия
if(obj.display == "none"){
	obj.display = "block";
	obj.li.display = "block";}
else
	obj.display = "none";
	
}
</script>
</body>
</html>