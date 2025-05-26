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

$public = $_POST['public'];
$send = $_POST['send'];
if (($public == 0) and ($send == 2)){ //비공개 and 트위터보내기
	echo "잘못된 접근입니다.";
	exit;
}

$content = $_POST['content'];

/*echo "public : ".$public." / send : ".$send." / content : ".$content;
echo $_SESSION['post_oauth_token'];
exit;*/



$short_url_random = get_rand($common_short_url);

$tmp_sql = "select count(*) as cnt from remember_short_url where su_short_url = '".$short_url_random."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt = $tmp_row['cnt'];

if ($cnt == 0){

	$sql = "insert into remember_board_".trim($_SESSION['user'])." (bo_public, su_short_url, bo_content, bo_date, bo_ip) ";
	$sql .= "values (".$public.", '".$short_url_random."', '".$content."', now(), '".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sql, $connect);
		
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
	
	//트위터보내기	
	if ($send == 2){
		require_once('../lib/twitteroauth.php');
		require_once('../lib/config.twitter.post.php');
		$access_token = $_SESSION['access_token'];
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['post_oauth_token'], $_SESSION['post_oauth_token_secret']);
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
