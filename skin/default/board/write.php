<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


if ($_SESSION['fb_facebook'] == 1){ //페이스북 ?>

	
<script type="text/javascript"> 
//<![CDATA[ 
$(document).ready(function() { 
		
	$( "#public1" ).click(function() {
		if ($(this).is(":checked")){
			$('input#send').attr('checked', false);
			$('input#send').attr('disabled', true);
			$("input#send_text").val("0");
		}
	});	
	$( "#public2" ).click(function() {
		if ($(this).is(":checked")){
			$('input#send').attr('checked', true);
			$('input#send').attr('disabled', false);
			$("input#send_text").val("1");
		}
	});	
	$( "#send" ).click(function() {
		if ($(this).is(":checked")){
			$("input#send_text").val("1");
		}else{ 
			$("input#send_text").val("0");
		}
	});
			
	$( "form#wrire" ).submit(function() {
		if ($.cookie('cookie') != 'write'){			
			if ( $("#write_content").val() ){
				$('div#right').html("<div style='padding:8px 0 0 0'><img src='/skin/<? echo $common_skin ?>/img/loading.gif'></div>");
				$.post('/process/write.php', {public:$("input:radio[name='public']:checked").val(), send:$("input#send_text").val(), content:$("#write_content").val()}, 
				function(data) {
					//alert(data);
					//$(".temp").after(data);
					if (data == 0){
						$.cookie('cookie', 'write', { expires: 7*1000 });
						self.location.href = '/';
					}else if (data == 1){
						$( "#hidden-message-error" ).dialog({
							resizable: false,
							width: 400,
							modal: true,
							buttons: {
								"확인": function() {
									$( this ).dialog( "close" );
								}
							}
						});
					}
					
				});
			}else{
				$( "#hidden-message-content" ).dialog({
					resizable: false,
					width: 400,
					modal: true,
					buttons: {
						"확인": function() {
							$( this ).dialog( "close" );
						}
					}
				});
			}
		}else{
			$( "#hidden-message-cookie" ).dialog({
				resizable: false,
				width: 400,
				modal: true,
				buttons: {
					"확인": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}		
		return false;
	});


});

//]]> 
</script>


<style> 

#content #write-form #setting{
	font-size:11px;
	padding:0 0 3px 0;
}

#content #write-form form#wrire #left { 
	padding: 0; margin: 0;
	width:451px;
	float: left;
	/*border:1px solid #FF0000;*/
}

#content #write-form form#wrire #right { 
	padding: 0; margin: 0;
	float:right;
	/*border:1px solid #FF0000;*/
}

#content #write-form form#wrire #left textarea#write_content {
	width:97%;
	height:70px;
	border: 1px solid #CCCCCC;
	background: none;
}
#content #write-form form#wrire #right input#submit {
	height:82px;
}

</style> 



<div id="write-form">
<form id="wrire">
	<div id="setting">
	<input type="radio" id="public1" name="public" <? echo ($_SESSION['set_open'] == 0) ? "checked" : "" ?> value="0" />비공개
    <input type="radio" id="public2" name="public" <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?> value="1" />공개&nbsp;&nbsp;
    <input type="checkbox" id="send" name="send" <? echo ($_SESSION['set_open'] == 0) ? "disabled" : "" ?> <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?>  />페이스북으로 보내기
    <input type="hidden" id="send_text" name="send_test" value="<? echo ($_SESSION['set_open'] == 1) ? "1" : "0" ?>" /></div>
    <div id="left"><textarea id="write_content" class="ui-widget-content ui-corner-all" /></textarea></div>
    <div id="right"><input type="image" title="Post it!" src="/skin/<? echo $common_skin ?>/img/post.png" /></div>
</form>   
</div>
<br clear="all">
	
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	
<? }else if ($_SESSION['fb_facebook'] == 2){ //트위터 { ?>









<script type="text/javascript"> 
//<![CDATA[ 
$(document).ready(function() { 
		
	$( "#public1" ).click(function() {
		if ($(this).is(":checked")){
			$('input#send').attr('checked', false);
			$('input#send').attr('disabled', true);
			$("input#send_text").val("0");
		}
	});	
	$( "#public2" ).click(function() {
		if ($(this).is(":checked")){
			$('input#send').attr('checked', true);
			$('input#send').attr('disabled', false);
			$("input#send_text").val("2");
		}
	});	
	$( "#send" ).click(function() {
		if ($(this).is(":checked")){
			$("input#send_text").val("2");
		}else{ 
			$("input#send_text").val("0");
		}
	});
			
	$( "form#wrire" ).submit(function() {
		if ($.cookie('cookie') != 'write'){			
			if ( $("#write_content").val() ){
				$('div#right').html("<div style='padding:8px 0 0 0'><img src='/skin/<? echo $common_skin ?>/img/loading.gif'></div>");
				$.post('/process/write.php', {public:$("input:radio[name='public']:checked").val(), send:$("input#send_text").val(), content:$("#write_content").val()}, 
				function(data) {
					//alert(data);
					//$(".temp").after(data);
					if (data == 0){
						$.cookie('cookie', 'write', { expires: 7*1000 });
						self.location.href = '/';
					}else if (data == 1){
						$( "#hidden-message-error" ).dialog({
							resizable: false,
							width: 400,
							modal: true,
							buttons: {
								"확인": function() {
									$( this ).dialog( "close" );
								}
							}
						});
					}
					
				});
			}else{
				$( "#hidden-message-content" ).dialog({
					resizable: false,
					width: 400,
					modal: true,
					buttons: {
						"확인": function() {
							$( this ).dialog( "close" );
						}
					}
				});
			}
		}else{
			$( "#hidden-message-cookie" ).dialog({
				resizable: false,
				width: 400,
				modal: true,
				buttons: {
					"확인": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}		
		return false;
	});


});

//]]> 
</script>


<style> 

#content #write-form #setting{
	font-size:11px;
	padding:0 0 3px 0;
}

#content #write-form form#wrire #left { 
	padding: 0; margin: 0;
	width:451px;
	float: left;
	/*border:1px solid #FF0000;*/
}

#content #write-form form#wrire #right { 
	padding: 0; margin: 0;
	float:right;
	/*border:1px solid #FF0000;*/
}

#content #write-form form#wrire #left textarea#write_content {
	width:97%;
	height:70px;
	border: 1px solid #CCCCCC;
	background: none;
}
#content #write-form form#wrire #right input#submit {
	height:82px;
}

