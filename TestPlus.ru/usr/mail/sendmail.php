<? 
session_start();
include ("../../link.php");
if(isset($_POST)){
$mail=$_POST['mailto'];
$content=substr(htmlspecialchars(trim($_POST['mail_content'])), 0, 1000);
$title=substr(htmlspecialchars(trim($_POST['mail_title'])), 0, 1000);
$from=CheckName($_SESSION['login']);
if(mail($mail,$title,$content,'From:'.$from))
	$_SESSION['msg']='Письмо успешно отправлено<br>';
else $_SESSION['msg']='Ошибка отправки<br>';
header("Location: index.php");
}
?>