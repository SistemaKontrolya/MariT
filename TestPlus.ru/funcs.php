<?php
function WhoIsWho($login,$password){
$q_l = mysql_query("SELECT * FROM users WHERE `Login`='$login'") or die("Invalid query: " .mysql_error());
if(!$q_l)
 echo "error select <br>";
$n_l=mysql_num_rows($q_l);
if($n_l==0){
 echo "Пользователь не найден <br>";
  SessionOff();
 }
else if($n_l>1){
 echo("ошибка (не уникальный логин)<br>");
 SessionOff();
 }
else if($n_l==1)
 {
   $str=mysql_fetch_array($q_l);
   $true_pass=$str["Password"];
   if($password!=$true_pass){
	 echo "Неверный пароль!";
	 SessionOff();
	 exit();
	}
   else
    {	
	$_SESSION['login']=$login;
	$rule=CheckRules($str);	
	if($rule==1){
		$_SESSION['adm']=$rule;
		//отправляем на админку
		header("Location: http://testplus.ru/admin/index.php");
	}
	if($rule==0){
		//отправляем в пользовательский раздел
		$_SESSION['usr']=1;
		header("Location: http://testplus.ru/usr/index.php");
		exit();
		}
	if(($rule!=0)&&($rule!=1)){
		SessionOff();
		header("Location: http://testplus.ru/index.php");
		exit();
	}
    }	
 }
}

function CheckRules($user){
  $adm=$user["Admin"];
 $simple_user=$user["Simple_user"];
if($adm==1)
	$result=1;
if(($adm==0)&&($simple_user==1))
   	$result=0;
if(($adm==0)&&($simple_user==0)) $result=-1;
return $result;	
}

function SessionOff(){
	session_unset();
	session_destroy();
}

function CheckName($login){
$q_l = mysql_query("SELECT * FROM users WHERE `Login`='$login'") or die("Invalid query: " .mysql_error());
if(!$q_l)
 echo "error select <br>";
$str=mysql_fetch_array($q_l);
$name=$str["Name"];
$_SESSION['Id']=$str["ID"];
return $name;
}

function Greeting($name){
echo "<br>Здравствуйте, ".$name."!";
if (isset($_SESSION['adm']))
 echo "<br> Вы вошли как Администратор. ";
}

function CheckUser($rule){
if(!isset($_SESSION[$rule])){
	header("Location: http://testplus.ru/index.php");
	exit();
	}
}

function ShowGroups() {
	 
	$q = mysql_query("SELECT * FROM Groups") or die("Invalid query: " .mysql_error());
	if(!$q)
		echo "error select <br>";
	$n=mysql_num_rows($q);
	echo "<table border=1 cellspacing=0 class='groups'><thead>
		<tr><td colspan='4'>Группы пользователей</td><td>
		<a href='index.php?new=1&id=NULL' onClick='return confirm(\'Создаем новую группу?\')'><img src='/pic/plus_32.png' alt='new' title='Создать новую группу'></a>
		<a href='#'><img src='/pic/print_32.png'></a>
		</td></tr></thead>
		<tr>
		<td hidden>id</td>
		<td>&nbsp;</td>	
		<td>Наименование</td>
		<td>Куратор</td>
		<td>Подразделение (кафедра)</td>
		<td>Комментарий</td>
		</tr>	";
	for($i=0;$i<$n;$i++){
		$str=mysql_fetch_object($q);
		$id_group=$str->Id;
		$name_group=$str->Name;
		$superv=$str->Supervisor;
		$dept=$str->Departament;
		$comt=$str->Comment;
		echo '<tr>
		<td hidden>'.$id_group.'&nbsp;</td>
		<td><a href="http://testplus.ru/admin/groups/index.php?edit=1&id='.$id_group.'"><img src="/pic/pencil_32.png" alt="Редактировать" title="Редактировать"></a>
		<a href="http://testplus.ru/admin/groups/index.php?showmembers=1&id='.$id_group.'"><img src="/pic/user_32.png" title="Посмотреть участников" alt="Посмотреть участников"></a>
		<a href="delgroup.php?id='.$id_group.'" onClick="return confirm(\'Внимание! Группа '.$name_group.' будет удалена. Вы согласны?\')"><img src="/pic/delete_32.png" alt="Удалить" title="Удалить группу"></a></td>
		<td>'.$name_group.'&nbsp;</td>
		<td>'.$superv.'&nbsp;</td>
		<td>'.$dept.'&nbsp;</td>
		<td>'.$comt.'&nbsp;</td>
		</tr>';
	}
	echo '</table>';
}

