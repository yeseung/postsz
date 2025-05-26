<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$sql = "select mb_email from remember_member where right(mb_open_mailling,1) = 0 and mb_email != '' order by mb_updated_date desc";
$result = mysql_query($sql, $connect);
//$row = mysql_fetch_array($result);
//$mb_email = $row['mb_email'];

$tmp_sql = "select count(*) as cnt from remember_member where right(mb_open_mailling,1) = 0 and mb_email != '' order by mb_updated_date desc";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$tmp_cnt = $tmp_row['cnt'];


/*echo $tmp_cnt"<br><br><br>";

for($i = 0; $i <= $cnt; $i++){
	echo $mb_email[$i].", ";

}*/

while ($row = mysql_fetch_array($result)){
	$mb_email = $row['mb_email'];
	
	echo $mb_email.", ";
	
}
?>
