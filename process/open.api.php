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



//echo $openapi = get_openapi("3bc30b1717c252da8593T0Pz5");
echo $openapi = get_openapi(get_rand(25, "lower"));






?>