function ShowMembers($id){
	$q=mysql_query("SELECT * FROM `users` WHERE `Group`='$id'") or die("Invalid query: ".mysql_error());
	echo "<div class='flow_window'><ul>";
	$n=mysql_num_rows($q);
	for($i=0;$i<$n;$i++)
	{
		$str=mysql_fetch_array($q);
		//$id_user=$str["ID"];
		$name_user=$str["Name"];
		//$group=$str["Group"];
		echo "<li>".$name_user."</li>";
	}
	echo "</ul></div>";
}

function EditGroups($id)
{
	$q=mysql_query("SELECT * FROM `Groups` WHERE `Id`='$id'") or die("Invalid query: ".mysql_error());
	$str=mysql_fetch_array($q);
	echo '<div class="edit">
	<a href="index.php?new=1&id=NULL" onClick="return confirm(\'Создаем новую группу?\')"><img src="/pic/plus_32.png" alt="new" style="vertical-align: middle"></a>
	<a href="delgroup.php?id='.$id.'" onClick="return confirm(\'Внимание! Группа '.$str["Name"].' будет удалена. Вы согласны?\')"><img src="/pic/delete_32.png" alt="new" style="vertical-align: middle"></a>
<form name="fEditGroup" action="savegroup.php?id="'.$id.'" method="POST">
<table>
<tr><td>ID</td><td><input type="text" readonly="readonly" value="'.$str["Id"].'" name="id"></input></td></tr>
<tr><td>Name </td><td><input type="text" value="'.$str["Name"].'" name="name"></input></td></tr>
<tr><td>Supervisor </td><td><input type="text" value="'.$str["Supervisor"].'" name="superv"></input></td></tr>
<tr><td>Department</td><td><input type="text" value="'.$str["Department"].'" name="dept"></input></td></tr>
<tr><td colspan="2">Comment: <br><textarea name="commt" cols="30">'.$str["Comment"].'</textarea></td></tr>
<tr><td></td>
<td><button type="submit" name="save"><img src="/pic/save_32.png" alt="Сохранить" title="Сохранить"></button></td></tr></table>
</form></div>';
}

function SaveGroup($id,$name,$superv,$dept,$commt)
{	
	if($id != NULL){
		$q=mysql_query("UPDATE `Groups` SET `Name`='$name', `Supervisor`='$superv', `Department` = '$dept', `Comment` = '$commt' WHERE `Id` = '$id'");
		header("Location: index.php");}
	else {
		$q=mysql_query("INSERT INTO `Groups` (`Id`, `Name`, `Supervisor`, `Department`, `Comment`) VALUES ('$id', '$name', '$superv', '$dept', '$commt')");
		header("Location: index.php");
		}
		if($q)
			$_SESSION['msg']= 'Изменения сохранены успешно';
		else die("Invalid query: ".mysql_error());
} 
function DeleteGroup($id)
{
	$q=mysql_query("SELECT * FROM `users` WHERE `Group`='$id'") or die("Invalid query: ".mysql_error());
	$n=mysql_num_rows($q);
	if(!$n){
	if($id != NULL)
		$dq=mysql_query("delete from `Groups` where `Id`=$id");
		(!$dq)or($_SESSION['msg']='Группа удалена успешно');
		} else{ $_SESSION['msg']='В удаляемой группе не должно быть пользователей!<br>Группа не может быть удалена!';}
	header("Location: index.php");
}

function ShowUsers(){
	echo "Пользователи системы: <br>";
	echo "<ul style='list-style-type: none; list-style-image:none; '><li><b>Администраторы</b>";
	ShowByRule(1,0);
	echo "</li><li><b>Пользователи (ограниченные права)</b>";
	ShowByRule(0,1);
	echo "</li><li><b>Без доступа</b>";
	ShowByRule(0,0);
	echo "<li style='list-style-image: url(/pic/plus_16.png)'><a href='/admin/access/?edit=1&id='>Создать нового пользователя</a></li></ul>";
	
}

