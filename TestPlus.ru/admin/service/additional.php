<?php
session_start();
include "admin_header.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>����������� ��������</title>
</head>
<body>
<header>������������ +
<div><a href="/admin">�� �������</a></div>
<div class="greeting">
<?php Greeting($usr_name)?>

<form name="logout" method="GET" action="../../Auth.php">
<button type="submit" name="logout">�����</button>
</form>
</div>
</header>


</body>
</html>