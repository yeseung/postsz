<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$sql = "select * from remember_visit_sum order by vs_date desc limit 1";
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);
$vs_date = $row['vs_date'];
$vs_count = $row['vs_count'];
$vs_visit = sscanf($row['vs_visit'], "오늘:%d,어제:%d,최대:%d,전체:%d");

?>
<table width="100%" border="0" cellpadding="0" cellspacing="2">
  <tr>
    <td valign="bottom"><?
echo "오늘 : ".$vs_visit[0]."&nbsp;&nbsp;&nbsp;";
echo "어제 : ".$vs_visit[1]."&nbsp;&nbsp;&nbsp;";
echo "최대 : ".$vs_visit[2]."&nbsp;&nbsp;&nbsp;";
echo "전체 : ".$vs_visit[3]."<br>";
?></td>
    <!--<td align="right"><form id="ip-search">
<input type="text" id="ip_search" value="<? echo $_GET['search'] ?>"  class="text ui-widget-content ui-corner-all" style="width:200px; font-size:11px" maxlength="30" />
<input type="submit" title="IP Search" value="IP Search" style="font-size:11px" />
</form></td>-->
  </tr>
</table>



<?


$page = $_GET[page];
if (!$page) $page = 1;


if (!$_GET['search']){
	$sql = "select * from remember_visit order by vi_id desc";
}else{
	$sql = "select * from remember_visit where vi_ip like '%".strip_tags($_GET['search'])."%' order by vi_id desc";
}
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
  	<td><strong>IP</strong></td>
    <td><strong>날짜</strong></td>
    <td><strong>접속 경로</strong></td>
    <td><strong>운영체제</strong></td>
    <td><strong>브라우저</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$vi_id = $row['vi_id'];
	$vi_ip = $row['vi_ip'];
	$vi_date = $row['vi_date'];
	$vi_time = $row['vi_time'];
	$vi_referer = $row['vi_referer'];
	//$vi_agent = $row['vi_agent'];
	$brow = get_brow($row['vi_agent']);
    $os = get_os($row['vi_agent']);
?>
	<tr>
    	<td><? echo $number ?></td>
       	<!--<td><a href="javascript:IPSearch_KR('<? echo $vi_ip ?>');"><? echo $vi_ip ?></a></td>-->
        <td><? echo get_ip_search($vi_ip) ?></td>
        <td><? echo $vi_date." ".$vi_time ?></td>
        <td><a href="<? echo $vi_referer ?>" target="_blank"><? echo get_mb_strimwidth($vi_referer, 80) ?></a></td>
        <!--<td><a title="<? echo $vi_agent ?>"><? echo get_mb_strimwidth($vi_agent, 70) ?></a></td>-->
        <td><? echo $os ?></td>
        <td><? echo $brow ?></td>
	</tr>
<?
	$number--;
} //for
?>
</table>

<br />
<div align="center">
<?

if (!$_GET['search']){
	$url_page = $common_path."admin/?mode=".$_GET['mode']."&page=";
}else{
	$url_page = $common_path."admin/?mode=".$_GET['mode']."&search=".strip_tags($_GET['search'])."&page=";
}

echo get_paging($common_admin_list_block, $page, $total_page, $url_page);

?>
</div>
<br />






















<!--<?
$sql = "select * from remember_visit order by vi_id desc limit 100";
$result = mysql_query($sql, $connect); 
?>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
<?
while ($row = mysql_fetch_array($result)){
	$vi_id = $row['vi_id'];
	$vi_ip = $row['vi_ip'];
	$vi_date = $row['vi_date'];
	$vi_time = $row['vi_time'];
	$vi_agent = $row['vi_agent'];
	$vi_agent = strcut_utf8($vi_agent, 60);
?>	
	<tr>
    	<td><? echo $vi_id ?></td>
        <td><? echo $vi_ip ?></td>
        <td><? echo $vi_date." ".$vi_time ?></td>
        <td><? echo $vi_agent ?></td>
	</tr>
<? } ?>
</table>-->



