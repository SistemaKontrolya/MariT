<?php
session_start();
include ("../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Администрирование</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
 <style>
  
  </style>
</head>
<body>
<?include "admin_header.php";
//include "menu.html";
?>

<div class="fon">
<ul>
<li><a href="#">Управление пользователями и доступом</a>
	<ul>
		<li><a href="groups">Группы пользователей</a></li>
		<li><a href="access">Управление доступом</a></li>
	</ul>
</li>
<li><a href="#">Редактирование тестовых испытаний</a>
	<ul>
		<li><a href="subjects">Темы тестирования</a></li>
		<li><a href="tests">Редактирование тестов</a></li>
		<li><a href="trials">Назначить тестирование</a></li>
	</ul>
</li>
<li><a href="kontrol">Контроль успеваемости</a></li>
<li><a href="#">Сервис</a>
	<ul>
		<li><a href="service/mail.php">Электронная рассылка</a></li>
		<li><a href="service/addition.php">Дополнительно</a></li>
	</ul>
</li>
</ul>
</div>
<script>
	
</script>
</body>
</html>