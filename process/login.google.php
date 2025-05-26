<?

$sql = "select mb_level, mb_login_cnt, mb_nick, mb_updated_date from remember_member where mb_user='".trim($_SESSION['gg_id'])."'";
$result = mysql_query($sql, $connect);
$num_record = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$mb_level = $row['mb_level'];
$mb_login_cnt_plus = $row['mb_login_cnt'] + 1;
$mb_nick = $row['mb_nick'];
$mb_updated_date = $row['mb_updated_date'];

if ($num_record == 1){

	$sql = "update remember_member set mb_email = '".trim($_SESSION['gg_email'])."', mb_date = now(), mb_ip = '".$_SERVER['REMOTE_ADDR']."', mb_agent = '".$_SERVER['HTTP_USER_AGENT']."', mb_login_cnt = ".$mb_login_cnt_plus.", mb_thumbnail = '".trim($_SESSION['gg_picture'])."', mb_level = 1 where mb_user = '".trim($_SESSION['gg_id'])."'";
	mysql_query($sql, $connect);
	
	$sql = "select * from remember_boardset where mb_user = '".trim($_SESSION['gg_id'])."'";
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
	
	//포인트 합계
	$_SESSION['point'] = get_point_sum(trim($_SESSION['gg_id']));
	
	$_SESSION['user'] = trim($_SESSION['gg_id']);
	$_SESSION['level'] = $mb_level;
	$_SESSION['nick'] = $mb_nick;
	$_SESSION['updated_date'] = $mb_updated_date;
	
	//포인트
	get_point(trim($_SESSION['user']), $common_point_login, "로그인");
	
	//로그인 기록 
	get_login_history(trim($_SESSION['user']));
	
	
	
	
	
	
	
	
	
	
	
	
	
}else{


	$tmp_sql = "select max(mb_id) as max_mb_id from remember_member";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$max_mb_id = $tmp_row['max_mb_id'] + 1;
	
	$sql = "insert into remember_member (mb_id, mb_user, mb_email, mb_updated_date, mb_ip, mb_agent, mb_facebook, mb_nick, mb_thumbnail, mb_level, mb_open_mailling) ";
	$sql .= "values (".$max_mb_id.", '".trim($_SESSION['gg_id'])."', '".trim($_SESSION['gg_email'])."', now(), '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['HTTP_USER_AGENT']."', 3, '".trim($_SESSION['gg_name'])."', '".trim($_SESSION['gg_picture'])."', 1, 1|0)";
	mysql_query($sql, $connect);
	
	$sql = "CREATE TABLE `remember_board_".trim($_SESSION['gg_id'])."` (";
	$sql .= "  `bo_id` int(11) NOT NULL auto_increment,";
	$sql .= "  `bo_public` tinyint(1) NOT NULL default '0',";
	$sql .= "  `su_short_url` varchar(20) NOT NULL default '',";
	$sql .= "  `ct_category_code` char(4) default NULL,";
	$sql .= "  `bo_content` longtext default NULL,";
	$sql .= "  `bo_date` datetime NOT NULL default '0000-00-00 00:00:00',";
	$sql .= "  `bo_hit` int(11) NOT NULL default '0',";
	$sql .= "  `bo_ip` varchar(25) default NULL,";
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
	
	$sql = "insert into remember_board_".trim($_SESSION['gg_id'])." (bo_id, bo_public, su_short_url, bo_content, bo_date, bo_ip, bo_option) ";
	$sql .= "values (1, 0, '".$short_url_random."', '<strong>".trim($_SESSION['gg_name'])."님, 환영합니다.</strong><br /><br />";
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
	
	//myfriend
	$tmp_sql = "select max(fr_id) as max_fr_id from remember_myfriends";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$fr_id = $tmp_row['max_fr_id'] + 1;
		
	$sql = "insert into remember_myfriends (fr_id, mb_user, fr_target_user, fr_date) ";
	$sql .= "values (".$fr_id.", 'admin', '".trim($_SESSION['gg_id'])."', now())";
	mysql_query($sql, $connect);
	
	//open API
	$openapikey = substr(md5(date("YmdHis")), 0, 20).get_rand(5, "lower");
	$openapisecret = substr(md5(trim($_SESSION['gg_id'])), 0, 20).get_rand(5, "lower");
	
	//set
	$tmp_sql = "select max(bs_id) as max_bs_id from remember_boardset";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$max_bs_id = $tmp_row['max_bs_id'] + 1;
	
	//내주소
	$tmp_email = explode("@", trim($_SESSION['gg_email']));
	$tmp_user_url = substr(str_replace(".", "_", $tmp_email[0]), 0, 20);
	
	$tmp_sql = "select count(*) as cnt from remember_boardset where bs_user_url='".$tmp_user_url."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$user_cnt = $tmp_row['cnt'];
	
	if ($user_cnt == 1){
		$sql = "insert into remember_boardset (bs_id, mb_user, bs_subject, bs_user_url, bs_openapikey, bs_openapisecret) ";
		$sql .= "values (".$max_bs_id.", '".trim($_SESSION['gg_id'])."', '".trim($_SESSION['gg_name'])."\'z', '".substr($tmp_user_url, 0, 15).get_rand(5, 'num')."', '".$openapikey."', '".$openapisecret."')";
	}else{
		$sql = "insert into remember_boardset (bs_id, mb_user, bs_subject, bs_user_url, bs_openapikey, bs_openapisecret) ";
		$sql .= "values (".$max_bs_id.", '".trim($_SESSION['gg_id'])."', '".trim($_SESSION['gg_name'])."\'z', '".$tmp_user_url."', '".$openapikey."', '".$openapisecret."')";
	}
	$result = mysql_query($sql, $connect);
	
	if ($result) {
		$sql = "select * from remember_boardset where mb_user = '".trim($_SESSION['gg_id'])."'";
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
	$_SESSION['point'] = get_point_sum(trim($_SESSION['gg_id']));
	
	$_SESSION['user'] = trim($_SESSION['gg_id']);
	$_SESSION['level'] = 3;
	$_SESSION['nick'] = trim($_SESSION['gg_name']);
	$_SESSION['updated_date'] = date("Y-m-d H:i:s");
	
	//포인트
	get_point(trim($_SESSION['user']), $common_point_register, "회원가입");
	get_point(trim($_SESSION['user']), $common_point_write, "메모장 글쓰기");
	
	//로그인 기록 
	get_login_history(trim($_SESSION['user']));

	
	
}

header('Location: /');

mysql_close();

?>	