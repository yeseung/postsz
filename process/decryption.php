<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

//echo $_POST['pass']." / ". $_POST['contentstr'];

if( ($_POST['user'] == "") && ($_POST['num'] == "") ){
	echo("<script>
		window.alert('잘못된 접근입니다..');
		location.href = '/';
		</script>");
	exit;
}


$sql = "select bo_content from remember_board_".trim($_POST['user'])." where bo_id = ".$_POST['num'];
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);
$bo_content = $row['bo_content'];

$key = $_POST['pass'];
$decryption = mcrypt_decryption($bo_content);


echo $decryption;





?>