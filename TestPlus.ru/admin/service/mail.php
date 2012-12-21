<?php
session_start();
include ("../../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Электронная рассылка</title>
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
 text-align:left;
 border:1px solid grey;
 padding:0;
 margin:0;
 height:200px;
 overflow: auto;
 
 }
 div.area + div{
 width: 40%;
 border:none;
 height:230px;
 overflow: auto;
 }
 .temp{background-color:yellow;}
 .form{width:100%;
 padding:0;
 align: center;}
 .area{
 text-align:right;
 width:40%;
 border:none;
 float:left;
 }
</style>
</head>
<body>
<?include ("../admin_header.php");?>
<!-- формируем письмо вручную или автоматически -->
<a href="?auto=1" title="Письмо будет сформировано автоматически">Сообщить о предстоящем тестировании (автоматически)</a><br>
<a href="?manual=1" title="Отправка одного письма нескольким получателям">Сформировать письмо вручную</a>
<div class="form">
<? if($_GET['manual']){
echo '<form name="fMakePost" action="service.php" method="POST" class="temp">	
<div class="area">
<div class="choose"><b>Выберите получателей</b><br>';
	
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
			$users=mysql_query("SELECT * FROM `users` WHERE `Group`=".$group_id." ");
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
	//end of .choose
	echo '</div>
		<input type="reset" name="reset" value="Сбросить">
		<input type="submit" name="makepost" value="Сформировать письмо">
	</div><!-- end of .area -->
	<div>
	<b>&nbsp; Тема письма: </b><br>
	<input type="text" name="title" size="82" required><br>
	<b>&nbsp; Текст письма: </b>
	<textarea cols=63 rows=9 name="mail_content" required>Уважаемый пользователь! <br> Сообщаем Вам, что необходимо сдать тестирование. Подробную информацию Вы получите в разделе <b>Контроль успеваемости</b> на сайте testplus.ru </textarea>
	</div></form>';	}//if manual
	
//автоматически: на основании сведений об активных тестах 
	if($_GET['auto']){
		echo '<div style="margin:10px 0;"><form name="period" method="POST" action="service.php">
		Выбрать активные тесты за период:
		<input type="date" name="from"> - <input type="date" name="to"><br>
		<input type="submit" name="autosend" value="Сформировать отправку">
		</form></div>';
	}
	
	?>
	</div><!-- end of ".form"-->

	

<div class="service">
<?
if(isset($_SESSION['msg']))
		echo $_SESSION['msg'];
$_SESSION['msg']='';
?>
</div>
</body>
</html>