<header>ТЕСТИРОВАНИЕ +
<div class="greeting">
<?php Greeting($usr_name)?>
</div>
<form name="logout" method="GET" action="/Auth.php">
<button type="submit" name="logout">Выйти</button>
</form></header>
<?
if(($_SERVER['REQUEST_URI']!="/admin/index.php")&&($_SERVER['REQUEST_URI']!="/admin/"))
	include("../menu.html");
?>