<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


/*$tmp_sql = "select count(*) as cnt from remember_board_".trim($_GET['user'])." where bo_id = ".$_GET['id'];
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt = $tmp_row['cnt'];


if ($cnt == 0){ 
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");
}else{*/
	
	//if ($_SESSION['user'] != $_GET['user']) {	
		//$tmp_sql = "select bs_subject, bs_skin, bs_user_url, bs_hit from remember_boardset where mb_user = '".trim($_GET['user'])."'";
		$tmp_sql = "select a.mb_nick, a.mb_profile, a.mb_thumbnail, a.mb_twitter_user, b.bs_subject, b.bs_skin, b.bs_user_url, b.bs_hit, b.bs_openapikey, b.bs_openapisecret ";
		$tmp_sql .= "from remember_member as a join remember_boardset as b on a.mb_user = b.mb_user where a.mb_user = '".trim($_GET['user'])."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		
		$public_nickname = $tmp_row['mb_nick'];
		$public_profile = $tmp_row['mb_profile'];
		$public_thumbnail = $tmp_row['mb_thumbnail'];
		$public_twitter_user = $tmp_row['mb_twitter_user'];
		//$_SESSION['set_subject_url'] = $tmp_row['bs_subject'];
		$public_title = strip_tags($tmp_row['bs_subject']);
		$skin_explode = explode("|", $tmp_row['bs_skin']);
		$public_skin = $skin_explode[0]; //web skin
		//$public_skin_m = $skin_explode[1]; //mobile skin
		$public_user_url = $tmp_row['bs_user_url'];
		$public_hit = $tmp_row['bs_hit'];
		$public_openapikey = $tmp_row['bs_openapikey'];
		//$public_openapisecret = $tmp_row['bs_openapisecret'];
		
		if ($_COOKIE["user_url_{$_GET['user']}"] != $_GET['user']){
			$tmp_sql = "update remember_boardset set bs_hit = bs_hit + 1 where mb_user = '".trim($_GET['user'])."'";
			mysql_query($tmp_sql, $connect);
			setcookie("user_url_{$_GET['user']}", "{$_GET['user']}", time() + 3600);
		}
		
		$tmp_sql = "select mb_facebook from remember_member where mb_user = '".trim($_GET['user'])."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$mb_facebook = $tmp_row['mb_facebook'];
	//}
	
	
	include_once ("../skin/{$public_skin}/public/head.php");
	/*if ($_SESSION['user'] == $_GET['user']) {
		//include_once ("../skin/{$public_skin}/board/write.php");
		if ($_SESSION['set_wysiwyg'] == 0){
			include_once ("../skin/{$public_skin}/board/write.php");
		}else if ($_SESSION['set_wysiwyg'] == 1){
			include_once ("../skin/{$public_skin}/board/write.wysiwyg.php");
		}
	}*/
	include_once ("../skin/{$public_skin}/public/list.user.url.main.php");
	include_once ("../skin/{$public_skin}/public/list.user.url.jquery.php");
	include_once ("../skin/{$public_skin}/index/open.php");
	include_once ("../skin/{$public_skin}/public/tail.php");
	
	

//}




?>