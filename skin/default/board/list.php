<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<br clear="all" />

<?

$page = $_GET['page']; 
if (!$page)	{ $page = 1; $_GET['page'] = 1; }

if (!$_GET['search']){
	if (!$_GET['date']){
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 order by bo_id desc";
		$url_view = "/view.php?page=".$_GET['page']."&id=";
	}else{
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 and left(bo_date,10) = '".get_date_time($_GET['date'])."' order by bo_id desc";
		$url_view = "/view.php?date=".$_GET['date']."&page=".$_GET['page']."&id=";
	}
}else{
	if (!$_GET['date']){
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 and bo_content like '%".htmlspecialchars($_GET['search'])."%' order by bo_id desc";
		$url_view = "/view.php?search=".htmlspecialchars($_GET['search'])."&page=".$_GET['page']."&id=";
	}else{
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 and bo_content like '%".htmlspecialchars($_GET['search'])."%' and left(bo_date,10) = '".get_date_time($_GET['date'])."' order by bo_id desc";
		$url_view = "/view.php?date=".$_GET['date']."&search=".htmlspecialchars($_GET['search'])."&page=".$_GET['page']."&id=";
	}
}
$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

if ($total_record == 0) { ?>
	<div align="center" style="padding-top:30px; font-size:11px;">등록된 게시글이 없습니다.</div>
<? }

$scale = $_SESSION['set_rows'];
if ($total_record % $scale == 0){
	$total_page = floor($total_record/$scale);
}else{
	$total_page = floor($total_record/$scale) + 1;
}

$start = ($page - 1) * $scale;
$number = $total_record - $start; 

for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i); 
	$row = mysql_fetch_array($result);

	$bo_id = $row['bo_id'];
	$bo_public = $row['bo_public'];
	//$bo_content = get_text_index($row['bo_content']);
	$bo_content = strip_tags($row['bo_content']);
	//$bo_content = strip_tags(get_text($row['bo_content']));
	//$bo_content = trim(htmlspecialchars($row['bo_content']));
	$bo_date_format = $row['bo_date_format'];
	//$common_content_len_ten = $common_content_len - 10; ?>
    
    <div id="listboard">
		<p id="list"><a href="<? echo $url_view.$bo_id ?>"><? echo get_mb_strimwidth($bo_content, 220) ?></a>&nbsp;<? echo ($bo_public == 1) ? "<img src=\"/skin/".$common_skin."/img/lock.png\" />" : "" ?></p>
		<p id="posted_date_comment">Post by <span style="font-size:11px; font-style:normal"><? echo (!($_SESSION['nick'])) ? ( (!($_SESSION['fb_name'])) ? $_SESSION['user'] : $_SESSION['fb_name'] ) : $_SESSION['nick'] ?></span>&nbsp;on&nbsp;<? echo $bo_date_format ?></p>    
	</div>
    	
<?
	$number--;
} //for
?>
<br clear="all" />


<div id="article">
<p><span class="butons">

<?

if (isset($_GET['search'])) { 
	if (!$_GET['date']){
		$url_page = "?search=".htmlspecialchars($_GET['search'])."&";
	}else{
		$url_page = "?search=".htmlspecialchars($_GET['search'])."&date=".$_GET['date']."&";
	}
}else{
	if (!$_GET['date']){
		$url_page = "?";
	}else{
		$url_page = "?date=".$_GET['date']."&";
	}	
}

$interval = $common_list_block; 
$start_page = (floor(($page-1)/$interval))*$interval + 1;
$end_page = $start_page + $interval-1;
if ($total_page <= $end_page) $end_page = $total_page;

if ($start_page>1) {
	$prev_page = $start_page - 1;
	echo "<a href='".$url_page."page=".$prev_page."'>prev</a>";
}

for ($i=$start_page; $i<=$end_page; $i++) {
	if ($page == $i) {
		echo "<a href='".$url_page."page=".$i."' class=\"active\">".$i."</a>";
	}else{
		echo "<a href='".$url_page."page=".$i."'>".$i."</a>";
	}    
}

if ($end_page < $total_page) {
	$next_page = $end_page + 1;
	echo "<a href='".$url_page."page=".$next_page."'>next</a>";
}
?>

</span></p>
</div>
