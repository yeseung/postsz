<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select * from remember_twitter_post order by tp_id desc";
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
    <td><strong>트위터 아이디</strong></td>
    <td><strong>스크린네임</strong></td>
    <td><strong>토큰</strong></td>
    <td><strong>시크릿 토큰</strong></td>
    <td><strong>날짜</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$tp_id = $row['tp_id'];
	$mb_user = $row['mb_user'];
	$tp_oauth_token = $row['tp_oauth_token'];
	$tp_oauth_token_secret = $row['tp_oauth_token_secret'];
	$tp_user_id = $row['tp_user_id'];
	$tp_screen_name = $row['tp_screen_name'];
	$tp_date = str_replace("-", "/", (substr($row['tp_date'], 2, 14)));
?>
	<tr>
    	<td><? echo $number ?></td>
        <td><? echo get_profile($mb_user) ?></td>
        <td><? echo get_twitter_id($tp_screen_name) ?></td>
        <td><? echo $tp_user_id ?></td>
        <td><? echo $tp_oauth_token ?></td>
        <td><? echo $tp_oauth_token_secret ?></td>
        <td><? echo $tp_date ?></td>
	</tr>
<?
	$number--;
} //for
?>
</table>

<br />
<div align="center">
<?

$url_page = $common_path."admin/?mode=".$_GET['mode']."&page=";
echo get_paging($common_admin_list_block, $page, $total_page, $url_page);

?>
</div>
<br />
