$(function() {
		   
	$(document).pngFix(); 
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "input:submit, button" ).button();
	$( "#public_radio" ).buttonset();
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	var id = $( "#id" ),
		email = $( "#email" ),
		password = $( "#password" ),
		allFields = $( [] ).add( id ).add( email ).add( password ),
		tips = $( ".validateTips" );
	
	function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}

	function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "Length of " + n + " must be between " +
				min + " and " + max + "." );
			return false;
		} else {
			return true;
		}
	}

	function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} else {
			return true;
		}
	}
	
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		resizable: false,
		//height: 350,
		width: 600,
		modal: true,
		buttons: {
			"회원가입": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );

				bValid = bValid && checkLength( id, "id", 3, 16 );
				bValid = bValid && checkLength( email, "email", 6, 80 );
				bValid = bValid && checkLength( password, "password", 4, 18 );

				bValid = bValid && checkRegexp( id, /^[a-z]([0-9a-z])+$/i, "Username may consist of a-z, 0-9, begin with a letter." );
				// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
				bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. webmaster@postsz.com" );
				bValid = bValid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

				if ( bValid ) {
					if ( $( "#check" ).is(":checked") ){
						$.post('/process/register.php', {id:id.val(), email:email.val(), password:password.val()}, 
						function(data) {
							if (data == 0){
								//alert("이미 사용중인 아이디 입니다.");
								$( "#hidden-message-id" ).dialog({
									resizable: false,
									width: 350,
									modal: true,
									buttons: {
										"확인": function() {
											$( this ).dialog( "close" );
											$( "#dialog-form" ).dialog( "open" );
										}
									}
								});
							}else if (data == 1){
								$( "#hidden-message-intro" ).dialog({
									resizable: false,
									width: 440,
									modal: true,
									buttons: {
										"확인": function() {
											$.cookie('cookie', 'register', { expires: 10*1000 });
											//self.location.reload();
											self.location.href = '/';
										}
									}
								});
							}else if (data == 2){
								//alert("같은 IP주소로 3번을 초과하여 가입하실 수 없습니다.");
								$( "#hidden-message-ip" ).dialog({
									resizable: false,
									width: 400,
									modal: true,
									buttons: {
										"확인": function() {
											$( this ).dialog( "close" );
											$( "#dialog-login" ).dialog( "open" );
										}
									}
								});
							}else if (data == 3){
								//alert("이미 존재하는 E-mail 주소입니다.");
								$( "#hidden-message-email" ).dialog({
									resizable: false,
									width: 400,
									modal: true,
									buttons: {
										"확인": function() {
											$( this ).dialog( "close" );
											$( "#dialog-form" ).dialog( "open" );
										}
									}
								});
							}
							//alert(data);
						});
						$( this ).dialog( "close" );
					}else{
						$( "#hidden-message-checked" ).dialog({
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
						
				}
			},
			"취소": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});
	
	
	/*$( "#remember" ).button({
		text: true,
		icons: {primary: "ui-icon-check"},
		//disabled: true
	})*/
	
	
	$( "#dialog-login" ).dialog({
		autoOpen: false,
		resizable: false,
		//height: 230,
		width: 530,
		modal: true,
		buttons: {
			"로그인": function() {
				if ( $("input#login_id").val() ) {
					if ( $("input#login_password").val() ) {
						$.post('/process/login.php', {id:$("#login_id").val(), password:$("#login_password").val()}, function(data) {
							if (data == 0){
								if ( $( "#remember" ).is(":checked") ){
									$.cookie('id_cookie', $("input#login_id").val(), { expires: 1000000*1000 });
								}else{
									$.cookie('id_cookie', null);
								}
								$.cookie('cookie', 'login', { expires: 10*1000 });
								//self.location.reload();
								self.location.href = '/';
							}else if (data == 1){
								$( "#hidden-message-password" ).dialog({
									resizable: false,
									width: 400,
									modal: true,
									buttons: {
										"확인": function() {
											$( "#dialog-login" ).dialog( "open" );
											$( this ).dialog( "close" );
											
										}
									}
								});
							}else if (data == 2){
								$( "#hidden-message-join" ).dialog({
									resizable: false,
									width: 400,
									modal: true,
									buttons: {
										"확인": function() {
											$( "#dialog-form" ).dialog( "open" );
											$( this ).dialog( "close" );
										}
									}
								});
							}
							//alert(data);
						});
					}else{
						//alert("비밀번호를 입력하세요.");
						$( "#hidden-message-login-pass" ).dialog({
							resizable: false,
							width: 400,
							modal: true,
							buttons: {
								"확인": function() {
									$( "#dialog-login" ).dialog( "open" );
									$( this ).dialog( "close" );
								}
							}
						});
					}
				}else{
					//alert("아이디를 입력하세요.");
					$( "#hidden-message-login-id" ).dialog({
						resizable: false,
						width: 400,
						modal: true,
						buttons: {
							"확인": function() {
								$( "#dialog-login" ).dialog( "open" );
								$( this ).dialog( "close" );
							}
						}
					});
				}
				$( this ).dialog( "close" );
			},
			"회원가입": function() {
				$( this ).dialog( "close" );
				$( "#dialog-form" ).dialog( "open" );
			},
			"취소": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );	
		}
	});
		
	/*$( "#create-user" )
		.button()
		.click(function() {
			if ($.cookie('cookie') != 'register'){
				$( "#dialog-form" ).dialog( "open" );
			}else{
				//alert("10초이상이 지나야 가능합니다.");
				$( "#hidden-message-ten" ).dialog({
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
		});*/
	
	$( "#create-user-a" ).click(function() {
		if ($.cookie('cookie') != 'register'){
			$( "#dialog-form" ).dialog( "open" );
		}else{
			//alert("10초이상이 지나야 가능합니다.");
			$( "#hidden-message-ten" ).dialog({
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
	
	/*$( "#login-user" )
		.button()
		.click(function() {
			if ($.cookie('cookie') != 'login'){
				$( "#dialog-login" ).dialog( "open" );
			}else{
				//alert("10초이상이 지나야 가능합니다.");
				$( "#hidden-message-ten" ).dialog({
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
			
		});*/
	
	$( "#login-user-a" ).click(function() {
		if ($.cookie('cookie') != 'login'){
			$( "#dialog-login" ).dialog( "open" );
		}else{
			//alert("10초이상이 지나야 가능합니다.");
			$( "#hidden-message-ten" ).dialog({
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
		
	/*$( "#logout" )
		.button()
		.click(function() {
			$.get('/process/logout.php');
			//setTimeout("self.location.reload();", 1000);
			setTimeout("self.location.href = '/';", 1000);
			
		});*/
	
	$( "#logout-a" ).click(function() {
		$.get('/process/logout.php', function(data){
			self.location.href = '/';
		});							
		//$.get('/process/logout.php');
		//$.cookie('id_cookie', null);
		//setTimeout("self.location.href = '/';", 1000);
		
	});
		
	$( "#check" ).button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})
	
	$( "#register" )
		.button({
			text: false,
			icons: {primary: "ui-icon-help"}
		})
		.click(function() {
			$( "#hidden-message-register" ).dialog({
				resizable: false,
				//resizable: true,
				width: 480,
				height: 280,
				modal: true,
				buttons: {
					"확인": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
		
		






	
	
	

		   
		 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
	
	$( "#open_private" )
		.click(function() {
			if ($(this).is(":checked")){ $("input#openset_text").val("0") }else{ $("input#openset_text").val("1") }
		});
	$( "#open_public" )
		.click(function() {
			if ($(this).is(":checked")){ $("input#openset_text").val("1") }else{ $("input#openset_text").val("0") }
		});
	$( "#post_twitter" )
		.click(function() {
			if ($(this).is(":checked")){ $("input#post_twitter_text").val("1") }else{ $("input#post_twitter_text").val("0") }
		});		
	$( "#scrolling" )
		.click(function() {
			if ($(this).is(":checked")){ $("input#scrolling_text").val("1") }else{ $("input#scrolling_text").val("0") }
		});
	$( "#recycle_bin" )
		.click(function() {
			if ($(this).is(":checked")){ $("input#recycle_bin_text").val("0") }else{ $("input#recycle_bin_text").val("1") }
		});	
	$( "#wysiwyg" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ($(this).is(":checked")){
				$("input#wysiwyg_text").val("1");
				$("input#security_text").val("0");
				$('input#security').attr('disabled', true);
			}else{
				$("input#wysiwyg_text").val("0");
				$('input#security').attr('disabled', false);
			}
		});	
	$( "#security" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ($(this).is(":checked")){ 
				$("input#security_text").val("1");
				$("input#wysiwyg_text").val("0");
				$('input#wysiwyg').attr('disabled', true);
			}else{ 
				$("input#security_text").val("0");
				$('input#wysiwyg').attr('disabled', false);
			}
		});	
		
	var re_user_url = /^[a-z0-9]{3,18}$/; // 아이디 검사식	
	
	$( "#hidden-message-set" ).dialog({
		autoOpen: false,
		resizable: false,
		//height: 540,
		width: 350,
		modal: true,
		buttons: {
			"저장": function() {
				if ( $("input#subject").val() ) {
					//if ( ($( "input#user_url" ).val() == "") || (re_user_url.test($( "input#user_url" ).val()) == true) ) { // 공개주소 검사
					if ( (re_user_url.test($( "input#user_url" ).val()) == true) ) { // 공개주소 검사
						$.post('/process/settings.php', $("form#set").serialize(), function(data) {
							//alert(data);
							//$("#temp").text(data);
							if (data == 0){
								//alert("이미 사용중인 공개주소입니다.");
								$( "#hidden-message-set-user-url-ing" ).dialog({
									resizable: false,
									width: 400,
									modal: true,
									buttons: {
										"확인": function() {
											$( this ).dialog( "close" );
										}
									}
								});
							}else if (data == 1){
								self.location.href = '/';
								$( this ).dialog( "close" );
							}else if (data == 2){
								//alert("예약어로 사용할 수없는 공개주소입니다.");
								$( "#hidden-message-set-user-url-res" ).dialog({
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
						//alert("공개주소를 입력하세요. (영문자, 숫자 만)");
						$( "#hidden-message-set-user-url" ).dialog({
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
					//alert("제목을 입력하세요.");
					$( "#hidden-message-set-subject" ).dialog({
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
			},
			"취소": function() {
				$( this ).dialog( "close" );
			},
			"백업": function() {
				$( "#hidden-message-set" ).dialog( "close" );
				$( "#hidden-message-set-backup" ).dialog({
					resizable: false,
					width: 350,
					modal: true,
					buttons: {
						"백업하기": function() {
							if ($.cookie('cookie_backup') != 'backup'){
								$.cookie('cookie_backup', 'backup', { expires: 10*1000 });
								self.location.href = "/process/backup.php?fr_date=" + $("input#fr_date").val() + "&to_date=" + $("input#to_date").val();
							}else{
								$( "#hidden-message-ten" ).dialog({
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
						},
						"취소": function() {
							$( "#hidden-message-set" ).dialog( "open" );
							$( this ).dialog( "close" );
						}
					}
				});
			},
			"복원": function() {
				$( "#hidden-message-set" ).dialog( "close" );
				window.open('/restoration.php','restoration','scrollbars=no,width=500,height=435');
				return false;
			}
			/*"개발자": function() {
				self.location.href = "/developers";
				return false;	
			}*/
			
		}
	});
	
	/*$( "#set" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-wrench"}
		})
		.click(function() {
			$( "#hidden-message-set" ).dialog( "open" );
		});	*/
	
	$( "#set-a" ).click(function() {
		$( "#hidden-message-set" ).dialog( "open" );
	});	
	
	$('input.subject').maxlength({
		'feedback' : '.charsLeft' // note: looks within the current form
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$( "#mailling" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ($(this).is(":checked")){ $("input#mailling_text").val("0") }else{ $("input#mailling_text").val("1") }
		});	
	
	$( "#open" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ($(this).is(":checked")){ $("input#open_text").val("0") }else{ $("input#open_text").val("1") }
		});
		
	$( "#thumbnail_del" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ($(this).is(":checked")){ $("input#thumbnail_del_text").val("thumbnail_del") }
		});		
	
	$( "#hidden-message-mypage" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 580,
		modal: true,
		buttons: {
			"저장": function() {
				if ( $("input#email").val() ) {
					if ( $("input#nickname").val() ) {
						if ( $("input#password").val()) {
							if ( $("input#password_confirm").val() ) {
								if ( $("input#password").val() == $("input#password_confirm").val() ) {
									$.post('/process/mypage.php', $("form#mypage").serialize(), 
										function(data) {
											//self.location.reload();
											self.location.href = '/';
									});
									$( this ).dialog( "close" );
								}else{
									$( "#hidden-message-password-confirm" ).dialog({
										resizable: false,
										width: 400,
										modal: true,
										buttons: {
											"확인": function() {
												$( this ).dialog( "close" );
											}
										}
									});
									//alert("비밀번호가 일치하지 않습니다. 다시 입력해주세요.");	
								}
							}else{
								//alert("비밀번호를 입력하세요.");
								$( "#hidden-message-password-none" ).dialog({
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
							//alert("비밀번호를 입력하세요.");
							$( "#hidden-message-password-none" ).dialog({
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
						//alert("별명을 입력하세요.");
						$( "#hidden-message-nickname-none" ).dialog({
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
					//alert("e-메일 주소를 입력하세요.");
					$( "#hidden-message-email-none" ).dialog({
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
			},
			"취소": function() {
				$( this ).dialog( "close" );
			},
			"초기화": function() {
				$( "#hidden-message-initialize" ).dialog({
					resizable: false,
					width: 330,
					modal: true,
					buttons: {
						"확인": function() {
							if ( $("input#initialize_password").val() ){
								$.post('/process/initialization.php', $("form#initialize").serialize(), function(data) {
									//alert(data);
									if (data == 2){
										//alert(게시판관리자 또는 서버관리자에게 문의 바랍니다.");
										$( "#hidden-message-level" ).dialog({
											resizable: false,
											width: 400,
											modal: true,
											buttons: {
												"확인": function() {
													$( this ).dialog( "close" );
												}
											}
										});
									}else if (data == 0){ 
										$( "#hidden-message-initialize-ok" ).dialog({
											resizable: false,
											width: 400,
											modal: true,
											buttons: {
												"확인": function() {
													$( this ).dialog( "close" );
													self.location.href = '/';
												}
											}
										});
									}else if (data == 1){
										$( "#hidden-message-password" ).dialog({
											resizable: false,
											width: 400,
											modal: true,
											buttons: {
												"확인": function() {
													$( this ).dialog( "close" );
													$( "#hidden-message-initialize" ).dialog( "open" );
												}
											}
										});
									}
								});
								$( this ).dialog( "close" );
							}else{
								$( "#hidden-message-password-confirm" ).dialog({
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
						},
						"취소": function() {
							$( this ).dialog( "close" );
						}
					}
				});
				$( this ).dialog( "close" );
			},
			"회원탈퇴": function() {
				$( "#hidden-message-dropout" ).dialog({
					resizable: false,
					width: 330,
					modal: true,
					buttons: {
						"확인": function() {
							if ( $("input#dropout_password").val() ){
								$.post('/process/dropout.php', $("form#dropout").serialize(), function(data) {
									//alert(data);
									if (data == 2){
										//alert(게시판관리자 또는 서버관리자에게 문의 바랍니다.");
										$( "#hidden-message-level" ).dialog({
											resizable: false,
											width: 400,
											modal: true,
											buttons: {
												"확인": function() {
													$( this ).dialog( "close" );
												}
											}
										});
									}else if (data == 0){ 
										$( "#hidden-message-dropout-ok" ).dialog({
											resizable: false,
											width: 400,
											modal: true,
											buttons: {
												"확인": function() {
													$( this ).dialog( "close" );
													self.location.href = '/';
												}
											}
										});
									}else if (data == 1){
										$( "#hidden-message-password" ).dialog({
											resizable: false,
											width: 400,
											modal: true,
											buttons: {
												"확인": function() {
													$( this ).dialog( "close" );
													$( "#hidden-message-dropout" ).dialog( "open" );
												}
											}
										});
									}
								});
								$( this ).dialog( "close" );
							}else{
								$( "#hidden-message-password-confirm" ).dialog({
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
						},
						"취소": function() {
							$( this ).dialog( "close" );
						}
					}
				});
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#hidden-message-mypage-fb" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 580,
		modal: true,
		buttons: {
			"저장": function() {
				//if ( $("input#email").val() ) {
					if ( $("input#nickname").val() ) {
						$.post('/process/mypage.php', $("form#mypage_fb").serialize(), 
							function(data) {
								//self.location.reload();
								self.location.href = '/';
						});
						$( this ).dialog( "close" );
					}else{
						//alert("별명을 입력하세요.");
						$( "#hidden-message-nickname-none" ).dialog({
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
				/*}else{
					//alert("e-메일 주소를 입력하세요.");
					$( "#hidden-message-email-none" ).dialog({
						resizable: false,
						width: 400,
						modal: true,
						buttons: {
							"확인": function() {
								$( this ).dialog( "close" );
							}
						}
					});
				}*/
			},
			"취소": function() {
				$( this ).dialog( "close" );
			},
			"초기화": function() {
				self.location.href = "/?mode=initialize";
				return false;	
			},
			"회원탈퇴": function() {
				self.location.href = "/?mode=dropout";
				return false;	
			}
		}
	});
	
	
	$( "#hidden-message-mypage-tw" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 580,
		modal: true,
		buttons: {
			"저장": function() {
				if ( $("input#email").val() ) {
					if ( $("input#nickname").val() ) {
						$.post('/process/mypage.php', $("form#mypage_tw").serialize(), 
							function(data) {
								//self.location.reload();
								self.location.href = '/';
						});
						$( this ).dialog( "close" );
					}else{
						//alert("별명을 입력하세요.");
						$( "#hidden-message-nickname-none" ).dialog({
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
					//alert("e-메일 주소를 입력하세요.");
					$( "#hidden-message-email-none" ).dialog({
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
			},
			"취소": function() {
				$( this ).dialog( "close" );
			},
			"초기화": function() {
				self.location.href = "/?mode=initialize";
				return false;	
			},
			"회원탈퇴": function() {
				self.location.href = "/?mode=dropout";
				return false;	
			}
		}
	});
	
	
	$( "#hidden-message-mypage-gg" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 580,
		modal: true,
		buttons: {
			"저장": function() {
				if ( $("input#nickname").val() ) {
					$.post('/process/mypage.php', $("form#mypage_gg").serialize(), 
						function(data) {							
							//self.location.reload();
							self.location.href = '/';
					});
					$( this ).dialog( "close" );
				}else{
					//alert("별명을 입력하세요.");
					$( "#hidden-message-nickname-none" ).dialog({
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
			},
			"취소": function() {
				$( this ).dialog( "close" );
			},
			"초기화": function() {
				self.location.href = "/?mode=initialize";
				return false;	
			},
			"회원탈퇴": function() {
				self.location.href = "/?mode=dropout";
				return false;	
			}
		}
	});
	
	
	
	/*$( "#mypage" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-gear"}
		})
		.click(function() {
			$( "#hidden-message-mypage" ).dialog( "open" );
		});	*/
	
	$( "#mypage-a" ).click(function() {
		$( "#hidden-message-mypage" ).dialog( "open" );
	});	
	
	/*$( "#mypage-fb" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-gear"}
		})
		.click(function() {
			$( "#hidden-message-mypage-fb" ).dialog( "open" );
		});	*/
	
	$( "#mypage-fb-a" ).click(function() {
		$( "#hidden-message-mypage-fb" ).dialog( "open" );
	});
	
	$( "#mypage-tw-a" ).click(function() {
		$( "#hidden-message-mypage-tw" ).dialog( "open" );
	});
	
	$( "#mypage-gg-a" ).click(function() {
		$( "#hidden-message-mypage-gg" ).dialog( "open" );
	});
	
	$('textarea.profile').maxlength({
		'feedback' : '.charsLeft' // note: looks within the current form
	});
	
	
	$("input#dropout_password").keydown(function(e){
		if(e.keyCode == 13){
			$( "#hidden-message-dropout" ).dialog( "open" );
			return false;
		}
	});
	
	$("input#code").keydown(function(e){
		if(e.keyCode == 13){
			$( "#hidden-message-dropout-fb" ).dialog( "open" );
			return false;
		}
	});
	
	$("input#initialize_password").keydown(function(e){
		if(e.keyCode == 13){
			$( "#hidden-message-initialize" ).dialog( "open" );
			return false;
		}
	});
	
	$("input#initialize_code").keydown(function(e){
		if(e.keyCode == 13){
			$( "#hidden-message-initialize-fb" ).dialog( "open" );
			return false;
		}
	});

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*function lastPostFunc() { 
		$('div#lastPostsLoader').html("<center><img src='/skin/" + $(".jq_common_skin").attr("id") + "/img/loading.gif'></center>");
		$.post("/skin/" + $(".jq_common_skin").attr("id") + "/board/list.jquery.more.php?search=" + $(".jq_search").attr("id") + "&lastPostID=" + $(".wrdLatest:last").attr("id"),
		function(data){
			if (data != "") {
				$(".wrdLatest:last").after(data);			
			}
			$('div#lastPostsLoader').empty();
		});
	};  
	
	$("#list_more").click(function(){ 
		lastPostFunc();
		return false;
	});	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$("form#quick-search input#qsearch").formtips({ 
		tippedClass: 'tipped'
	});
	
	
	$("form#quick-search").submit(function() {
		if ( $("input#qsearch").val() ) {
			//alert("?search=" + $("input#qsearch").val() + "");
			self.location.href = "/index.php?search=" + $("input#qsearch").val();
		}else{
			$( "#hidden-message-search" ).dialog({
				resizable: false,
				width: 400,
				modal: true,
				buttons: {
					"확인": function() {
						$( this ).dialog( "close" );
					}
				}
			});
			//alert("검색어를 입력하세요.");
		}
		return false;
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	$("a#copy-shorturl").zclip({
        path:'/js/ZeroClipboard.swf',
        copy:$('#shorturl').text()
    });
	
	$("a#copy-content").zclip({
        path:'/js/ZeroClipboard.swf',
        copy:$('#contentstr').text()
    });
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$( "#comments" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ( $(this).is(":checked") ){ $("input#comments").val("0") }else{ $("input#comments").val("1") }
		});	
	
	$( "#recommendations" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ( $(this).is(":checked") ){ $("input#recommendations").val("0") }else{ $("input#recommendations").val("1") }
		});
		
	$( "#sns" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ( $(this).is(":checked") ){ $("input#sns").val("0") }else{ $("input#sns").val("1") }
		});
		
	$( "#qrcode" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ( $(this).is(":checked") ){ $("input#qrcode").val("0") }else{ $("input#qrcode").val("1") }
		});
		
	$( "#html" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-check"}
		})*/
		.click(function() {
			if ( $(this).is(":checked") ){ $("input#html").val("0") }else{ $("input#html").val("1") }
		});				
	
	$( "#hidden-message-option" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 250,
		modal: true,
		buttons: {
			"저장": function() {
				$.post('/process/option.php', $("form#option").serialize(), 
					function(data) {
						//alert(data);
						self.location.reload();
				});
				
			},
			"취소": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	/*$( "#option" )
		.button({
			text: false, 
			icons: {primary: "ui-icon-gear"}
		})
		.click(function() {
			$( "#hidden-message-option" ).dialog( "open" );
		});	*/
		
	$( "a#option" ).click(function() {
		$( "#hidden-message-option" ).dialog( "open" );					   
	});	
		
		
		
		
		























		
		
		
		
	
								   
								   
	









	$(".contactme").click(function (e) {
		$('#contactme-modal-content').modal();
		return false;
	});
	
	$("#thumbnail").click(function () {
		window.open('/thumbnail.php','thumbnail','scrollbars=yes,width=800,height=600');
		//self.location.href = "/thumbnail.php";
		return false;
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
	
	$( "a#toolbar_listview" ).click(function() {
		window.open("/listview.php","listview","scrollbars=yes,width=700,height=500");
		return false;
	});
	
	$( "a#toolbar_memo_recv" ).click(function() {
		window.open("/memo.php","memo","scrollbars=yes,width=700,height=530");
		return false;
	});
	
	$( "a#toolbar_history" ).click(function() {
		window.open("/history.php","history","scrollbars=yes,width=700,height=500");
		return false;
	});
	
	$( "a#toolbar_point" ).click(function() {
		window.open("/point.php","point","scrollbars=yes,width=700,height=500");
		return false;
	});
	
	$( "a#toolbar_scrap" ).click(function() {
		window.open("/scrap.php","scrap","scrollbars=yes,width=700,height=500");
		return false;
	});
	
	$( "a#toolbar_recycle_bin" ).click(function() {
		window.open("/recycle.bin.php","recycle","scrollbars=yes,width=700,height=500");
		return false;
	});
	
	$( "a#toolbar_notice" ).click(function() {
		window.open("/notice.php","notice","scrollbars=yes,width=700,height=500");
		return false;
	});
	
	
	
	
	
	$("#tb_control").click(function () {
		$(".toolbar_box").slideToggle("slow");
	});
	
	$( "#log-menu-login-user-a" ).click(function() {
		$( "#dialog-login" ).dialog( "open" );	
		return false;		
	});
	
	$( "#log-menu-create-user-a" ).click(function() {
		$( "#dialog-form" ).dialog( "open" );	
		return false;		
	});
	
	$( "#log-menu-logout-a" ).click(function() {
		$.get('/process/logout.php', function(data){
			self.location.href = '/';
		});	
	});
	
	
	
	
	$( "a#profile_tosend" )
		.click(function() {
			window.open("/memo.php?mode=write&to=" + encodeURIComponent( $(this).attr("title") ) + "","memo","scrollbars=yes,width=700,height=550");
			return false;
		});
		
	$( "button#profile_tosend" )
		.button({
			text: true,
			icons: {primary: "ui-icon-mail-open"}
		})
		.click(function() {
			window.open("/memo.php?mode=write&to=" + encodeURIComponent( $(this).attr("title") ) + "","memo","scrollbars=yes,width=700,height=550");
			return false;
		});	



	
	
	$("button#openapi_reset").click(function () {
		$.post('/process/open.api.php',	function(data) {
			if (data == 1){
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
			}else{
				$("input#openapikey").val(data)
			}
		});
		return false;
	});	
	
	
	
	$("button#email_certify").click(function () {
		//alert( $("input#email").val() );
		$.post('/process/email.check.php', { email:$("input#email").val() }, function(data) {
			//alert(data);
			if (data == 1){
				//alert("e-메일 주소를 입력하세요.");
				$( "#hidden-message-email-none" ).dialog({
					resizable: false,
					width: 400,
					modal: true,
					buttons: {
						"확인": function() {
							$( this ).dialog( "close" );
						}
					}
				});
			}else if (data == 0){
				//alert("동일한 메일주소가 2개 이상 존재합니다. 관리자에게 문의하여 주십시오.");
				$( "#hidden-message-email-same" ).dialog({
					resizable: false,
					width: 400,
					modal: true,
					buttons: {
						"확인": function() {
							$( this ).dialog( "close" );
						}
					}
				});
			}else if (data == 2){
				//alert("메일을 발송하였습니다.");
				$( "#hidden-message-email-ok" ).dialog({
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
		return false;
	});	
	
	
	
	
	
	
	
	
	
	
	var $elem = $('#warp_all');
	
	$('#nav_up').fadeIn('slow');
	$('#nav_down').fadeIn('slow');  
	
	$(window).bind('scrollstart', function(){
		$('#nav_up,#nav_down').stop().animate({'opacity':'0.3'});
	});
	$(window).bind('scrollstop', function(){
		$('#nav_up,#nav_down').stop().animate({'opacity':'1'});
	});
	
	$('#nav_down').click(
		function (e) {
			$('html, body').animate({scrollTop: $elem.height()}, 2000);
		}
	);
	$('#nav_up').click(
		function (e) {
			$('html, body').animate({scrollTop: '0px'}, 800);
		}
	);
	
	
	
	
	
	
	
});