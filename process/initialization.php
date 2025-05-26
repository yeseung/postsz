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

if ($_POST['mode'] == "initialize") {

	$passwd = trim($_POST['initialize_password']);
	$tmp_sql = "select password('".$passwd."') as db_passwd";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	
	$sql = "select mb_password, mb_level from remember_member where mb_user='".trim($_SESSION['user'])."'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);
	$mb_password = $row['mb_password'];
	
	if ($tmp_row['db_passwd'] == $mb_password){
	
		if ($row['mb_level'] == $common_admin_level) { //관리자
			echo 2;
			exit;
		}else{
			
			//메모장 DROP
			$sql = "DROP TABLE remember_board_".trim($_SESSION['user']);
			mysql_query($sql, $connect);
			
			//단축url
			$sql = "delete from remember_short_url where mb_user = '".trim($_SESSION['user'])."'";
			mysql_query($sql, $connect);
			
			//메모장 CREATE
			$sql = "CREATE TABLE `remember_board_".trim($_SESSION['user'])."` (";
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
			
			$sql = "insert into remember_board_".trim($_SESSION['user'])." (bo_id, bo_public, su_short_url, bo_content, bo_date, bo_ip, bo_option) ";
			$sql .= "values (1, 0, '".$short_url_random."', '<strong>".trim($_SESSION['nick'])."님, 환영합니다.</strong><br /><br />";
			$sql .= "<strong>너무 간단한 무료 가입</strong><br />페이스북/트위터 연동하기.<br />";
			$sql .= "또는<br />아이디, e-메일, 비밀번호. 딱 셋가지만.<br /><br />";
			$sql .= "<strong>깔끔해진 메모 관리 웹/모바일 서비스</strong><br />나만의 아이디어와 생각들, 간단한 메모, 일기쓰기, 여행기록, 체크리스트, 쇼핑리스트, ";
			$sql .= "기록을 좋아하시는 분이나, 업무/학업상 평소에 메모를 많이 하시던 분, 수집광 등. <br /><br />";
			$sql .= "<strong>주요기능</strong><br />개인PC와 모바일 환경 사용이 가능. (동기화가 없습니다.) <br />자신만의 공간.<br />비공개로 메모 작성.<br />메모 검색.<br />";
			$sql .= "인쇄하기.<br />공유하기. (짧은 주소 사용, SNS 바로 보내기, 리플, QR코드 등 사용)<br /><br />";
			$sql .= "<strong>사용자 인터페이스</strong><br />쉽고 편한 사용법.<br />가로보기 지원. (모바일웹)<br /><br />";
			$sql .= "<strong>비밀번호나 계좌번호를 비롯한 중요한 개인 정보 보안에 유의하시기 바랍니다.</strong>', ";
			$sql .= "now(), '".$_SERVER['REMOTE_ADDR']."', '0|0|0|0|0|0|0|0|0|0|0|0|0')";
			mysql_query($sql, $connect);
			
			echo 0;
			exit;
		}
		
	}else{
		echo 1; //비밀번호가 틀립니다.";
		exit;
	}




}else if ($_POST['mode'] == "initialize_fb"){

	$sql = "select mb_level from remember_member where mb_user='".trim($_SESSION['user'])."'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);

	if ($row['mb_level'] == $common_admin_level) { //관리자
		echo 2;
		exit;
	}else{
	
		//메모장 DROP
		$sql = "DROP TABLE remember_board_".trim($_SESSION['user']);
		mysql_query($sql, $connect);
		
		//단축url
		$sql = "delete from remember_short_url where mb_user = '".trim($_SESSION['user'])."'";
		mysql_query($sql, $connect);
		
		//메모장 CREATE
		$sql = "CREATE TABLE `remember_board_".trim($_SESSION['user'])."` (";
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
		
		$sql = "insert into remember_board_".trim($_SESSION['user'])." (bo_id, bo_public, su_short_url, bo_content, bo_date, bo_ip, bo_option) ";
		$sql .= "values (1, 0, '".$short_url_random."', '<strong>".trim($_SESSION['nick'])."님, 환영합니다.</strong><br /><br />";
		$sql .= "<strong>너무 간단한 무료 가입</strong><br />페이스북/트위터 연동하기.<br />";
		$sql .= "또는<br />아이디, e-메일, 비밀번호. 딱 셋가지만.<br /><br />";
		$sql .= "<strong>깔끔해진 메모 관리 웹/모바일 서비스</strong><br />나만의 아이디어와 생각들, 간단한 메모, 일기쓰기, 여행기록, 체크리스트, 쇼핑리스트, ";
		$sql .= "기록을 좋아하시는 분이나, 업무/학업상 평소에 메모를 많이 하시던 분, 수집광 등. <br /><br />";
		$sql .= "<strong>주요기능</strong><br />개인PC와 모바일 환경 사용이 가능. (동기화가 없습니다.) <br />자신만의 공간.<br />비공개로 메모 작성.<br />메모 검색.<br />";
		$sql .= "인쇄하기.<br />공유하기. (짧은 주소 사용, SNS 바로 보내기, 리플, QR코드 등 사용)<br /><br />";
		$sql .= "<strong>사용자 인터페이스</strong><br />쉽고 편한 사용법.<br />가로보기 지원. (모바일웹)<br /><br />";
		$sql .= "<strong>비밀번호나 계좌번호를 비롯한 중요한 개인 정보 보안에 유의하시기 바랍니다.</strong>', ";
		$sql .= "now(), '".$_SERVER['REMOTE_ADDR']."', '0|0|0|0|0|0|0|0|0|0|0|0|0')";
		mysql_query($sql, $connect);
		
		echo 0;
		exit;

	}

}

mysql_close();



	

?>