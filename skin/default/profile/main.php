<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

$tmp_sql = "select count(*) as cnt from remember_member where mb_user = '".$_GET['user']."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt = $tmp_row['cnt'];

if ($cnt == 0){
	echo "<div style=\"padding:10px 0 10px 78px;font-size:11px;\">존재하지 않는 아이디입니다.</div>";
    exit;
}


include_once ("skin/{$common_skin}/profile/head.php");


$tmp_sql = "select a.*, b.* from remember_member as a join remember_boardset as b on a.mb_user = b.mb_user where a.mb_user = '".trim($_GET['user'])."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);

$updated_date = sscanf($tmp_row['mb_updated_date'], "%d-%d-%d %d:%d:%d");
$updated_date_period = get_date_period(substr($tmp_row['mb_updated_date'], 0, 10));
//$updated_date_str = $updated_date[0]."년 ".$updated_date[1]."월 ".$updated_date[2]."일에 가입 (".$updated_date_period."일전)";
$updated_date_str = str_replace("-", ".", (substr($tmp_row['mb_updated_date'], 0, 10)))." (".$updated_date_period."일전)";
$open_mailling_explode = explode("|", $tmp_row['mb_open_mailling']);
$open = $open_mailling_explode[0];
$facebook = $tmp_row['mb_facebook'];
$nickname = $tmp_row['mb_nick'];
$profile = strip_tags($tmp_row['mb_profile']);
$thumbnail = $tmp_row['mb_thumbnail'];
$twitter_user = $tmp_row['mb_twitter_user'];

$subject = strip_tags($tmp_row['bs_subject']);
$user_url = $tmp_row['bs_user_url'];
$bs_hit = $tmp_row['bs_hit'];
	


?>

<div style="position:absolute;top:32px;left:243px;float:right;width:50px;height:50px;">
<? if ($facebook == 1){ ?>
	<a href="http://www.facebook.com/profile.php?id=<? echo $_GET['user'] ?>&sk=info" target="_blank"><!--<a href="/<? echo $user_url ?>">--><img src="https://graph.facebook.com/<? echo $_GET['user'] ?>/picture" title="<? echo $subject ?>" align="right" /></a>
<? }else if ($facebook == 2){ ?>
	<a href="http://twitter.com/<? echo $twitter_user ?>" target="_blank"><img src="<? echo $thumbnail ?>" title="<? echo $subject ?>" align="right" /></a>
<? }else{ 
    if ($thumbnail != ""){ ?>
        <a href="/<? echo $user_url ?>"><img src="<? echo $thumbnail ?>" title="<? echo $subject ?>" align="right" /></a>
    <? }else{ ?>
        <a href="/<? echo $user_url ?>"><img src="/skin/<? echo $common_skin ?>/img/person.png" title="<? echo $subject ?>" align="right" /></a>   
<? }} ?>
</div>


<table width="283" border="0" cellspacing="0" cellpadding="3" style="font-size:11px;">
	<tr>
        <td width="30%" align="right" valign="top"><strong>아이디</strong> : &nbsp;</td>
        <td><? //echo ($facebook == 2) ? trim($twitter_user)." (".trim($_GET['user']).")" : trim($_GET['user']) ?><? echo ($facebook == 2) ? trim($twitter_user) : trim($_GET['user']) ?></td>
    </tr>
    <tr>
    	<td align="right" valign="top"><strong>가입일</strong> : &nbsp;</td>
        <td><? echo $updated_date_str ?></td>
    </tr>    
    <? if ($nickname != ""){ ?>
    <tr>
        <td align="right" valign="top"><strong>별명</strong> : &nbsp;</td>
        <td><? echo $nickname ?></td>
    </tr>
    <? } ?>
    <? if ($profile != ""){ ?>
    <tr>
        <td align="right" valign="top"><strong>프로필</strong> : &nbsp;</td>
        <td><? echo $profile ?></td>
    </tr>
    <? } ?>
    <tr>
        <td align="right" valign="top"><strong>공개주소</strong> : &nbsp;</td>
        <td><a href="<? echo $common_path.$user_url ?>"><? echo $common_path.$user_url ?></a>&nbsp;(<? echo $bs_hit ?>)</td>
    </tr>
</table>


<? if (isset($_SESSION['user'])) { ?>
<br />
<button id="profile_tosend" title="<? echo $_GET['user'] ?>" style="font-size:11px;">쪽지보내기</button>
<?
if ($_SESSION['user'] != $_GET['user']) {
	$tmp_sql = "select count(*) as cnt from remember_myfriends where mb_user='".trim($_SESSION['user'])."' and fr_target_user='".trim($_GET['user'])."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$friend_cnt = $tmp_row['cnt']; ?>
		<? if ($friend_cnt == 1){ ?><button id="profile_friend_del" title="<? echo $_GET['user'] ?>" style="font-size:11px;">친구해제</button>
		<? }else{ ?><button id="profile_friend_add" title="<? echo $_GET['user'] ?>" style="font-size:11px;">친구추가</button>
		<? } ?>
<? }} ?>
    
    



<? include_once ("skin/{$common_skin}/profile/tail.php"); ?>