<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>




<form action="http://whois.nic.or.kr/kor/whois.jsp" method="post" name="Post_IP" target="_blank">
<input type="hidden" name="sWord">
<input type="hidden" name="query">
</form>

<script type="text/javascript"> 
//<![CDATA[ 

$(document).ready(function() { 
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "input:submit, button" ).button();
	$( "#button" ).buttonset();


	$('#total').click(function(){
		if ($("input#total").is(":checked")) { 
			$('input:checkbox[id^=rec_num[]]:not(checked)').attr("checked", true); 
		} else { 
			$('input:checkbox[id^=rec_num[]]:checked').attr("checked", false); 
		} 	
	}); 
	
	$( "button#del" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-mail-closed"}
		})*/
		.click(function() {
			var answer = confirm ('선택된 로그인 기록을 삭제하시겠습니까?');
			if(answer){
				$.post('/process/history.php', $("form#history_del").serialize(), function(data) {
					//alert(data);
					self.location.href = '/history.php';
					//opener.document.location.href="/";
					//self.location.reload();
				});
				return false;
			}else{
				return false;
			}	
		});	
	
	
});

function IPSearch_KR(wIP){
	Post_IP.sWord.value=wIP;
	Post_IP.query.value=wIP;
	Post_IP.submit();
}



//]]> 
</script>


</body>
</html>



<?


//현재접속자
get_login();


//로그인 기록
get_logout_history();


?>
