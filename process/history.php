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




if ($_POST['mode'] == "write"){





}else if ($_POST['mode'] == "del"){
	
	for($i=0; $i<count($_POST['del']); $i++) {
		$sql = "delete from remember_login_history where lh_id = ".$_POST['del'][$i]." and mb_user = '".trim($_SESSION['user'])."'";
		mysql_query($sql, $connect);
	}
	
}

mysql_close();


?>