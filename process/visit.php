<?
/*session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");*/

// 컴퓨터의 아이피와 쿠키에 저장된 아이피가 다르다면 테이블에 반영함
	//if (get_cookie('ck_visit_ip') != $_SERVER['REMOTE_ADDR']) {
   //set_cookie('ck_visit_ip', $_SERVER['REMOTE_ADDR'], 86400); // 하루동안 저장

if ($_SERVER['REMOTE_ADDR'] != $common_my_ip){ //my com


	if ($_COOKIE["remember_visit"] != $_SERVER['REMOTE_ADDR']){
		//setcookie("bopeep_visit", $_SERVER['REMOTE_ADDR'], 86400);
		setcookie("remember_visit", $_SERVER['REMOTE_ADDR'], time() + 43200);
		//12시 43200 / 6시 21600 / 3시 10800 / 1시 3600
		
		$date = date("Y-m-d");
		$time = date("H:i:s");
		
		//echo $date." / ".$time;
		//exit;
		
		$tmp_sql = "select max(vi_id) as max_vi_id from remember_visit";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$vi_id = $tmp_row[max_vi_id]+1;
		
		$sql = "insert into remember_visit (vi_id, vi_ip, vi_date, vi_time, vi_referer, vi_agent ) values ";
		$sql .= "(".$vi_id.", '".$_SERVER['REMOTE_ADDR']."', '".$date."', '".$time."', '".$_SERVER['HTTP_REFERER']."', '".$_SERVER['HTTP_USER_AGENT']."')";
		$result = mysql_query($sql, $connect);
		
		if ($result) {
	   
		$sql = "insert remember_visit_sum (vs_count, vs_date) values (1, '".$date."') ";
		$result = mysql_query($sql, $connect);
		
	
		   if (!$result) {
		   $sql = "update remember_visit_sum set vs_count = vs_count + 1 where vs_date = '".$date."' ";
		   $result = mysql_query($sql, $connect);
		   }
	 
			// INSERT, UPDATE 된건이 있다면 기본환경설정 테이블에 저장
			// 방문객 접속시마다 따로 쿼리를 하지 않기 위함 (엄청난 쿼리를 줄임 ^^)
	
			// 오늘
			$sql = "select vs_count as cnt from remember_visit_sum where vs_date = '".$date."'";
			$result = mysql_query($sql, $connect);
			$row = mysql_fetch_array($result);
			$vi_today = $row[cnt];
	
			// 어제
			$sql = "select vs_count as cnt from remember_visit_sum where vs_date = DATE_SUB('".$date."', INTERVAL 1 DAY)";
			$result = mysql_query($sql, $connect);        
			$row = mysql_fetch_array($result);
			$vi_yesterday = $row[cnt];
	
			// 최대
			$sql = "select max(vs_count) as cnt from remember_visit_sum";
			$result = mysql_query($sql, $connect);
			$row = mysql_fetch_array($result);
			$vi_max = $row[cnt];
	
			// 전체
			//$sql = " select count(*) as cnt from visit_table ";
			$sql = "select sum(vs_count) as total from remember_visit_sum";
			$result = mysql_query($sql, $connect); 
			$row = mysql_fetch_array($result);
			$vi_sum = $row[total];
	
			$visit = "오늘:$vi_today,어제:$vi_yesterday,최대:$vi_max,전체:$vi_sum";
			//$visit = $vi_today."|".$vi_yesterday."|".$vi_max."|".$vi_sum;
	
			// 기본설정 테이블에 방문자수를 기록한 후 
			// 방문자수 테이블을 읽지 않고 출력한다.
			// 쿼리의 수를 상당부분 줄임
			$sql = "update remember_visit_sum set vs_visit = '".$visit."' where vs_date = '".$date."'";
			mysql_query($sql, $connect);
		}
	}




} //if ($_SERVER['REMOTE_ADDR'] != "121.129.24.193"){
	
//mysql_close();   
    
?>