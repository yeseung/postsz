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


//echo $_POST['column'];
//exit;

if ($_POST['table'] == "remember_board_{mb_user}"){

	echo "<textarea id=\"wrdLatest\" style=\"width:90%; height:300px;\">";
	
	$sql = "select mb_user from remember_member order by mb_updated_date desc";
	$result = mysql_query($sql, $connect); 
	while ($row = mysql_fetch_array($result)){
		$mb_user = $row['mb_user'];
		echo "alter table remember_board_".$mb_user." ".$_POST['amcd']." column ".$_POST['column']."\n";
	}
	
	echo "</textarea>";

}else{
	echo "<textarea id=\"wrdLatest\" style=\"width:90%; height:50px;\">alter table ".$_POST['table']." ".$_POST['amcd']." column ".$_POST['column']."</textarea>";
}
?>


