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



//echo $_POST['url']." / ".$_POST['url_user']." / ".$_POST['reason']." / ".$_POST['andsoon'];
//exit;

if ( ($_POST['reason'] == "") and ($_POST['andsoon'] == "") ){
	echo 2;
}else if ( ($_POST['reason'] == 9) and ($_POST['andsoon'] == "") ){
	echo 1;
}else{
	$tmp_sql = "select max(sp_id) as max_sp_id from remember_spam";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$sp_id = $tmp_row['max_sp_id'] + 1;
	
	$sql = "insert into remember_spam (sp_id, sp_url, sp_url_user, sp_from_user, sp_reason, sp_andsoon, sp_ip, sp_date) ";
	$sql .= "values (".$sp_id.", '".$_POST['url']."', '".$_POST['url_user']."', '".$_SESSION['user']."', ".$_POST['reason'].", '".$_POST['andsoon']."', ";
	$sql .= "'".$_SERVER['REMOTE_ADDR']."', now())";
	mysql_query($sql, $connect);
	
	echo 0;
}	


mysql_close();

?>