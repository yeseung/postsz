<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../../../lib/common.php");
include_once ("../../../lib/dbconn.php");
include_once ("../../../lib/function.php");


if (!$_GET['search']){
	if (!$_GET['date']){
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." ";
		$sql .= "where bo_recycle_bin != 9 and bo_id < ".$_GET['lastPostID']." ";
		$sql .= "order by bo_id desc LIMIT ".$_SESSION['set_rows'];
		$url_view = "/view.php?id=";
	}else{
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." ";
		$sql .= "where bo_recycle_bin != 9 and bo_id < ".$_GET['lastPostID']." and left(bo_date,10) = '".get_date_time($_GET['date'])."' ";
		$sql .= "order by bo_id desc LIMIT ".$_SESSION['set_rows'];
		$url_view = "/view.php?date=".$_GET['date']."&id=";
	}	
}else{
	if (!$_GET['date']){
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." ";
		$sql .= "where bo_recycle_bin != 9 and bo_id < ".$_GET['lastPostID']." and bo_content like '%".htmlspecialchars($_GET['search'])."%' ";
		$sql .= "order by bo_id desc LIMIT ".$_SESSION['set_rows'];
		$url_view = "/view.php?search=".htmlspecialchars($_GET['search'])."&id=";
	}else{
		$sql = "select bo_id, bo_public, bo_content, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." ";
		$sql .= "where bo_recycle_bin != 9 and bo_id < ".$_GET['lastPostID']." and bo_content like '%".htmlspecialchars($_GET['search'])."%' ";
		$sql .= "and left(bo_date,10) = '".get_date_time($_GET['date'])."' ";
		$sql .= "order by bo_id desc LIMIT ".$_SESSION['set_rows'];
		$url_view = "/view.php?date=".$_GET['date']."&search=".htmlspecialchars($_GET['search'])."&id=";
	}	
}
$result = mysql_query($sql, $connect); 
$total_record = mysql_num_rows($result);

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
            <p id="list"><a href="<? echo $url_view.$bo_id ?>"><? //echo strcut_utf8($bo_content, 180) ?><? echo get_mb_strimwidth($bo_content, 220) ?></a>&nbsp;<? echo ($bo_public == 1) ? "<img src=\"/skin/".$common_skin."/img/lock.png\" />" : "" ?></p>
            <p id="posted_date_comment">Post by <span style="font-size:11px; font-style:normal"><? echo (!($_SESSION['nick'])) ? ( (!($_SESSION['fb_name'])) ? $_SESSION['user'] : $_SESSION['fb_name'] ) : $_SESSION['nick'] ?></span>&nbsp;on&nbsp;<? echo $bo_date_format ?></p>    
        </div>
    </div>

<? } ?>