function ShowByRule($adm,$usr){
	if($adm)
		$q=mysql_query("SELECT * FROM `users` WHERE `Admin`='$adm'");
	else
		$q=mysql_query("SELECT * FROM `users` WHERE `Admin`='$adm' AND `Simple_user`='$usr'");
	if(!$q)
		echo "Error select";
	$n=mysql_num_rows($q);
	echo "<ul style='list-style-image: url(/pic/user_16.png)'>";
	for($i=0;$i<$n;$i++)
	{
		$str=mysql_fetch_array($q);
		$id_user=$str["ID"];
		$name_user=$str["Name"];
		echo "<li>
		<a href='/admin/access/?edit=1&id=".$id_user."'><img src='/pic/pencil_16.png' alt=' редактировать ' title='редактировать пользователя'></a>
		<a href='/admin/access/?show=1&id=".$id_user."' title='просмотр'>".$name_user."</a></li>";
	}
	echo "</li></ul>";
}

function EditUsers($id,$just_show){
	if($just_show) 
		$disabled='disabled';
	$q=mysql_query("SELECT * FROM `Users` WHERE `ID`='$id'") or die("Invalid query: ".mysql_error());
	$str=mysql_fetch_array($q);
	$groups=mysql_query("SELECT * FROM `groups`")or die("Invalid query: ".mysql_error());
	$n_groups=mysql_num_rows($groups);
	$q1=mysql_query("SELECT Name FROM `groups` WHERE `Id`='$str[Group]'") or die("Invalid query: ".mysql_error());
	$n_g=mysql_fetch_array($q1);
	$rule=CheckRules($str);
	$adm=''; 
	$usr='';
	if($rule==1)
		$adm='checked';
	if($rule==0)
		$usr='checked';
	echo '<div class="edit">';
	if(!$just_show)
		echo '<a href="deluser.php onClick="return confirm(\'Внимание! Пользователь '.$str["Name"].' будет удален. Вы согласны?\')"><img src="/pic/delete_32.png" alt="delete" style="vertical-align: middle"></a>';
	echo '<form name="fEditUser" action="saveuser.php?id="'.$id.'" method="POST">
	<table>
	<tr><td>ID </td><td><input type="text" readonly="readonly" value="'.$str["ID"].'" name="id"></input></td></tr>
	<tr><td>Имя </td><td><input type="text" '.$disabled.' value="'.$str["Name"].'" name="name"></input></td></tr>
	<tr><td>Логин </td><td><input type="text" '.$disabled.' value="'.$str["Login"].'" name="login"></input></td></tr>
	<tr><td>Пароль </td><td><input type="password" '.$disabled.' value="'.$str["Password"].'" name="password"></input></td></tr>
	<tr><td>E-mail </td><td><input type="email" '.$disabled.' name="email" value='.$str["E-mail"].'></input></td></tr>
	<tr><td>Группа пользователя</td> <td>
	<select name="select_group" '.$disabled.'><option selected value='.$str["Group"].'>'.$n_g['Name'].'</option>';
	for($i=0;$i<$n_groups;$i++){
		$group=mysql_fetch_object($groups) or die("Invalid query: ".mysql_error());
		if(($group->Id)!=($str["Group"]))
			echo '<option value="'.$group->Id.'">'.$group->Name.'</option>';
	}
	echo '</select>
	</td></tr>
	<tr><td>Роли </td><td><input type="checkbox" '.$adm.' name="adm" '.$disabled.' value="1">Администратор <br>
						<input type="checkbox" '.$usr.' name="usr" '.$disabled.' value="1">Пользователь </td></tr>
	<tr><td></td><td>';
	if(!$just_show)
		echo '<button type="submit" name="save"><img src="/pic/save_32.png" alt="Сохранить" title="Сохранить"></button>';
	echo '&nbsp;</td></tr></table></form></div>';
}

