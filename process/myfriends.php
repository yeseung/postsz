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

if ($_SESSION['user'] == $_POST['target_user']){
	echo("<script>
		window.alert('자신을 등록할 순 없습니다.')
		history.go(-1)
		</script>");
	exit;
}


if ($_POST['mode'] == "add"){

	$tmp_sql = "select count(*) as cnt from remember_myfriends where mb_user='".trim($_SESSION['user'])."' and fr_target_user='".trim($_POST['target_user'])."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$friend_cnt = $tmp_row['cnt'];
	
	if ($friend_cnt == 1){
		echo 0;
		exit;
	}else{
		
		$tmp_sql = "select max(fr_id) as max_fr_id from remember_myfriends";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$fr_id = $tmp_row['max_fr_id'] + 1;
		
		$sql = "insert into remember_myfriends (fr_id, mb_user, fr_target_user, fr_date) ";
		$sql .= "values (".$fr_id.", '".trim($_SESSION['user'])."', '".trim($_POST['target_user'])."', now())";
		mysql_query($sql, $connect);
		
		echo 1;
	
	}

}else if ($_POST['mode'] == "del"){
	
	$sql = "delete from remember_myfriends where mb_user = '".trim($_SESSION['user'])."' and fr_target_user = '".trim($_POST['target_user'])."'";
	mysql_query($sql, $connect);

}


mysql_close();


?>