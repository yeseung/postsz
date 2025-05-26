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







if ($_POST['mode'] == "del"){
	
	for($i=0; $i<count($_POST['del']); $i++) {
	
		//echo $_POST['del'][$i]." / ";
		
		$sql = "select bo_public from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_POST['del'][$i];
		$result = mysql_query($sql, $connect);
		$row = mysql_fetch_array($result);
		$public = $row['bo_public'];
		
		if ($public == 1){
			$sql = "delete from remember_short_url where mb_user = '".trim($_SESSION['user'])."' and bo_id = ".$_POST['del'][$i];
			mysql_query($sql, $connect);
		}
		
		$sql = "delete from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_POST['del'][$i];
		mysql_query($sql, $connect);
	
		//포인트
		get_point(trim($_SESSION['user']), $common_point_write * (-1), "메모장 글삭제");
		
	
	} //for($i=0; $i<count($_POST['del']); $i++) {
		





}


mysql_close();


?>