<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select * from remember_spam order by sp_id desc";
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
  	<td><strong>주소</strong></td>
    <td><strong>아이디</strong></td>
    <td><strong>from. 아이디</strong></td>
    <td><strong>사유</strong></td>
    <td><strong>기타</strong></td>
    <td><strong>IP</strong></td>
    <td><strong>날짜</strong></td>
    <td colspan="3"><strong>피드백</strong></td>
    <td><strong>삭제</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$sp_id = $row['sp_id'];
	$sp_url = $row['sp_url'];
	$sp_url_user = $row['sp_url_user'];
	$sp_from_user = $row['sp_from_user'];
	$sp_reason = $row['sp_reason'];
	$sp_andsoon = get_text_index($row['sp_andsoon']);
	$sp_ip = $row['sp_ip'];
	$sp_date = $row['sp_date'];
	//$sp_date = str_replace("-", "/", (substr($row['sp_date'], 2, 14)));
	$sp_feedback = $row['sp_feedback'];
	$sp_feedback_date = $row['sp_feedback_date'];
	$sp_feedback_date_str = str_replace(" ", "", (str_replace(":", "", (str_replace("-", "", (substr($sp_feedback_date, 2, 9)))))));
	
	switch($sp_reason){
		case "0" : $sp_reason_str = "영리목적/홍보성"; break;
		case "1" : $sp_reason_str = "음란성/선정성"; break;
		case "2" : $sp_reason_str = "불법정보"; break;
		case "3" : $sp_reason_str = "욕설/인신공격"; break;
		case "4" : $sp_reason_str = "개인정보노출"; break;
		case "5" : $sp_reason_str = "내용의 반복 게시 (도배)"; break;
		case "9" : $sp_reason_str = "기타"; break;
		default: $sp_reason_str = ""; break;	
	}
	
?>
	<tr>
    	<td><? echo $number ?></td>
        <td><a href="<? echo $common_path.$sp_url ?>" target="_blank"><? echo $sp_url ?></a></td>
        <!--<td><? echo get_member_user_url($sp_url_user) ?></td>
        	<td><? echo get_member_user_url($sp_from_user) ?></td>-->
        <td><? echo get_profile($sp_url_user) ?></td>
        <td><? echo get_profile($sp_from_user) ?></td>
        <td><? echo $sp_reason_str//."(".$sp_reason.")" ?></td>
		<td><a title="<? echo $sp_andsoon ?>"><? echo get_mb_strimwidth($sp_andsoon,40) ?></a></td>
        <!--<td><a href="javascript:IPSearch_KR('<? echo $sp_ip ?>');"><? echo $sp_ip ?></a></td>-->
        <td><? echo get_ip_search($sp_ip) ?></td>
        <td><? echo $sp_date ?></td>
        <td><? echo $sp_feedback ?></td>
        <td><? if ($sp_feedback_date != "0000-00-00 00:00:00"){ ?><? echo $sp_feedback_date_str ?><? } ?></td>
        <td><button id="feedback" title="<? echo $sp_id ?>">feedback</button></td>
        <td><button id="spam_del" title="<? echo $sp_id ?>">del</button></td>
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





<div id="hidden-message-spam-del" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>한번 삭제한 자료는 복구할 방법이 없습니다.<br />정말 삭제하시겠습니까?</p>
    <form id="spam_del">
    	<input type="hidden" value="del" name="mode" />
    	<input type="hidden" id="spam_del" name="num"  />
    </form>
</div>



<? if (isset($_GET['feedback'])){  ?>
<div id="hidden-message-feedback" title="<? echo $_GET['feedback'] ?>" style="display:none">
<?
$sql = "select sp_feedback from remember_spam where sp_id = ".$_GET['feedback'];
$tmp_result = mysql_query($sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$sp_feedback = $tmp_row['sp_feedback'];
?>
<form id="feedback">
<input type="hidden" name="mode" value="feedback" />
<input type="hidden" name="num" value="<? echo $_GET['feedback'] ?>" />
<textarea style="height:50px; width:98%;" maxlength="200" class="ui-widget-content ui-corner-all" name="feedback" /><? echo $sp_feedback ?></textarea>  
</form>
</div>
<? } //if (isset($_GET['user'])){ ?>