<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<span style="font-size:13px;">메모장이 모두 삭제됩니다. 메모장을 삭제하시겠습니까?</span><br />
<div align="center" style="padding:20px 0 0 0">
<form action=""  method="post">
<?php
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
				
				$sql = "select mb_level from remember_member where mb_user='".trim($_SESSION['user'])."'";
				$result = mysql_query($sql, $connect);
				$row = mysql_fetch_array($result);
			
				if ($row['mb_level'] == $common_admin_level) { //관리자
					echo("<script>
						window.alert('게시판관리자 또는 서버관리자에게 문의 바랍니다.');
						</script>");
					echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
					exit;
				}else{
				
					//메모장 삭제
					get_initialize($_SESSION['user'], $_SESSION['nick']);
					
					echo("<script>
						window.alert('메모장을 모두 삭제하였습니다.');
						</script>");
					echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");
					exit;
			
				}                   
				
		} else {
				# set the error code so that we can display it
				$error = $resp->error;
		}
}
echo recaptcha_get_html($publickey, $error);
?>
<input type="submit" style="width:313px" value="확인" />
</form></div>
    