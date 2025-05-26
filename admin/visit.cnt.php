<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select * from remember_visit_sum order by vs_date desc";
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
  	<td><strong>날짜</strong></td>
    <td><strong>방문자수</strong></td>
    <td><strong>비고</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$vs_date = $row['vs_date'];
	$vs_count = $row['vs_count'];
	$vs_visit = $row['vs_visit'];
	$vs_visit_explode = explode(",", $vs_visit);
	
?>
	<tr>
    	<td><? echo $number ?></td>
    	<td><? echo $vs_date ?></td>
        <td><? echo $vs_count ?></td>
        <td><? echo $vs_visit ?></td>
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
$sql = "select * from remember_visit_sum order by vs_date desc limit 100";
$result = mysql_query($sql, $connect); 
?>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
<?
while ($row = mysql_fetch_array($result)){
	$vs_date = $row['vs_date'];
	$vs_count = $row['vs_count'];
	$vs_visit = $row['vs_visit'];
?>
	<tr>
    	<td><? echo $vs_date ?></td>
        <td><? echo $vs_count ?></td>
        <td><? echo $vs_visit ?></td>
	</tr>
<? } ?>
</table>-->