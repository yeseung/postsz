$(function() {




$( "#login_m" ).click(function() {
	if ($.cookie('cookie') != 'login'){
		if ( $("input#login_id").val() ) {
			if ( $("input#login_password").val() ) {
				$.post('/process/login.php', {id:$("input#login_id").val(), password:$("input#login_password").val()}, function(data) {
					if (data == 0){
						if ( $( "input#remember" ).is(":checked") ){
							$.cookie('id_cookie', $("input#login_id").val(), { expires: 1000000*1000 });
						}else{
							$.cookie('id_cookie', null);
						}
						$.cookie('cookie', 'login', { expires: 10*1000 });
						self.location.href = '/';
					}else if (data == 1){
						alert("비밀번호가 틀립니다. 비밀번호는 대소문자를 구분합니다.");
					}else if (data == 2){
						alert("가입된 회원이 아닙니다. 다시 가입하세요.");
					}
				});
			}else{
				alert("비밀번호를 입력하세요.");
			}
	   }else{
		   alert("아이디를 입력하세요.");
	   }		
	}else{
		alert("10초이상이 지나야 가능합니다.");
	}		
	return false;							   
});




/*$( "#login_m_home" ).click(function() {
	if ($.cookie('cookie') != 'login'){
		if ( $("input#login_id_home").val() ) {
			if ( $("input#login_password_home").val() ) {
				$.post('/process/login.php', {id:$("input#login_id_home").val(), password:$("input#login_password_home").val()}, function(data) {
					if (data == 0){
						$.cookie('id_cookie', $("input#login_id_home").val(), { expires: 1000000*1000 });
						$.cookie('cookie', 'login', { expires: 10*1000 });
						self.location.href = '/';
					}else if (data == 1){
						alert("비밀번호가 틀립니다. 비밀번호는 대소문자를 구분합니다.");
					}else if (data == 2){
						alert("가입된 회원이 아닙니다. 다시 가입하세요.");
					}
				});
			}else{
				alert("비밀번호를 입력하세요.");
			}
	   }else{
		   alert("아이디를 입력하세요.");
	   }		
	}else{
		alert("10초이상이 지나야 가능합니다.");
	}		
	return false;							   
});*/


var re_id = /^[a-z0-9]{3,16}$/; // 아이디 검사식
var re_pw = /^[a-z0-9_-]{4,18}$/; // 비밀번호 검사식
var re_mail = /^([\w\.-]+)@([a-z\d\.-]+)\.([a-z\.]{2,6})$/; // 이메일 검사식



$( "#register_m" ).click(function() {
								  
	if ($.cookie('cookie') != 'register'){
		if (re_id.test($( "input#id" ).val()) == true) { // 아이디 검사
			if (re_mail.test($( "input#email" ).val()) == true) { // 이메일 검사
				if (re_pw.test($( "input#password" ).val()) == true) { // 비밀번호 검사
		/*if ( $( "input#id" ).val() ) {	
			if ( $( "input#email" ).val() ) {
				if ( $( "input#password" ).val() ) {*/
					$.post('/process/register.php', {id:$( "input#id" ).val(), email:$( "input#email" ).val(), password:$( "input#password" ).val()}, function(data) {
						if (data == 0){
							alert("이미 사용중인 아이디 입니다.");
						}else if (data == 2){
							alert("같은 IP주소로 3번을 초과하여 가입하실 수 없습니다.");
						}else if (data == 1){
							alert("회원가입을 진심으로 축하합니다.\n회원님의 패스워드는 암호화 코드로 저장되므로 안심하셔도 좋습니다.\n회원의 탈퇴는 언제든지 가능하며 탈퇴 후, 회원님의 모든 소중한 정보는 삭제하고 있습니다.\n감사합니다.");
							$.cookie('cookie', 'register', { expires: 10*1000 });
							self.location.href = '/';
						}
					});
				}else{
					alert("비밀번호를 입력하세요.");
				}
			}else{
				alert("e-메일 주소를 입력하세요.");
			}
		}else{
			alert("아이디를 입력하세요. (영문자, 숫자 만)");
		}
	}else{
		alert("10초이상이 지나야 가능합니다.");
	}		
	return false;		
});



$("#radio1").click(function() {
	if ($("#radio1").is(":checked")){ $("input#public_checked").val("radio1")	}
});
$("#radio2").click(function() {
	if ($("#radio2").is(":checked")){ $("input#public_checked").val("radio2") 	}
});
$("#write_m").click(function(){ 
	if ($.cookie('cookie') != 'write'){
		if ( $("textarea#textarea-a").val() ){
			//alert ($("input#public_checked").val());
			$.post('/process/write.php', {public:$("input#public_checked").val(), content:$("textarea#textarea-a").val()}, 
				function(data) {
					if (data == 0){
						$.cookie('cookie', 'write', { expires: 10*1000 });
						self.location.href = '/';
					}else if (data == 1){
						alert("에러가 발생하였습니다.\n문제가 계속되는 경우에는 시스템 관리자에게 문의하십시오.");
					}
				});
		}else{
			alert("내용을 입력하세요.");
		}
	}else{
		alert("너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.");
	}		
	return false;
	
	
});





$( "#logout_m" ).click(function() {
	$.get('/process/logout.php', function(data){
		self.location.href = '/';
	});
});	


$( "#home_m" ).click(function(){ 
	self.location.href = '/';
});



var re_user_url = /^[a-z0-9]{3,18}$/; // 아이디 검사식	

$( "#set_m" ).click(function() {
	//alert($("input#subject").val() + " / " + $("select#rows").val() + " / " + $("input#scrolling_text").val());
	if ( $("input#subject").val() ) {
		if ( (re_user_url.test($( "input#user_url" ).val()) == true) ) { // 공개주소 검사
			$.post('/process/settings.php', { subject:$("input#subject").val(), user_url:$("input#user_url").val(), user_url_text:$("input#user_url_text").val(), rows_m:$("select#rows_m").val(), rows:$("input#rows").val(), scrolling_text:$("input#scrolling_text").val(), wysiwyg_text:$("input#wysiwyg_text").val(), security_text:$("input#security_text").val(), openset_text:$("input#openset_text").val(), recycle_bin_text:$("input#recycle_bin_text").val(), openapikey:$("input#openapikey").val(), openapisecret:$("input#openapisecret").val() }, function(data) {
				//alert(data);
				if (data == 1){
					alert('변경하셨습니다.');
					self.location.href = '/';
				}else if (data == 2){
					alert('예약어로 사용할 수없는 공개주소입니다.');
				}else if (data == 0){
					alert('이미 사용중인 공개주소입니다.');
				}
			});
		}else{
			alert("공개주소를 입력하세요. (영문자, 숫자 만)");
		}
	}else{
		alert("제목을 입력하세요.");	
	}
	return false;
});








$( "#mailling" ).click(function() {
	if ($(this).is(":checked")){ $("input#mailling_text").val("0") }else{ $("input#mailling_text").val("1") }
});	
$( "#open" ).click(function() {
	if ($(this).is(":checked")){ $("input#open_text").val("0") }else{ $("input#open_text").val("1") }
});	
$("#mypage_fb_m").click(function(){
	//if ( $("input#mypage_email").val() ) {
	//if (re_mail.test($( "input#mypage_email" ).val()) == true) { // 이메일 검사
		if ( $("input#mypage_nick").val() ){
			$.post('/process/mypage.php', {nickname:$("input#mypage_nick").val(), profile:$("textarea#profile").val(), open_text:$("input#open_text").val(), mailling_text:$("input#mailling_text").val()},																																											 			//$.post('/process/mypage.php', {email:$("input#mypage_email").val(), nickname:$("input#mypage_nick").val(), profile:$("textarea#profile").val(), open_text:$("input#open_text").val(), mailling_text:$("input#mailling_text").val()},
				function(data) {
					//self.location.reload();
					alert('변경하셨습니다.');
					self.location.href = '/';
			});
		}else{
			alert("별명을 입력하세요.");
		}	
	/*}else{
		alert("e-메일 주소를 입력하세요.");
	}*/
	return false;
});
$("#mypage_tw_m").click(function(){
	//if ( $("input#mypage_email").val() ) {
	if (re_mail.test($( "input#mypage_email" ).val()) == true) { // 이메일 검사
		if ( $("input#mypage_nick").val() ){
			$.post('/process/mypage.php', {email:$("input#mypage_email").val(), nickname:$("input#mypage_nick").val(), profile:$("textarea#profile").val(), open_text:$("input#open_text").val(), mailling_text:$("input#mailling_text").val()},																																											 			//$.post('/process/mypage.php', {email:$("input#mypage_email").val(), nickname:$("input#mypage_nick").val(), profile:$("textarea#profile").val(), open_text:$("input#open_text").val(), mailling_text:$("input#mailling_text").val()},
				function(data) {
					//self.location.reload();
					alert('변경하셨습니다.');
					self.location.href = '/';
			});
		}else{
			alert("별명을 입력하세요.");
		}	
	}else{
		alert("e-메일 주소를 입력하세요.");
	}
	return false;
});
$("#mypage_m").click(function(){ 
	//if ( $("input#mypage_email").val() ) {	
	if (re_mail.test($( "input#mypage_email" ).val()) == true) { // 이메일 검사
		if ( $("input#mypage_nick").val() ){
			if ( $("input#mypage_password").val() && $("input#mypage_password_confirm").val() ) {
				if ( $("input#mypage_password").val() == $("input#mypage_password_confirm").val() ) {
					$.post('/process/mypage.php', {email:$("input#mypage_email").val(), nickname:$("input#mypage_nick").val(), profile:$("textarea#profile").val(), password:$("input#mypage_password").val(), open_text:$("input#open_text").val(), mailling_text:$("input#mailling_text").val()}, function(data) {
						//self.location.reload();
						alert('변경하셨습니다.');
						self.location.href = '/';
					});
				}else{
					alert("비밀번호가 일치하지 않습니다. 다시 입력해주세요.");
				}	
			}else{
				alert("비밀번호를 입력하세요.");
			}
		}else{
			alert("별명을 입력하세요.");
		}
	}else{
		alert("e-메일 주소를 입력하세요.");
	}
	return false;
});









$("#search_m").click(function(){
	if ( $("input#qsearch").val() ) {
		//alert("?search=" + $("input#qsearch").val() + "");
		self.location.href = "/index.php?search=" + $("input#qsearch").val();
	}else{
		alert("검색어를 입력하세요.");
	}
	return false;
});






/*$( "#del" ).click(function() {
	var ret = confirm("글을 삭제하시면\n다시 복구할 수 없습니다.\n삭제하시겠습니까?");
	if(ret){
		alert(".............;;");
	}
	return false;
});*/
							   

$( "#del" ).click(function() {
		//alert( $(".delete_id").attr("id") );
		var ret = confirm("글을 삭제하시면\n다시 복구할 수 없습니다.\n삭제하시겠습니까?");
		if(ret){
			$.post('/process/delete.php', {mode:"no_recycle_bin", num:$(".delete_id").attr("id")}, function(data) {
				//alert(data);
				self.location.href = '/';
			});
		}
		return false;
	});












});