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


//echo $_POST['mode']." / ".$_POST['user']." / ".$_POST['point']." / ".$_POST['content'];
//exit;

if ($_POST['mode'] == "write"){

	$tmp_sql = "select count(*) as cnt from remember_member where mb_user='".trim($_POST['user'])."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$user_cnt = $tmp_row['cnt'];
	
	if ($user_cnt == 0){
		echo 1;
	}else{
		$tmp_sql = "select max(po_id) as max_po_id from remember_point";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$po_id = $tmp_row['max_po_id'] + 1;
	
		$sql = "insert into remember_point (po_id, mb_user, po_point, po_content, po_date) ";
		$sql .= "values (".$po_id.", '".trim($_POST['user'])."', ".$_POST['point'].", '".trim($_POST['content'])."', now() )";
		mysql_query($sql, $connect);
	
		echo 0;
	}



}else if ($_POST['mode'] == "del"){

	for($i=0; $i<count($_POST['del']); $i++) {
		//echo $_POST['del'][$i]." / ";
		$sql = "delete from remember_point where po_id = ".$_POST['del'][$i];
		mysql_query($sql, $connect);
	}



}else if ($_POST['mode'] == "update"){

	//$sql = "LOCK TABLES `remember_point` WRITE"; 
	//mysql_query($sql, $connect);

	$sql = "CREATE TABLE `remember_point_tmp` (";
	$sql .= "  `po_id` int(11) NOT NULL auto_increment,";
	$sql .= "  `mb_user` varchar(50) default NULL,";
	$sql .= "  `po_point` int(11) NOT NULL default '0',";
	$sql .= "  `po_content` varchar(255) default NULL,";
	$sql .= "  `po_date` datetime NOT NULL default '0000-00-00 00:00:00',";
	$sql .= "  PRIMARY KEY  (`po_id`)";
	$sql .= ") ENGINE=MyISAM";
	mysql_query($sql, $connect);

	$tmp_sql = "select mb_user from remember_member order by mb_updated_date";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$count = mysql_num_rows($tmp_result);
	
	while ($tmp_row = mysql_fetch_array($tmp_result)){
		$mb_user = $tmp_row['mb_user'];
		
		$tmp_sql1 = "select sum(po_point) as sum_point from remember_point where mb_user = '".$mb_user."'"; 
		$tmp_result1 = mysql_query($tmp_sql1, $connect);
		$tmp_row1 = mysql_fetch_array($tmp_result1);
		$sum_point = $tmp_row1['sum_point'];
		
		$sql = "insert into `remember_point_tmp` (mb_user, po_point, po_content, po_date) "; 
		$sql .= "values ('".$mb_user."', ".$sum_point.", '포인트 정리', now())";
		mysql_query($sql, $connect);
	}
	
	//$sql = "UNLOCK TABLES";
	//mysql_query($sql, $connect);
	
	$sql = "DROP TABLE `remember_point`";
	mysql_query($sql, $connect);
	
	$sql = "RENAME TABLE `remember_point_tmp` TO `remember_point`";
	mysql_query($sql, $connect);
		
	echo "총 {$count}건의 회원포인트 내역이 정리 되었습니다.";
	
	
	
	

}



mysql_close();




?>