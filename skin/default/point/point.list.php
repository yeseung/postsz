<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<form id="srcap_del">
<input type="hidden" name="mode" value="<? echo $_GET['mode'] ?>" />
<input type="hidden" name="exec" value="del_all">

<?

$page = $_GET['page'];
if (!$page) $page = 1;

$sql = "select * from remember_point where mb_user = '".trim($_SESSION['user'])."' order by po_id desc";
$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

$scale = 10;

/*if ($total_record == 0){ 
    echo "<div align=\"center\" style=\"padding:30px; font-size:11px;\"></div>";
}*/

if ($total_record % $scale == 0){ 
    $total_page = floor($total_record/$scale); 
}else{
    $total_page = floor($total_record/$scale) + 1;
}

$start = ($page - 1) * $scale; 
$number = $total_record - $start;

?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="30"><img src="/skin/<? echo $common_skin ?>/img/point_num.gif" title="번호" /></td>
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="200"><img src="/skin/<? echo $common_skin ?>/img/point_date.gif" title="일시" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/point_cont.gif" title="내용" /></td>
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="130"><img src="/skin/<? echo $common_skin ?>/img/point.gif" title="포인트" /></td>
	</tr>

	<? 
    for($i=$start; $i<$start+$scale && $i < $total_record; $i++){
    	mysql_data_seek($result, $i);
    	$row = mysql_fetch_array($result);
		$po_id = $row['po_id'];
		$mb_user = $row['mb_user'];
		$po_point = $row['po_point'];
		$po_content = trim(strip_tags($row['po_content']));
		$po_date = str_replace("-", "/", (substr($row['po_date'], 2, 17)));
		if ($po_point > 0) $po_point = "+".number_format($po_point);
	?>
	<tr>
    	<td height="28" align="center"><? echo $number ?></td>
		<td align="center"><? echo $po_date ?></td>
        <td><? echo $po_content ?></a></td>
        <td align="center"><? echo $po_point ?></td>
	</tr>
    <tr>
		<td bgcolor="#F0F0F0" colspan="5"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
	</tr>
	<?		
		$number--;
    }
    ?>
</table>


<div style="padding:15px;" align="center">
	<span style="font-weight:bold; font-size:16px;">보유 포인트 : <? echo get_point_sum(trim($_SESSION['user'])) ?> point</span>
</div>


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
