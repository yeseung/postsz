<?
session_start();
header("content-type:text/html; charset=utf-8");
include_once ("lib/common.php");
include_once ("lib/dbconn.php");
include_once ("lib/function.php");

if ((!$_SESSION['user']) or (!$_GET['id'])){
	echo ("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");		
	exit;
}

if (eregi("[^0-9]", $_GET['id'])){
	echo ("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
	exit;
}

$tmp_sql = "select count(*) as cnt from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_GET['id'];
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt = $tmp_row['cnt'];

if ($cnt == 0){
	echo ("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");		
	exit;
	
}else{
	$tmp_sql = "select bo_recycle_bin from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_GET['id'];
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$bo_recycle_bin = $tmp_row['bo_recycle_bin'];
	
	if ($bo_recycle_bin == 9){
		echo("<script>
			window.alert('글이 존재하지 않습니다.\\n글이 삭제되었거나 이동된 경우입니다.');
			</script>");
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");		
		exit;
		
	}else{
		include_once ("skin/{$common_skin}/print/print.php");
	}

}
?>