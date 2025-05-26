<?
session_start();
header("content-type:text/html; charset=utf-8");
include_once ("lib/common.php");
include_once ("lib/dbconn.php");
include_once ("lib/function.php");

if ((!$_GET['user']) or (!$_GET['id'])){
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

$tmp_sql = "select count(*) as cnt_user from remember_member where mb_user = '".trim($_GET['user'])."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt_user = $tmp_row['cnt_user'];

if ($cnt_user == 0){
	echo ("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");		
	exit;
	
}else{	

	$tmp_sql = "select count(*) as cnt from remember_board_".trim($_GET['user'])." where bo_id = ".$_GET['id'];
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
		$tmp_sql = "select bo_recycle_bin from remember_board_".trim($_GET['user'])." where bo_id = ".$_GET['id'];
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
	
			$sql = "select bo_public from remember_board_".trim($_GET['user'])." where bo_id = ".$_GET['id'];
			$result = mysql_query($sql, $connect);
			$row = mysql_fetch_array($result);
			$bo_public = $row['bo_public'];
			
			if($bo_public  == 1){
				include_once ("skin/{$common_skin}/print/print.short.php");
			}else{
				echo ("<script>
					window.alert('본 페이지는 열람하실 수 없습니다.');
					</script>");
				echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");		
				exit;
			}
		}
	}
	
	
} //if ($cnt_user == 0){
	
?>