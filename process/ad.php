<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");


$sql = "select ad_url from remember_advertisement where ad_id = ".$_GET['num'];
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);
$ad_url = $row['ad_url'];

if (isset($ad_url)){

	if ($_COOKIE["ad_{$_GET['num']}"] != $_GET['num']){
		$sql = "update remember_advertisement set ad_hit = ad_hit + 1 where ad_id = ".$_GET['num'];
		mysql_query($sql, $connect);
		setcookie("ad_{$_GET['num']}", "{$_GET['num']}", time() + 3600);
	}
				
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=".$ad_url."\">");
	exit;
	
}else{
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");
	exit;
}

mysql_close();



?>
