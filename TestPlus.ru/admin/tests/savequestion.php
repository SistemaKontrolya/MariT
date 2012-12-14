<?php
session_start();
include "admin_header.php";
$delete=$_POST['delete']; 
$save=$_POST['save_question'];
if(!isset($delete)){
	if(isset($_POST['new_question'])){ 
		if($_POST[content]!='')
			$save_new=mysql_query("INSERT INTO `questions`(`ID`,`Test_owner`,`Content`) VALUES ('','$_POST[owner]','$_POST[content]') ");
		else $_SESSION['msg']="Запрещено сохранять пустой вопрос";
	}
	if(isset($save)){
		//сохранение вопроса
		SaveQuestion($_POST['question'],$_POST['question_id'],$_POST['owner']);
		//сохранение ответов
		for($i;$i<6;$i++){
			if($_POST['correct']==$_POST['answer_num'.$i])$correct=1; else $correct='';
			if(($correct==1)&&($_POST['answer_cont'.$i]=='')){  //если выбрали верный ответ без содержания
				$_SESSION['msg']="В качестве верного выбран пустой ответ!<br> Заполните содержание или измените выбор!<br>";
				header("Location: index.php".$_SESSION['location']."&question=".$_POST['question_id']); //отправляем исправлять
				exit();
			} 
	//если заполнено содержание ответа, сохраняем его
			if($_POST['answer_cont'.$i]!='')
				SaveAnswer($_POST['answer_num'.$i],$_POST['answer_cont'.$i],$_POST['question_id'],$correct);
	//если не заполнено содержание ответа и есть id
			if(($_POST['answer_cont'.$i]=='')&&($_POST['answer_num'.$i]!='')) DeleteAnswer($_POST['answer_num'.$i]);
	//если не заполено ни одно поле, ничего не делаем
		}
	}
} else DeleteQuestion($_POST['question_id']);
header("Location: index.php".$_SESSION['location']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Сохранение Теста</title>
</head>
<body>
Если вы видите эту страницу, произошла ошибка! Обратитесь к поставщику программы.
</body></html>