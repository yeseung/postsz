<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");



//echo $_GET['id']." / ".$_GET['datetime']." / ".$_GET['auth_key']."<br><br>";

$id           = trim($_GET['id']);
$datetime     = trim($_GET['datetime']);
$auth_key     = trim($_GET['auth_key']);

$tmp_sql = "select * from remember_tmp_email_auth where ta_id = '".trim($id)."'";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);

//echo $tmp_row['ta_id']." / ".$tmp_row['mb_user']." / ".$tmp_row['ta_email']." / ".$tmp_row['ta_date']." / ".get_password($tmp_row['ta_date'])." / ".$tmp_row['ta_auth_key'];

$db_datetime = get_password($tmp_row['ta_date']);
$db_auth_key = $tmp_row['ta_auth_key'];
;


if ($auth_key && $datetime === $db_datetime && $auth_key === $db_auth_key){

	$tmp_sql1 = "select mb_open_mailling from remember_member where mb_user = '".trim($tmp_row['mb_user'])."'";
	$tmp_result1 = mysql_query($tmp_sql1, $connect);
	$tmp_row1 = mysql_fetch_array($tmp_result1);
	
	if (!$tmp_row1['mb_open_mailling']){
		die("Error");
	}else{	
		$open_mailling_explode = explode("|", $tmp_row1['mb_open_mailling']);
		$open = $open_mailling_explode[0];
		//$mailling = $open_mailling_explode[1];
		$open_mailling = $open_mailling_explode[0]."|0";
	
		$sql = "update remember_member set ";
		$sql .= "mb_email = '".trim($tmp_row['ta_email'])."', ";
		$sql .= "mb_open_mailling = '".$open_mailling."', ";
		$sql .= "mb_level = 1 ";
		$sql .= "where mb_user = '".trim($tmp_row['mb_user'])."'";
		mysql_query($sql, $connect);
		
		$sql = "delete from remember_tmp_email_auth where mb_user = '".trim($tmp_row['mb_user'])."' and ta_id = '".trim($id)."'";
		mysql_query($sql, $connect);
		
		//포인트
		get_point($tmp_row['mb_user'], $common_point_email_auth, "메일 인증 완료");
			
		session_unset();
		session_destroy();
		
		echo("<script>
			window.alert('E-mail 인증 처리를 완료 하였습니다.\\n\정회원으로 등록 되었습니다.');			
			</script>");
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
		exit;
	}

}else {
    die("Error");
}

		
		

exit;





?>