<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$tmp_sql = "select count(*) as cnt from remember_board_".trim($_GET['user'])." where bo_id = ".$_GET['id'];
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt = $tmp_row['cnt'];


if ($cnt == 0){ 
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");
}else{
	
	//if ($_SESSION['user'] != $_GET['user']) {	
		//$tmp_sql = "select bs_subject, bs_skin, bs_user_url from remember_boardset where mb_user = '".trim($_GET['user'])."'";
		$tmp_sql = "select a.mb_nick, b.bs_subject, b.bs_skin, b.bs_user_url from remember_member as a join remember_boardset as b on a.mb_user = b.mb_user where a.mb_user = '".trim($_GET['user'])."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		
		$public_nickname = $tmp_row['mb_nick'];
		//$_SESSION['set_subject_short'] = $tmp_row['bs_subject'];
		$public_title = htmlspecialchars($tmp_row['bs_subject']);
		$skin_explode = explode("|", $tmp_row['bs_skin']);
		$public_skin = $skin_explode[0]; //web skin
		//$public_skin_m = $skin_explode[1]; //mobile skin
		$public_user_url = $tmp_row['bs_user_url'];
		/*if (!(isset($public_user_url))){
			$public_user_url = "";
		}*/
	//}
	
	/*$tmp_sql = "select mb_facebook from remember_member where mb_user = '".trim($_GET['user'])."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$_SESSION['set_facebook_short'] = $tmp_row['mb_facebook'];*/
	

	include_once ("../skin/{$public_skin}/public/head.php");
	/*if ($_SESSION['user'] == $_GET['user']) {
		//include_once ("../skin/{$public_skin}/board/write.php");
		if ($_SESSION['set_wysiwyg'] == 0){
			include_once ("../skin/{$public_skin}/board/write.php");
		}else if ($_SESSION['set_wysiwyg'] == 1){
			include_once ("../skin/{$public_skin}/board/write.wysiwyg.php");
		}
	}*/	
	include_once ("../skin/{$public_skin}/public/view.short.php");
	//include_once ("../skin/{$public_skin}/index/public.memo.php");
	include_once ("../skin/{$public_skin}/public/tail.php");
	
	

}




?>