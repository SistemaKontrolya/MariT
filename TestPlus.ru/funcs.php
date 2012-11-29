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

function CheckRules($str){
  $adm=$str["Admin"];
 $s_u=$str["Simple_user"];
if($adm==1)
	$result=1;
if(($adm==0)&&($s_u==1))
   	$result=0;
if(($adm==0)&&($s_u==0)) $result=-1;
return $result;	
}

function SessionOff(){
	session_unset();
	session_destroy();
	//header("Location: http://testplus.ru/index.php");
}

function CheckName($login){
$q_l = mysql_query("SELECT * FROM users WHERE `Login`='$login'") or die("Invalid query: " .mysql_error());
if(!$q_l)
 echo "error select <br>";
$str=mysql_fetch_array($q_l);
$name=$str["Name"];
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
	//$thisPage = $_SERVER['REQUEST_URI']; 
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
		echo "<tr>
		<td hidden>".$id_group."&nbsp;</td>
		<td><a href='http://testplus.ru/admin/groups/index.php?edit=1&id=".$id_group."'><img src='/pic/pencil_32.png' alt='Редактировать' title='Редактировать'></a>
		<a href='http://testplus.ru/admin/groups/index.php?showmembers=1&id=".$id_group."'><img src='/pic/user_32.png' title='Посмотреть участников' alt='Посмотреть участников'></a>
		<a href='delgroup.php?id=".$id_group."' onClick='return confirm(\'Внимание! Группа ".$name_group." будет удалена. Вы согласны?\')'><img src='/pic/delete_32.png' alt='Удалить' title='Удалить группу'></a></td>
		<td>".$name_group."&nbsp;</td>
		<td>".$superv."&nbsp;</td>
		<td>".$dept."&nbsp;</td>
		<td>".$comt."&nbsp;</td>
		</tr>";
	}
	echo "</table>";
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
	$thisPage = $_SERVER['REQUEST_URI']; 
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
//$submit=$_POST['save'];
//if(isset($submit))
//	SaveGroup($id, $_POST['name'], $_POST['superv'], $_POST['dept'], $_POST['commt']);
}

function SaveGroup($id,$name,$superv,$dept,$commt)
{	
	if($id != NULL){
		$q=mysql_query("UPDATE `Groups` SET `Name`='$name', `Supervisor`='$superv', `Department` = '$dept', `Comment` = '$commt' WHERE `Id` = '$id'");
		header("Location: groups/index.php");}
	else {
		$q=mysql_query("INSERT INTO `Groups` (`Id`, `Name`, `Supervisor`, `Department`, `Comment`) VALUES ('$id', '$name', '$superv', '$dept', '$commt')");
		header("Location: groups/index.php");
		if($q){
			echo "Группа ".$name." успешно создана!<a href='groups/index.php'>Обновите список групп</a>, или <a href='groups/index.php?new=1&id=NULL'>обновите страницу</a> для создания новой группы";
			//$_GET['new']=0;
		}
	}
	if(!$q)
		die("Invalid query: ".mysql_error());
} 
function DeleteGroup($id)
{
	$q=mysql_query("SELECT * FROM `users` WHERE `Group`='$id'") or die("Invalid query: ".mysql_error());
	if(!$q){
	if($id != NULL)
		$dq=mysql_query("delete from `Groups` where `Id`=$id");
		(!$dq)or($_SESSION['msg']='Группа удалена успешно');
		} else{ $_SESSION['msg']='В удаляемой группе не должно быть пользователей!<br>Группа не может быть удалена!';}
	header("Location: groups/index.php");
}
?>