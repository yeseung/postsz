<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<form id="email_form">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="100" align="right">보내는 분 : &nbsp;</td>
    <td><input type="text" id="email_from" name="email_from" value="<? echo $common_email_from ?>" class="text ui-widget-content ui-corner-all" style="font-size:11px; width:99%; background: none;" /></td>
  </tr>
  <tr>
    <td align="right">반송될 메일 : &nbsp;</td>
    <td><input type="text" id="email_reply" name="email_reply" value="<? echo $common_email_reply_to ?>" class="text ui-widget-content ui-corner-all" style="font-size:11px; width:99%; background: none;" /></td>
  </tr>
  <tr>
    <td align="right">메일 : &nbsp;</td>
    <td><input type="text" id="email_to" name="email_to" class="text ui-widget-content ui-corner-all" style="font-size:11px; width:99%; background: none;" /></td>
  </tr>
  <tr>
    <td align="right">제목 : &nbsp;</td>
    <td><input type="text" id="email_sub" name="email_sub" class="text ui-widget-content ui-corner-all" style="font-size:11px; width:99%; background: none;" /></td>
  </tr>
  <tr>
    <td align="right">내용 : &nbsp;</td>
    <td><textarea id="email_cont" name="email_cont" style="font-size:11px; height:230px; width:99%; background: none;" class="text ui-widget-content ui-corner-all" /></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" style="padding:0 4px 0 0"><input type="submit" value="확인" style="font-size:11px;" /></td>
  </tr>
</table>
</form>






<script type="text/javascript">
//<![CDATA[ 



$("form#email_form").submit(function() {
    if ( $("input#email_from").val() &&  $("input#email_reply").val() && $("input#email_to").val() && $("input#email_sub").val() && $("textarea#email_cont").val()){
		$.post('/process/adm.email.php', $("form#email_form").serialize(), function(data){
			//alert(data);
			if (data == 1){
				alert("메일을 발송하였습니다.");
				self.location.reload();
			}else{
				alert("메일주소 오류입니다.");
			}
		});	
    }else{
        alert("입력하세요.");
    }
    return false;
});
    
    
    
//]]>
</script>