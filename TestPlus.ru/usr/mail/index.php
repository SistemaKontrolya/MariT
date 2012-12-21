<? 
session_start();
include ("../../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Связь с администратором</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<?include ("../header.php");?>
<ul class="topmenu"><li><a href="../index.php">Главная</a></li><li>Связь с администратором</li></ul>
<div style="margin 30px 0">
<? $get_info=mysql_query("SELECT `email` FROM `service`");
if((mysql_num_rows($get_info))<=1){
	if((mysql_num_rows($get_info))==1){
	$info=mysql_fetch_array($get_info);
	$mail=$info['email'];
	}
	echo '<form name="mail" action="sendmail.php" method="POST">
	<input type="hidden" value="'.$mail.'" name="mailto">
	<table><tr>
	<td>Тема письма: </td><td><input type="text" name="mail_title" size="50"></td></tr>
	<tr><td valign="top">Тело письма: </td><td><textarea name="mail_content" cols="39" rows="10"></textarea></td></tr>
	<tr><td></td><td valign="bottom" align="right">
	<input type="submit" name="send" value="Отправить" onClick="return confirm(\'Подтвердите отправку\');">
	</td></tr>
	</table>
	</form>';
} else {
	echo 'Извините, сейчас сервис недоступен. Ошибка БД<br>';
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