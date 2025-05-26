<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select * from remember_short_url order by su_id desc";
$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

$scale = $common_admin_rows;

if ($total_record % $scale == 0){ 
	$total_page = floor($total_record/$scale); 
}else{
	$total_page = floor($total_record/$scale) + 1;
}

$start = ($page - 1) * $scale; 
$number = $total_record - $start;
?>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
  	<td><strong>번호</strong></td>
  	<td><strong>공개 주소</strong></td>
    <td><strong>내용</strong></td>
    <td><strong>아이디</strong></td>
    <td><strong>조회수</strong></td>
    <td><strong>스크랩수</strong></td>
    <td><strong>날짜</strong></td>
    <td><strong>블랙리스트</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$su_id = $row['su_id'];
	$su_short_url = $row['su_short_url'];
	$mb_user = $row['mb_user'];
	
	$tmp_sql = "select bs_user_url from remember_boardset where mb_user = '".trim($mb_user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$bs_user_url = $tmp_row['bs_user_url'];
	
	$tmp_sql = "select left(bo_content, ".$common_admin_content_len.") as bo_content from remember_board_".trim($mb_user)." where su_short_url = '".$su_short_url."' order by bo_id desc";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$bo_content = trim(strip_tags(htmlspecialchars($tmp_row['bo_content'])));

	$su_hit = $row['su_hit'];
	$su_date = $row['su_date'];
	//$su_date = str_replace("-", "/", (substr($row['su_date'], 2, 14)));
	$su_blacklist_date = $row['su_blacklist_date'];
	$su_blacklist_date_str = str_replace(" ", "", (str_replace(":", "", (str_replace("-", "", (substr($su_blacklist_date, 2, 14)))))));	
	
?>
	<tr>
    	<td><? echo $number ?></td>
        <td><a href="<? echo $common_path.$su_short_url ?>" target="_blank"><? echo $common_path.$su_short_url ?></a></td>
        <td><? echo get_mb_strimwidth($bo_content, 50) ?></td>
        <!--<td><? if ($bs_user_url != ""){ ?><a href="<? echo $common_path.$bs_user_url ?>" target="_blank"><? echo $mb_user ?></a><? }else{ ?><? echo $mb_user ?><? } ?></td>-->
        <td><? echo get_profile($mb_user) ?></td>
        <td><? echo $su_hit ?></td>
        <td><? echo get_scrap_num($su_short_url) ?></td>
        <td><? echo $su_date ?></td>
        <td>
		<? if ($su_blacklist_date != "0000-00-00 00:00:00"){ ?>
        	<button id="blacklist_on" title="<? echo $su_id ?>">ON</button>
		<? }else{ ?>
        	<button id="blacklist_off" title="<? echo $su_id ?>">OFF</button>
        <? } ?> <? echo ($su_blacklist_date != "0000-00-00 00:00:00") ? $su_blacklist_date_str : "" ?>   
        </td>
	</tr>
<?
	$number--;
} //for
?>
</table>

<br />
<div align="center">
<? echo get_paging($common_admin_list_block, $page, $total_page, $common_path."admin/?mode=".$_GET['mode']."&page="); ?>
</div>
<br />






















<!--<?
$sql = "select * from remember_short_url order by su_id desc limit 100";
$result = mysql_query($sql, $connect); 
?>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
<?
while ($row = mysql_fetch_array($result)){
	$su_id = $row['su_id'];
	$su_short_url = $row['su_short_url'];
	$mb_user = $row['mb_user'];
	$su_hit = $row['su_hit'];
	$su_date = $row['su_date'];
?>
	<tr>
    	<td><? echo $su_id ?></td>
        <td><a href="<? echo $common_path.$su_short_url ?>" target="_blank"><? echo $common_path.$su_short_url ?></a></td>
        <td><? echo $mb_user ?></td>
        <td><? echo $su_hit ?></td>
        <td><? echo $su_date ?></td>
	</tr>
<? } ?>
</table>-->
