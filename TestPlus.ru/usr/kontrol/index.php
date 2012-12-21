<?
session_start();
include ("../../link.php");?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Контроль успеваемости</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<?include ("../header.php");?>
<ul class="topmenu"><li><a href="../index.php">Главная</a></li><li>Контроль успеваемости</li></ul>
<div>
<form name="filter" action="" method="GET">
Показать тесты: <select name="show">
<option value="active">Активные</option>
<option value="failed">Несданные</option>
<option value="passed">Пройденные</option>
<option value="all">Все</option>
</select>
<input type="submit" name="filter" value="OK">
</form>
</div>
<div class="service">
<? if(isset($_SESSION['msg']))
		echo $_SESSION['msg'];
	$_SESSION['msg']='';
?>
</div>
<div>
<table>
<?
$current_date=date("Y-m-d");
if(isset($_GET['filter'])){
	if($_GET['show']=='active'){ 	//если выбраны "активные"
		$select="AND `Date_end`>='$current_date' AND `Date_start`<='$current_date'"; //отбираем только те, по которым дата окончания больше текущей, и дата начала меньше текущей
		$caption="Активные тесты для пользователя ".CheckName($_SESSION['login']);
	}
	if($_GET['show']=='failed'){ 	//если выбраны "несданные"
		$select="AND `Date_end`<'$current_date' AND `Failed`=1"; //отбираем только те, по которым дата окончания меньше текущей, и есть признак "не сдан"
		$caption="Несданные тесты для пользователя ".CheckName($_SESSION['login']);
	}
	if($_GET['show']=='passed'){ 	//если выбраны "несданные"
		$select="AND `Passed`=1"; //отбираем только те, по которым есть признак "пройден"
		$caption="Пройденные тесты для пользователя ".CheckName($_SESSION['login']);
	}
	if($_GET['show']=='all'){ 	//если выбраны "все"
		$select=""; //ничего не дополняем
		$caption="Все тесты для пользователя ".CheckName($_SESSION['login']);
	}
$select_trials=mysql_query("SELECT * FROM `trials` WHERE `User_id`='".$_SESSION['id']."' ".$select.""); //отбираем по текущему пользователю + по значению фильтра
$num_trials=mysql_num_rows($select_trials); //считаем полученное количество 

//формирование таблицы с найденными записями:
if($num_trials){
	echo '<table border=1 cellspacing=0>
	<caption>'.$caption.'</caption>
	<thead><tr><td>Название теста</td>
		<td>Дата начала <br>тестирования</td>
		<td>Дата окончания</td>
		<td>Прохождение <br>теста</td>
		<td>Отметка</td></tr></thead>';
	for($i=0;$i<$num_trials;$i++){
	$trial=mysql_fetch_object($select_trials);
	//находим название теста по id
	$get_test_name=mysql_query("SELECT `Name` FROM `tests` WHERE `ID`='".$trial->Test_id."'");
	$test=mysql_fetch_array($get_test_name);
	//получаем отметку о прохождении
	if(($trial->Passed)==1)
		$passed='пройден';
	else $passed='не было попыток сдать тест';
	//получаем отметку о сдаче теста
	if(($trial->Failed)==1)
		$failed='тест не сдан';
	else $failed='';
	//выводим строки	
	echo '<tr><td><a href="testinfo.php?id='.$trial->ID.'">'.$test['Name'].'</a></td>
		<td>'.$trial->Date_start.'</td>
		<td>'.$trial->Date_end.'</td>
		<td>'.$passed.'</td>
		<td>'.$failed.'</td></tr>
		';
	}
	echo '</table>';
} else {
	$_SESSION['msg']='не найдено ни одной записи';
}

}
$this_page='?show='.$_GET['show'].'&filter=OK';
echo '<a href="print.php'.$this_page.'" title="Версия для печати" target="_blank">Напечатать страницу</a>';
?>
</table>
</div>