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

//echo $_POST['mode']." / ".$_POST['num']." / ".$_SESSION['user'];
//exit;

if ($_POST['mode'] == "no_recycle_bin"){ //삭제

	$sql = "select bo_public from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_POST['num'];
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);
	$public = $row['bo_public'];
	
	if ($public == 1){
		$sql = "delete from remember_short_url where mb_user = '".trim($_SESSION['user'])."' and bo_id = ".$_POST['num'];
		mysql_query($sql, $connect);
	}
	
	$sql = "delete from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_POST['num'];
	mysql_query($sql, $connect);

	//포인트
	get_point(trim($_SESSION['user']), $common_point_write * (-1), "메모장 글삭제");
	
	
	
	
	
	
}else if ($_POST['mode'] == "recycle_bin"){ //휴지통
	
	$sql = "update remember_board_".trim($_SESSION['user'])." set bo_recycle_bin = 9, bo_recycle_bin_date = now() where bo_id = ".$_POST['num'];
	mysql_query($sql, $connect);






}else if ($_POST['mode'] == "recycle"){ //휴지통 갔다온거

	for($i=0; $i<count($_POST['rec_num']); $i++) {
	
		//echo $_POST['rec_num'][$i]." / ";
	
		$sql = "select bo_public from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_POST['rec_num'][$i];
		$result = mysql_query($sql, $connect);
		$row = mysql_fetch_array($result);
		$public = $row['bo_public'];
		
		if ($public == 1){
			$sql = "delete from remember_short_url where mb_user = '".trim($_SESSION['user'])."' and bo_id = ".$_POST['rec_num'][$i];
			mysql_query($sql, $connect);
		}
		
		$sql = "delete from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_POST['rec_num'][$i];
		mysql_query($sql, $connect);
	
		//포인트
		get_point(trim($_SESSION['user']), $common_point_write * (-1), "메모장 글삭제");
		
	}	

}

mysql_close();

?>