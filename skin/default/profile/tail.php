

<script type="text/javascript"> 
//<![CDATA[ 

$(document).ready(function() {


	$( "button#profile_tosend" )
		.button({
			text: true,
			icons: {primary: "ui-icon-mail-open"}
		})
		.click(function() {
			//alert( $(this).attr("title") );
			//alert("구현 중입니다. 빠른 시일내에 구현하도록 하겠습니다.");
			window.open("/memo.php?mode=write&to=" + encodeURIComponent( $(this).attr("title") ) + "","memo","scrollbars=yes,width=700,height=550");
			return false;
		});
		
	$( "button#profile_friend_add" )
		.button({
			text: true,
			icons: {primary: "ui-icon-squaresmall-plus"}
		})
		.click(function() {
			$.post('/process/myfriends.php', { mode:"add", target_user:$(this).attr("title") }, function(data) {
				self.location.reload();
			});
		});	
		
	$( "button#profile_friend_del" )
		.button({
			text: true,
			icons: {primary: "ui-icon-squaresmall-minus"}
		})
		.click(function() {
			$.post('/process/myfriends.php', { mode:"del", target_user:$(this).attr("title") }, function(data) {
				self.location.reload();
			});
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
