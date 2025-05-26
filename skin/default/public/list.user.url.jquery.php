<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

//echo $_GET['user']." / ".$public_path.$_GET['url']." / ".$public_title;
?>


<br clear="all" />

<?

$sql = "select bo_id, bo_public, su_short_url, bo_content, bo_date, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_GET['user'])." ";
$sql .= "where bo_public = 1 and bo_recycle_bin != 9 order by bo_id desc LIMIT ".$common_public_rows;
//$url_view = "/view.php?id=";

$result = mysql_query($sql, $connect); 
$total_record = mysql_num_rows($result);

if ($total_record == 0) { ?>
	<div align="center" style="padding-top:30px; padding-bottom:200px;"><img src="/skin/<? echo $public_skin ?>/img/public_num.png" /></div>
<? }

while ($row = mysql_fetch_array($result)){

	$bo_id = $row['bo_id'];
	$bo_public = $row['bo_public'];
	$su_short_url = $row['su_short_url'];
	//$bo_content = get_text_index($row['bo_content']);
	$bo_content = strip_tags($row['bo_content']);
	//$bo_content = strip_tags(get_text($row['bo_content']));
	//$bo_content = trim(htmlspecialchars($row['bo_content']));
	$bo_date = $row['bo_date'];
	$bo_date_format = $row['bo_date_format']; ?>
    
    <div class="wrdLatest" id="<? echo $bo_id ?>">
        <div id="listboard">
            <p id="list"><a href="<? echo $common_path.$su_short_url ?>"><? echo get_mb_strimwidth($bo_content, 220) ?></a>&nbsp;<? echo ($bo_public == 1) ? "<img src=\"/skin/".$public_skin."/img/lock.png\" />" : "" ?></p>
            <p id="posted_date_comment">Post by <span style="font-size:11px; font-style:normal"><? echo ($public_nickname == "") ? $_GET['user'] : $public_nickname ?></span>&nbsp;<? //echo diffDate($bo_date) ?>on&nbsp;<? echo $bo_date_format ?></p>    
        </div>
    </div>

<? } ?>

<div id="lastPostsLoader"></div>

<? if ($total_record != 0) { 
        if ($total_record >= $common_public_rows) { ?>
    <br clear="all"><a href="#" id="list_more"><img src="/skin/<? echo $public_skin ?>/img/more.gif" alt="더보기" /></a>
<? }} ?>

<br /><br /><br />

<script>
$(document).ready(function(){

	function lastPostFunc() { 
		$('div#lastPostsLoader').html("<center><img src='/skin/<? echo $public_skin ?>/img/loading.gif'></center>");
		$.post("/skin/<? echo $public_skin ?>/public/list.user.url.jquery.more.php?user=<? echo $_GET['user'] ?>&skin=<? echo $public_skin ?>&nickname=<? echo $public_nickname ?>&lastPostID=" + $(".wrdLatest:last").attr("id"),
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







<?
//임시
//session_unregister("set_subject_url");
?>
