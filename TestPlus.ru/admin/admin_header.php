<?
CheckUser("adm");
if(isset($_SESSION['login'])){
	$name=$_SESSION['login'];
	$usr_name=CheckName($name);
	}
else {
	SessionOff();
}
?>