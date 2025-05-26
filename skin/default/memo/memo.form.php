<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<form id="memo_form">
<input type="hidden" name="mode" value="<? echo $_GET['mode'] ?>" />

<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size:11px;">
	<tr bgcolor="#f5f5f5">
		<td width="20%" align="right"><strong>받는 회원 아이디</strong> : &nbsp;</td>
		<td><input id="send_email" name="send_email" maxlength="20" style="width:98%;" class="text ui-widget-content ui-corner-all" <? echo (isset($_GET['to'])) ? "value=\"".urldecode($_GET['to'])."\" readonly" : "" ?> /></td>
	</tr>
	<!--<tr>
		<td>from.</td>
		<td><? echo $_SESSION['nick']." (".$_SESSION['user'].")" ?></td>
	</tr>-->
	<tr bgcolor="#f5f5f5">
		<td align="right" valign="top"><strong>내용 </strong> (<span class="charsLeft">255</span>/255) : &nbsp;</td>
		<td><textarea id="memo" name="memo" style="width:98%; height:250px;" maxlength="255" class="ui-widget-content ui-corner-all memo"></textarea></td>
	</tr>
    <tr bgcolor="#f5f5f5">
		<td>&nbsp;</td>
		<td align="right"><input type="submit" value="쪽지 보내기" style="font-size:11px;"></td>
	</tr>
</table>
	
</form>

