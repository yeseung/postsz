<?
session_start();
header("content-type:text/html; charset=utf-8");
include_once ("lib/common.php");
include_once ("lib/dbconn.php");
include_once ("lib/function.php");

if (!$_SESSION['user']){
	echo("<script>
		window.alert('로그인을 하셔야 이용하실 수 있습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
	exit;
}


include_once ("thumbnail/step1.php");



?>