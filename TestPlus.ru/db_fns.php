<?php
function db_connect()
{
 $result=mysql_connect('127.0.0.1','root','');
 if(!$result)
	return false;
 mysql_query('SET NAMES utf8');
 mysql_query("set character_set_server=utf8");
 if(!mysql_select_db('syst_konrl'))
	return false;
 return $result;
}
?>