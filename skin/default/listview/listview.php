<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<form id="listview_del">
<input type="hidden" name="mode" value="del">

<?

$page = $_GET['page'];
if (!$page) $page = 1;

switch ($_GET['mode']){
	case "public":
		switch ($_GET['type']){
			case 1: $sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_public = 1 and bo_recycle_bin != 9 order by bo_date desc"; break;
			case 2: $sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_public = 1 and bo_recycle_bin != 9 order by bo_date"; break;
			default: $sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_public = 1 and bo_recycle_bin != 9 order by bo_id desc";			
		}
	break;
	case "closed":
		switch ($_GET['type']){
			case 1: $sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_public = 0 and bo_recycle_bin != 9 order by bo_date desc"; break;
			case 2: $sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_public = 0 and bo_recycle_bin != 9 order by bo_date"; break;
			default: $sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_public = 0 and bo_recycle_bin != 9 order by bo_id desc";			
		}
	break;	
	default:
		switch ($_GET['type']){
			case 1: $sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 order by bo_date desc"; break;
			case 2: $sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 order by bo_date"; break;
			default: $sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 order by bo_id desc";			
		}		
}



$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

$scale = 10;

if ($total_record == 0){ 
    echo "<div align=\"center\" style=\"padding:30px; font-size:11px;\">등록된 게시글이 없습니다.</div>";
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
		<td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" width="110"><img src="/skin/<? echo $common_skin ?>/img/datetime.gif" border="0" usemap="#Map" title="날짜" width="45" height="43" /></td>
	</tr>

	<? 
    for($i=$start; $i<$start+$scale && $i < $total_record; $i++){
    	mysql_data_seek($result, $i);
    	$row = mysql_fetch_array($result);
		$bo_id = $row['bo_id'];
		$bo_public = $row['bo_public'];
		$bo_content = strip_tags($row['bo_content']);
		$bo_date = str_replace("-", "/", (substr($row['bo_date'], 2, 14)));
	?>
	<tr>
    	<td height="28" align="center"><input type="checkbox" id="del[]" name="del[]" value="<? echo $bo_id ?>"></td>
        <td><a href="javascript:;" onclick="opener.document.location.href='/view.php?id=<? echo $bo_id ?>'" title="<? echo get_mb_strimwidth($bo_content, 200) ?>"><? echo get_mb_strimwidth($bo_content, 70) ?></a>&nbsp;<? echo ($bo_public == 1) ? "<img src=\"/skin/".$common_skin."/img/lock.png\" />" : "" ?></td>
        <td align="center"><? echo $bo_date ?></td>
	</tr>
    <tr>
		<td bgcolor="#F0F0F0" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
	</tr>
	<?		
		$number--;
    }
    ?>
</table>
<div style="padding-top:2px;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input type="submit" value="삭제" style="font-size:11px;" />&nbsp;</td>
    <td align="right"><select class="text ui-widget-content ui-corner-all" style="font-size:11px; width:95px" onchange="linkTo(this.options[this.selectedIndex].value);">
<option value="/listview.php" <? echo ($_GET['mode'] != "") ? "selected" : "" ?>>기본</option>
<option value="/listview.php?mode=public" <? echo ($_GET['mode'] == "public") ? "selected" : "" ?>>공개</option>
<option value="/listview.php?mode=closed" <? echo ($_GET['mode'] == "closed") ? "selected" : "" ?>>비공개</option>
</select>&nbsp;</td>
  </tr>
</table>






</div>
</form>

<? } //if ($total_record != 0){ ?>



<div align="center">
<?
//$url_page = $_SERVER["SCRIPT_NAME"]."?";
$url_page = $common_path."listview.php?mode=".$_GET['mode']."&type=".$_GET['type']."&";

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


<map name="Map" id="Map">
<area shape="rect" coords="29,1,44,24" href="/listview.php?mode=<? echo $_GET['mode'] ?>&type=1" /><area shape="rect" coords="29,24,44,42" href="/listview.php?mode=<? echo $_GET['mode'] ?>&type=2" />
</map>