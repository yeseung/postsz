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
			var answer = confirm ('휴지통에 있는 항목들을 영구적으로 지우겠습니까?');
			if(answer){
				$.post('/process/delete.php', $("form#recycle_bin").serialize(), function(data) {
					//alert(data);
					//self.location.href = '/recycle.bin.php';
					//opener.document.location.href="/";
					self.location.reload();
				});
				return false;
			}else{
				return false;
			}	
		});	
	
	$( "button#recycle" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-mail-closed"}
		})*/
		.click(function() {
			var answer = confirm ('복원하시겠습니까?');
			if(answer){
				$.post('/process/recycle.php', $("form#recycle_bin").serialize(), function(data) {
					//alert(data);
					//self.location.href = '/recycle.bin.php';
					opener.document.location.href="/";
					self.location.reload();
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
