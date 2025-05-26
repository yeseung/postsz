<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");


$tmp_sql = "select count(*) as cnt from remember_short_url where su_short_url = '".$_GET['short']."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt = $tmp_row['cnt'];

if ($cnt == 0){ 
	echo("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		location.href = '/';
		</script>");
	exit;
	//echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");
}else{
	Header("Location:".$common_path.$_GET['short']."");
	//echo ("<meta http-equiv=\"refresh\" content=\"0; url=\"".$common_path.$_GET['short']."\"\">");
}


?>