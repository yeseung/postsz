<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<? echo get_rand(10)." / ".get_rand(10, "upper")." / ".get_rand(10, "lower")." / ".get_rand(10, "num") ?>

<br /><br />

하예승 test.php
<br /><br />

<? echo get_profile("temp") ?>

<br /><br />

<?
$tmp_sql = "select mb_user from remember_member order by mb_updated_date"; 
$tmp_result = mysql_query($tmp_sql, $connect); 

while ($tmp_row = mysql_fetch_array($tmp_result)){ 
	$mb_user = $tmp_row['mb_user'];  ?>
    
    <? echo get_profile($mb_user) ?>
    <br /><br />

<? } ?> 