<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>



<form action="/process/adm.notice.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="write" />
<table width="100%" border="0" cellspacing="3" cellpadding="0">
    <tr>
        <td width="80" align="right">제목 : &nbsp;</td>
        <td><input type="text" name="sub" class="text ui-widget-content ui-corner-all" style="font-size:11px; width:99%; background: none;" /></td>
    </tr>
    <tr>
        <td align="right">내용 : &nbsp;</td>
        <td><textarea name="cont" style="font-size:11px; height:80px; width:99%; background: none;" class="text ui-widget-content ui-corner-all" /></textarea></td></td>
    </tr>
    <tr>
        <td align="right">링크1 : &nbsp;</td>
        <td><input type="text" name="link1" class="text ui-widget-content ui-corner-all" style="font-size:11px; width:99%; background: none;" /></td></td>
    </tr>
    <tr>
        <td align="right">링크2 : &nbsp;</td>
        <td><input type="text" name="link2" class="text ui-widget-content ui-corner-all" style="font-size:11px; width:99%; background: none;" /></td></td>
    </tr>
    <tr>
        <td align="right">파일첨부 : &nbsp;</td>
        <td><input type='button' value='추가' onclick='appendItem()' /><br />
            <input type="file" name="files[]" /><br />
            <div id="itemList"></div></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" value="글쓰기" style="font-size:11px;" /></td>
    </tr>
</table>   
</form>
    
    
<br />




<form id="notice_del">
<input type="hidden" name="mode" value="del">

<?

$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select * from remember_notice_board where mb_user = '".$common_admin."' order by nb_id desc";
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
    <td><strong>내용</strong></td>
    <td><strong>날짜</strong></td>
    <td><strong>최종업데이트 날짜</strong></td>
    <td><strong>조회</strong></td>
    <td><strong>링크</strong></td>
    <td><strong>수정</strong></td>
    <td><strong>삭제</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$nb_id = $row['nb_id'];
	$mb_user = $row['mb_user'];
	$nb_subject = $row['nb_subject'];
	//$nb_content = $row['nb_content'];
	//$nb_date = substr($row['nb_date'], 0, 10);
	//$nb_updated_date = substr($row['nb_updated_date'], 0, 10);
	$nb_date = str_replace("-", "/", (substr($row['nb_date'], 2, 14)));
	$nb_updated_date = str_replace("-", "/", (substr($row['nb_updated_date'], 2, 14)));
	//$nb_file_name_exp = explode("|", $row['nb_file_name']);
	//$nb_file_size_exp = explode("|", $row['nb_file_size']);
	$nb_hit = $row['nb_hit'];
	$nb_link_1 = $row['nb_link_1'];
	$nb_link_2 = $row['nb_link_2'];
	$nb_link = $nb_link_1."|".$nb_link_2;
	$nb_link_explode = explode("|", $nb_link);
	$nb_link_hit_1 = $row['nb_link_hit_1'];
	$nb_link_hit_2 = $row['nb_link_hit_2'];
	$nb_link_hit = $nb_link_hit_1."|".$nb_link_hit_2;
	$nb_link_hit_explode = explode("|", $nb_link_hit);
	$nb_recycle_bin = $row['nb_recycle_bin'];
	$nb_recycle_bin_date = $row['nb_recycle_bin_date'];

	
?>
	<tr>
    	<td><input type="checkbox" id="del[]" name="del[]" value="<? echo $nb_id ?>"></td>
        <td><? if ($nb_recycle_bin == 0){ ?><a href="#" onclick="MM_openBrWindow('/notice.php?mode=view&id=<? echo $nb_id ?>','notice','scrollbars=yes,width=700,height=500')" title="<? echo $nb_subject ?>" ><? echo get_mb_strimwidth($nb_subject, 160) ?></a><? }else{ ?><strike><span style="color:#999999"><? echo get_mb_strimwidth($nb_subject, 160) ?></span></strike><? } ?></td>
        <td><? echo $nb_date ?></td>
        <td><? echo $nb_updated_date ?></td>
        <td><? echo $nb_hit ?></td>
        <td><? if ($nb_link_1 != "") { ?><a href="<? echo $nb_link_1 ?>" title="<? echo $nb_link_1 ?>" target="_blank">LINK</a>(<? echo $nb_link_hit_1 ?>)<? } ?>&nbsp;<? if ($nb_link_2 != "") { ?><a href="<? echo $nb_link_2 ?>" title="<? echo $nb_link_2 ?>" target="_blank">LINK</a>(<? echo $nb_link_hit_2 ?>)<? } ?></td>
        <td><a href="#" onclick="MM_openBrWindow('/admin/notice.modify.php?id=<? echo $nb_id ?>','nb_modify','scrollbars=yes,width=700,height=620')" /><img src="/admin/img/nb_modify.gif" title="<? echo $nb_id ?>" /></a></td>
        <td><a href="#" id="strike"  title="<? echo $nb_id ?>" /><img src="/admin/img/nb_strike.gif" title="<? echo $nb_id ?>" /></a></td>
	</tr>
<?
	$number--;
} //for
?>
</table>
<input type="submit" value="삭제" style="font-size:11px;" />
</form>

<div align="right" style="padding-top:2px"></div>

<div align="center">
<? echo get_paging($common_admin_list_block, $page, $total_page, $common_path."admin/?mode=".$_GET['mode']."&page="); ?>
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

	$( "form#notice_del" ).submit(function() {
		var answer = confirm ('선택된 공지사항을 삭제하시겠습니까?');
  		if(answer){
			$.post('/process/adm.notice.php', $("form#notice_del").serialize(), function(data) {
				self.location.reload();
			});
			return false;
		}else{
			return false;
		}
	});
	
	$( "a#strike" ).click(function(){
		//alert ($(this).attr("title"));	
		$.post('/process/adm.notice.php', { mode:"strike", id:$(this).attr("title") }, function(data){
			//alert(data);
			self.location.reload();
		});
	}); 

});


var count = 0;
function appendItem() {
	if (count < 4){
		count++;
		var newItem = document.createElement("div");
		newItem.setAttribute("id", "item_" + count);
		var html = '<input type="file" name="files[]" />' + //새로 추가된 아이템['+count+']'+
		'<input type="button" value="삭제" onclick="removeItem(' + count + ')"/>';
		newItem.innerHTML = html;
		
		var itemListNode = document.getElementById('itemList');
		itemListNode.appendChild(newItem);
	}
}
function removeItem(idCount) {
	var item = document.getElementById("item_"+idCount);
	if (item != null) {
		item.parentNode.removeChild(item);
	}
}
//]]>	
</script>