</style> 

<div id="write-form">
<form id="wrire">
	<div id="setting">
	<input type="radio" id="public1" name="public" <? echo ($_SESSION['set_open'] == 0) ? "checked" : "" ?> value="0" />비공개
    <input type="radio" id="public2" name="public" <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?> value="1" />공개&nbsp;&nbsp;
    <input type="checkbox" id="send" name="send" <? echo ($_SESSION['set_open'] == 0) ? "disabled" : "" ?> <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?>  />트위터로 보내기
    <input type="hidden" id="send_text" name="send_test" value="<? echo ($_SESSION['set_open'] == 1) ? "2" : "0" ?>" /></div>
    <div id="left"><textarea id="write_content" class="ui-widget-content ui-corner-all" /></textarea></div>
    <div id="right"><input type="image" title="Post it!" src="/skin/<? echo $common_skin ?>/img/post.png" /></div>
</form>   
</div>
<br clear="all">







































<? }else{ ?>









<script type="text/javascript"> 
//<![CDATA[ 
$(document).ready(function() { 


	$( "#radio1" )
		.button({
			text: false,
			icons: {primary: "ui-icon-locked"}
		});
	$( "#radio2" )
		.button({
			text: false,
			icons: {primary: "ui-icon-unlocked"}
		});
		
	$( "form#wrire" ).submit(function() {
		if ($.cookie('cookie') != 'write'){
			var text = "";
			$( "#public_radio" ).find('label.ui-state-active').each(function() {
				text = $(this).attr("for");
			});
			if ( $("#write_content").val() ){
				$('div#right').html("<div style='padding:8px 0 0 0'><img src='/skin/<? echo $common_skin ?>/img/loading.gif'></div>");
				$.post('/process/write.php', {public:text, content:$("#write_content").val()}, 
				function(data) {
					//alert(data);
					//$(".temp").after(data);
					if (data == 0){
						$.cookie('cookie', 'write', { expires: 7*1000 });
						self.location.href = '/';
					}else if (data == 1){
						$( "#hidden-message-error" ).dialog({
							resizable: false,
							width: 400,
							modal: true,
							buttons: {
								"확인": function() {
									$( this ).dialog( "close" );
								}
							}
						});
					}
					
				});
			}else{
				$( "#hidden-message-content" ).dialog({
					resizable: false,
					width: 400,
					modal: true,
					buttons: {
						"확인": function() {
							$( this ).dialog( "close" );
						}
					}
				});
			}
		}else{
			$( "#hidden-message-cookie" ).dialog({
				resizable: false,
				width: 400,
				modal: true,
				buttons: {
					"확인": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}		
		return false;
	});


});

//]]> 
</script>


<style> 

<? if (stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) { ?>
#content #write-form form#wrire #public_radio { margin-bottom:4px; }
<? }else{ ?>
#content #write-form form#wrire #public_radio { margin-bottom:2px; }
<? }//if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) ?>

#content #write-form form#wrire #left { 
	padding: 0; margin: 0;
	width:451px;
	float: left;
	/*border:1px solid #FF0000;*/
}

#content #write-form form#wrire #right { 
	padding: 0; margin: 0;
	float:right;
	/*border:1px solid #FF0000;*/
}

#content #write-form form#wrire #left textarea#write_content {
	width:97%;
	height:70px;
	border: 1px solid #CCCCCC;
	background: none;
}
#content #write-form form#wrire #right input#submit {
	height:82px;
}

</style> 



<div id="write-form">
<form id="wrire">
	<div id="public_radio"><input type="radio" id="radio1" name="radio" <? echo ($_SESSION['set_open'] == 0) ? "checked" : "" ?> /><label for="radio1">비공개</label>
    <input type="radio" id="radio2" name="radio" <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?> /><label for="radio2">공개</label></div>
    <div id="left"><textarea id="write_content" class="ui-widget-content ui-corner-all" /></textarea></div>
    <div id="right"><input type="image" title="Post it!" src="/skin/<? echo $common_skin ?>/img/post.png" /></div>
</form>   
</div>
<br clear="all">



<? } //if ($_SESSION['fb_facebook'] == 1){ ?>