function SaveUser($id,$name,$login,$password,$email,$group,$adm,$usr){

	if($id){
		$save_user=mysql_query("UPDATE `Users` SET `Name`='$name', `Login`='$login', `Password`='$password', `E-mail`='$email', `Group`='$group',`Admin`='$adm',`Simple_user`='$usr' WHERE `ID`='$id'") or die("Invalid query: " .mysql_error());
		header("Location: index.php");
	} else {
		$save_user=mysql_query("INSERT INTO `Users` (`ID`,`Name`,`Login`,`Password`,`E-mail`,`Group`,`Admin`,`Simple_user`) VALUES ('$id','$name','$login','$password','$email','$group','$adm','$usr')");
		header("Location: index.php");
	}
	if($save_user)$_SESSION['msg']='Изменения сохранены успешно'; else $_SESSION['msg']='Ошибка операции с БД';

}

function DeleteUser($id){
	
	if($id != NULL){
		if($id==$_SESSION['Id']) $_SESSION['msg']='Вы пытаетесь удалить себя! Это невозможно';
		elseif($id !=1) $delete=mysql_query("DELETE FROM `Users` where `ID`=$id");
		elseif($id==1) $_SESSION['msg']='Невозможно удалить пользователя admin';
		(!$delete)or($_SESSION['msg']='Пользователь удален успешно');}
	header("Location: index.php");
}

function ShowSubjects(){
	$get_subjects=mysql_query("SELECT * FROM `subjects`");
	$subjects_amount=mysql_num_rows($get_subjects);
	echo '<h1>Темы тестирования: </h1>';
	if ($subjects_amount==0) echo 'Пока нет ни одной темы';
	else{
		echo '<ul>';		
		for($i;$i<$subjects_amount;$i++){
		$subject=mysql_fetch_object($get_subjects);
		echo "<li style='list-style-type: none;'>
			<a href='?edit=1&id=".$subject->ID."'><img src='/pic/pencil_16.png' alt=' редактировать ' title='редактировать тему'></a>
			".$subject->Name;
			if(isset($_GET['edit'])&&($_GET['id']==$subject->ID))EditSubject($subject->ID,$subject->Name);
		echo "</li>";
		}
	}
	echo "<li style='list-style-image: url(/pic/plus_16.png)'><a href='?edit=1&id='>Создать новую тему</a></li></ul>";
	if(isset($_GET['edit'])&&($_GET['id']=='')){
		echo '<div> <b>Создание новой группы </b><br>';
		EditSubject('','');
		echo '</div>';
		}
}

function EditSubject($subject_id,$subject_name){
	$get_subjects=mysql_query("SELECT * FROM `subjects`");
	$subjects_amount=mysql_num_rows($get_subjects);
		echo '
		<form name="edit_subject" action="editsubject.php" method="POST">
		<input type="text" name="id" value="'.$subject_id.'" hidden></input>
		<input type="text" name="name" value="'.$subject_name.'"></input>
		<button type="submit" name="save"><img src="/pic/save_16.png" alt="Сохранить" title="Сохранить"></button>
		<a href="delsubject.php?id='.$subject_id.'" onClick="return confirm(\'Внимание! Тема '.$subject_name.' будет удалена. Вы согласны?\')"><button type="button"><img src="/pic/delete_16.png" alt="delete" ></button></a>
		</br>
		</form>';
}

function SaveSubject($subject_id,$subject_name){
	if($subject_id){ 
		$save_subj=mysql_query("UPDATE `subjects` SET `Name`='$subject_name' WHERE `ID`='$subject_id'")or die("Invalid query: " .mysql_error());
		header("Location: index.php");
	} else {
		$save_subj=mysql_query("INSERT INTO `subjects`(`ID`,`Name`) VALUES ('$subject_id','$subject_name')");
		header("Location: index.php");
	}
}

function DeleteSubject($subject_id){
	if($subject_id){
		//добавить проверку на наличие подчиненных тестов
		$delete=mysql_query("DELETE FROM `Subjects` where `ID`='$subject_id'");
		(!$delete)or($_SESSION['msg']='Тема удалена успешно');}
	header("Location: index.php");
}


function ShowTests($selected_subj){
	echo "<h1>Список тестов: </h1><br>";
	if($selected_subj){
		//если выбрана конкретная тема, выводим список тестов только по ней
		ShowBySubj($selected_subj,1);
	}
	else {/*выводим список всех тестов с группировкой по теме*/
		$all_subjects=mysql_query("SELECT `ID` FROM `Subjects`");
		$subjects_amount=mysql_num_rows($all_subjects);
		for($i;$i<$subjects_amount;$i++){
			$subj=mysql_fetch_object($all_subjects);
			ShowBySubj($subj->ID,"");
		}
	}
	//echo "<li style='list-style-image: url(/pic/plus_16.png)'><a href='/admin/tests/?edit=1&id='>Создать новый тест</a></li></ul>";
}

