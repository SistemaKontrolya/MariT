<?
session_start();
include ("../../link.php");
CheckUser('usr');
$counter=Counter();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Прохождение теста</title>
</head>
<body>
<br>
<div class="service">
<?
if(isset($_SESSION['msg']))
	echo $_SESSION['msg'];
$_SESSION['msg']='';

?>
<div style="text-align: right;">
<?
echo '<a href="testinfo.php?id='.$_SESSION['trial_id'].'" onClick="return confirm(\'Внимание! Результат тестирования не будет сохранен! Всё еще хотите прервать тестирование?\');">Прервать тестирование</a>';
?>
</div>
<div>
<form name="testing" action="" method="POST">
<?
//получаем ид вопроса
$question_id=$_SESSION['testing'][$counter];
//все стили временные, только на время отладки
echo '<div style="margin: 20px; background-color: grey;">';
echo $_SESSION['questions'][$question_id].'</div>';
echo '<div style="margin: 20px; background-color: silver;">
<input type="text" value="'.($counter+1).'" name="question" hidden>';
$get_answers=mysql_query("SELECT * FROM `answers` WHERE `Question_owner`='".$question_id."'");
while($answer=mysql_fetch_object($get_answers)){
	echo '<input type="radio" name="choise" value="'.$answer->ID.'">'.$answer->Content.'</input><br>';
}
if(($counter+1)<$_SESSION["questions_amount"])
	echo '</div><input type="submit" name="next" value="Далее" onClick="return confirm(\'Вы уверены, что хотите перейти к следующему вопросу?\');">';
else echo '</div><input type="submit" name="complete" value="Завершить тестирование" >';
?>
</form>
</div>
</body>
</html>