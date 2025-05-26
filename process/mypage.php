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

//인증메일
$tmp_sql = "select mb_level from remember_member where mb_user = '".trim($_SESSION['user'])."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$tmp_level = $tmp_row['mb_level'];


$open_mailling = $_POST['open_text']."|".$_POST['mailling_text'];


if ($_SESSION['fb_facebook'] == 0){
	
	$sql = "update remember_member set ";
	if ($tmp_level == 0) $sql .= "mb_email = '".$_POST['email']."', ";
	if ($_POST['thumbnail_del_text'] == "thumbnail_del") $sql .= "mb_thumbnail = '', ";
	$sql .= "mb_password = password('".$_POST['password']."'), ";
	$sql .= "mb_nick = '".$_POST['nickname']."', ";
	$sql .= "mb_open_mailling = '".$open_mailling."', ";
	$sql .= "mb_profile = '".$_POST['profile']."' ";
	$sql .= "where mb_user = '".trim($_SESSION['user'])."'";
	mysql_query($sql, $connect);
	

}else if ($_SESSION['fb_facebook'] == 1){ //facebook

	$sql = "update remember_member set mb_nick = '".$_POST['nickname']."', ";
	$sql .= "mb_open_mailling = '".$open_mailling."', ";
	$sql .= "mb_profile = '".$_POST['profile']."' ";
	$sql .= "where mb_user = '".trim($_SESSION['user'])."'";
	mysql_query($sql, $connect);


}else if ($_SESSION['fb_facebook'] == 2){ //twitter

	$sql = "update remember_member set ";
	if ($tmp_level == 0) $sql .= "mb_email = '".$_POST['email']."', ";
	$sql .= "mb_nick = '".$_POST['nickname']."', ";
	$sql .= "mb_open_mailling = '".$open_mailling."', ";
	$sql .= "mb_profile = '".$_POST['profile']."' ";
	$sql .= "where mb_user = '".trim($_SESSION['user'])."'";
	mysql_query($sql, $connect);


}else if ($_SESSION['fb_facebook'] == 3){ //google

	$sql = "update remember_member set ";
	if ($tmp_level == 0) $sql .= "mb_email = '".$_POST['email']."', ";
	$sql .= "mb_nick = '".$_POST['nickname']."', ";
	$sql .= "mb_open_mailling = '".$open_mailling."', ";
	$sql .= "mb_profile = '".$_POST['profile']."' ";
	$sql .= "where mb_user = '".trim($_SESSION['user'])."'";
	mysql_query($sql, $connect);


}



$_SESSION['nick'] = $_POST['nickname'];

mysql_close();


//echo "email : ".$_POST['email']." / password : ".$_POST['password']." / mailling_text : ".$_POST['mailling_text']." / open_text : ".$_POST['open_text'];

?>