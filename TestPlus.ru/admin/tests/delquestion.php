<?php
session_start();
include "admin_header.php";
$id=$_GET['id'];
if(isset($id))
	DeleteQuestion($id);
header("Location: http://testplus.ru/admin/tests/index.php?subject=1&choise=OK&showquestions=1&id=1");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>�������� �������</title>
</head>
<body>
���� �� ������ ��� ��������, ��������� ������. ���������� � ���������� ���������.
</body></html>
