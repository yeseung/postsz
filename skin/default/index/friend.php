<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

echo "<br />";


$sql = "select fr_target_user from remember_myfriends where mb_user ='".trim($_SESSION['user'])."' order by fr_id desc";
$result = mysql_query($sql, $connect);

$tmp_sql = "select count(*) as cnt from remember_myfriends where mb_user ='".trim($_SESSION['user'])."' order by fr_id desc";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$total_record = $tmp_row['cnt'];

$a = 0; ?>

<span style="font-size:11px; font-weight:bold"><? echo (!($_SESSION['nick'])) ? ( (!($_SESSION['fb_name'])) ? $_SESSION['user'] : $_SESSION['fb_name'] ) : $_SESSION['nick'] ?>의 친구들 (<? echo $total_record ?>명)</span><br />

<? while ($row = mysql_fetch_array($result)){ 
	$fr_target_user = $row['fr_target_user'];
	
	//$tmp_sql = "select bs_subject, bs_user_url from remember_boardset where mb_user = '".$fr_target_user."'";
	$tmp_sql = "select a.bs_subject, a.bs_user_url, b.mb_facebook, b.mb_thumbnail, b.mb_twitter_user from remember_boardset as a join remember_member as b on a.mb_user = b.mb_user where a.mb_user = '".trim($fr_target_user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$target_subject = $tmp_row['bs_subject'];
	$target_user_url = $tmp_row['bs_user_url'];
	$target_facebook = $tmp_row['mb_facebook'];
	$target_thumbnail = $tmp_row['mb_thumbnail'];
	$target_twitter_user = $tmp_row['mb_twitter_user'];
	//echo $target_subject." / ".$target_user_url." / ".$target_facebook." / ".$target_thumbnail."<br>";
	
	$ano = $a % 9;
	echo ($ano == 0) ? "<br />" : "";
	
	//if ($target_user_url != ""){
		if ($target_facebook == 1){ ?>
            <a href="/<? echo $target_user_url ?>"><img src="https://graph.facebook.com/<? echo $fr_target_user ?>/picture" title="<? echo $target_subject ?>" /></a>
        <? }else if ($target_facebook == 2){ ?>
			<a href="/<? echo $target_user_url ?>" target="_blank"><img src="<? echo $target_thumbnail ?>" title="<? echo $target_subject ?>" width="50" height="50" /></a>
        <? }else{ 
            if ($target_thumbnail != ""){ ?>
                <a href="/<? echo $target_user_url ?>"><img src="<? echo $target_thumbnail ?>" title="<? echo $target_subject ?>" /></a>
            <? }else{ ?>
                <a href="/<? echo $target_user_url ?>"><img src="/skin/<? echo $common_skin ?>/img/person.png" title="<? echo $target_subject ?>" /></a>   
    <? }}
			
	echo ($ano == 9) ? "<br />" : "";
	$a++;
	//echo $a;
}
?>
<br /><br /><br /><br />




<?

$sql = "select mb_user from remember_myfriends where fr_target_user ='".trim($_SESSION['user'])."' order by fr_id desc";
$result = mysql_query($sql, $connect);

$tmp_sql = "select count(*) as cnt from remember_myfriends where fr_target_user ='".trim($_SESSION['user'])."' order by fr_id desc";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$total_record = $tmp_row['cnt'];

$a = 0; ?>

<span style="font-size:11px; font-weight:bold">나를 친구로 추가한 친구들&nbsp;(<? echo $total_record ?>명)</span><br />

<? while ($row = mysql_fetch_array($result)){ 
	$target_mb_user = $row['mb_user'];
	
	//$tmp_sql = "select bs_subject, bs_user_url from remember_boardset where mb_user = '".$fr_target_user."'";
	$tmp_sql = "select a.bs_subject, a.bs_user_url, b.mb_facebook, b.mb_thumbnail, b.mb_twitter_user from remember_boardset as a join remember_member as b on a.mb_user = b.mb_user where a.mb_user = '".trim($target_mb_user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$target_subject = $tmp_row['bs_subject'];
	$target_user_url = $tmp_row['bs_user_url'];
	$target_facebook = $tmp_row['mb_facebook'];
	$target_thumbnail = $tmp_row['mb_thumbnail'];
	$target_twitter_user = $tmp_row['mb_twitter_user'];
	//echo $target_subject." / ".$target_user_url." / ".$target_facebook." / ".$target_thumbnail."<br>";
	
	$ano = $a % 9;
	echo ($ano == 0) ? "<br />" : "";
	
	//if ($target_user_url != ""){
		if ($target_facebook == 1){ ?>
			<a href="/<? echo $target_user_url ?>"><img src="https://graph.facebook.com/<? echo $target_mb_user ?>/picture" title="<? echo $target_subject ?>" /></a>
        <? }else if ($target_facebook == 2){ ?>
			<a href="/<? echo $target_user_url ?>" target="_blank"><img src="<? echo $target_thumbnail ?>" title="<? echo $target_subject ?>" width="50" height="50" /></a>    
		<? }else{ 
			if ($target_thumbnail != ""){ ?>
				<a href="/<? echo $target_user_url ?>"><img src="<? echo $target_thumbnail ?>" title="<? echo $target_subject ?>" /></a>
			<? }else{ ?>
				<a href="/<? echo $target_user_url ?>"><img src="/skin/<? echo $common_skin ?>/img/person.png" title="<? echo $target_subject ?>" /></a>   
	<? }}
			
	echo ($ano == 9) ? "<br />" : "";
	$a++;
	//echo $a;
}
?>
<br /><br /><br /><br />