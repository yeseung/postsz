<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<script type="text/javascript"> 
//<![CDATA[ 
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
		start: 0,
        visible: 9,
        scroll: 9,
        animation: 800,
        wrap: "last"
    });
});
//]]> 
</script>

<ul id="mycarousel" class="jcarousel-skin-tango">
<?
$tmp_sql = "select mb_user from remember_member order by rand() limit 18";
$tmp_result = mysql_query($tmp_sql, $connect);
while ($tmp_row = mysql_fetch_array($tmp_result)){
	$tmp_user = $tmp_row['mb_user'];
	echo "<li>".get_member_thumbnail($tmp_user)."</li>\n";
}
?>	
</ul>

