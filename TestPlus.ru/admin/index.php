<?php
session_start();
include "admin_header.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Администрирование</title>

</head>
<body>
<header>ТЕСТИРОВАНИЕ +
<div class="greeting">
<?php Greeting($usr_name)?>

<form name="logout" method="GET" action="../Auth.php">
<button type="submit" name="logout">Выйти</button>
</form>
</div>
</header>
<div>
<ul class="nav">
<li><a href="#">Управление пользователями и доступом</a>
	<ul>
		<li><a href="groups">Группы пользователей</a></li>
		<li><a href="access">Управление доступом</a></li>
	</ul>
</li>
<li><a href="#">Редактирование тестовых испытаний</a>
	<ul>
		<li><a href="tests/subjects">Темы тестирования</a></li>
		<li><a href="#">Редактирование тестов</a></li>
		<li><a href="#">Назначить тестирование</a></li>
	</ul>
</li>
<li><a href="#">Контроль успеваемости</a></li>
<li><a href="#">Сервис</a>
	<ul>
		<li><a href="#">Электронная рассылка</a></li>
		<li><a href="#">Дополнительно</a></li>
	</ul>
</li>
</ul>
</div>
</body>
</html>