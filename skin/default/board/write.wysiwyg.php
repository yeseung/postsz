<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


if ($_SESSION['fb_facebook'] == 1){ //페이스북 ?>



<!-- Load TinyMCE -->
<script type="text/javascript" src="/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>

<script type="text/javascript"> 
//<![CDATA[ 

$().ready(function() {
	$('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		
		//한글적용
		language: "ko",
		//팝업스타일추가
    	popup_css_add: "/tinymce/tiny_mce_popup.css",
		//css_add: "/tiny_mce/tiny_mce_popup.css"
		
		script_url : '/tinymce/jscripts/tiny_mce/tiny_mce.js',
				
		forced_root_block : false, 
		
		//에디터 너비 높이 설정  
        height: "310",  
        width: "521",
			
		// General options
		theme : "advanced",
		//theme : "simple",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
		
		// Skin options
        //skin : "o2k7",
        //skin_variant : "silver",

		// Theme options
		//theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		//theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,forecolor,backcolor,|,fontselect,fontsizeselect",
		//theme_advanced_buttons2 : "cut,copy,paste,|,tablecontrols,|,charmap,emotions",
		theme_advanced_buttons2 : "insertdate,inserttime,|,link,unlink,|,sub,sup,|,charmap,emotions,image,|,preview,print,fullscreen,|,code,help",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		
		theme_advanced_fonts : "맑은고딕='malgun gothic';굴림=굴림;굴림체=굴림체;궁서=궁서;궁서체=궁서체;돋움=돋움;돋움체=돋움체;바탕=바탕;바탕체=바탕체;Arial=Arial; Comic Sans MS='Comic Sans MS';Courier New='Courier New';Tahoma=Tahoma;Times New Roman='Times New Roman';Verdana=Verdana",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css: "/tinymce/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
		
		

	$( "#radio_public" ).click(function() {
		if ($(this).is(":checked")){
			$("input#public").val("0");
			$('input#send').attr('checked', false);
			$('input#send').attr('disabled', true);
			$("input#send_text").val("0");
		}else{
			$("input#public").val("1");
		}
	});
	$( "#radio_closed" ).click(function() {
		if ($(this).is(":checked")){
			$("input#public").val("1");
			$('input#send').attr('checked', true);
			$('input#send').attr('disabled', false);
			$("input#send_text").val("1");
		}else{
			$("input#public").val("0");
		}
	});
		
	$( "#send" ).click(function() {
		if ($(this).is(":checked")){
			$("input#send_text").val("1");
		}else{ 
			$("input#send_text").val("0");
		}
	});	
		
	$( "form#write_wysiwyg" ).submit(function() {
		if ($.cookie('cookie') != 'write'){
			//alert($("input#public").val());
			//alert($('#elm1').html());
			if ( $('#elm1').html() ){
				$('div#right').html("<div style='padding:10px 25px 0 0'><img src='/skin/<? echo $common_skin ?>/img/loading_s.gif'></div>");
				$.post('/process/write.wysiwyg.php', {public:$("input#public").val(), send:$("input#send_text").val(), content:$('#elm1').html()}, 
				function(data) {
					//alert(data);
					///$(".temp").after(data);
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
<!-- /TinyMCE -->



<style> 

#content #write-form form#write_wysiwyg #left { 
	padding: 5px 0 0 0; margin: 0;
	width:451px;
	float: left;
	/*border:1px solid #FF0000;*/
	font-size:11px;
}

#content #write-form form#write_wysiwyg #right { 
	padding: 1px 0 0 0; margin: 0;
	float:right;
	height:30px;
	/*border:1px solid #FF0000;*/
}

</style> 

<div id="write-form">
<form id="write_wysiwyg">
<textarea id="elm1" name="elm1" class="tinymce"></textarea>
<div id="left"><input type="radio" id="radio_public" name="radio" <? echo ($_SESSION['set_open'] == 0) ? "checked" : "" ?> />비공개
<input type="radio" id="radio_closed" name="radio" <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?> />공개
<input type="checkbox" id="send" name="send" <? echo ($_SESSION['set_open'] == 0) ? "disabled" : "" ?> <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?>  />페이스북으로 보내기
<input type="hidden" id="public" name="public" value="<? echo ($_SESSION['set_open'] == 0) ? "0" : "1" ?>" />
<input type="hidden" id="send_text" name="send_test" value="<? echo ($_SESSION['set_open'] == 1) ? "1" : "0" ?>" /></div>
<div id="right"><input type="submit" name="save" value="post it!" /></div>
</form>
</div>

<script type="text/javascript">
if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
</script>


<? if ($_SERVER["SCRIPT_NAME"] == "/view.php") echo "<br /><br />" ?>













<? }else if ($_SESSION['fb_facebook'] == 2){ //트위터 { ?>











<!-- Load TinyMCE -->
<script type="text/javascript" src="/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>

<script type="text/javascript"> 
//<![CDATA[ 

$().ready(function() {
	$('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		
		//한글적용
		language: "ko",
		//팝업스타일추가
    	popup_css_add: "/tinymce/tiny_mce_popup.css",
		//css_add: "/tiny_mce/tiny_mce_popup.css"
		
		script_url : '/tinymce/jscripts/tiny_mce/tiny_mce.js',
				
		forced_root_block : false, 
		
		//에디터 너비 높이 설정  
        height: "310",  
        width: "521",
			
		// General options
		theme : "advanced",
		//theme : "simple",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
		
		// Skin options
        //skin : "o2k7",
        //skin_variant : "silver",

		// Theme options
		//theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		//theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,forecolor,backcolor,|,fontselect,fontsizeselect",
		//theme_advanced_buttons2 : "cut,copy,paste,|,tablecontrols,|,charmap,emotions",
		theme_advanced_buttons2 : "insertdate,inserttime,|,link,unlink,|,sub,sup,|,charmap,emotions,image,|,preview,print,fullscreen,|,code,help",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		
		theme_advanced_fonts : "맑은고딕='malgun gothic';굴림=굴림;굴림체=굴림체;궁서=궁서;궁서체=궁서체;돋움=돋움;돋움체=돋움체;바탕=바탕;바탕체=바탕체;Arial=Arial; Comic Sans MS='Comic Sans MS';Courier New='Courier New';Tahoma=Tahoma;Times New Roman='Times New Roman';Verdana=Verdana",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css: "/tinymce/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
		
		

	$( "#radio_public" ).click(function() {
		if ($(this).is(":checked")){
			$("input#public").val("0");
			$('input#send').attr('checked', false);
			$('input#send').attr('disabled', true);
			$("input#send_text").val("0");
		}else{
			$("input#public").val("1");
		}
	});
	$( "#radio_closed" ).click(function() {
		if ($(this).is(":checked")){
			$("input#public").val("1");
			$('input#send').attr('checked', true);
			$('input#send').attr('disabled', false);
			$("input#send_text").val("2");
		}else{
			$("input#public").val("0");
		}
	});
		
	$( "#send" ).click(function() {
		if ($(this).is(":checked")){
			$("input#send_text").val("2");
		}else{ 
			$("input#send_text").val("0");
		}
	});	
		
	$( "form#write_wysiwyg" ).submit(function() {
		if ($.cookie('cookie') != 'write'){
			//alert($("input#public").val());
			//alert($('#elm1').html());
			if ( $('#elm1').html() ){
				$('div#right').html("<div style='padding:10px 25px 0 0'><img src='/skin/<? echo $common_skin ?>/img/loading_s.gif'></div>");
				$.post('/process/write.wysiwyg.php', {public:$("input#public").val(), send:$("input#send_text").val(), content:$('#elm1').html()}, 
				function(data) {
					//alert(data);
					///$(".temp").after(data);
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
<!-- /TinyMCE -->



<style> 

#content #write-form form#write_wysiwyg #left { 
	padding: 5px 0 0 0; margin: 0;
	width:451px;
	float: left;
	/*border:1px solid #FF0000;*/
	font-size:11px;
}

#content #write-form form#write_wysiwyg #right { 
	padding: 1px 0 0 0; margin: 0;
	float:right;
	height:30px;
	/*border:1px solid #FF0000;*/
}

</style> 

<div id="write-form">
<form id="write_wysiwyg">
<textarea id="elm1" name="elm1" class="tinymce"></textarea>
<div id="left"><input type="radio" id="radio_public" name="radio" <? echo ($_SESSION['set_open'] == 0) ? "checked" : "" ?> />비공개
<input type="radio" id="radio_closed" name="radio" <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?> />공개
<input type="checkbox" id="send" name="send" <? echo ($_SESSION['set_open'] == 0) ? "disabled" : "" ?> <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?>  />트위터로 보내기
<input type="hidden" id="public" name="public" value="<? echo ($_SESSION['set_open'] == 0) ? "0" : "1" ?>" />
<input type="hidden" id="send_text" name="send_test" value="<? echo ($_SESSION['set_open'] == 1) ? "2" : "0" ?>" /></div>
<div id="right"><input type="submit" name="save" value="post it!" /></div>
</form>
</div>

<script type="text/javascript">
if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
</script>


<? if ($_SERVER["SCRIPT_NAME"] == "/view.php") echo "<br /><br />" ?>



































<? }else{ ?>

























<!-- Load TinyMCE -->
<script type="text/javascript" src="/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>

<script type="text/javascript"> 
//<![CDATA[ 

$().ready(function() {
	$('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		
		//한글적용
		language: "ko",
		//팝업스타일추가
    	popup_css_add: "/tinymce/tiny_mce_popup.css",
		//css_add: "/tiny_mce/tiny_mce_popup.css"
		
		script_url : '/tinymce/jscripts/tiny_mce/tiny_mce.js',
				
		forced_root_block : false, 
		
		//에디터 너비 높이 설정  
        height: "310",  
        width: "521",
			
		// General options
		theme : "advanced",
		//theme : "simple",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
		
		// Skin options
        //skin : "o2k7",
        //skin_variant : "silver",

		// Theme options
		//theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		//theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,forecolor,backcolor,|,fontselect,fontsizeselect",
		//theme_advanced_buttons2 : "cut,copy,paste,|,tablecontrols,|,charmap,emotions",
		theme_advanced_buttons2 : "insertdate,inserttime,|,link,unlink,|,sub,sup,|,charmap,emotions,image,|,preview,print,fullscreen,|,code,help",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		
		theme_advanced_fonts : "맑은고딕='malgun gothic';굴림=굴림;굴림체=굴림체;궁서=궁서;궁서체=궁서체;돋움=돋움;돋움체=돋움체;바탕=바탕;바탕체=바탕체;Arial=Arial; Comic Sans MS='Comic Sans MS';Courier New='Courier New';Tahoma=Tahoma;Times New Roman='Times New Roman';Verdana=Verdana",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css: "/tinymce/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
		
		
		
	$( "#radio_wysiwyg" ).buttonset();

	$( "#radio_public" )
		.button({
			text: false,
			icons: {primary: "ui-icon-locked"}
		})	
		.click(function() {
			if ($(this).is(":checked")){ $("input#public").val("0") }else{ $("input#public").val("1") }
		});
	$( "#radio_closed" )
		.button({
			text: false,
			icons: {primary: "ui-icon-unlocked"}
		})
		.click(function() {
			if ($(this).is(":checked")){ $("input#public").val("1") }else{ $("input#public").val("0") }
		});
		
	$( "form#write_wysiwyg" ).submit(function() {
		if ($.cookie('cookie') != 'write'){
			//alert($("input#public").val());
			//alert($('#elm1').html());
			
			if ( $('#elm1').html() ){
				$.post('/process/write.wysiwyg.php', {public:$("input#public").val(), content:$('#elm1').html()}, 
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
<!-- /TinyMCE -->



<form id="write_wysiwyg">
<table width="100%" border="0" cellspacing="0" cellpadding="1">
	<tr>
		<td colspan="2"><textarea id="elm1" name="elm1" class="tinymce"></textarea></td>
	</tr>
	<tr>
    	<td align="right"><div id="radio_wysiwyg">
<input type="radio" id="radio_public" name="radio" <? echo ($_SESSION['set_open'] == 0) ? "checked" : "" ?> /><label for="radio_public">비공개</label>
<input type="radio" id="radio_closed" name="radio" <? echo ($_SESSION['set_open'] == 1) ? "checked" : "" ?> /><label for="radio_closed">공개</label>
</div>
<input type="hidden" id="public" name="public" value="<? echo ($_SESSION['set_open'] == 0) ? "0" : "1" ?>" /></td>
		<td align="right" style="padding-top:1px; width:20px;"><input type="submit" name="save" value="post it!" /></td>
	</tr>
</table>
</form>


<script type="text/javascript">
if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
</script>












<? } ?>