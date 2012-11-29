<?php
session_start();
include("db_fns.php");																			
include("funcs.php");
$db=db_connect();
if(!$db)
 echo "error db connect <br>";
 
if (isset($_GET['logout'])) {
    SessionOff();
    header("Location: http://testplus.ru/index.php");
    exit(); 
}
else {
$login=$_POST['login'];
$password=$_POST['pass'];
	if (count($_POST) <= 0){
        echo "Не получены данные формы";
		SessionOff();
	}
	else
		WhoIsWho($login,$password);
}
	?>