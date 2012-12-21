<?
session_start();
include ("../../link.php");
//обработка отправки fEditTrial
	if(isset($_POST['savetrial'])){
		if((isset($_POST['user']))&&(isset($_POST['test'])))
			if(MakeTrial($_POST['id'],$_POST['user'],$_POST['test'],$_POST['start'],$_POST['finish'],'',''))
				$_SESSION['msg']="Изменения сохранены успешно!<br>";
		header("Location: index.php");
	exit();
	}//сохранение тестовых испытаний по результатам отбора формы

	
//обракботчик fMakeTrial	
	
if(!isset($_POST['maketrial'])){
	$_SESSION['msg']="Ошибка сохранения!<br>";
	header("Location: index.php");
	exit();
}
//при неправильном заполнении выбрасываем:
if((!isset($_POST['check_user']))&&(!isset($_POST['check_group']))){
	$_SESSION['msg']="Ошибка: не выбраны пользователи! Невозможно сформировать задание <br>";
	header("Location: index.php");
	exit();
}
if((!isset($_POST['check_test']))&&(!isset($_POST['check_subj']))){
	$_SESSION['msg']="Ошибка: не выбран тест! Невозможно сформировать задание <br>";
	header("Location: index.php");
	exit();
}

//получаем результаты формы
if(isset($_POST['check_group'])) $arr_gr = $_POST['check_group'];
if(isset($_POST['check_user'])) $arr_users = $_POST['check_user'];
if(isset($_POST['check_subj'])) $arr_sub = $_POST['check_subj'];
if(isset($_POST['check_test'])) $arr_tests = $_POST['check_test'];
if(isset($_POST['start'])) $date_start = $_POST['start'];
if(isset($_POST['finish'])) $date_end = $_POST['finish'];
/* для отладки
  echo "groups: ";  print_r($arr_gr);
  echo "<br>users: "; print_r($arr_users);
  echo "<br>subjs: ";print_r($arr_sub);
  echo "<br>arr_tests: ";print_r ($arr_tests);
  echo "<br>start: ".$date_start." end: ".$date_end."<br>";
  */
  
 if(is_array($arr_gr)){ //если выбраны группы пользователей, разбираем полученный массив
 foreach($arr_gr as $ind=>$group_id){  //находим id пользователей по группе и записываем в массив users
	$get_users=mysql_query("SELECT `ID` FROM `users` WHERE `Group`='$group_id' AND `Simple_user`=1");
	$num_users=mysql_num_rows($get_users);
	for($i=0;$i<$num_users;$i++){
		$user=mysql_fetch_object($get_users);
		$users[]=$user->ID;
	}
 }
 }
if(is_array($arr_users)){ //если выбраны пользоыватели
 //обрабатываем полученных из формы пользователей: если такого еще нет в массиве users, добавляем значение
 foreach($arr_users as $index=>$user_id){
	$get_user=mysql_query("SELECT `ID` FROM `users` WHERE `ID`='$user_id'");
	$user=mysql_fetch_array($get_user);
	if(is_array($users)){
		if(!(in_array($user['ID'],$users))){
			$users[]=$user['ID'];
		} 
	} else $users[]=$user['ID'];
  }
 }
//для отладки echo '<br>users: '; print_r($users);
 if(is_array($arr_sub)){ //если выбраны темы, разбираем полученный массив
 foreach($arr_sub as $ind=>$subj_id){  //находим id пользователей по группе и записываем в массив users
	$get_tests=mysql_query("SELECT `ID` FROM `tests` WHERE `Subject`='$subj_id'");
	$num_tests=mysql_num_rows($get_tests);
	for($i=0;$i<$num_tests;$i++){
		$test=mysql_fetch_object($get_tests);
		$tests[]=$test->ID;
	}
  }
 }
 
 if(is_array($arr_tests)){ //если выбраны тесты, разбираем полученный массив
	foreach($arr_tests as $ind=>$test_id){
	$get_test=mysql_query("SELECT `ID` FROM `tests` WHERE `ID`='$test_id'");
	$test=mysql_fetch_array($get_test);
	if(is_array($tests)){  //если какие-то тесты уже записаны в массив
		if(!(in_array($test['ID'],$tests))){ //и если текущего теста в массиве еще нет
			$tests[]=$test['ID']; //то добавляем туда текущий тест
		} //если уже есть, ничего не делаем
	} else $tests[]=$test['ID']; //если массива еще нет, создаем и пишем туда текущий тест
 }
}
//для отладки echo '<br>tests: '; print_r($tests);
//далее для каждого пользователя из масива users формируем задание на все тесты из массива tests
for($i=0;$i<count($users);$i++){
	for($n=0;$n<count($tests);$n++){
		$num_created+=MakeTrial('',$users[$i],$tests[$n],$date_start,$date_end,0,1);
	}
}
//для отладки echo 'created: '.$num_created.' trials';
if($num_created ==(count($users)*count($tests))) 
	$_SESSION['msg']='Все записи по запросу сохранены успешно<br>';
else {
	if($num_created==0) $_SESSION['msg']='Новых записей не создано. Проверьте запрос, возможно задания уже существуют<br>';
	else $_SESSION['msg']='Не удалось сохранить некоторые записи. Проверьте запрос, возможно задания уже существуют<br>';
}
if(isset($_POST['makenotices']))
	SendNotice($date_start,$date_end);
header("Location: index.php");
?>
