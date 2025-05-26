<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>
</td>
</tr>
</table>

<!-- tail.php 하예승 -->



<form action="http://whois.nic.or.kr/kor/whois.jsp" method="post" name="Post_IP" target="_blank">
<input type="hidden" name="sWord">
<input type="hidden" name="query">
</form>


<script type="text/javascript">
//<![CDATA[

$(document).ready(function() { 

	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "input:submit, button" ).button();

	$( "#logout-a" ).click(function() {
		$.get('/process/logout.php', function(data){
			self.location.href = '/';
		});
	});

	$( "#submit_db" ).click(function() {
		$.post('/process/adm.db.php', { table:$("select#table").val(), amcd:$("select#amcd").val(), column:$("input#column").val() }, function(data){
			if (data != "") {
				$(".wrdLatest:last").after(data);			
			}
		});
	});
	
	$( "#submit_ad" ).click(function() {
		$.post('/process/adm.ad.php', $("form#ad").serialize(), function(data){
			//alert(data);
			if (data == 0){
				self.location.reload();
			}
		});
	});
	

	$( "#hidden-message-set" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 400,
		modal: true,
		buttons: {
			"확인": function() {
				$.post('/process/adm.member.php', $("form#set").serialize(), function(data) {
					if (data == 0){
						alert('변경하셨습니다.');
						self.location.reload();
					}/*else if (data == 1){
						alert("게시판관리자 또는 서버관리자에게 문의 바랍니다.");
					}*/
				});
				$( this ).dialog( "close" );
			},
			"취소": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	<? if (isset($_GET['user'])){ ?>
	$( "#hidden-message-set" ).dialog( "open" );	
	<? } ?>			
		
	$( "button#set" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-wrench"}
		})
		.click(function() {
			self.location.href = "/admin/?mode=member&type=<? echo $_GET['type'] ?>&page=<? echo $_GET['page'] ?>&user=" + $(this).attr("title");
		});
	
	
	$( "#hidden-message-delete" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 400,
		modal: true,
		buttons: {
			"확인": function() {
				$.post('/process/adm.member.php', $("form#delete").serialize(), function(data) {
					//alert(data);
					if (data == 0){
						self.location.reload();
					}else if (data == 1){
						alert("게시판관리자 또는 서버관리자에게 문의 바랍니다.");
					}
				});
				$( this ).dialog( "close" );
			},
			"취소": function() {
				$( this ).dialog( "close" );
			}
		}
	});		
		
	$( "button#delete" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-trash"}
		})
		.click(function() {
			$("input#delete").val( $(this).attr("title") )
			$( "#hidden-message-delete" ).dialog( "open" );
		});
		
	$( "#hidden-message-spam-del" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 400,
		modal: true,
		buttons: {
			"확인": function() {
				$.post('/process/adm.spam.php', $("form#spam_del").serialize(), function(data) {
					//alert(data);
					if (data == 0){
						self.location.reload();
					}
				});
				$( this ).dialog( "close" );
			},
			"취소": function() {
				$( this ).dialog( "close" );
			}
		}
	});	
	
	
	/*$( "#hidden-message-search-del" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 400,
		modal: true,
		buttons: {
			"확인": function() {
				$.post('/process/adm.search.php', $("form#search_del").serialize(), function(data) {
					//alert(data);
					if (data == 0){
						self.location.reload();
					}
				});
				$( this ).dialog( "close" );
			},
			"취소": function() {
				$( this ).dialog( "close" );
			}
		}
	});*/
	
	
	$( "button#search_del" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-trash"}
		})
		.click(function() {
			//alert( $(this).attr("title") );
			//$("input#search_del").val( $(this).attr("title") );
			//$( "#hidden-message-search-del" ).dialog( "open" );
			$.post('/process/adm.search.php', {mode:"del", num:$(this).attr("title")}, function(data) {
				//alert(data);
				if (data == 0){
					self.location.reload();
				}
			});		
			
		});	
		
	$( "button#spam_del" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-trash"}
		})
		.click(function() {
			//alert( $(this).attr("title") );
			$("input#spam_del").val( $(this).attr("title") );
			$( "#hidden-message-spam-del" ).dialog( "open" );
		});	
	
	$( "button#ad_del" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-trash"}
		})
		.click(function() {
			$.post('/process/adm.ad.php', {mode:"del", num:$(this).attr("title")}, function(data) {
				//alert(data);
				if (data == 0){
					self.location.reload();
				}
			});		
			
		});
	
		
		
		
		
		
	$( "#hidden-message-feedback" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 400,
		modal: true,
		buttons: {
			"확인": function() {
				$.post('/process/adm.spam.php', $("form#feedback").serialize(), function(data) {
					if (data == 0){
						self.location.reload();
					}
				});
				$( this ).dialog( "close" );
			},
			"취소": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	<? if (isset($_GET['feedback'])){ ?>
	$( "#hidden-message-feedback" ).dialog( "open" );	
	<? } ?>			
		
	$( "button#feedback" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-pencil"}
		})
		.click(function() {
			self.location.href = "/admin/?mode=spam&page=<? echo $_GET['page'] ?>&feedback=" + $(this).attr("title");
		});
		
			
		
		
		
	$( "button#blacklist_on" )
		.button({
			text: true,
			icons: {primary: "ui-icon-plusthick"}
		})
		.click(function() {
			$.post('/process/adm.blacklist.php', { num:$(this).attr("title") }, function(data) {
				//alert(data);
				self.location.reload();
			});
		});
	
	$( "button#blacklist_off" )
		.button({
			text: true,
			icons: {primary: "ui-icon-minusthick"}
		})
		.click(function() {
			$.post('/process/adm.blacklist.php', { num:$(this).attr("title") }, function(data) {
				//alert(data);
				self.location.reload();
			});
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
	
	
	
	

	/*$( "button#point_del" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-trash"}
		})
		.click(function() {
			if (window.confirm("삭제하시겠습니까?")) {
				$.post('/process/adm.point.php', {mode:"del", num:$(this).attr("title")}, function(data) {
					if (data == 0){
						self.location.reload();
					}
				});		
			}else{
				return false;
			}
		});*/
		
	$( "#submit_point" ).click(function() {
		if ( $("input#user").val() &&  $("input#content").val() && $("input#point").val() ){
			$.post('/process/adm.point.php', $("form#insert_point").serialize(), function(data){
				if (data == 0){
					self.location.reload();
				}else if (data == 1){
					alert("존재하지 않는 아이디입니다. 올바른 아이디를 입력해주세요.");
				}
			});	
		}else{
			alert("아이디, 포인트, 내용을 입력하세요.");
		}
	});
	
	$( "#update_point" ).click(function() {
		if (window.confirm("포인트 정리를 하시면 최근 포인트 부여 내역을 삭제하므로\n포인트 부여 내역을 필요로 할때 찾지 못할 수도 있습니다.\n\n그래도 진행하시겠습니까?")) {
			$.post('/process/adm.point.php', {mode:"update"}, function(data){
				alert(data);
				self.location.reload();
			});
		}else{
			return false;
		}	
	});	
	
	
	$("form#ip-search").submit(function() {
		if ( $("input#ip_search").val() ) {
			self.location.href = "/admin/index.php?mode=visit&search=" + $("input#ip_search").val();
		}else{
			alert("검색어를 입력하세요.");
		}
		return false;
	});
	
	$("form#ip-search-history").submit(function() {
		if ( $("input#ip_search").val() ) {
			self.location.href = "/admin/index.php?mode=history&search=" + $("input#ip_search").val();
		}else{
			alert("검색어를 입력하세요.");
		}
		return false;
	});	
	
	
	$("form#contactform").submit(function() {
		if ( $("input#title").val() &&  $("input#message").val() ){
			alert("fdfgfgfgfgfg");
		}else{
			alert("제목, 내용을 입력하세요.");
		}
		return false;
	});	
	
	
	
	



});

function IPSearch_KR(wIP){
	Post_IP.sWord.value=wIP;
	Post_IP.query.value=wIP;
	Post_IP.submit();
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

 
//]]>
</script>


</body>
</html>

