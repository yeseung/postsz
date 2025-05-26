<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if ($_SESSION['level'] != $common_admin_level){
	echo("<script>
		window.alert('관리자 메뉴입니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");			
	exit;	
}

if ($_SERVER['REMOTE_ADDR'] != $common_my_ip){ //my com
	echo("<script>
		window.alert('허용된 IP주소가 아닙니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");			
	exit;
}


if ($_POST['mode'] == "write"){


	$sql = "select mb_user from remember_member order by mb_updated_date"; 
	$result = mysql_query($sql, $connect); 
	
	while ($row = mysql_fetch_array($result)){ 
		$mb_user = $row['mb_user'];
		
		$tmp_sql = "select max(mm_id) as max_mm_id from remember_memo";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$mm_id = $tmp_row['max_mm_id'] + 1;
				
		$sql = "insert into remember_memo (mm_id, mb_user, mm_send_user, mm_notice, mm_memo, mm_send_date, mm_ip) ";
		$sql .= "values (".$mm_id.", '".trim($_SESSION['user'])."', '".$mb_user."', ".$_POST['notice'].", '".$_POST['memo']."', now(), '".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sql, $connect);
	
	}	






}else if ($_POST['mode'] == "del"){
	
	for($i=0; $i<count($_POST['del']); $i++) {
		$sql = "delete from remember_memo where mm_id = ".$_POST['del'][$i];
		mysql_query($sql, $connect);
	}
		





}


mysql_close();


?>