function ShowBySubj($subject,$selected){
 if($selected)$choise="&choise=OK"; else $choise="";
 $select_name=mysql_query("SELECT Name FROM `subjects` WHERE `ID`='$subject'") or die("Invalid query: ".mysql_error());
 $subj_name=mysql_fetch_array($select_name);
 echo '<ul style="list-style-type: none;"><b>'.$subj_name["Name"].'</b>';
 $tests_list=mysql_query("SELECT `ID`,`Name` FROM `tests` WHERE `Subject`='$subject'") or die("Invalid query: ".mysql_error());
 $test_amount=mysql_num_rows($tests_list);
 if(!$test_amount) echo '<li>Для этой темы нет тестов</li></ul>';
 for($i;$i<$test_amount;$i++){
		$test=mysql_fetch_object($tests_list);
		echo '<li><a href="?subject='.$subject.$choise.'&edit=1&id='.$test->ID.'"><img src="/pic/pencil_16.png" alt=" редактировать " title="редактировать тест"></a>
		 <a href="?subject='.$subject.$choise.'&show=1&id='.$test->ID.'">'.$test->Name.'</a>
		</li>';
	}
		echo "<li style='list-style-image: url(/pic/plus_16.png)'><a href='?subject=".$subject.$choise."&edit=1&id='>Создать новый тест</a></li></ul>";
		echo '</ul>';
}

function EditTest($test_id,$just_show){
	if($just_show)
		$disabled='disabled';
	$select_test=mysql_query("SELECT * FROM `tests` WHERE `ID`='$test_id'") or die("Invalid query: ".mysql_error());
	$test=mysql_fetch_array($select_test);
	$test_subj_array=mysql_query("SELECT Name FROM `Subjects` WHERE `ID`='$_GET[subject]'") or die("Invalid query: ".mysql_error());
	$test_subj=mysql_fetch_array($test_subj_array);
	$subjects=mysql_query("SELECT * FROM `Subjects`") or die("Invalid query: ".mysql_error());
	$subjects_amount=mysql_num_rows($subjects);
	if(isset($_GET['choise']))$choise='&choise=OK';
	echo '<div class="edit">';
	if(!$just_show)
		echo '<a href="deltest.php?id='.$test_id.'" onClick="return confirm(\'Внимание! Тест '.$test["Name"].' будет удален. удаление теста повлечет за собой удаление связанных ВОПРОСОВ И ОТВЕТОВ, а также назначенных ЗАДАНИЙ для тестирования! Вы согласны?\')"><img src="/pic/delete_32.png" alt="delete" style="vertical-align: middle"></a>';
	echo '<form name=fEditTest action="savetest.php" method="POST">
	<table>
	<tr><td>ID</td><td>	<input type="text" readonly="readonly" value="'.$test["ID"].'" name="id"></input></td></tr>
	<tr><td>Имя теста</td><td><input type="text" '.$disabled.' value="'.$test["Name"].'" name="name"></input></td></tr>
	<tr><td>Тема</td><td><select name="select_subject" '.$disabled.'><option selected value="'.$_GET["subject"].'">'.$test_subj["Name"].'</option>';
	for($i;$i<$subjects_amount;$i++){
		$subject=mysql_fetch_object($subjects);
		if(($subject->ID)!=($_GET["subject"]))
			echo '<option value="'.$subject->ID.'">'.$subject->Name.'</option>';
	}
	echo '</select></td></tr>
	<tr><td>Количество вопросов <br>в сеансе</td><td><input size="2" type="test" '.$disabled.' name="quest_amount" value="'.$test["Questions_amount"].'"></input></td></tr>
	<tr><td>Необходимое количество <br>верных ответов</td><td><input size="2" type="test" '.$disabled.' name="ans_amount" value="'.$test["Cor_ans_amount"].'"></input></td></tr>
	<tr><td colspan="2"><a href="?subject='.$_GET["subject"].$choise.'&showquestions=1&id='.$test_id.'">Список вопросов теста</a></td></tr>
	<tr><td colspan="2"> Комментарий <br><textarea name="commt" '.$disabled.' cols="40">'.$test["Comment"].'</textarea></td></tr>
	<tr><td>&nbsp;</td><td>';
	if(!$just_show)
		echo '<button type="submit" name="save"><img src="/pic/save_32.png" alt="Сохранить" title="Сохранить"></button>';
	echo '&nbsp;</td></tr></table></form>';
	echo'<a href="?subject='.$_GET["subject"].$choise.'"><button>Отмена</button></a></div>';
}

