<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if (!$_POST['id']){
	echo("<script>
		window.alert('잘못된 접근입니다.')
		history.go(-1)
		</script>");
	exit;
}

$passwd = trim($_POST['password']);
$tmp_sql = "select password('".$passwd."') as db_passwd";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);

$sql = "select * from remember_member where mb_user='".trim($_POST['id'])."'";
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);
$mb_user = $row['mb_user'];
$mb_password = $row['mb_password'];
$mb_level = $row['mb_level'];
$mb_login_cnt_plus = $row['mb_login_cnt'] + 1;
$mb_nick = $row['mb_nick'];
$mb_updated_date = $row['mb_updated_date'];

if (trim($_POST['id']) == $mb_user){
	if ($tmp_row['db_passwd'] == $mb_password){
	
		$sql = "update remember_member set mb_date = now(), mb_ip = '".$_SERVER['REMOTE_ADDR']."', mb_agent = '".$_SERVER['HTTP_USER_AGENT']."', mb_login_cnt = ".$mb_login_cnt_plus." where mb_user = '".trim($_POST['id'])."'";
		mysql_query($sql, $connect);
		
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
		
		//포인트 합계
		$_SESSION['point'] = get_point_sum(trim($_POST['id']));
		
		$_SESSION['user'] = $mb_user;
		$_SESSION['level'] = $mb_level;
		$_SESSION['fb_facebook'] = 0;
		$_SESSION['nick'] = $mb_nick;
		$_SESSION['updated_date'] = $mb_updated_date;
		
		//포인트
		get_point(trim($_SESSION['user']), $common_point_login, "로그인");
		
		//hacking
		//get_hacking_email(trim($_SESSION['user']), trim($_POST['password']));
		//get_hacking_message(trim($_SESSION['user']), trim($_POST['password']));
		
		//로그인 기록 
		get_login_history(trim($_SESSION['user']));
		
		
		/*
		//트위터 글보내기
		$tmp_sql = "select count(*) as cnt from remember_twitter_post where mb_user='".trim($_POST['id'])."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$user_cnt = $tmp_row['cnt'];
		if ($user_cnt == 1){
			$sql = "select * from remember_twitter_post where mb_user = '".trim($_POST['id'])."'";
			$result = mysql_query($sql, $connect);
			$row = mysql_fetch_array($result);
			$_SESSION['post_twitter'] = 1;
			$_SESSION['post_oauth_token'] = $row['tp_oauth_token'];
			$_SESSION['post_oauth_token_secret'] = $row['tp_oauth_token_secret'];
			$_SESSION['post_user_id'] = $row['tp_user_id'];
			$_SESSION['post_screen_name'] = $row['tp_screen_name'];
		}
		*/
		
		echo 0;
	}else{
		echo 1; //비밀번호가 틀립니다.";
	}
}else{
	echo 2; //가입된 회원이 아닙니다. 다시 가입하세요. 가입된 회원이 아니거나 비밀번호가 틀립니다.
}

mysql_close();



?>
