<?php
session_start();
include ("../../link.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Группы</title>
<style>
TD{padding-left: 5px;}
.names{background: #cccccc;}
</style>
</head>
<body>
<?
	$q = mysql_query("SELECT * FROM Groups") or die("Invalid query: " .mysql_error());
	if(!$q)
		echo "error select <br>";
	$n=mysql_num_rows($q);
	echo "<table border=1 cellspacing=0 class='groups' width='800px'>
	<thead><tr><td colspan='4' align='center' height='40px'>Группы пользователей</td></thead>
		<tr class='names'>
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
		<td>'.$name_group.'&nbsp;</td>
		<td>'.$superv.'&nbsp;</td>
		<td>'.$dept.'&nbsp;</td>
		<td>'.$comt.'&nbsp;</td>
		</tr>';
	}
	echo '</table>';
?>
</body></html>