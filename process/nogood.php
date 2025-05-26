<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");


$sql = "update remember_board_".$_POST['user']." set bo_".$_POST['mode']." = bo_".$_POST['mode']." + 1 where bo_id = ".$_POST['num'];
mysql_query($sql, $connect);

mysql_close();   
?>