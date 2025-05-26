<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if ($_SESSION['level'] != $common_admin_level){
	echo("<script>
		window.alert('관리자 메뉴입니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");			
	exit;	
}

if ($_SERVER['REMOTE_ADDR'] != $common_my_ip){ //my com
	echo("<script>
		window.alert('허용된 IP주소가 아닙니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");			
	exit;
}


//echo $_POST['email_from']." / ".$_POST['email_reply']." / ".$_POST['email_to']." / ".$_POST['email_sub']." / ".$_POST['email_cont'];

$email_from = $_POST['email_from'];
$email_reply = $_POST['email_reply'];
$email_to = $_POST['email_to'];
$email_sub = $_POST['email_sub'];
$email_cont = $_POST['email_cont'];

$sw = preg_match("/[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*/", $email_to);
if ($sw == true) {
	get_mailer($email_from, $email_reply, $email_to, $email_sub, $email_cont, 2);
	echo 1;
}else{
	echo 0;
}




?>