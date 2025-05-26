<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if ($_SESSION['level'] != $common_admin_level){
	echo("<script>
		window.alert('관리자 메뉴입니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");			
	exit;	
}

if ($_SERVER['REMOTE_ADDR'] != $common_my_ip){ //my com
	echo("<script>
		window.alert('허용된 IP주소가 아닙니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");			
	exit;
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/img/postsz.ico" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<title><? echo $_GET['user'] ?> - 관리자</title>
<style>
body {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>

<script type="text/javascript" src="/js/jquery-1.6.2.js"></script>

<script type="text/javascript"> 
//<![CDATA[ 
$(document).ready(function() { 

}); 
//]]> 
</script>


</head>

<body>
<?

$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select * from remember_board_".$_GET['user']." order by bo_id desc";
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

echo "공개 : ".get_member_cnt_board_public($_GET['user'])."&nbsp;&nbsp;&nbsp;&nbsp;비공개 : ".get_member_cnt_board_private($_GET['user'])."<br /><br />";

if ($total_record != 0) {
?>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
	<tr>
        <td><strong>번호</strong></td>
        <td><strong>공개</strong></td>
        <td><strong>주소</strong></td>
        <td><strong>내용</strong></td>
        <td><strong>날짜</strong></td>
        <td><strong>조회수</strong></td>
        <td><strong>추천</strong></td>
        <td><strong>비추천</strong></td>
        <td><strong>삭제</strong></td>
	</tr>

<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	
	$bo_id = $row['bo_id'];
	$bo_public = $row['bo_public'];
	$su_short_url = $row['su_short_url'];
	$bo_content = trim(strip_tags(htmlspecialchars($row['bo_content'])));
	$bo_date = str_replace("-", "/", (substr($row['bo_date'], 2, 14)));
	$bo_hit = $row['bo_hit'];
	$bo_ip = $row['bo_ip'];
	$bo_good = $row['bo_good'];
	$bo_nogood = $row['bo_nogood'];
	$bo_option = $row['bo_option'];
	$bo_content_str = get_mb_strimwidth($bo_content, 60);
	$bo_recycle_bin = $row['bo_recycle_bin'];
	
	if ($common_admin_public == 1){
		//$bo_content_str_public = $bo_content_str;
		$bo_content_str_public = "<a title=\"".$bo_content."\">".$bo_content_str."</a>";
		//$bo_content_str_public = "<a href='#' onMouseover=\"ddrivetip('".$bo_content."', 300)\" onMouseout=\"hideddrivetip()\">".$bo_content_str."</a>";
	}else if ($common_admin_public == 0){
		if ($bo_public == 0){
			$bo_content_str_public = "비공개";
		}else if ($bo_public == 1){
			$bo_content_str_public = "<a title=\"".$bo_content."\">".$bo_content_str."</a>";
		}	 
	}

	?>
    
	<tr>
        <td><? echo $number ?></td>
        <td><? echo $bo_public == 0 ? "비공개" : "공개" ?></td>
        <td><? if ($bo_public == 1){ ?><a href="<? echo $common_path.$su_short_url ?>" target="_blank"><? echo $su_short_url ?></a><? } ?></td>
        <td><? echo $bo_content_str_public ?></td>
        <td><? echo $bo_date ?></td>
        <td><? echo $bo_hit ?></td>
        <td><? echo $bo_good ?></td>
        <td><? echo $bo_nogood ?></td>
        <td><? echo ($bo_recycle_bin == 9) ? "9" : "" ?></td>
   	</tr>  
    
    <?
	$number--;
} //for
?>
</table>
<br />

<div align="center">
<?
$url_page = $common_path."admin/member.post.php?user=".$_GET['user'];
$interval = $common_admin_list_block;

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

<? } //if ($total_record != 0}{ ?>

</body>
</html>
