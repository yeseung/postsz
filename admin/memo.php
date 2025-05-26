<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

//읽은 쪽지 자동 삭제
$tmp_sql = "delete from remember_memo where mm_read_date != '0000:00:00 00:00:00' and mm_read_date < date_add(now(), interval - ".$common_memo_auto_del." day)";
mysql_query($tmp_sql, $connect);

?>


<form id="memo_form">
<input type="hidden" name="mode" value="write" />

<table width="100%" border="0" cellpadding="1" cellspacing="0" style="font-size:11px;">
    <tr>
    	<td colspan="2"><select name="notice" class="text ui-widget-content ui-corner-all" style="font-size:11px;">
        			<option value="0" selected>기본</option>
            		<option value="1" selected>공지사항</option>
                    <option value="2">긴급상황</option>
				</select></td>
    </tr>            
    <tr>    
		<td colspan="2"><textarea id="memo" name="memo" style="width:99%; height:80px; background: none;" maxlength="255" class="ui-widget-content ui-corner-all memo"></textarea></td>
	</tr>
    <tr>
    	<td valign="top" style="color:#999999">(<span class="charsLeft">255</span>/255)</td>
		<td align="right"><input type="submit" value="쪽지 보내기" style="font-size:11px;"></td>
	</tr>
</table>
</form>


<select class="text ui-widget-content ui-corner-all" style="font-size:11px;" onchange="linkTo(this.options[this.selectedIndex].value);">
<option value="/admin/?mode=memo" <? echo ($_GET['type'] != "") ? "selected" : "" ?>>기본</option>
<option value="/admin/?mode=memo&type=1" <? echo ($_GET['type'] == "1") ? "selected" : "" ?>>공지사항</option>
<option value="/admin/?mode=memo&type=2" <? echo ($_GET['type'] == "2") ? "selected" : "" ?>>긴급상황</option>
</select>

<form id="memo_del">
<input type="hidden" name="mode" value="del">

<?
$page = $_GET[page];
if (!$page) $page = 1;

switch ($_GET['type']){
	case 1: $sql = "select * from remember_memo where mm_notice = 1 order by mm_id desc"; break;
	case 2: $sql = "select * from remember_memo where mm_notice = 2 order by mm_id desc"; break;
	default: $sql = "select * from remember_memo order by mm_id desc";		
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
    <td><strong>보낸사람</strong></td>
    <td><strong>받는사람</strong></td>
    <td><strong>내용</strong></td>
    <td><strong>보낸시간</strong></td>
    <td><strong>읽은시간</strong></td>
    <td><strong>ip</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$mm_id = $row['mm_id'];
	$mb_user = $row['mb_user'];
	$mm_send_user = $row['mm_send_user'];
	$mm_notice = $row['mm_notice'];
	$mm_memo = trim(strip_tags(htmlspecialchars($row['mm_memo'])));
	$mm_send_date = str_replace("-", "/", (substr($row['mm_send_date'], 2, 14)));
	$mm_read_date = str_replace("-", "/", (substr($row['mm_read_date'], 2, 14)));
	$mm_ip = $row['mm_ip'];
	
?>
	<tr>
        <td><input type="checkbox" id="del[]" name="del[]" value="<? echo $mm_id ?>"></td>
        <td><? echo $number ?></td>
        <td><? echo get_profile($mb_user) ?></td>
        <td><? echo get_profile($mm_send_user) ?></td>
        <td><? echo get_notice_str($mm_notice) ?><? echo "<a title=\"".$mm_memo."\">".get_mb_strimwidth($mm_memo, 50)."</a>" ?></td>
        <td><? echo $mm_send_date ?></td>
        <td><? echo $mm_read_date ?></td>
        <td><a href="javascript:IPSearch_KR('<? echo $mm_ip ?>');"><? echo $mm_ip ?></a></td>
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
<? echo get_paging($common_admin_list_block, $page, $total_page, $common_path."admin/?mode=".$_GET['mode']."&type=".$_GET['type']."&page="); ?>
</div>
<br />




<script type="text/javascript"> 
//<![CDATA[ 

$(document).ready(function() { 

	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "input:submit, button" ).button();
	$( "#button" ).buttonset();

	$( "form#memo_form" ).submit(function() {
		if ( $("textarea#memo").val() ){
			$.post('/process/adm.memo.php', $("form#memo_form").serialize(), function(data) {
				self.location.reload();
			});
		}else{
			alert("쪽지 내용을 입력해주세요.");
		}			

		return false;
	});
	
	
	$('textarea.memo').maxlength({
		'feedback' : '.charsLeft' // note: looks within the current form
	});
	
	$('#total').click(function(){
		if ($("input#total").is(":checked")) { 
			$('input:checkbox[id^=del[]]:not(checked)').attr("checked", true); 
		} else { 
			$('input:checkbox[id^=del[]]:checked').attr("checked", false); 
		} 	
	}); 

	$( "form#memo_del" ).submit(function() {
		var answer = confirm ('선택된 쪽지를 삭제하시겠습니까?');
  		if(answer){
			$.post('/process/adm.memo.php', $("form#memo_del").serialize(), function(data) {
				self.location.reload();
			});
			return false;
		}else{
			return false;
		}
	});

});

function linkTo(optVal){
	if (optVal == "") return false;
	window.location = optVal;
}

//]]> 
</script>
