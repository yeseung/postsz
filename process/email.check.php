<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if (!$_SESSION['user']){
	echo("<script>
		window.alert('잘못된 접근입니다.')
		history.go(-1)
		</script>");
	exit;
}

if ($_SESSION['level'] == $common_admin_level) die("Error");

//echo $_SESSION['user']." / ".$_SESSION['level']." / ".$_POST['email'];
//exit;

$email = trim($_POST['email']);

$sw = preg_match("/[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*/", $email);
if ($sw == true) {

	$tmp_sql = "select count(*) as cnt from remember_member where mb_email = '".$email."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	
	if ($tmp_row['cnt'] != 0){
		echo 0; //동일한 메일주소가 2개 이상 존재합니다.');
		exit;
		
	}else{
		
		$ta_id = get_rand(10, "lower");
		$auth_key = get_password(get_rand(10));
		
		$tmp_sql = "select count(*) as cnt from remember_tmp_email_auth where mb_user = '".trim($_SESSION['user'])."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		if ($tmp_row['cnt'] == 0){	
			$sql = "insert into remember_tmp_email_auth (ta_id, mb_user, ta_email, ta_date, ta_auth_key) ";
			$sql .= "values ('".$ta_id."', '".trim($_SESSION['user'])."', '".$email."', now(), '".$auth_key."')";
			mysql_query($sql, $connect);
		}else{
			$sql = "update remember_tmp_email_auth set ";
			$sql .= "ta_email = '".$email."', ";
			$sql .= "ta_date = now(), ";
			$sql .= "ta_auth_key = '".$auth_key."' where mb_user = '".trim($_SESSION['user'])."'";
			mysql_query($sql, $connect);
		}
		mysql_close();
		
		
		$tmp_sql = "select * from remember_tmp_email_auth where mb_user = '".trim($_SESSION['user'])."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
			
		$href = $common_path."process/email.authority.php?id=".$tmp_row['ta_id'];
		$href .= "&datetime=".get_password($tmp_row['ta_date']);
		$href .= "&auth_key=".$tmp_row['ta_auth_key'];	
	
		$subject = "인증 메일입니다.";
		
		$content = "";
		$content .= "<div style='line-height:180%;'>";
		$content .= "<p><a href='".$href."' target='_blank'>".$href."</a></p>";
		$content .= "<p>";
		$content .= "1. 위의 링크를 클릭하십시오. 링크가 클릭되지 않는다면 링크를 브라우저의 주소창에 직접 복사해 넣으시기 바랍니다.<br />";
		$content .= "2. 링크를 클릭하시면 인증 메세지가 출력됩니다.";
		$content .= "</p>";
		$content .= "<p>감사합니다.</p>";
		$content .= "<p>[끝]</p>";
		$content .= "</div>";
		
		get_mailer($common_email_from, $common_email_reply_to, $email, $subject, $content, 1);
		
		echo 2; //메일을 발송하였습니다.
		exit; 
	}			
	
}else{ //if ($sw == true) {
	echo 1; //e-메일 주소를 입력하세요.
	exit;

}














?>