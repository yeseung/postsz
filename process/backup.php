<?
session_start();
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if (!$_SESSION['user']){
	echo("<script>
		window.alert('잘못된 접근입니다.')
		history.go(-1)
		</script>");
	exit;
}

$fr_date = $_GET['fr_date'];
$to_date = $_GET['to_date'];
$fr_date_filename = substr(str_replace("-", "", $fr_date), 2);
$to_date_filename = substr(str_replace("-", "", $to_date), 2);
//echo $fr_date_filename." / ".$to_date_filename;
//exit;

header("Content-type:application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition:attachment; filename={$common_path_str}_{$_SESSION['user']}_{$fr_date_filename}_{$to_date_filename}.xls");
header("Content-Description:PHP4 Generated Data");

//$sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 order by bo_id desc";
$sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_recycle_bin != 9 and ";
$sql .= "bo_date between right('".$fr_date."',10) and right('".$to_date."',10) order by bo_date desc"; 

$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);
if ($total_record == 0) { ?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><!--등록된 게시글이 없습니다.-->NULL</td>
    </tr>
</table>
<? }else{ ?>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
	<tr>
		<td>No.</td>
		<!--<td>공개</td>-->
		<td>Add</td>
		<td>Content</td>
		<td>Date</td>
	</tr>         
<?
$num = $total_record;
while ($row = mysql_fetch_array($result)){
	$bo_id = $row['bo_id'];
	$bo_public = $row['bo_public'];
	$su_short_url = $row['su_short_url'];
	//$bo_content = get_text_index($row['bo_content']);
	$bo_content = conv_content($row['bo_content'], 0);
	$bo_date = $row['bo_date'];
	//$bo_hit = $row['bo_hit'];
?>
	<tr>
		<td><? echo $num ?></td>
		<!--<td><? echo $bo_public == 0 ? "비공개" : "공개" ?></td>-->
		<td><? if ($bo_public == 1){ ?><a href="<? echo $common_path.$su_short_url ?>" target="_blank"><? echo $common_path.$su_short_url ?></a><? } ?></td>
		<td><? echo $bo_content ?></td>
		<td style="mso-number-format:'\@'"><? echo $bo_date ?></td>
	</tr>
<? 
	$num --;
}
?>
</table>

<?
} //if ($total_record == 0) {
mysql_close();
?>

