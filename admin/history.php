<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

//로그인 기록 자동 삭제
$tmp_sql = "delete from remember_login_history where lh_datetime_login < date_add(now(), interval - ".$common_history_auto_del." day)";
mysql_query($tmp_sql, $connect);
//echo $tmp_sql;
?>


<table width="100%" border="0" cellpadding="0" cellspacing="2">
  <tr>
    <td valign="bottom">&nbsp;</td>
    <td align="right"><form id="ip-search-history">
<input type="text" id="ip_search" value="<? echo $_GET['search'] ?>"  class="text ui-widget-content ui-corner-all" style="width:200px; font-size:11px" maxlength="30" />
<input type="submit" title="IP Search" value="IP Search" style="font-size:11px" />
</form></td>
  </tr>
</table>


<form id="history_del">
<input type="hidden" name="mode" value="del">

<?
$page = $_GET[page];
if (!$page) $page = 1;


if (!$_GET['search']){
	$sql = "select * from remember_login_history order by lh_id desc";
}else{
	$sql = "select * from remember_login_history where lh_ip like '%".strip_tags($_GET['search'])."%' order by lh_id desc";
}

	
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
  	<td><input type="checkbox" id="total" /></td>
    <td><strong>번호</strong></td>
    <td><strong>아이디</strong></td>
    <td><strong>접속 IP</strong></td>
    <td><strong>운영체제</strong></td>
    <td><strong>브라우저</strong></td>
    <td><strong>최초 인증시간</strong></td>
    <td><strong>최근 접속시간</strong></td>
    <td><strong>유지 시간</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$lh_id = $row['lh_id'];
	$mb_user = $row['mb_user'];
	$lh_ip = $row['lh_ip'];
	$lh_agent = $row['lh_agent'];
	$lh_datetime_login = $row['lh_datetime_login'];
	$lh_datetime_logout = $row['lh_datetime_logout'];
	
?>
	<tr>
        <td><input type="checkbox" id="del[]" name="del[]" value="<? echo $lh_id ?>"></td>
        <td><? echo $number ?></td>
        <td><? echo get_profile($mb_user) ?></td>
        <!--<td><a href="javascript:IPSearch_KR('<? echo $lh_ip ?>');"><? echo $lh_ip ?></a></td>-->
        <td><? echo get_ip_search($lh_ip) ?></td>
        <td><? echo get_os($lh_agent) ?></td>
        <td><? echo get_brow($lh_agent) ?></td>
        <td><? echo str_replace("-", "/", (substr($lh_datetime_login, 2, 17))) ?></td>
        <td><? echo str_replace("-", "/", (substr($lh_datetime_logout, 2, 17))) ?></td>
        <td><? echo get_time_keep($lh_datetime_login, $lh_datetime_logout) ?></td>
	</tr>
<?
	$number--;
} //for
?>
</table>
<input type="submit" value="삭제" style="font-size:11px;" />
</form>


<br />
<div align="center">
<?

if (!$_GET['search']){
	$url_page = $common_path."admin/?mode=".$_GET['mode']."&page=";
}else{
	$url_page = $common_path."admin/?mode=".$_GET['mode']."&search=".strip_tags($_GET['search'])."&page=";
}

echo get_paging($common_admin_list_block, $page, $total_page, $url_page);

?>
</div>
<br />




<script type="text/javascript"> 
//<![CDATA[ 

$(document).ready(function() { 

	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "input:submit, button" ).button();
	$( "#button" ).buttonset();

	
	$('#total').click(function(){
		if ($("input#total").is(":checked")) { 
			$('input:checkbox[id^=del[]]:not(checked)').attr("checked", true); 
		} else { 
			$('input:checkbox[id^=del[]]:checked').attr("checked", false); 
		} 	
	}); 

	$( "form#history_del" ).submit(function() {
		var answer = confirm ('선택된 로그인 기록을 삭제하시겠습니까?');
  		if(answer){
			$.post('/process/adm.history.php', $("form#history_del").serialize(), function(data) {
				self.location.reload();
			});
			return false;
		}else{
			return false;
		}
	});

});

//]]> 
</script>