function SaveTest($id, $name, $select_subject, $quest_amount, $ans_amount, $commt){
	if($id){
		$save_test=mysql_query("UPDATE `Tests` SET `Name`='$name', `Subject`='$select_subject', `Questions_amount`='$quest_amount', `Cor_ans_amount`='$ans_amount', `Comment`='$commt' WHERE `ID`='$id'") or die("Invalid query: " .mysql_error());
		header("Location: index.php");
	} else {
		$save_test=mysql_query("INSERT INTO `Tests` (`ID`,`Name`,`Subject`,`Questions_amount`,`Cor_ans_amount`,`Comment`) VALUES ('$id','$name','$select_subject','$quest_amount','$ans_amount','$commt')");
		header("Location: index.php");
	}
	if($save_test)
		$_SESSION['msg']='Изменения сохранены успешно'; 
		else $_SESSION['msg']='Ошибка операции с БД';
}

function DeleteTest($id){
	if($id){
		$check_questions=mysql_query("SELECT `ID` FROM `questions` WHERE `Test_owner`='$id'");
		$num_questions=mysql_num_rows($check_questions);
		$check_trials=mysql_query("SELECT `ID` FROM `trials` WHERE `Test_id`='$id'");
		$num_trials=mysql_num_rows($check_trials);
		$delete=mysql_query("DELETE FROM `Tests` where `ID`='$id'");
		 if($num_questions){
			for($i;$i<$num_questions;$i++){
				$question=mysql_fetch_object($check_questions);
				$delete=DeleteQuestion($question->ID);
			}
		 }
		 if($num_trials){
			for($i=0;$i<$num_trials;$i++){
				$trial=mysql_fetch_object($check_trials);
				$delete=DeleteTrial($trial->ID);
			}
		 }
		(!$delete)or($_SESSION['msg']='Тест удален успешно');
	}
	header("Location: index.php");
}

function ShowQuestions($test_id){
	$test_owner=mysql_query("SELECT Name FROM `tests` WHERE `ID`='$test_id'");
	$test_name=mysql_fetch_array($test_owner);
	$questions=mysql_query("SELECT Content,ID FROM `Questions` WHERE `Test_owner`='$test_id'");
	$amount_questions=mysql_num_rows($questions);
	if(!$amount_questions) echo 'К этому тесту нет привязанных вопросов<br>';
	echo '<a href="'.$_SESSION['location'].'&new_question=1"><img src="/pic/plus_16.png">Создать новый вопрос</a>';
	if(isset($_GET['new_question'])){
		echo '<div><form name="new_question" action="savequestion.php" method="POST"><input type="text" name="owner" value="'.$test_id.'" hidden></input>
		<textarea name="content" cols="57" rows="3" autofocus></textarea><br>
		<button type="submit" name="new_question"><img src="/pic/save_32.png" alt="сохранить" title="сохранить"></button>
		</form></div>';
	}
	echo '<div><ul style="list-style-type: decimal;list-style-position: inside"><b>'.$test_name[Name].'</b>';
	$thisPage = $_SERVER['REQUEST_URI']; 
	for($i;$i<$amount_questions;$i++){
		$question=mysql_fetch_object($questions);
		echo '<li><a href="'.$_SESSION['location'].'&question='.$question->ID.'">'.$question->Content.'</a></li>';
	}
	echo '</ul></div>';
}

