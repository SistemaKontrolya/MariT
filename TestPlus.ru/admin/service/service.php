<?php
session_start();
include ("../../link.php");
$submit=$_POST["save_info"];
if(isset($submit)){
 $check_table=mysql_query("SELECT * FROM `service`");
 if(mysql_num_rows($check_table))
   $save=mysql_query("UPDATE `service` SET `email`='".$_POST["admin_mail"]."', `content`='".$_POST["mail_content"]."'")or die ("Invalid query: " .mysql_error());
 else 
   $save=mysql_query("INSERT INTO `service` (`email`, `content`) VALUES ('".$_POST["admin_mail"]."', '".$_POST["mail_content"]."')")or die ("Invalid query: " .mysql_error());
	if($save)
		$_SESSION['msg']='Изменения сохранены успешно';
	else 
		$_SESSION['msg']='Простите, не удалось сохранить изменения';

header("Location: addition.php");
exit();
}	
	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Сервис</title>
</head>
<body>
Если вы видите страницу, что-то пошло не так...
</body></html>