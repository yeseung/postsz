<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../../../lib/common.php");
include_once ("../../../lib/dbconn.php");
include_once ("../../../lib/function.php");



$sql = "select bo_id, bo_public, su_short_url, bo_content, bo_date, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_GET['user'])." ";
$sql .= "where bo_id < ".$_GET['lastPostID']." and bo_public = 1 and bo_recycle_bin != 9 ";
$sql .= "order by bo_id desc LIMIT ".$common_public_rows;
$url_view = "/view.php?id=";

$result = mysql_query($sql, $connect); 
$total_record = mysql_num_rows($result);

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
            <p id="list"><a href="<? echo $common_path.$su_short_url ?>"><? echo get_mb_strimwidth($bo_content, 220) ?></a>&nbsp;<? echo ($bo_public == 1) ? "<img src=\"/skin/".$_GET['skin']."/img/lock.png\" />" : "" ?></p>
            <p id="posted_date_comment">Post by <span style="font-size:11px; font-style:normal"><? echo ($_GET['nickname'] == "") ? $_GET['user'] : $_GET['nickname'] ?></span>&nbsp;<? //echo diffDate($bo_date) ?>on&nbsp;<? echo $bo_date_format ?></p>    
        </div>
    </div>

<? } ?>
