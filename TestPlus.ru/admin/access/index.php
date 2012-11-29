<?php
session_start();
include "admin_header.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Управление доступом</title>
</head>
<body>
<header>ТЕСТИРОВАНИЕ +
<div><a href="/admin">На главную</a></div>
<div class="greeting">
<?php Greeting($usr_name)?>

<form name="logout" method="GET" action="../../Auth.php">
<button type="submit" name="logout">Выйти</button>
</form>
</div></header>

</body>
</html>