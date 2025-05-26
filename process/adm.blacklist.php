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

//echo $_POST['num'];


$tmp_sql = "select su_blacklist_date from remember_short_url where su_id = ".$_POST['num'];
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$su_blacklist_date = $tmp_row['su_blacklist_date'];

if ($su_blacklist_date == "0000-00-00 00:00:00"){
	$sql = "update remember_short_url set su_blacklist_date = now() ";
	$sql .= "where su_id = ".$_POST['num'];
	mysql_query($sql, $connect);
	
}else{
	$sql = "update remember_short_url set su_blacklist_date = '0000-00-00 00:00:00' ";
	$sql .= "where su_id = ".$_POST['num'];
	mysql_query($sql, $connect);

}

mysql_close();


?>