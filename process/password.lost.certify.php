<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

$id           = trim($_GET['id']);
$datetime     = trim($_GET['datetime']);
$lost_certify = trim($_GET['lost_certify']);
//echo $id." / ".$datetime." / ".$lost_certify."<br><br>";



//회원아이디가 아닌 회원고유번호로 회원정보를 구한다.
$tmp_sql = "select mb_id, mb_updated_date, mb_lost_certify from remember_member where mb_id = '".$id."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);

if (!trim($tmp_row['mb_lost_certify'])) die("Error");

$db_datetime = get_password($tmp_row['mb_updated_date']);
$db_lost_certify = $tmp_row['mb_lost_certify'];
//echo $db_datetime. " / ".$db_lost_certify."<br><br>";

//인증 링크는 한번만 처리가 되게 한다.
$sql = "update remember_member set mb_lost_certify = '' where mb_id = '".$id."'";
$result = mysql_query($sql, $connect);

// 변경될 패스워드가 넘어와야하고 저장된 변경패스워드를 md5 로 변환하여 같으면 정상
if ($lost_certify && $datetime === $db_datetime && $lost_certify === $db_lost_certify){
	$sql = "update remember_member set mb_password = '".$db_lost_certify."' where mb_id = '".$id."'";
	$result = mysql_query($sql, $connect);
	
	echo("<script>
		window.alert('이메일로 보내드린 패스워드로 변경 하였습니다.\\n\회원아이디와 변경된 패스워드로 로그인 하시기 바랍니다.');			
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
	exit; 
}else {
    die("Error");
}





?>
