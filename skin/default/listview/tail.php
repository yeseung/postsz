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


	$( "form#listview_del" ).submit(function() {
		var answer = confirm ('글을 삭제하시면 다시 복구할 수 없습니다.\n삭제하시겠습니까?');
  		if(answer){
			$.post('/process/listview.php', $("form#listview_del").serialize(), function(data) {
				//alert(data);
				self.location.href = '/listview.php';
				opener.document.location.href="/";
				//self.location.reload();
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


</body>
</html>



<?


//현재접속자
get_login();


//로그인 기록
get_logout_history();


?>

