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
</head>
<body>
<?include ("../admin_header.php");?>

<?php
/*
$to = ""; 
// емайл получателя 

$subject = "Проверка отправки писем"; 
// тема письма 

$message = "Здравствуйте
Если вы читаете это письмо значит все ок
Почтовый робот"; 
// текст сообщения 

$mailheaders = "Content-type:text/plain;charset=windows-1251rn"; 
$mailheaders .= "From: SiteRobot <>rn"; 
$mailheaders .= "Reply-To: rn"; 
// почтовые заголовки

$mailheaders .= "Bcc: rn"; 
$mailheaders .= "Bcc: rn"; 
// заголовков Bcc может быть неограниченное количество

mail($to, $subject, $message, $mailheaders);
// отправляем письмо 
*/
?>

</body>
</html>