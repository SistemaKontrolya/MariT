<?php session_start();
include("link.php");																			
//include("funcs.php");
//$db=db_connect();
//if(!$db)
// echo "error db connect <br>";
if(isset($_SESSION['login'])){
	echo "Вы уже авторизованы. Перейти на ";
	if (isset($_SESSION['adm']))
		echo "<a href='admin/index.php'>главную страницу</a> своего раздела";
	if (isset($_SESSION['usr']))
		echo "<a href='usr/index.php'>главную страницу</a> своего раздела";
	}
//if (isset($_GET['logout'])) {
 //   SessionOff();
 //   header("Location: http://testplus/index.php");
 //   exit(); 
//}
if(isset($_POST['submit'])){
$login=$_POST['login'];
$password=$_POST['pass'];
	if (count($_POST) <= 0){
        echo "Не получены данные формы";
		SessionOff();
	}
	else
		WhoIsWho($login,$password);
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Авторизация</title>
<style>
</style>
</head>

<body>
<form name="fAuth" method="post" action="" accept-charset="utf-8">
<h1>Введите логин и пароль</h1>
<input type="text" name="login" size="20" maxlength="20"> <br>
<input type="password" name="pass" size="20" maxlength="20"><br>
<input type="submit" name="submit" value="Войти">
<input type="reset" name="reset" value="Очистить форму">

</form>
</body>
</html>