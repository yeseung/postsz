<? 
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<div style="padding:0 5px 5px 5px;">
<?
$page = $_GET['page']; 
if (!$page)	{ $page = 1; $_GET['page'] = 1; }

if (!$_GET['search']){
	//$sql = "select bo_id, bo_public, left(bo_content, ".$common_content_len_m.") as bo_content from remember_board_".trim($_SESSION['user'])." order by bo_id desc";
	$sql = "select bo_id, bo_public, bo_content from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 order by bo_id desc";
	$url_view = "/view.php?page=".$_GET['page']."&id=";
}else{
	//$sql = "select bo_id, bo_public, left(bo_content, ".$common_content_len_m.") as bo_content from remember_board_".trim($_SESSION['user'])." where bo_content like '%".htmlspecialchars($_GET['search'])."%' order by bo_id desc";
	$sql = "select bo_id, bo_public, bo_content from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 and bo_content like '%".htmlspecialchars($_GET['search'])."%' order by bo_id desc";
	$url_view = "/view.php?search=".htmlspecialchars($_GET['search'])."&page=".$_GET['page']."&id=";
}
$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

if ($total_record == 0) { ?>
    <div align="center" style="padding-top:30px; padding-bottom:30px; font-size:11px;">등록된 게시글이 없습니다.</div>
<? }

$scale = $_SESSION['set_rows_m'];
if ($total_record % $scale == 0){
	$total_page = floor($total_record/$scale);
}else{
	$total_page = floor($total_record/$scale) + 1;
}

$start = ($page - 1) * $scale;
$number = $total_record - $start; ?>

<ul data-role="listview" data-inset="true" > 
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i); 
	$row = mysql_fetch_array($result);

	$bo_id = $row['bo_id'];
	//$bo_public = $row['bo_public'];
	//$bo_content = get_text_index(trim(htmlspecialchars($row['bo_content'])));
	//$bo_content = trim(htmlspecialchars($row['bo_content']));
	//$bo_content = htmlspecialchars($row['bo_content']);
	$bo_content = strip_tags($row['bo_content']);
	//$common_content_len_ten_m = $common_content_len_m - 5; ?>
    
    <li data-icon="false"><a href="<? echo $url_view.$bo_id ?>" rel="external" data-ajax="false"><? echo get_mb_strimwidth($bo_content, 120) ?></a></li>
		
<?	
	$number--;
} //for ($i=$start; $i<$start+$scale && $i < $total_record; $i++){
?>
</ul>
</div>