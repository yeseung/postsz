<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


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


	$( "form#memo_del" ).submit(function() {
		var answer = confirm ('선택된 쪽지를 삭제하시겠습니까?');
  		if(answer){
			$.post('/process/memo.php', $("form#memo_del").serialize(), function(data) {
				self.location.href = '/memo.php?mode=<? echo $_GET['mode'] ?>';
				//self.location.reload();
			});
			return false;
		}else{
			return false;
		}
	});
	
	
	$('a#tosend').click(function(){
		self.location.href = "/memo.php?mode=write&to=" + encodeURIComponent( $(this).attr("title") );
	});
	
	
	
	$( "form#memo_form" ).submit(function() {
		if ( $("input#send_email").val() ) {
			if ( $("textarea#memo").val() ){
				$.post('/process/memo.php', $("form#memo_form").serialize(), function(data) {
					//alert(data);
					if (data == 0){
						alert("존재하지 않는 아이디입니다. 올바른 아이디를 입력해주세요.");
					}else if (data == 1){
						self.location.href = '/memo.php?mode=send';
					}
				});
			}else{
				alert("쪽지 내용을 입력해주세요.");
			}			
		}else{
			alert("쪽지를 보낼 사용자의 아이디를 입력해주세요.");
		}	
		return false;
	});
	
	
	$('textarea.memo').maxlength({
		'feedback' : '.charsLeft' // note: looks within the current form
	});
	
	$( "button#memo_recv" )
		.button({
			text: true,
			icons: {primary: "ui-icon-mail-closed"}
		})
		.click(function() {
			self.location.href = "/memo.php?mode=recv";
		});
	
	$( "button#memo_send" )
		.button({
			text: true,
			icons: {primary: "ui-icon-mail-open"}
		})
		.click(function() {
			self.location.href = "/memo.php?mode=send";
		});
		
	$( "button#memo_write" )
		.button({
			text: true,
			icons: {primary: "ui-icon-pencil"}
		})
		.click(function() {
			self.location.href = "/memo.php?mode=write";
		});	
	
	$( "button#memo_write_mine" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-pencil"}
		})*/
		.click(function() {
			self.location.href = "/memo.php?mode=write&to=" + encodeURIComponent( $(this).attr("title") );
		});	
		
			
		
	$( "button#memo_reply" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-comment"}
		})*/
		.click(function() {
			self.location.href = "/memo.php?mode=write&to=" + encodeURIComponent( $(this).attr("title") );
		});
		
	$( "button#memo_list_send" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-document"}
		})*/
		.click(function() {
			self.location.href = "/memo.php?mode=send&page=" + $(this).attr("title");
		});
	
	$( "button#memo_list_recv" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-document"}
		})*/
		.click(function() {
			self.location.href = "/memo.php?mode=recv&page=" + $(this).attr("title");
		});	
		
	$( "button#memo_del" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-document"}
		})*/
		.click(function() {
			var answer = confirm ('선택된 쪽지를 삭제하시겠습니까?');
			if(answer){
				$.post('/process/memo.php', { mode:"<? echo substr($_GET['mode'], 0, 4) ?>", exec:"del", del: $(this).attr("title") }, function(data) {
					self.location.href = '/memo.php?mode=<? echo substr($_GET['mode'], 0, 4) ?>';
				});
				return false;
			}else{
				return false;
			}
		});	
		
	
	
	$('a.jt').cluetip({
		cluetipClass: 'jtip',
		arrows: false,
		dropShadow: false,
		hoverIntent: false,
		sticky: true,
		mouseOutClose: true,
		closePosition: 'title',
		width: '300px',
		closeText: '<img src="/img/cross.png" alt="close" />'
	});			
	

	
});

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
