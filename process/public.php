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



if ($_POST['mode'] == "closed"){
	
	$sql = "delete from remember_short_url where mb_user = '".trim($_SESSION['user'])."' and bo_id = ".$_POST['num'];
	mysql_query($sql, $connect);
	
	$public_temp = 0;
	
	$sql = "update remember_board_".trim($_SESSION['user'])." set bo_public = ".$public_temp.", bo_date = now() ";
	$sql .= "where bo_id = ".$_POST['num'];
	mysql_query($sql, $connect);
	
	echo 0;
	
}else if ($_POST['mode'] == "public"){

	$short_url_random = get_rand($common_short_url);

	$tmp_sql = "select count(*) as cnt from remember_short_url where su_short_url = '".$short_url_random."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$cnt = $tmp_row['cnt'];
	
	if ($cnt == 0){
	
		$tmp_sql = "select max(su_id) as max_su_id from remember_short_url";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$su_id = $tmp_row['max_su_id'] + 1;
		
		$sql = "insert into remember_short_url (su_id, su_short_url, mb_user, bo_id, su_date) ";
		$sql .= "values (".$su_id.", '".$short_url_random."', '".trim($_SESSION['user'])."', ".$_POST['num'].", now())";
		mysql_query($sql, $connect);

		$public_temp = 1;
		
		$sql = "update remember_board_".trim($_SESSION['user'])." set bo_public = ".$public_temp.", su_short_url = '".$short_url_random."', bo_date = now() ";
		$sql .= "where bo_id = ".$_POST['num'];
		mysql_query($sql, $connect);
		
		
		echo 0;
		
	}else{
		echo 1; //에러가 발생하였습니다. \\n문제가 계속되는 경우에는 시스템 관리자에게 문의하십시오.
	}
	
}



mysql_close();


?>