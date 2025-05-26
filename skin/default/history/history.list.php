<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<form id="history_del">
<input type="hidden" name="mode" value="del">


<?

$page = $_GET['page'];
if (!$page) $page = 1;

$sql = "select * from remember_login_history where mb_user = '".trim($_SESSION['user'])."' order by lh_id desc";
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
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="50"><img src="/skin/<? echo $common_skin ?>/img/point_num.gif" title="번호" /><!--<input type="checkbox" id="total" />--></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/history_ip.gif" title="접속IP" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/history_os.gif" title="운영체제" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/history_bro.gif" title="브라우저" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/history_login.gif" title="최초인증시간" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/history_logout.gif" title="최근접속시간" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/history_keep.gif" title="유지시간" /></td>
	</tr>

	<? 
    for($i=$start; $i<$start+$scale && $i < $total_record; $i++){
    	mysql_data_seek($result, $i);
    	$row = mysql_fetch_array($result);
		$lh_id = $row['lh_id'];
		$mb_user = $row['mb_user'];
		$lh_ip = $row['lh_ip'];
		$lh_agent = $row['lh_agent'];
		$lh_datetime_login = $row['lh_datetime_login'];
		$lh_datetime_logout = $row['lh_datetime_logout'];
	?>
	<tr>
        <td height="28" align="center"><? echo $number ?><!--<input type="checkbox" id="del[]" name="del[]" value="<? echo $lh_id ?>">--></td>
        <td align="center"><a href="javascript:IPSearch_KR('<? echo $lh_ip ?>');"><? echo $lh_ip ?></a></td>
        <td align="center"><? echo get_os($lh_agent) ?></td>
        <td align="center"><? echo get_brow($lh_agent) ?></td>
        <td align="center"><? echo str_replace("-", "/", (substr($lh_datetime_login, 2, 14))) ?></td>
        <td align="center"><? echo str_replace("-", "/", (substr($lh_datetime_logout, 2, 14))) ?></td>
        <td align="center"><? echo get_time_keep($lh_datetime_login, $lh_datetime_logout) ?></td>
	</tr>
    <tr>
		<td bgcolor="#F0F0F0" colspan="7"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
	</tr>
	<?		
		$number--;
    }
    ?>
</table>
<div style="padding: 15px 0 15px 10px">
<!--<button id="del" title="삭제" style="font-size:11px;">삭제</button>&nbsp;&nbsp;&nbsp;&nbsp;--><span style="color:#999999">로그인 기록은 개인정보취급방침에 명시된 통신비밀보호법에 의해 최대 <? echo $common_history_auto_del ?>일까지만 보관됩니다. </span></div>
<!--</form>-->

<br />

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


