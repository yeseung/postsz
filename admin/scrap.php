<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select * from remember_scrap order by sc_id desc";
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
    <td><strong>아이디</strong></td>
    <td><strong>스크랩 아이디</strong></td>
    <td><strong>내용</strong></td>
    <td><strong>공개주소</strong></td>
    <td><strong>날짜</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$sc_id = $row['sc_id'];
	$mb_user = $row['mb_user'];
	$sc_table_user = $row['sc_table_user'];
	$bo_id = $row['bo_id'];
	$su_short_url = $row['su_short_url'];
	$sc_date = str_replace("-", "/", (substr($row['sc_date'], 2, 14)));
	
?>
	<tr>
    	<td><? echo $number ?></td>
        <td><? echo get_profile($mb_user) ?></td>
        <td><? echo get_profile($sc_table_user) ?></td>
        <td><a href="/<? echo $su_short_url ?>" title="<? echo get_scrap_content($sc_table_user, $bo_id, 300) ?>" target="_blank"><? echo get_scrap_content($sc_table_user, $bo_id, 80) ?></a></td>
        <td><a href="/<? echo $su_short_url ?>" target="_blank"><? echo $common_path.$su_short_url ?></a></td>
        <td><? echo $sc_date ?></td>
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

