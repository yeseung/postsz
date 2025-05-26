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


/*for($i=0; $i<count($_POST['rec_num']); $i++) {
	echo $_POST['rec_num'][$i]." / ";
}
echo $_POST['mode'];
exit;*/



if ($_POST['mode'] == "recycle"){

	for($i=0; $i<count($_POST['rec_num']); $i++) {
		$sql = "update remember_board_".trim($_SESSION['user'])." set bo_recycle_bin = 0, bo_recycle_bin_date = '0000-00-00 00:00:00' where bo_id = ".$_POST['rec_num'][$i];
		mysql_query($sql, $connect);
	}

}


mysql_close();


?>