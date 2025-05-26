<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가



$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select distinct mb_user from remember_myfriends order by fr_id desc";
//$sql = "select mb_user from remember_member order by mb_updated_date desc";
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
    <td><strong>아이디</strong></td>
    <td><strong>사진</strong></td>
    <td width="40%"><strong>친구들</strong></td>
    <td width="40%"><strong>나를 친구로 추가한 친구들</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$mb_user = $row['mb_user'];
?>
	<tr>
    	<td><? echo $number ?></td>
        <!--<td><? echo get_member_post($mb_user) ?></td>-->
        <td><? echo get_profile($mb_user) ?></td>
        <td><? echo get_member_thumbnail($mb_user, 20, 20) ?></td>
        <td><?
		$sql1 = "select fr_target_user from remember_myfriends where mb_user ='".trim($mb_user)."' order by fr_id desc";
		$result1 = mysql_query($sql1, $connect);
		while ($row1 = mysql_fetch_array($result1)){ 
			$fr_target_user = $row1['fr_target_user'];
			echo get_member_thumbnail($fr_target_user, 20, 20);
		} ?></td>
        <td><?
		$sql2 = "select mb_user from remember_myfriends where fr_target_user ='".trim($mb_user)."' order by fr_id desc";
		$result2 = mysql_query($sql2, $connect);
		while ($row2 = mysql_fetch_array($result2)){ 
			$target_mb_user = $row2['mb_user'];
			echo get_member_thumbnail($target_mb_user, 20, 20);
		} ?></td>
	</tr>
<?
	$number--;
} //for
?>
</table>



<br />
<div align="center">
<? echo get_paging($common_admin_list_block, $page, $total_page, $common_path."admin/?mode=".$_GET['mode']."&page="); ?>
</div>
<br />