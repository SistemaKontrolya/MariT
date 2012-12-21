<?php
session_start();
include ("../../link.php");
include ("../admin_header.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Редактирование тестов</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
<style>
	textarea:invalid + span:after {
    content: "заполните поле";
    padding-left: 5px;
   }
</style>
</head>
<body>
<?include ("../cap.php");?>
<div>
<form name="fChooseSubject" action="" method="GET" >
	Выберите тему: 
	<select name="subject">
	<?
	$subjects=mysql_query("SELECT * FROM `Subjects`") or die("Invalid query: ".mysql_error());
	$subjects_amount=mysql_num_rows($subjects);
	for($i;$i<$subjects_amount;$i++){
		$subject=mysql_fetch_object($subjects);
			echo '<option value="'.$subject->ID.'">'.$subject->Name.'</option>';
	}
	?>
	<option value="">Вывести все</option>
	</select>
	<input type="submit" name="choise" value="OK"></input>
</form>
</div>
</div>
<div>
<?php
if(isset($_GET['choise'])){
	$selected=$_GET['subject'];
	$choise='&choise=OK';
	}
ShowTests($selected);
if(isset($_GET['show'])) EditTest($_GET['id'],1);
if(isset($_GET['edit'])) EditTest($_GET['id'],0);
if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	$_SESSION['msg']=NULL;}
?>
<!-- cтиль временный, только для удобства проверки-->
<div style="float: left; position: relative; top: -250px; left: 400px; ">
<?
if(isset($_GET['showquestions'])) {
$_SESSION['location']="?subject=".$_GET['subject']."".$choise."&showquestions=1&id=".$_GET['id'];
ShowQuestions($_GET['id']);}

if(isset($_GET['question'])) {
	$_SESSION['location']="?subject=".$_GET['subject']."".$choise."&showquestions=1&id=".$_GET['id'];
	EditQuestion($_GET['question']);
	}
if(isset($_GET['showtrial'])){
	if(MakeTesting($_GET['id'])){
		echo 'Пробный тест сформирован успешно, для прохождения перейдите по ссылке ';
		echo '<a href="testtrial.php" target="_blank">пройти тестирование</a>';
		}
	else $_SESSION['msg']='Не удалось построить тест';
}
	
if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	$_SESSION['msg']=NULL;
	}
?>
</div>
</div>
</body>
</html>