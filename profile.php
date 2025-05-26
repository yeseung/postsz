<?
session_start();
header("content-type:text/html; charset=utf-8");
include_once ("lib/common.php");
include_once ("lib/dbconn.php");
include_once ("lib/function.php");

/*if ((!$_SESSION['user']) or (!$_GET['user'])){
	echo ("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");		
	exit;
}*/

/*$tmp_sql = "select count(*) as cnt from remember_member where mb_user = '".$_GET['user']."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt = $tmp_row['cnt'];

if ($cnt == 0){
	echo ("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");		
	exit;
	
}else{*/

	include_once ("skin/{$common_skin}/profile/main.php");	
	exit;


//}
?>