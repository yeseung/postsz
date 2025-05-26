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


//echo $_POST['mode']." / ".$_POST['name']." / ".$_POST['url'];


if ($_POST['mode'] == "write"){

	$tmp_sql = "select max(ad_id) as max_ad_id from remember_advertisement";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$ad_id = $tmp_row['max_ad_id'] + 1;

	$sql = "insert into remember_advertisement (ad_id, ad_name, ad_url, ad_date) ";
	$sql .= "values (".$ad_id.", '".$_POST['name']."', '".$_POST['url']."', now() )";
	mysql_query($sql, $connect);

	echo 0;

}else if ($_POST['mode'] == "del"){

	$sql = "delete from remember_advertisement where ad_id = ".$_POST['num'];
	mysql_query($sql, $connect);
	
	echo 0;

}



mysql_close();




?>