<?php
session_start();
include ("../../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Контроль успеваемости</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
<style>
TABLE{
	width: 800px;
}
FORM+TABLE{
    width: 400px; /* Ширина таблицы */
    border: 1px solid black; /* Рамка вокруг таблицы */
   }
TD {
    padding: 3px; /* Поля вокруг содержимого ячеек */
   }
</style>
</head>
<body>
<? //обработка результатов фильтра
	if($_GET['group']!=''){ //если выбрана группа, просматриваем по всем пользователям группы
		$user='AND `User_id` IN ('; // записываем в переменную кусок запроса для отбора по пользователю
		$get_users=mysql_query("SELECT `ID` FROM `users` WHERE `Group`=".$_GET['group'].""); 
		$num_users=mysql_num_rows($get_users);	
		for($i=0;$i<$num_users;$i++){
		$fetch_user=mysql_fetch_object($get_users);
		if(($i+1)!=$num_users)
			$user.=$fetch_user->ID.","; //добавляем пользователя в отбор
		else $user.=$fetch_user->ID.")"; //последний элемент закрывает запрос
		}
	}
	if($_GET['user']!=''){	//если выбран пользователь, 
		$user='AND `User_id`='.$_GET['user']; //переписываем отбор по пользователю
	}
	
	if($_GET['subject']!=''){ //если выбрана тема, просматриваем по всем тестам темы
		$test='AND `Test_id` IN (';  //начало запроса
		$get_tests=mysql_query("SELECT `ID` FROM `tests` WHERE `Subject`=".$_GET['subject']."");
		$num_tests=mysql_num_rows($get_tests);	
		for($i=0;$i<$num_tests;$i++){
		$fetch_test=mysql_fetch_object($get_tests);
		if(($i+1)!=$num_tests)
			$test.=$fetch_test->ID.","; //добавляем тест в отбор
		else $test.=$fetch_test->ID.")"; //последний элемент закрывает запрос
		}
	}
	if($_GET['test']!=''){ //если выбран тест
		$test='AND `Test_id`='.$_GET['test']; //переписываем отбор по тесту
	}
	//НА ВРЕМЯ ОТЛАДКИ! УБРАТЬ ПОСЛЕ ПОЯВЛЕНИЯ ПРОВЕДЕННЫХ ИСПЫТАНИЙ
	if($_GET['passed']==1){		//если стоит флаг "тест пройден"
		$passed='AND `Passed`=1'; //добавляем отбор только по пройденным
	}
	if($_GET['failed']==1){		//если стоит флаг "тест не сдан"
		$failed='AND `Failed`=1'; //добавляем отбор только несданным
	}
		
	//если выбран период, то выводим записи по периоду
	if(($_GET['from']!='')&&($_GET['to']!='')) 
		$select_trials=mysql_query("SELECT * FROM `trials` WHERE `Date_start`>='".$_GET['from']."' AND `Date_end`<='".$_GET['to']."' ".$test." ".$user." ".$passed." ".$failed."");
	else if($_GET['from']!='')
		$select_trials=mysql_query("SELECT * FROM `trials` WHERE `Date_start`>='".$_GET['from']."' ".$test." ".$user." ".$passed." ".$failed."");
	else if($_GET['to']!='')
		$select_trials=mysql_query("SELECT * FROM `trials` WHERE `Date_end`<='".$_GET['to']."' ".$test." ".$user." ".$passed." ".$failed."");
	else  //если период не выбран
		$select_trials=mysql_query("SELECT * FROM `trials` WHERE `Date_start`>=0 ".$test." ".$user." ".$passed." ".$failed."");

unset($test,$user,$passed,$failed); //удаляем переменные с текстом запроса
//выводим результат
$num_select=mysql_num_rows($select_trials);	
//echo '<table>';
/*for($i=0;$i<$num_select;$i++){
	$trial=mysql_fetch_object($select_trials);
	echo '<tr><td>'.$trial->ID.'</td><td>'.$trial->User_id.'</td>
	<td>'.$trial->Test_id.'</td><td>'.$trial->Date_start.'</td>
	<td>'.$trial->Date_end.'</td><td>'.$trial->Passed.'</td><td>'.$trial->Failed.'</td></tr>';
}*/
echo '<table border=1 cellspacing=0 width="100%">
<caption>Проведенные тестовые испытания:</caption>
<thead>
<tr><td>Назначено пользователю: </td><td>Название теста</td><td>Дата начала</td><td>Дата окончания</td><td>Отметка о<br> прохождении</td>
<td>Результат</td><td>Количество<br>вопросов<br>в тесте</td><td>Требуется<br>правильных<br>ответов</td></tr>
</thead>';

for($i=0;$i<$num_select;$i++){
	$trial=mysql_fetch_object($select_trials);
	echo '<tr>';
	$user=mysql_query("SELECT `Name` FROM `users` WHERE `Id`=$trial->User_id");
	$username=mysql_fetch_array($user);
	echo'<td>'.$username['Name'].'</td>';
	$test_info=mysql_query("SELECT `Name`, `Questions_amount`, `Cor_ans_amount` FROM `tests` WHERE `ID`=$trial->Test_id");
	$test=mysql_fetch_array($test_info);
	echo'<td>'.$test['Name'].'</td>
		<td width="12%">'.$trial->Date_start.'</td>
		<td width="12%">'.$trial->Date_end.'</td>';
	if(($trial->Passed)==1)	$passed="тест пройден"; else $passed="не пройден";
	echo '<td>'.$passed.'</td>';
	if((($trial->Failed)==0)&&(($trial->Passed)==1)) $failed="тест сдан"; else $failed="тест не сдан";
	echo '<td>'.$failed.'</td>
		<td>'.$test['Questions_amount'].'</td>
		<td>'.$test['Cor_ans_amount'].'</td></tr>';
		}
echo '</table>';
?>
</body></html>