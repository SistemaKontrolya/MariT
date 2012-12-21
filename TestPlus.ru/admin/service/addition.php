<?php
session_start();
include ("../../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Дополнительно</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<?include ("../admin_header.php");?>
<div style="margin 30px 0">
<? $get_info=mysql_query("SELECT * FROM `service`");
if((mysql_num_rows($get_info))<=1){
	if((mysql_num_rows($get_info))==1){
	$info=mysql_fetch_array($get_info);
	$mail=$info['email'];
	$content=$info['content'];
	}
	echo '<form name="additional" action="service.php" method="POST">
	<table><tr>
	<td>Адрес почты администратора: </td><td><input type="e-mail" name="admin_mail" value="'.$mail.'" size="50"></td></tr>
	<tr><td valign="top">Заголовок письма: </td><td rowspan="2"><textarea name="mail_content" cols="39" rows="10">'.$content.'</textarea></td></tr>
	<tr><td valign="bottom"><input type="image" src="/pic/save_32.png" name="save_info" value="сохранить"></input></td></tr>
	</table>
	</form>';
} else {
	echo 'Ошибка: слишком много записей в таблице service';
}
?>
</div>
<div class="service">
<?
	if(isset($_SESSION['msg']))
		echo $_SESSION['msg'];
	$_SESSION['msg']='';
?>
</div>
</body>
</html>