function EditQuestion($id){
	//$thisPage = $_SERVER['REQUEST_URI']; 
	$select_questions=mysql_query("SELECT * FROM `questions` WHERE `ID`='$id'") or die("Invalid query: ".mysql_error());
	$question_info=mysql_fetch_array($select_questions);
	$select_answers=mysql_query("SELECT * FROM `answers` WHERE `Question_owner`='$id'");
	$answers_amount=mysql_num_rows($select_answers);
	echo '<div><form name="fEditQuestion" action="savequestion.php" method="POST">
	<input type="text" name="owner" hidden value="'.$id.'"></input>
	Вопрос:<br>
	<textarea name="question" cols="60" rows="3">'.$question_info["Content"].'</textarea><br>
	<input type="text" hidden name="question_id" value="'.$question_info["ID"].'"></input>';
	if(!$answers_amount) echo "Не введено ни одного ответа<br>Введите ";
		echo 'варианты ответов: <br>';
		//выводим 6 полей для редактирования. если ответа еще нет, поле пустое
		for($i;$i<6;$i++){
		$answer=mysql_fetch_object($select_answers);
		$checked="";
		 if(($answer->correct)==1) $checked='checked';
		echo '<input type="text" hidden name="answer_num'.$i.'" value="'.$answer->ID.'"></input>
		<input type="radio" name="correct" value="'.$answer->ID.'" '.$checked.' title="Выберите правильный ответ с помощью переключателя"></input>
		<textarea cols="57" rows="1" name="answer_cont'.$i.'">'.$answer->Content.'</textarea><span></span><br>';
		}
	echo '<button type="submit" name="save_question"><img src="/pic/save_32.png" alt="сохранить" title="сохранить"></button>';
	echo '<button onClick="return confirm(\'Внимание! Вопрос будет удален. УДАЛЕНИЕ ВОПРОСА ПОВЛЕЧЕТ ЗА СОБОЙ УДАЛЕНИЕ СВЯЗАННЫХ ОТВЕТОВ! Вы согласны?\')" type="submit" name="delete">
	<img src="/pic/delete_32.png" alt="delete" ></button>';
	echo'</form></div><a href="'.$_SESSION['location'].'"><button>Отмена</button></a></div>';
}

function SaveQuestion($question_content, $question_id, $owner){
if(isset($question_id))
	$save_question=mysql_query("UPDATE `questions` SET `Content`='$question_content' WHERE `ID`='$question_id'") or die("Invalid query: ".mysql_error());
else
	$save_question=mysql_query("INPUT INTO `questions` (`ID`,`Content`,`Test_owner`) VALUES ('$question_id','$question_content','$owner')");
}

function DeleteQuestion($id){
	if($id){
		$check_answers=mysql_query("SELECT `ID` FROM `answers` WHERE `Question_owner`='$id'");
		$num_answers=mysql_num_rows($check_answers);
		$delete=mysql_query("DELETE FROM `questions` where `ID`='$id'");
		 if($num_answers){
			for($i;$i<$num_answers;$i++){
				$ans=mysql_fetch_object($check_answers);
				DeleteAnswer($ans->ID);
			}
		 }
	}
}

function SaveAnswer($answer_id,$answer_content,$question_owner,$correct){
	if($answer_id)
		$save_answer=mysql_query("UPDATE `answers` SET `Question_owner`='$question_owner',`Content`='$answer_content',`correct`='$correct' WHERE `ID`='$answer_id'") or die("Invalid query: ".mysql_error());
	else
		$save_answer=mysql_query("INSERT INTO `answers` (`ID`,`Question_owner`,`Content`,`correct`) VALUES ('$answer_id','$question_owner','$answer_content','$correct')") or die("Invalid query: ".mysql_error());
}

function DeleteAnswer($id){
	if($id)
		$delete=mysql_query("DELETE FROM `answers` where `ID`='$id'");
	header("Location: ".$_SESSION['location']."");
}

