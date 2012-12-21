<?php
session_start();
include ("../../link.php");

//обработчик формы additional (сохранение дополнительных сведений)
$submit=$_POST["save_info"];
if(isset($submit)){
 $check_table=mysql_query("SELECT * FROM `service`");
 if(mysql_num_rows($check_table))
   $save=mysql_query("UPDATE `service` SET `email`='".$_POST["admin_mail"]."',`title`='".$_POST["mail_title"]."', `content`='".$_POST["mail_content"]."'")or die ("Invalid query: " .mysql_error());
 else 
   $save=mysql_query("INSERT INTO `service` (`email`, `title`, `content`) VALUES ('".$_POST["admin_mail"]."', '".$_POST["mail_title"]."', '".$_POST["mail_content"]."')")or die ("Invalid query: " .mysql_error());
	if($save)
		$_SESSION['msg']='Изменения сохранены успешно';
	else 
		$_SESSION['msg']='Простите, не удалось сохранить изменения';

header("Location: addition.php");
exit();
}
	
//обработчик формы fMakePost (ручное формирование письма)
if(isset($_POST["makepost"])){
	if((!isset($_POST['check_user']))&&(!isset($_POST['check_group']))){
		$_SESSION['msg']="Ошибка: не выбраны получатели! Невозможно сформировать письмо <br>";
		header("Location: mail.php");
	exit();
	}	
	if(isset($_POST['check_user'])) $arr_users = $_POST['check_user'];
	if(isset($_POST['check_group'])) $arr_gr = $_POST['check_group'];
	$content = $_POST['mail_content'];
	$title=$_POST['title'];
	$get_sender=mysql_query("SELECT `email` FROM `service`");
	if($sender=mysql_fetch_array($get_sender))
		$from=$sender['email'];
	
	if(is_array($arr_gr)){ //если выбраны группы пользователей, разбираем полученный массив
		foreach($arr_gr as $ind=>$group_id){  //находим id пользователей по группе и записываем в массив users
		$get_users=mysql_query("SELECT `ID`, `Email`, `Name` FROM `users` WHERE `Group`='$group_id'");
		$num_users=mysql_num_rows($get_users);
			for($i=0;$i<$num_users;$i++){
				$user=mysql_fetch_object($get_users);
				$users[$user->ID]=array($user->Email,$user->Name);
			}
		}
	}
	if(is_array($arr_users)){ //если выбраны пользователи
	//обрабатываем полученных из формы пользователей: если такого еще нет в массиве users, добавляем значение
		foreach($arr_users as $index=>$user_id){
		$get_user=mysql_query("SELECT `ID`,`Email`,`Name` FROM `users` WHERE `ID`='$user_id'");
		$user=mysql_fetch_array($get_user);
		if(is_array($users)){
			if(!(in_array($user[ID],$users))){
				$users[$user[ID]]=array($user[Email],$user[Name]);
			} 
		} else $users[$user[ID]]=array($user[Email],$user[Name]);
		}
	}
	
	foreach($users as $id=>$adress){
	//если адрес не заполнен, пишем сообщение
	if(!$adress[0])
		$_SESSION['msg'].='Не определен адрес для пользователя '.$adress[1];
	else{
		//отправляем письмо (остальное определено)
		if(mail($adress[0], $title, $content, 'From:'.$from))
			$_SESSION['msg'].='Отправлено пользователю '.$adress[1].' успешно<br>';
		}
	}
	header("Location: mail.php");
} //end of if makepost

//обработчик формы period (для автоматического формирования письма)
if(isset($_POST["autosend"])){
	SendNotice($_POST["from"],$_POST["to"]);
	header("Location: mail.php");
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