<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<form id="recycle_bin">
<input type="hidden" name="mode" value="recycle">

<?

$page = $_GET['page'];
if (!$page) $page = 1;

$sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin = 9 order by bo_recycle_bin_date desc";
$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

$scale = 10;

if ($total_record == 0){ 
    echo "<div align=\"center\" style=\"padding:30px; font-size:11px;\">자료가 없습니다.</div>";
	echo("<script>
		setTimeout('self.close()', 1500);
		</script>");
}

if ($total_record % $scale == 0){ 
    $total_page = floor($total_record/$scale); 
}else{
    $total_page = floor($total_record/$scale) + 1;
}

$start = ($page - 1) * $scale; 
$number = $total_record - $start;


if ($total_record != 0){
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="50"><input type="checkbox" id="total" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/point_cont.gif" title="내용" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="160"><img src="/skin/<? echo $common_skin ?>/img/scrap_open.gif" title="공개주소" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="160"><img src="/skin/<? echo $common_skin ?>/img/recycle_bin_date.gif" title="삭제날짜" /></td>
	</tr>

	<? 
    for($i=$start; $i<$start+$scale && $i < $total_record; $i++){
    	mysql_data_seek($result, $i);
    	$row = mysql_fetch_array($result);
		$bo_id = $row['bo_id'];
		$bo_public = $row['bo_public'];
		$su_short_url = $row['su_short_url'];
		$bo_content = trim(htmlspecialchars($row['bo_content']));
		$bo_recycle_bin_date = str_replace("-", "/", (substr($row['bo_recycle_bin_date'], 2, 14)));
	?>
	<tr>
    	<td height="28" align="center"><input type="checkbox" id="rec_num[]" name="rec_num[]" value="<? echo $bo_id ?>"></td>
        <td><? echo get_mb_strimwidth($bo_content, 50) ?></td>
        <td align="center"><? if ($bo_public == 1){ ?><a href="/<? echo $su_short_url ?>" target="_blank"><? echo $common_path.$su_short_url ?></a><? } ?></td>
        <td align="center"><? echo $bo_recycle_bin_date ?></td>
	</tr>
    <tr>
		<td bgcolor="#F0F0F0" colspan="5"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
	</tr>
	<?		
		$number--;
    }
    ?>
</table>
<div style="padding-top:2px;">
<button id="del" title="삭제" style="font-size:11px;">삭제</button>
<button id="recycle" title="복원" style="font-size:11px;">복원</button></div>
</form>

<? } //if ($total_record != 0){ ?>



<div align="center">
<?
$url_page = $_SERVER["SCRIPT_NAME"]."?";

$interval = 7;

$start_page = (floor(($page-1)/$interval))*$interval + 1;
$end_page = $start_page + $interval-1;

if ($total_page <= $end_page) $end_page = $total_page; 

if ($start_page>1) {
	$prev_page = $start_page - 1;
	echo "<a href='".$url_page."page=".$prev_page."'>[prev]</a> ";
}
for ($i=$start_page; $i<=$end_page; $i++) {
	if ($page == $i) {
		echo "<strong><a href='".$url_page."page=".$i."'>[".$i."]</a></strong> ";
	}else{
   		echo "<a href='".$url_page."page=".$i."'>[".$i."]</a> ";
    }    
}
if ($end_page < $total_page) {
 	$next_page = $end_page + 1;
 	echo " <a href='".$url_page."page=".$next_page."'>[next]</a>";
}
?>

</div>
