<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


/*if (eregi("[^0-9]", $_GET['id'])){
	echo ("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
	exit;
}*/



if ($_GET['mode'] == "recv_view"){
	$sql = "select * from remember_memo where mm_id = '".trim($_GET['id'])."' and mm_send_user = '".trim($_SESSION['user'])."'";
}else if ($_GET['mode'] == "send_view"){	
	$sql = "select * from remember_memo where mm_id = '".trim($_GET['id'])."' and mb_user = '".trim($_SESSION['user'])."'";
}
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);
$total_record = mysql_num_rows($result);
if ($total_record == 0) {
	echo ("<script>
		window.alert('본 페이지는 열람하실 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");		
	exit;
}
$mb_user = $row['mb_user'];
$mm_send_user = $row['mm_send_user'];
$mm_notice = $row['mm_notice'];
$mm_memo = conv_content($row['mm_memo'], 0);
$mm_send_date = str_replace("-", "/", (substr($row['mm_send_date'], 2, 14)));
$mm_read_date = str_replace("-", "/", (substr($row['mm_read_date'], 2, 14)));
//$mm_send_date = $row['mm_send_date'];
//$mm_read_date = $row['mm_read_date'];

?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<? if ($_GET['mode'] == "send_view"){ ?>
	<tr>
		<td width="20%" align="right" height="28"><strong>받는사람</strong> : &nbsp;</td>
		<td><? echo get_profile($mm_send_user) ?></td>
	</tr>
    
<? }else if ($_GET['mode'] == "recv_view"){ ?>	
	<tr>
		<td width="20%" align="right" height="28"><strong>보낸사람</strong> : &nbsp;</td>
		<td><? echo get_profile($mb_user) ?></td>
	</tr>
<? } ?>
	<tr>
    	<td bgcolor="#F0F0F0" colspan="2"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
    </tr>    
	<tr>
		<td align="right" height="28"><strong>보낸시간</strong> : &nbsp;</td>
		<td><? echo $mm_send_date ?></td>
	</tr>
    <tr>
    	<td bgcolor="#F0F0F0" colspan="2"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
    </tr>
	<tr>
		<td align="right" valign="top" style="padding-top:7px;"><strong>내용</strong> : &nbsp;</td>
		<td style="padding-top:7px; padding-bottom:7px; word-wrap:break-word; line-height:1.6em;"><? echo get_notice_str($mm_notice) ?><? echo $mm_memo ?></td>
	</tr>
    <tr>
    	<td bgcolor="#F0F0F0" colspan="2"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
    </tr>	
</table>


<div align="right" style="padding-top:5px;">
	<button id="memo_del" title="<? echo $_GET['id'] ?>" style="font-size:11px;">삭제</button>
<? if ($_GET[mode] == "send_view"){ ?>
    <button id="memo_reply" title="<? echo $mm_send_user ?>" style="font-size:11px;">답장</button>
    <button id="memo_list_send" title="<? echo $_GET['page'] ?>" style="font-size:11px;">목록</button>
<? }else if ($_GET[mode] == "recv_view"){ ?>
    <button id="memo_reply" title="<? echo $mb_user ?>" style="font-size:11px;">답장</button>
    <button id="memo_list_recv" title="<? echo $_GET['page'] ?>" style="font-size:11px;">목록</button>
<? } ?>
</div>






<?
if ( ($_GET['mode'] == "recv_view") and ($mm_read_date == "00/00/00 00:00") ){
	$sql = "update remember_memo set mm_read_date = now() where mm_id = ".trim($_GET['id']);
	$result = mysql_query($sql, $connect);
}
?>