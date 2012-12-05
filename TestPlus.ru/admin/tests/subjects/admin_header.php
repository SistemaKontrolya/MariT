<?php
include("../../../db_fns.php");
include("../../../funcs.php");
CheckUser("adm");
$db=db_connect();
if(!$db)
echo "error db connect <br>";

if(isset($_SESSION['login'])){
	$name=$_SESSION['login'];
	$usr_name=CheckName($name);
	}
else {
	SessionOff();
}
?>