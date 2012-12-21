<?php
session_start();
include ("../../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Назначить испытания</title>
<link rel="stylesheet" type="text/css" href="/styles.css">
<style>
ul{list-style-type:none;}
#edit_trial{
text-align: right;
float: left; 
position: relative; 
top: -400px; 
left: 400px;
width: 40%;
height: 40%;
background-color:yellow; !important
visibility: hidden; !important}

.choose{
 width:40%;
 border:1px solid grey;
 padding:0;
 margin:0;
 height:150px;
 margin-left:4%;
 margin-right:12%;
 overflow: auto;
 float:left;
 }
 div.choose + div{
 width: 40%;
 border:1px solid grey;
 height:150px;
 overflow: auto;
 }
 .temp{background-color:yellow;}
 .form{width:1000px;
 padding:0;
 align: center;}
</style>
</head>
<body>
<?include ("../admin_header.php");?>
<div class="form">
<form name="fMakeTrial" action="maketrials.php" method="POST" class="temp">	
<div class="choose"><b>Выберите пользователей или группу</b><ul>
	<?
	$groups=mysql_query("SELECT * FROM `Groups`") or die("Invalid query: ".mysql_error());
	$groups_amount=mysql_num_rows($groups);
	for($i;$i<$groups_amount;$i++){
		if($groups_amount==1) {
			$group=mysql_fetch_array($groups);
			$group_id='$group[Id]';
			$group_name='$group[Name]';
		} else if($groups_amount>1){
			$group=mysql_fetch_object($groups);
			$group_id=$group->Id;
			$group_name=$group->Name;
			}
			$users=mysql_query("SELECT * FROM `users` WHERE `Group`=".$group_id." AND `Simple_user`=1");
			$num_users=mysql_num_rows($users);
			if($num_users>0){
			echo '<input type="checkbox" name="check_group[]" value="'.$group_id.'">'.$group_name.'</input>';
				echo '<fieldset>';
				if($num_users==1){
					$user=mysql_fetch_array($users); 
					echo '<input type="checkbox" name="check_user[]" value="'.$user[ID].'">'.$user[Name];
				} else {
					for($ii=0;$ii<$num_users;$ii++){
						$user=mysql_fetch_object($users);
					echo '<input type="checkbox" name="check_user[]" value="'.$user->ID.'">'.$user->Name.'<br>';
					}
				 } 
			}
			echo '</fieldset>';
	}	
	?>
	</ul></div>
	<div><b>Выберите тест(ы)</b>
	<?
	$all_subjects=mysql_query("SELECT * FROM `subjects`") or die("Invalid query: ".mysql_error());
	$subjects_amount=mysql_num_rows($all_subjects);
	for($n;$n<$subjects_amount;$n++){
		if($subjects_amount==1) {
			$subj=mysql_fetch_array($all_subjects);
			$subj_id='$subj[ID]';
			$subj_name='$subj[Name]';
		} else if($subjects_amount>1){
			$subj=mysql_fetch_object($all_subjects);
			$subj_id=$subj->ID;
			$subj_name=$subj->Name;
			}
			$tests=mysql_query("SELECT * FROM `tests` WHERE `Subject`=".$subj_id."");
			$num_tests=mysql_num_rows($tests);
			
			if($num_tests>0){
			echo '<input type="checkbox" name="check_subj[]" value="'.$subj_id.'">'.$subj_name.'</input>';
				echo '<fieldset>';
				if($num_tests==1){
					$test=mysql_fetch_array($tests); 
					echo '<input type="checkbox" name="check_test[]" value="'.$test[ID].'">'.$test[Name];
				} else {
					for($c=0;$c<$num_tests;$c++){
						$test=mysql_fetch_object($tests);
					echo '<input type="checkbox" name="check_test[]" value="'.$test->ID.'">'.$test->Name.'<br>';
					} echo '</fieldset>';
				 } 
			}
	}
	?>
	</div>
	<div><table width="100%"><tr>
	<td>Дата начала теста<br><input type="date" name="start" required></td><!-- подумать как сделать, чтоб было во всех браузерах -->
	<td>Дата окончания теста<br><input type="date" name="finish" required></td>
	<td valign="bottom"><input type="checkbox" name="makenotices">Оповестить пользователей о начале теста</input></td>
	<td><input onClick="return confirm('Проверьте заполнение всех полей! Подтвердите сохранение ')" type="submit" name="maketrial" value="Сохранить"></td>
	<td><input type="reset" name="reset" value="Сбросить"></td>
	</tr></table></div>
</form>
</div>
</div>

<div class="service">
<!-- для служебных сообщений-->
<?
if(isset($_SESSION['msg'])){ 
echo $_SESSION['msg'];
     $_SESSION['msg']='';
}
	 ?>
</div>
<div>
<table border=1 cellspacing=0 width="1000px">
<caption>Назначенные тестовые испытания:</caption>
<thead>
<tr><td>&nbsp;</td><td>Назначено пользователю: </td><td>Название теста</td><td>Дата начала</td><td>Дата окончания</td><td>Отметка о<br> прохождении</td>
<td>Результат</td><td>Количество<br>вопросов<br>в тесте</td><td>Требуется<br>правильных<br>ответов</td></tr>
</thead>
<?
$trials=mysql_query("SELECT * FROM `trials` ORDER BY `Date_end`");
$amount_trials=mysql_num_rows($trials);
for($i=0;$i<$amount_trials;$i++){
	$trial=mysql_fetch_object($trials);
	echo '<tr><td>
	<a href="deltrial.php?id='.$trial->ID.'" onClick="return confirm(\'Вы уверены, что хотите удалить задание?\');"><img src="/pic/delete_16.png"></a>
	<a href="?edit_trial='.$trial->ID.'" ><img src="/pic/pencil_16.png" title="Изменить задание"></a></td>';
	$user=mysql_query("SELECT `Name` FROM `users` WHERE `Id`=$trial->User_id");
	$username=mysql_fetch_array($user);
	echo'<td>'.$username['Name'].'</td>';
	$test_info=mysql_query("SELECT `Name`, `Questions_amount`, `Cor_ans_amount` FROM `tests` WHERE `ID`=$trial->Test_id");
	$test=mysql_fetch_array($test_info);
	echo'<td>'.$test['Name'].'</td>
		<td>'.$trial->Date_start.'</td>
		<td>'.$trial->Date_end.'</td>';
	if(($trial->Passed)==1)	$passed="тест пройден"; else $passed="не пройден";
	echo '<td>'.$passed.'</td>';
	if((($trial->Failed)==0)&&(($trial->Passed)==1)) $failed="тест сдан"; else $failed="тест не сдан";
	echo '<td>'.$failed.'</td>
		<td>'.$test['Questions_amount'].'</td>
		<td>'.$test['Cor_ans_amount'].'</td></tr>';
}
?>
</table>
</div>
<div id="edit_trial">
<?
if(isset($_GET['edit_trial'])) {
echo '<div style="visibility: visible; border:1px solid blue;">
<a href="index.php"><img src="/pic/close_32.png" alt="Выйти" title="Закрыть"></a>';
EditTrial($_GET['edit_trial']);
echo '</div>';
}
?>
</div>
</body>
</html>