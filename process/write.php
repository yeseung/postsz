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

if ($_SESSION['user_agent'] == "mobile"){
	$public = substr($_POST['public'], 5, 1);
	$public = $public - 1;
}else{
	if ($_SESSION['fb_facebook'] == 1){ //페이스북
		$public = $_POST['public'];
		$send = $_POST['send'];
		if (($public == 0) and ($send == 1)){ //비공개 and 페이스북보내기
			echo "잘못된 접근입니다.";
			exit;
		}
	}else if ($_SESSION['fb_facebook'] == 2){ //트위터	
		$public = $_POST['public'];
		$send = $_POST['send'];
		if (($public == 0) and ($send == 2)){ //비공개 and 트위터보내기
			echo "잘못된 접근입니다.";
			exit;
		}	
	}else{
		$public = substr($_POST['public'], 5, 1);
		$public = $public - 1;
	}	
}
//$key = $_POST['security_pass'];
$content = $_POST['content'];


//echo "public : ".$public." / send : ".$send." / content : ".$content;
//exit;



$short_url_random = get_rand($common_short_url);

$tmp_sql = "select count(*) as cnt from remember_short_url where su_short_url = '".$short_url_random."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt = $tmp_row['cnt'];

if ($cnt == 0){

	$sql = "insert into remember_board_".trim($_SESSION['user'])." (bo_public, su_short_url, bo_content, bo_date, bo_ip) ";
	$sql .= "values (".$public.", '".$short_url_random."', '".$content."', now(), '".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sql, $connect);
		
	/*if (!$key){
		$sql = "insert into remember_board_".trim($_SESSION['user'])." (bo_public, su_short_url, bo_content, bo_date, bo_ip) ";
		$sql .= "values (".$public.", '".$short_url_random."', '".$content."', now(), '".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sql, $connect);
	}else{
		$sql = "insert into remember_board_".trim($_SESSION['user'])." (bo_public, su_short_url, bo_content, bo_date, bo_ip, bo_security_pass) ";
		$sql .= "values (".$public.", '".$short_url_random."', '".mcrypt_encryption($content)."', now(), '".$_SERVER['REMOTE_ADDR']."', password('".$key."'))";
		mysql_query($sql, $connect);
	}*/
		
	$sql = "select last_insert_id()"; //최근 auto_increment
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);
	$auto_num = $row[0]; 
	
	if ($public == 1){ //공개
		$tmp_sql = "select max(su_id) as max_su_id from remember_short_url";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$su_id = $tmp_row['max_su_id'] + 1;
		
		$sql = "insert into remember_short_url (su_id, su_short_url, mb_user, bo_id, su_date) ";
		$sql .= "values (".$su_id.", '".$short_url_random."', '".trim($_SESSION['user'])."', ".$auto_num.", now())";
		mysql_query($sql, $connect);
	}
	
	//페이스북보내기
	if ($send == 1){ 
		require '../lib/facebook.php';
		$facebook = new Facebook(array(
			'appId'  => $common_facebook_app_id,
			'secret' => $common_facebook_app_secret,
		));
		$tmp_message = get_mb_strimwidth($content, 300);
		try {
			$attachment = array(
				'message' => $tmp_message,
				'link' => $common_path.$short_url_random,
				'description' => $common_help_title,
				'picture' => $common_logo,
			);
			$result = $facebook->api('/me/feed/', 'POST', $attachment);
		}catch(FacebookApiException $e){
			$result = $e->getResult();
			error_log(json_encode($result));
		}
	
	//트위터보내기	
	}else if ($send == 2){
		require_once('../lib/twitteroauth.php');
		require_once('../lib/config.twitter.php');
		$access_token = $_SESSION['access_token'];
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$tmp_message = $common_tweet_via." ".get_mb_strimwidth($content, 140)." ".$common_path.$short_url_random;
		$tmp_msg = $connection->post('statuses/update', array('status' => $tmp_message));
	
	
	
	} //end 보내기 
	
	
	//포인트
	get_point(trim($_SESSION['user']), $common_point_write, "메모장 글쓰기");

	echo 0;
		
	
	
}else{
	echo 1; //에러가 발생하였습니다. \\n문제가 계속되는 경우에는 시스템 관리자에게 문의하십시오.
}	




mysql_close();

?>