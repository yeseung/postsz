<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

$sql = "select * from remember_login order by lo_date desc limit 100";
$result = mysql_query($sql, $connect); 
?>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
	<tr>
    	<td>IP</td>
        <td>아이디</td>
        <td>최근접속일</td>
        <td>제목</td>
        <td>주소</td>
	</tr>       
<?
while ($row = mysql_fetch_array($result)){
	$lo_ip = $row['lo_ip'];
	$mb_user = $row['mb_user'];
	$lo_date = $row['lo_date'];
	$lo_location = $row['lo_location'];
	$lo_url = $row['lo_url'];
	$lo_url_str = substr($lo_url, 1);
?>
	<tr>
    	<!--<td><a href="javascript:IPSearch_KR('<? echo $lo_ip ?>');"><? echo $lo_ip ?></a></td>-->
        <td><? echo get_ip_search($lo_ip) ?></td>
        <td><? echo get_profile($mb_user) ?></td>
        <td><? echo $lo_date ?></td>
        <td><? echo $lo_location ?></td>
        <td><? echo $lo_url != NULL ? "<a href=\"".$lo_url."\">".$common_path.$lo_url_str."</a>" : "" ?></td>
	</tr>
<? } ?>
</table>