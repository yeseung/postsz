<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

//echo $_GET['id']." / ".$_GET['no'];
$no = trim($_GET['no']);

$tmp_sql = "select count(*) as cnt from remember_notice_board where nb_id = ".trim($_GET['id']);
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
if (!$tmp_row['cnt']){
	echo ("<script>
		window.alert('웹 페이지를 표시할 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
	exit;
}


$sql = "select nb_link_{$no} from remember_notice_board where nb_id = ".trim($_GET['id']);
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);
$nb_link = $row['0'];

if ($nb_link != ""){
	if ($_COOKIE["nb_hit_{$_GET[id]}_{$no}"] != $_GET['id']){
		$sql = "update remember_notice_board set nb_link_hit_{$no} = nb_link_hit_{$no} + 1 where nb_id = ".trim($_GET['id']);
		mysql_query($sql, $connect);
		setcookie("nb_hit_{$_GET[id]}_{$no}", "{$_GET[id]}", time() + 3600);
	}
	echo ("<meta http-equiv=\"refresh\" content=\"0; url={$nb_link}\">");			
	exit;
}




?>