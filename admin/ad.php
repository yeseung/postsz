<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<form id="ad">
<input type="hidden" name="mode" value="write">
내용 : <input type="text" name="name" id="name" style="width:500px"><br />
주소 : <input type="text" name="url" id="url" style="width:500px">&nbsp;<a href="#" id="submit_ad">확인</a>
</form><br><br>



<?
$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select * from remember_advertisement order by ad_id desc";
$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

$scale = $common_admin_rows_member;

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
	<td><strong>내용</strong></td>
    <td><strong>주소</strong></td>
    <td><strong>날짜</strong></td>
    <td><strong>클릭수</strong></td>
    <td><strong>삭제</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$ad_id = $row['ad_id'];
	$ad_name = $row['ad_name'];
	$ad_url = $row['ad_url'];
	$ad_date = $row['ad_date'];
	$ad_hit = $row['ad_hit'];
?>
	<tr>
    	<td><? echo $number ?></td>
        <td><? echo $ad_name ?></td>
        <td><a href="<? echo $ad_url ?>" target="_blank"><? echo $ad_url ?></a></td>
        <td><? echo $ad_date ?></td>
        <td><? echo $ad_hit ?></td>
        <td><button id="ad_del" title="<? echo $ad_id ?>">delete</button></td>
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