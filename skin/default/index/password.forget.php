<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<div style="font-size:17px; font-weight:bold; padding:0 0 20px 0;">회원아이디/패스워드 찾기</div><br />
<div style="font-size:11px">

<form id="email_pass_forget_submit" method="post">
<table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="padding:0 0 3px 5px">회원가입시 등록하신 이메일주소 입력</td>
  </tr>
  <tr>
    <td align="center" style="padding:0 0 0 1px"><input type="text" name="email_pass_forget" id="email_pass_forget" size="45" class="text ui-widget-content ui-corner-all" style="border:1px solid #999999; width:300px;" /></td>
  </tr>
  <!--<tr>
    <td>문자/숫자를 입력하세요.</td>
  </tr>-->
  <tr>
    <td align="center"><?php
require_once('lib/recaptchalib.php');

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

# was there a reCAPTCHA response?
if ($_POST["recaptcha_response_field"]) {
		$resp = recaptcha_check_answer ($privatekey,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);

		if ($resp->is_valid) {
				//echo "You got it!";
				
				//echo "test : ".$_POST['email_pass_forget'];
				
				$email_pass_forget = trim($_POST['email_pass_forget']);
				
				if (!$email_pass_forget){
					echo("<script>
						window.alert('메일주소 오류입니다.');
						</script>");
					echo ("<meta http-equiv=\"refresh\" content=\"0; url=/forget\">");	
					exit;
				}
				
				$tmp_sql = "select count(*) as cnt from remember_member where mb_email='".$email_pass_forget."'";
				$tmp_result = mysql_query($tmp_sql, $connect);
				$tmp_row = mysql_fetch_array($tmp_result);
				
				if ($tmp_row['cnt'] > 1){
					echo("<script>
						window.alert('동일한 메일주소가 2개 이상 존재합니다.\\n\관리자에게 문의하여 주십시오.');
						</script>");
					echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
					exit;
				}
				
				$tmp_sql = "select mb_id, mb_user, mb_updated_date, mb_level, mb_facebook from remember_member where mb_email='".$email_pass_forget."'";
				$tmp_result = mysql_query($tmp_sql, $connect);
				$tmp_row = mysql_fetch_array($tmp_result);
				
				if ($tmp_row['mb_level'] == $common_admin_level){
					echo("<script>
						window.alert('관리자 아이디는 접근 불가합니다.');
						</script>");
					echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
					exit;
				}
				
				if (!$tmp_row['mb_user']){
					echo("<script>
						window.alert('존재하지 않는 회원입니다.');
						</script>");
					echo ("<meta http-equiv=\"refresh\" content=\"0; url=/forget\">");	
					exit;
				}
				
				if ($tmp_row['mb_facebook'] != 0){
					echo("<script>
						window.alert('트위터/페이스북 아이디는 접근 불가합니다.');
						</script>");
					echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
					exit;
				}
				
				// 난수 발생
				srand(time());
				$randval = rand(4, 6); 
				$change_password = substr(md5(get_microtime()), 0, $randval);
				
				$lost_certify = get_password($change_password);
				$datetime = get_password($tmp_row['mb_updated_date']);
				
				$sql = "update remember_member set mb_lost_certify = '".$lost_certify."' where mb_id = '".$tmp_row['mb_id']."'";
				$result = mysql_query($sql, $connect);
				
				$href = $common_path."process/password.lost.certify.php?id=".$tmp_row['mb_id']."&datetime=".$datetime."&lost_certify=".$lost_certify;

				$subject = "요청하신 회원아이디/패스워드 정보입니다.";
				
				$content = "";
				$content .= "<div style='line-height:180%;'>";
				$content .= "<p>요청하신 계정정보는 다음과 같습니다.</p>";
				$content .= "<hr>";
				$content .= "<ul>";
				$content .= "<li>회원아이디 : ".$tmp_row['mb_user']."</li>";
				$content .= "<li>변경 패스워드 : <span style='color:#ff3300; font:13px Verdana;'><strong>".$change_password."</strong></span></li>";
				$content .= "<li>이메일주소 : ".addslashes($email_pass_forget)."</li>";
				$content .= "<li>요청일시 : ".date("Y-m-d H:i:s")."</li>";
				$content .= "<li>홈페이지 : ".$common_path."</li>";
				$content .= "</ul>";
				$content .= "<hr>";
				$content .= "<p><a href='".$href."' target='_blank'>".$href."</a></p>";
				$content .= "<p>";
				$content .= "1. 위의 링크를 클릭하십시오. 링크가 클릭되지 않는다면 링크를 브라우저의 주소창에 직접 복사해 넣으시기 바랍니다.<br />";
				$content .= "2. 링크를 클릭하시면 패스워드가 변경 되었다는 인증 메세지가 출력됩니다.<br />";
				$content .= "3. 홈페이지에서 회원아이디와 위에 적힌 변경 패스워드로 로그인 하십시오.<br />";
				$content .= "4. 로그인 하신 후 새로운 패스워드로 변경하시면 됩니다.";
				$content .= "</p>";
				$content .= "<p>감사합니다.</p>";
				$content .= "<p>[끝]</p>";
				$content .= "</div>";
				
				get_mailer($common_email_from, $common_email_reply_to, $email_pass_forget, $subject, $content, 1);
				
				echo("<script>
					window.alert('{$email_pass_forget} 메일로 회원아이디와 패스워드를 인증할 수 있는 메일이 발송 되었습니다.\\n\메일을 확인하여 주십시오.');			
					</script>");
				echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
				exit; 
				              
				//window.alert('test : {$email_pass_forget} / {$change_password} / {$tmp_row[mb_user]} / \\n{$lost_certify} / {$tmp_row['mb_id']}');
		
		} else {
				# set the error code so that we can display it
				$error = $resp->error;
		}
}
echo recaptcha_get_html($publickey, $error);
?></td>
  </tr>
  <tr>
    <td align="center" style="padding:7px 0 0 3px;"><input type="submit" style="width:313px;"  value="확인" /></td>
  </tr>
</table>
</form>

</div>

