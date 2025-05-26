<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<br clear="all" />

<?

if (!$_GET['search']){
	if (!$_GET['date']){
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 order by bo_id desc LIMIT ".$_SESSION['set_rows'];
		$url_view = "/view.php?id=";
	}else{
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 and left(bo_date,10) = '".get_date_time($_GET['date'])."' order by bo_id desc LIMIT ".$_SESSION['set_rows'];
		$url_view = "/view.php?date=".$_GET['date']."&id=";
	}	
}else{
	if (!$_GET['date']){
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 and bo_content like '%".htmlspecialchars($_GET['search'])."%' order by bo_id desc LIMIT ".$_SESSION['set_rows'];
		$url_view = "/view.php?search=".htmlspecialchars($_GET['search'])."&id=";
	}else{
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 and bo_content like '%".htmlspecialchars($_GET['search'])."%' and left(bo_date,10) = '".get_date_time($_GET['date'])."' order by bo_id desc LIMIT ".$_SESSION['set_rows'];
		$url_view = "/view.php?date=".$_GET['date']."&search=".htmlspecialchars($_GET['search'])."&id=";
	}	
}

$result = mysql_query($sql, $connect); 
$total_record = mysql_num_rows($result);

if ($total_record == 0) { ?>
	<div align="center" style="padding-top:30px; font-size:11px;">등록된 게시글이 없습니다.</div>
<? }

while ($row = mysql_fetch_array($result)){

	$bo_id = $row['bo_id'];
	$bo_public = $row['bo_public'];
	//$bo_content = get_text_index($row['bo_content']);
	$bo_content = strip_tags($row['bo_content']);
	//$bo_content = strip_tags(get_text($row['bo_content']));
	//$bo_content = trim(htmlspecialchars($row['bo_content']));
	$bo_date_format = $row['bo_date_format'];
	//$common_content_len_ten = $common_content_len - 10; ?>
    
    <div class="wrdLatest" id="<? echo $bo_id ?>">
        <div id="listboard">
            <p id="list"><a href="<? echo $url_view.$bo_id ?>"><? echo get_mb_strimwidth($bo_content, 220) ?></a>&nbsp;<? echo ($bo_public == 1) ? "<img src=\"/skin/".$common_skin."/img/lock.png\" />" : "" ?></p>
            <p id="posted_date_comment">Post by <span style="font-size:11px; font-style:normal"><? echo (!($_SESSION['nick'])) ? ( (!($_SESSION['fb_name'])) ? $_SESSION['user'] : $_SESSION['fb_name'] ) : $_SESSION['nick'] ?></span>&nbsp;on&nbsp;<? echo $bo_date_format ?></p>    
        </div>
    </div>

<? } ?>

<div id="lastPostsLoader"></div>

<? if ($total_record != 0) { 
        if ($total_record >= $_SESSION['set_rows']) { ?>
    <br clear="all"><a href="#" id="list_more"><img src="/skin/<? echo $common_skin ?>/img/more.gif" alt="더보기" /></a>
<? }} ?>

<br /><br /><br />

<script>
$(document).ready(function(){

	function lastPostFunc() { 
		$('div#lastPostsLoader').html("<center><img src='/skin/<? echo $common_skin ?>/img/loading.gif'></center>");
		$.post("/skin/<? echo $common_skin ?>/board/list.jquery.more.php?search=<? echo htmlspecialchars($_GET['search']) ?>&date=<? echo $_GET['date'] ?>&lastPostID=" + $(".wrdLatest:last").attr("id"),
		function(data){
			if (data != "") {
				$(".wrdLatest:last").after(data);			
			}
			$('div#lastPostsLoader').empty();
		});
	};  
	
	$("#list_more").click(function(){ 
		lastPostFunc();
		return false;
	});
	
});
</script>	