function EditTrial($id){
	$get_trial=mysql_query("SELECT * FROM `trials` WHERE `ID`='$id'");
	$trial=mysql_fetch_array($get_trial);
	//набираем массивов для селекта
	$get_users=mysql_query("SELECT `ID`,`Name` FROM `users` WHERE `Simple_user`=1");
	$num_users=mysql_num_rows($get_users);
	$get_tests=mysql_query("SELECT `ID`,`Name` FROM `tests`");
	$num_tests=mysql_num_rows($get_tests);
	//находим уже выбранные значения
	$get_selected_test=mysql_query("SELECT * FROM `tests` WHERE `ID`='".$trial['Test_id']."'");
	$selected_test=mysql_fetch_array($get_selected_test);
	$get_selected_user=mysql_query("SELECT `ID`,`Name` FROM `users` WHERE `ID`='".$trial['User_id']."'");
	$selected_user=mysql_fetch_array($get_selected_user);
	//рисуем форму для изменения тестового испытания
	echo '<form align=left name="fEditTrial" method="POST" action="maketrials.php">
	<input type="text" name="id" hidden value="'.$id.'">
	<fieldset><legend>Редактировать данные</legend>
	Пользователь: <select name="user">';
	for($i;$i<$num_users;$i++){
		$user=mysql_fetch_object($get_users);
		if(($user->ID)==($selected_user['ID'])){
			echo '<option value="'.$user->ID.'" selected>'.$user->Name.'</option>';
		}
		echo '<option value="'.$user->ID.'">'.$user->Name.'</option>';
	}
	echo '</select><br>
	Тест: <select name="test">';
	for($i=0;$i<$num_tests;$i++){
		$test=mysql_fetch_object($get_tests);
		if(($test->ID)==($selected_test['ID'])){
			echo '<option value="'.$test->ID.'" selected>'.$test->Name.'</option>';
		}
		echo '<option value="'.$test->ID.'">'.$test->Name.'</option>';
	}
	echo '</select><br>
	<input type="date" name="start" value="'.$trial['Date_start'].'" required>
	<input type="date" name="finish" value="'.$trial['Date_end'].'" required>
	</fieldset>

	<input type="submit" name="savetrial" value="Сохранить">
	
	<fieldset disabled><legend>Информация о тесте</legend>
	<table><tr><td colspan=2>';
	$get_subj=mysql_query("SELECT `Name` FROM `subjects` WHERE `ID`='".$selected_test['Subject']."'");
	$subj=mysql_fetch_array($get_subj);
	echo 'Тема тестирования:<br><textarea cols=55 rows=2>'.$subj['Name'].'</textarea></td></tr>
	<tr>
	<td>Количество<br>вопросов<br>в тесте: <input type="text" value="'.$selected_test['Questions_amount'].'" size="2"></td>
	<td>Необходимо<br>верно <br>ответить на: <input type="text" value="'.$selected_test['Cor_ans_amount'].'" size="2"></td></tr></table>
	</fieldset>
	<fieldset disabled><legend>Отметки о прохождении</legend>
	<table width="80%"><tr><td width="50%">';
	if(($trial['Passed'])==1) echo 'тест пройден'; else echo 'не было попыток прохождения</td><td>';
	if(($trial['Passed']==1)&&($trial['Failed']==0)) echo 'тест сдан'; else echo 'тест не сдан';
	echo '</td></tr></table></fieldset>';
	echo '</form>';
}

function MakeTrial($id,$user_id,$test_id,$date_start,$date_end,$passed,$failed){
	$check=mysql_query("SELECT `ID` FROM `trials` WHERE `User_id`='$user_id' AND `Test_id`='$test_id' AND `Date_start`='$date_start' AND `Date_end`='$date_end'");
	$num_check=mysql_num_rows($check);
	if($num_check>0){ 
	return 0;
	}
	if(!$id){
	$new=mysql_query("INSERT INTO `trials` (`ID`, `User_id`, `Test_id`, `Date_start`, `Date_end`, `Passed`, `Failed`) VALUES (NULL,'$user_id','$test_id','$date_start','$date_end','$passed', '$failed')");
	}
	if($id){
	$new=mysql_query("UPDATE `trials` SET `User_id`='$user_id', `Test_id`='$test_id', `Date_start`='$date_start', `Date_end`='$date_end' WHERE `ID`='$id'");	
	}
	return $new;
}

function DeleteTrial($id){
	if($id)
		$delete=mysql_query("DELETE FROM `trials` where `ID`='$id'");
	return $delete;
}

function MakeOptions($objects,$num,$name){
	if($_REQUEST["$name"])$id=$_REQUEST["$name"];
	echo '<option value="">'.$obj->Name.'</option>';
	for($i=0;$i<$num;$i++){
		$obj=mysql_fetch_object($objects);
		if(($obj->ID)==$id) echo '<option value="'.$obj->ID.'" selected >'.$obj->Name.'</option>';
		else echo '<option value="'.$obj->ID.'" >'.$obj->Name.'</option>';
	}
}
?>