<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

//echo "<strong>".$_SESSION['user']."</strong><br>" 
?>


<form id="memo_del">
<input type="hidden" name="mode" value="<? echo $_GET['mode'] ?>" />
<input type="hidden" name="exec" value="del_all">

<?

$page = $_GET['page'];
if (!$page) $page = 1;
    

// 받은 쪽지 출력
if ($_GET['mode'] == "recv"){

	$sql = "select * from remember_memo where mm_send_user = '".trim($_SESSION['user'])."' order by mm_id desc";
	$result = mysql_query($sql, $connect);
	$total_record = mysql_num_rows($result);
	
	$scale = 10;
	
	if ($total_record == 0){ 
    	echo "<div align=\"center\" style=\"padding:30px; font-size:11px;\">받는 쪽지가 없습니다.</div>";
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
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="140"><img src="/skin/<? echo $common_skin ?>/img/memo_q16.gif" title="보낸사람" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/memo_q20.gif" title="내용" /></td>
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="100"><img src="/skin/<? echo $common_skin ?>/img/memo_q17.gif" title="보낸시간" /></td>
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="100"><img src="/skin/<? echo $common_skin ?>/img/memo_q18.gif" title="읽은시간" /></td>
	</tr>

	<? 
    for($i=$start; $i<$start+$scale && $i < $total_record; $i++){
    	mysql_data_seek($result, $i);
    	$row = mysql_fetch_array($result);
		$mm_id = $row['mm_id'];
		$mb_user = $row['mb_user'];
		$mm_notice = $row['mm_notice'];
		$mm_memo = trim(strip_tags($row['mm_memo']));
		$mm_send_date = str_replace("-", "/", (substr($row['mm_send_date'], 2, 14)));
		$mm_read_date = str_replace("-", "/", (substr($row['mm_read_date'], 2, 14)));
	?>
	<tr>
    	<td height="28" align="center"><input type="checkbox" id="del[]" name="del[]" value="<? echo $mm_id ?>"></td>
		<td align="center"><? echo get_profile($mb_user) ?></td>
        <td><a href="/memo.php?mode=recv_view&id=<? echo $mm_id ?>&page=<? echo $page ?>"><? echo get_notice_str($mm_notice) ?><? echo get_mb_strimwidth($mm_memo, 40) ?></a></td>
        <td align="center"><? echo $mm_send_date ?></td>
		<td align="center"><? echo $mm_read_date == "00/00/00 00:00" ? "아직 읽지 않음" : $mm_read_date ?></td>
	</tr>
    <tr>
		<td bgcolor="#F0F0F0" colspan="5"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
	</tr>
	<?		
		$number--;
    }
    ?>
</table>
    
	
    







    
<? 
	} //if ($total_record != 0){ 
  
// 보낸 쪽지 출력
}else if ($_GET['mode'] == "send"){

	$sql = "select * from remember_memo where mb_user = '".trim($_SESSION['user'])."' order by mm_id desc";
	$result = mysql_query($sql, $connect);
	$total_record = mysql_num_rows($result);
	
	$scale = 10;
	
	if ($total_record == 0){ 
    	echo "<div align=\"center\" style=\"padding:30px; font-size:11px;\">보낸 쪽지가 없습니다.</div>";
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
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="140"><img src="/skin/<? echo $common_skin ?>/img/memo_q15.gif" title="받는사람" /></td>
        <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center"><img src="/skin/<? echo $common_skin ?>/img/memo_q20.gif" title="내용" /></td>
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="100"><img src="/skin/<? echo $common_skin ?>/img/memo_q17.gif" title="보낸시간" /></td>
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="100"><img src="/skin/<? echo $common_skin ?>/img/memo_q18.gif" title="읽은시간" /></td>
	</tr>	
	
    <?	
    for($i=$start; $i<$start+$scale && $i < $total_record; $i++){
    	mysql_data_seek($result, $i);
		$row = mysql_fetch_array($result);
		$mm_id = $row['mm_id'];
		$mm_send_user = $row['mm_send_user'];
		$mm_notice = $row['mm_notice'];
		$mm_memo = trim(strip_tags($row['mm_memo']));
		$mm_send_date = str_replace("-", "/", (substr($row['mm_send_date'], 2, 14)));
		$mm_read_date = str_replace("-", "/", (substr($row['mm_read_date'], 2, 14)));
	?>
	
	<tr>
    	<td height="28" align="center"><input type="checkbox" id="del[]" name="del[]" value="<? echo $mm_id ?>"></td>
		<td align="center"><? echo get_profile($mm_send_user) ?></td>
        <td><a href="/memo.php?mode=send_view&id=<? echo $mm_id ?>&page=<? echo $page ?>"><? echo get_notice_str($mm_notice) ?><? echo get_mb_strimwidth($mm_memo, 40) ?></a></td>
		<td align="center"><? echo $mm_send_date ?></td>
		<td align="center"><? echo $mm_read_date == "00/00/00 00:00" ? "아직 읽지 않음" : $mm_read_date ?></td>
	</tr>
    <tr>
		<td bgcolor="#F0F0F0" colspan="5"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
	</tr>
	
	<?
		$number--;
    }
    ?>

</table>    	
    	
    	
    


<?
	} //if ($total_record != 0){ 
} //if ($_GET['mode'] == "recv"){, else if ($_GET['mode'] =="send"){

if ($total_record != 0){
?><div style="padding-top:2px;"><input type="submit" value="삭제" style="font-size:11px;" />&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999999">읽은 쪽지는 <? echo $common_memo_auto_del ?>일 후에 자동으로 삭제됩니다.</span></div><? } ?>
</form>


<br />


<div align="center">
<?
$url_page = $_SERVER["SCRIPT_NAME"]."?mode=".$_GET['mode'];

$interval = 7;

$start_page = (floor(($page-1)/$interval))*$interval + 1;
$end_page = $start_page + $interval-1;

if ($total_page <= $end_page) $end_page = $total_page; 

if ($start_page>1) {
	$prev_page = $start_page - 1;
	echo "<a href='".$url_page."&page=".$prev_page."'>[prev]</a> ";
}
for ($i=$start_page; $i<=$end_page; $i++) {
	if ($page == $i) {
		echo "<strong><a href='".$url_page."&page=".$i."'>[".$i."]</a></strong> ";
	}else{
   		echo "<a href='".$url_page."&page=".$i."'>[".$i."]</a> ";
    }    
}
if ($end_page < $total_page) {
 	$next_page = $end_page + 1;
 	echo " <a href='".$url_page."&page=".$next_page."'>[next]</a>";
}
?>

</div>




