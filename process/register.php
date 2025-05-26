<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

//$mb_id = trim(strip_tags(mysql_escape_string($_POST['id'])));

if ((!$_POST['id']) or (!$_POST['password'])){
	echo("<script>
		window.alert('잘못된 접근입니다.');
		location.href = '/';
		</script>");
	exit;
}
if(ereg("[^a-z0-9$]",$_POST['id'])){
	echo("<script>
		window.alert('잘못된 접근입니다.');
		location.href = '/';
		</script>");
	exit;
}

/*$sql = "select * from remember_member where mb_user='".trim($_POST['id'])."'";
$result = mysql_query($sql, $connect);
$num_record = mysql_num_rows($result);*/

$tmp_sql = "select count(*) as cnt from remember_member where mb_user = '".trim($_POST['id'])."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$user_cnt = $tmp_row['cnt'];
if ($user_cnt == 1){
	echo 0;
}else{

	$tmp_sql = "select count(*) as cnt from remember_member where mb_email = '".trim($_POST['email'])."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$email_cnt = $tmp_row['cnt'];
	if ($email_cnt != 0){
		echo 3;
	}else{

		$tmp_sql = "select count(*) as cnt from remember_boardset where bs_user_url = '".trim($_POST['id'])."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$user_url_cnt = $tmp_row['cnt'];
		if ($user_url_cnt == 1){
			echo 0;
		}else{
	
			$tmp_sql = "select count(*) as cnt from remember_member where mb_ip = '".$_SERVER['REMOTE_ADDR']."'";
			$tmp_result = mysql_query($tmp_sql, $connect);
			$tmp_row = mysql_fetch_array($tmp_result);
			$ip_cnt = $tmp_row['cnt'];
			
			if ($ip_cnt > $common_ip_exceed){
			//if ( ($_SERVER['REMOTE_ADDR'] != $common_my_ip) && ($ip_cnt > 2) ){
				echo 2;
				exit;
			}else{
			
				$tmp_sql = "select max(mb_id) as max_mb_id from remember_member";
				$tmp_result = mysql_query($tmp_sql, $connect);
				$tmp_row = mysql_fetch_array($tmp_result);
				$max_mb_id = $tmp_row['max_mb_id'] + 1;
			
				$sql = "insert into remember_member (mb_id, mb_user, mb_password, mb_email, mb_updated_date, mb_ip, mb_agent, mb_nick) ";
				$sql .= "values (".$max_mb_id.", '".trim($_POST['id'])."', password('".$_POST['password']."'), '".$_POST['email']."', now(), '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['HTTP_USER_AGENT']."', '".trim($_POST['id'])."')";
				mysql_query($sql, $connect);
				
				$sql = "CREATE TABLE `remember_board_".trim($_POST['id'])."` (";
				$sql .= "  `bo_id` int(11) NOT NULL auto_increment,";
				$sql .= "  `bo_public` tinyint(1) NOT NULL default '0',";
				$sql .= "  `su_short_url` varchar(20) NOT NULL default '',";
				$sql .= "  `ct_category_code` char(4) default NULL,";
				$sql .= "  `bo_content` longtext default NULL,";
				$sql .= "  `bo_date` datetime NOT NULL default '0000-00-00 00:00:00',";
				$sql .= "  `bo_hit` int(11) NOT NULL default '0',";
				$sql .= "  `bo_ip` varchar(50) default NULL,";
				$sql .= "  `bo_good` int(11) NOT NULL default '0',";
				$sql .= "  `bo_nogood` int(11) NOT NULL default '0',";
				$sql .= "  `bo_option` varchar(25) NOT NULL default '0|0|0|0|1|0|0|0|0|0|0|0|0',";
				$sql .= "  `bo_security_pass` varchar(255) default NULL,";
				$sql .= "  `bo_recycle_bin` tinyint(1) NOT NULL default '0',";
				$sql .= "  `bo_recycle_bin_date` datetime NOT NULL default '0000-00-00 00:00:00',";
				$sql .= "  PRIMARY KEY  (`bo_id`),";
				$sql .= "  UNIQUE KEY (`su_short_url`)";
				$sql .= ") ENGINE=MyISAM";
				mysql_query($sql, $connect);
				
				$short_url_random = get_rand($common_short_url);
				
				/*$sql = "insert into remember_board_".trim($_POST[id])." (bo_id, bo_public, su_short_url, bo_content, bo_date, bo_ip) ";
				$sql .= "values (1, 0, '".$short_url_random."', '".trim($_POST[id])."님, 환영합니다.\n\n\너무 간단한 무료 가입\n페이스북 연동하기.\n";
				$sql .= "또는\n아이디, e-메일, 비밀번호. 딱 셋가지만.\n\n";
				$sql .= "깔끔해진 메모 관리 웹/모바일 서비스\n나만의 아이디어와 생각들, 간단한 메모, 일기쓰기, 여행기록, 체크리스트, 쇼핑리스트, ";
				$sql .= "기록을 좋아하시는 분이나, 업무/학업상 평소에 메모를 많이 하시던 분, 수집광 등. \n\n";
				$sql .= "주요기능\n개인PC와 모바일 환경 사용이 가능. (동기화가 없습니다.) \n자신만의 공간.\n비공개로 메모 작성.\n메모 검색.\n";
				$sql .= "인쇄하기.\n공유하기. (짧은 주소 사용, SNS 바로 보내기, 리플, QR코드 등 사용)\n\n";
				$sql .= "사용자 인터페이스\n쉽고 편한 사용법.\n가로보기 지원. (모바일웹)\n\n";
				$sql .= "비밀번호나 계좌번호를 비롯한 중요한 개인 정보 보안에 유의하시기 바랍니다.', ";
				$sql .= "now(), '".$_SERVER['REMOTE_ADDR']."')";
				mysql_query($sql, $connect);*/
				
				$sql = "insert into remember_board_".trim($_POST[id])." (bo_id, bo_public, su_short_url, bo_content, bo_date, bo_ip, bo_option) ";
				$sql .= "values (1, 0, '".$short_url_random."', '<strong>".trim($_POST[id])."님, 환영합니다.</strong><br /><br />";
				$sql .= "<strong>너무 간단한 무료 가입</strong><br />페이스북/트위터/구글+ 연동하기.<br />";
				$sql .= "또는<br />아이디, e-메일, 비밀번호. 딱 셋가지만.<br /><br />";
				$sql .= "<strong>깔끔해진 메모 관리 웹/모바일 서비스</strong><br />나만의 아이디어와 생각들, 간단한 메모, 일기쓰기, 여행기록, 체크리스트, 쇼핑리스트, ";
				$sql .= "기록을 좋아하시는 분이나, 업무/학업상 평소에 메모를 많이 하시던 분, 수집광 등. <br /><br />";
				$sql .= "<strong>주요기능</strong><br />개인PC와 모바일 환경 사용이 가능. (동기화가 없습니다.) <br />자신만의 공간.<br />비공개로 메모 작성.<br />메모 검색.<br />";
				$sql .= "인쇄하기.<br />공유하기. (짧은 주소 사용, SNS 바로 보내기, 리플, QR코드 등 사용)<br /><br />";
				$sql .= "<strong>사용자 인터페이스</strong><br />쉽고 편한 사용법.<br />가로보기 지원. (모바일웹)<br /><br />";
				$sql .= "<strong>비밀번호나 계좌번호를 비롯한 중요한 개인 정보 보안에 유의하시기 바랍니다.</strong>', ";
				$sql .= "now(), '".$_SERVER['REMOTE_ADDR']."', '0|0|0|0|0|0|0|0|0|0|0|0|0')";
				mysql_query($sql, $connect);
				
				/*$tmp_sql = "select max(su_id) as max_su_id from remember_short_url";
				$tmp_result = mysql_query($tmp_sql, $connect);
				$tmp_row = mysql_fetch_array($tmp_result);
				$su_id = $tmp_row['max_su_id'] + 1;
					
				$sql = "insert into remember_short_url (su_id, su_short_url, mb_user, bo_id, su_date) ";
				$sql .= "values (".$su_id.", '".$short_url_random."', '".trim($_POST[id])."', 1, now())";
				mysql_query($sql, $connect);*/
				
				//myfriend
				$tmp_sql = "select max(fr_id) as max_fr_id from remember_myfriends";
				$tmp_result = mysql_query($tmp_sql, $connect);
				$tmp_row = mysql_fetch_array($tmp_result);
				$fr_id = $tmp_row['max_fr_id'] + 1;
					
				$sql = "insert into remember_myfriends (fr_id, mb_user, fr_target_user, fr_date) ";
				$sql .= "values (".$fr_id.", 'admin', '".trim($_POST[id])."', now())";
				mysql_query($sql, $connect);
				
				//open API
				$openapikey = substr(md5(date("YmdHis")), 0, 20).get_rand(5, "lower");
				$openapisecret = substr(md5(trim($_POST['id'])), 0, 20).get_rand(5, "lower");
				
				//set		
				$tmp_sql = "select max(bs_id) as max_bs_id from remember_boardset";
				$tmp_result = mysql_query($tmp_sql, $connect);
				$tmp_row = mysql_fetch_array($tmp_result);
				$max_bs_id = $tmp_row['max_bs_id'] + 1;
				
				$sql = "insert into remember_boardset (bs_id, mb_user, bs_subject, bs_user_url, bs_openapikey, bs_openapisecret) ";
				$sql .= "values (".$max_bs_id.", '".trim($_POST['id'])."', '".trim($_POST['id'])."\'z', '".trim($_POST['id'])."', '".$openapikey."', '".$openapisecret."')";
				//$sql .= "values (".$max_bs_id.", '".trim($_POST['id'])."', '".trim($_POST['id'])."님, 환영합니다.')";
				$result = mysql_query($sql, $connect);
				
				if ($result) {
					$sql = "select * from remember_boardset where mb_user = '".trim($_POST['id'])."'";
					$result = mysql_query($sql, $connect);
					$row = mysql_fetch_array($result);
					$_SESSION['set_subject'] = $row['bs_subject'];
					$setting_explode = explode("|", $row['bs_setting']);
					$_SESSION['set_scrolling'] = $setting_explode[0];
					$_SESSION['set_wysiwyg'] = $setting_explode[1];
					$_SESSION['set_security'] = $setting_explode[2];
					$_SESSION['set_open'] = $setting_explode[3];
					$_SESSION['set_recycle_bin'] = $setting_explode[4];
					$rows_explode = explode("|", $row['bs_rows']);
					$_SESSION['set_rows'] = $rows_explode[0];
					$_SESSION['set_rows_m'] = $rows_explode[1];
					$skin_explode = explode("|", $row['bs_skin']);
					$_SESSION['set_skin'] = $skin_explode[0];
					$_SESSION['set_skin_m'] = $skin_explode[1];
					$_SESSION['set_user_url'] = $row['bs_user_url'];
					
					//open API
					$_SESSION['set_openapikey'] = $row['bs_openapikey'];
					$_SESSION['set_openapisecret'] = $row['bs_openapisecret'];
					$_SESSION['set_openapi_hit'] = $row['bs_openapi_hit'];
				}
				
				//포인트 합계
				$_SESSION['point'] = get_point_sum(trim($_POST['id']));
				
				$_SESSION['user'] = trim($_POST['id']);
				$_SESSION['level'] = 0;
				$_SESSION['nick'] = trim($_POST['id']);
				$_SESSION['updated_date'] = date("Y-m-d H:i:s");
				
				//포인트
				get_point(trim($_SESSION['user']), $common_point_register, "회원가입");
				get_point(trim($_SESSION['user']), $common_point_write, "메모장 글쓰기");

				//로그인 기록 
				get_login_history(trim($_SESSION['user']));
				
				echo 1;
				
			} //if ($ip_cnt > $common_ip_exceed){
		} //if ($user_url_cnt == 1){
	} //if ($email_cnt == 1){			
} //if ($user_cnt == 1){

mysql_close();


?>