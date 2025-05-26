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




//echo $_POST['mode']." / ".$_POST['user']." / ".$_POST['num']." / ".$_POST['short_url'];
//exit;


if ($_POST['mode'] == "write"){

	$tmp_sql = "select count(*) as cnt from remember_scrap where mb_user = '".trim($_SESSION['user'])."' and ";
	$tmp_sql .= "sc_table_user = '".trim($_POST['user'])."' and bo_id = ".$_POST['num']." and su_short_url = '".trim($_POST['short_url'])."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	
	if ($tmp_row['cnt'] != 0){
		echo 0;
	}else{
	
		$tmp_sql = "select max(sc_id) as max_sc_id from remember_scrap";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$sc_id = $tmp_row['max_sc_id'] + 1;
				
		$sql = "insert into remember_scrap (sc_id, mb_user, sc_table_user, bo_id, su_short_url, sc_date) ";
		$sql .= "values (".$sc_id.", '".trim($_SESSION['user'])."', '".trim($_POST['user'])."', '".$_POST['num']."', '".trim($_POST['short_url'])."', now())";
		mysql_query($sql, $connect);
		
		/*스크랩수
		$tmp_sql = "select max(su_scrap) as max_su_scrap from remember_short_url where su_short_url = '".trim($_POST['short_url'])."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$max_su_scrap = $tmp_row['max_su_scrap'] + 1;
		
		$sql = "update remember_short_url set su_scrap = ".$max_su_scrap." where su_short_url = '".trim($_POST['short_url'])."'";
		mysql_query($sql, $connect);
		*/


		echo 1;
	
	}






}else if ($_POST['mode'] == "del"){
	
	for($i=0; $i<count($_POST['del']); $i++) {
	
		/*스크랩수	
		$tmp_sql = "select su_short_url from remember_scrap where sc_id = ".$_POST['del'][$i]." and mb_user = '".trim($_SESSION['user'])."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$tmp_su_short_url = $tmp_row['su_short_url'];
		
		if (isset($tmp_su_short_url)){
			$tmp_sql = "select max(su_scrap) as max_su_scrap from remember_short_url where su_short_url = '".trim($tmp_su_short_url)."'";
			$tmp_result = mysql_query($tmp_sql, $connect);
			$tmp_row = mysql_fetch_array($tmp_result);
			$max_su_scrap = $tmp_row['max_su_scrap'];
			if ($max_su_scrap == 0) $max_su_scrap_minus = 0; else $max_su_scrap_minus = $max_su_scrap - 1;	

			$sql = "update remember_short_url set su_scrap = ".$max_su_scrap_minus." where su_short_url = '".trim($tmp_su_short_url)."'";
			mysql_query($sql, $connect);
		}
		*/
		
		$sql = "delete from remember_scrap where sc_id = ".$_POST['del'][$i]." and mb_user = '".trim($_SESSION['user'])."'";
		mysql_query($sql, $connect);
	
	} //for($i=0; $i<count($_POST['del']); $i++) {
		





}


mysql_close();


?>