<?
session_start();
include ("../../link.php");
if(!isset($_GET['id']))
	header("Location: index.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Информация о тесте</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<?include ("../header.php");?>
<ul class="topmenu"><li><a href="../index.php">Главная</a></li><li><a href="index.php">Контроль успеваемости</a></li><li>Информация о тесте</li></ul>
<br>
<div class="service">
<?
if(isset($_SESSION['msg']))
	echo $_SESSION['msg'];
$_SESSION['msg']='';
?>
<div>
<?
$trial_id=$_GET['id'];
$select_trials=mysql_query("SELECT * FROM `trials` WHERE `ID`='$trial_id'");
$trial=mysql_fetch_array($select_trials);
$test_info=GetTestInfo($trial["Test_id"]);
$current_date=date("Y-m-d");
if($trial["Passed"]==1)
	$passed="Тест пройден";
else $passed="Не было попыток прохождения";
if(($trial["Failed"]==0)&&($trial["Passed"]==1))
	$failed="Тест сдан";
else $failed="Тест не сдан";
?>
<h1>Информация о тесте</h1>
<?
echo 'Тема тестирования: '.$test_info["Subject_name"].'
<br>Название теста: '.$test_info["Name"].'
<br>Количество вопросов: '.$test_info["Questions"].'
<br>Необходимо дать правильных ответов: '.$test_info["Answers"].'
<br>Комментарий к тесту: '.$test_info["Comment"].'
<br>
<br>Начало тестирования: '.$trial["Date_start"].'
<br>Окончание тестирования: '.$trial["Date_end"].'
<br>
<br>Попытки прохождения: '.$passed.'
<br>Оценка: '.$failed;


if(($trial["Date_start"]<=$current_date)&&($trial["Date_end"]>=$current_date)&&($trial["Passed"]!=1))
	echo '<br><a href="test.php?id='.$trial_id.'">Начать тестирование</a>';
?>
</div>
</div>
</body>
</html>