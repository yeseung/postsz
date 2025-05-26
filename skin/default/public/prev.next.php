<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가



$sql = "select su_short_url from remember_board_".trim($_GET['user'])." where bo_public = 1 and bo_id < ".$_GET['id']." order by bo_id desc limit 1";
$result_prev = mysql_query($sql, $connect);
$row_prev = mysql_fetch_array($result_prev);
$su_short_url_prev = $row_prev['su_short_url'];


$sql = "select su_short_url from remember_board_".trim($_GET['user'])." where bo_public = 1 and bo_id > ".$_GET['id']." order by bo_id limit 1";
$result_next = mysql_query($sql, $connect);
$row_next = mysql_fetch_array($result_next);
$su_short_url_next = $row_next['su_short_url'];


$tmp_sql = "select bs_user_url from remember_boardset where mb_user = '".trim($_GET['user'])."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$bs_user_url = $tmp_row['bs_user_url'];

?>




<div id="prev_next_list">
    <p id="prev_next"><? if (isset($su_short_url_prev)){ ?><a href="/<? echo $su_short_url_prev ?>"><img src="/skin/<? echo $public_skin ?>/img/icon_prev.png" title="이전글" class="png24" /></a><? } ?><? if (isset($su_short_url_next)){ ?><a href="/<? echo $su_short_url_next ?>"><img src="/skin/<? echo $public_skin ?>/img/icon_next.png" title="다음글" class="png24" /></a><? } ?></p>
    <p id="list"><? if ($bs_user_url != ""){ ?><a href="/<? echo $bs_user_url ?>"><img src="/skin/<? echo $public_skin ?>/img/icon_list.png" title="목록" class="png24" /></a><? }else{ ?><a href="/"><img src="/skin/<? echo $public_skin ?>/img/icon_home.png" title="<? echo $common_title ?>" class="png24" /></a><? } ?></p>
</div>

