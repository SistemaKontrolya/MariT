<? 
session_start();
include ("../../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Персональные данные</title>
</head>
<body>
<?include ("../header.php");?>
<div>
<?
if(isset($_SESSION['Id'])){
	
	$users=mysql_query("SELECT * FROM `Users` WHERE `ID`='".$_SESSION['Id']."'") or die("Invalid query: ".mysql_error());
	$user=mysql_fetch_array($users);
	$rule=CheckRules($user);
	$adm=''; 
	$usr='';
	if($rule==1)
		$adm='checked';
	if($rule==0)
		$usr='checked';
	echo '<div class="edit">';
	echo '<form name="fEditUserData" action="saveuser.php" method="POST">
	<table>
	<tr hidden><td>ID </td><td><input type="text" hidden value="'.$user["ID"].'" name="id"></input></td></tr>
	<tr><td>Имя </td><td><input type="text" value="'.$user["Name"].'" name="name"></input></td></tr>
	<tr><td>Логин </td><td><input type="text" value="'.$user["Login"].'" name="login"></input></td></tr>
	<tr><td>Пароль </td><td><input type="password" value="'.$user["Password"].'" name="password"></input></td></tr>
	<tr><td>E-mail </td><td><input type="email" name="email" value='.$user["E-mail"].'></input></td></tr>
	<tr hidden><td>Группа пользователя</td> <td>
	<input type="text" name="group" value='.$user["Group"].' hidden>
	</td></tr>
	<tr hidden><td>Роли </td><td><input type="checkbox" '.$adm.' name="adm" value="1" hidden>
	<input type="checkbox" '.$usr.' name="usr" value="1" hidden></td></tr><tr><td></td><td>';
	echo '<button type="submit" name="save"><img src="/pic/save_32.png" alt="Сохранить" title="Сохранить"></button>';
	echo '&nbsp;</td></tr></table></form></div>';
} else echo 'Простите, не удалось определить пользователя';
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