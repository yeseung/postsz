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





}else if ($_POST['mode'] == "del"){
	
	for($i=0; $i<count($_POST['del']); $i++) {
		$sql = "delete from remember_login_history where lh_id = ".$_POST['del'][$i];
		mysql_query($sql, $connect);
	}
		





}


mysql_close();

?>