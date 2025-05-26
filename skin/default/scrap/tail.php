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


	$( "form#scrap_del" ).submit(function() {
		var answer = confirm ('선택된 스크랩을 삭제하시겠습니까?');
  		if(answer){
			$.post('/process/scrap.php', $("form#scrap_del").serialize(), function(data) {
				//alert(data);
				self.location.href = '/scrap.php';
				//self.location.reload();
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

