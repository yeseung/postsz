<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");


if (!$_SESSION['user']){
	echo("<script>
		window.alert('잘못된 접근입니다.')
		history.go(-1)
		</script>");
	exit;
}


$option = $_POST['comments']."|".$_POST['recommendations']."|".$_POST['sns']."|".$_POST['qrcode']."|".$_POST['html']."|0|0|0|0|0|0|0|0";



$sql = "update remember_board_".trim($_SESSION['user'])." set bo_option = '".$option."' ";
$sql .= "where bo_id = ".$_POST['num'];
mysql_query($sql, $connect);

mysql_close();


?>