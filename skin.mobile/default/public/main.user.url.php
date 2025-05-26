<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$tmp_sql = "select bs_subject, bs_skin, bs_user_url, bs_hit from remember_boardset where mb_user = '".trim($_GET['user'])."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
//$_SESSION['set_subject_url'] = $tmp_row['bs_subject'];
$public_title = htmlspecialchars($tmp_row['bs_subject']);
$skin_explode = explode("|", $tmp_row['bs_skin']);
//$public_skin = $skin_explode[0]; //web skin
$public_skin_m = $skin_explode[1]; //mobile skin
$public_user_url = $tmp_row['bs_user_url'];
$public_hit = $tmp_row['bs_hit'];

if ($public_user_url == ""){
	echo ("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");		
	exit;
}

$tmp_sql = "select a.mb_nick, a.mb_profile, a.mb_thumbnail, b.bs_subject, b.bs_skin, b.bs_user_url, b.bs_hit from remember_member as a join remember_boardset as b on a.mb_user = b.mb_user where a.mb_user = '".trim($_GET['user'])."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);

$public_nickname = $tmp_row['mb_nick'];
$public_profile = $tmp_row['mb_profile'];
$public_thumbnail = $tmp_row['mb_thumbnail'];
//$_SESSION['set_subject_url'] = $tmp_row['bs_subject'];
$public_title = htmlspecialchars($tmp_row['bs_subject']);
$skin_explode = explode("|", $tmp_row['bs_skin']);
//$public_skin = $skin_explode[0]; //web skin
$public_skin_m = $skin_explode[1]; //mobile skin
$public_user_url = $tmp_row['bs_user_url'];
$public_hit = $tmp_row['bs_hit'];

if ($_COOKIE["user_url_{$_GET['user']}"] != $_GET['user']){
	$tmp_sql = "update remember_boardset set bs_hit = bs_hit + 1 where mb_user = '".trim($_GET['user'])."'";
	mysql_query($tmp_sql, $connect);
	setcookie("user_url_{$_GET['user']}", "{$_GET['user']}", time() + 3600);
}

$tmp_sql = "select mb_facebook from remember_member where mb_user = '".trim($_GET['user'])."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$mb_facebook = $tmp_row['mb_facebook'];


include_once ("skin.mobile/{$public_skin_m}/public/head.php");
include_once ("skin.mobile/{$public_skin_m}/public/list.user.url.php");
//include_once ("skin.mobile/{$public_skin_m}/public/page.php");
include_once ("skin.mobile/{$public_skin_m}/public/tail.php");




?>