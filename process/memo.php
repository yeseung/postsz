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




//echo $_POST['send_email']." / ".$_POST['message']." / ".$_POST['mode'];



if ($_POST['mode'] == "write"){

	$tmp_sql = "select count(*) as cnt from remember_member where mb_user='".trim($_POST['send_email'])."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$user_cnt = $tmp_row['cnt'];
	
	if ($user_cnt == 0){
		echo 0;
	}else{
	
		$tmp_sql = "select max(mm_id) as max_mm_id from remember_memo";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$mm_id = $tmp_row['max_mm_id'] + 1;
				
		$sql = "insert into remember_memo (mm_id, mb_user, mm_send_user, mm_memo, mm_send_date, mm_ip) ";
		$sql .= "values (".$mm_id.", '".trim($_SESSION['user'])."', '".trim($_POST['send_email'])."', '".$_POST['memo']."', now(), '".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sql, $connect);

		echo 1;
	
	}






}else if ($_POST['exec'] == "del_all"){
	
	for($i=0; $i<count($_POST['del']); $i++) {
		if ($_POST['mode'] == "recv"){
			$sql = "delete from remember_memo where mm_id = ".$_POST['del'][$i]." and mm_send_user = '".trim($_SESSION['user'])."'";
		}else if ($_POST['mode'] == "send"){	
			$sql = "delete from remember_memo where mm_id = ".$_POST['del'][$i]." and mb_user = '".trim($_SESSION['user'])."'";
		}
		mysql_query($sql, $connect);
	}
		





}else if ($_POST['exec'] == "del"){

	if ($_POST['mode'] == "recv"){
		$sql = "delete from remember_memo where mm_id = ".$_POST['del']." and mm_send_user = '".trim($_SESSION['user'])."'";
	}else if ($_POST['mode'] == "send"){	
		$sql = "delete from remember_memo where mm_id = ".$_POST['del']." and mb_user = '".trim($_SESSION['user'])."'";
	}
	mysql_query($sql, $connect);

}


mysql_close();


?>