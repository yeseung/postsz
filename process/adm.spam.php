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


//echo $_POST['mode']." / ".$_POST['id'];


if ($_POST['mode'] == "del"){
	//echo $_POST['num'];
	
	$sql = "delete from remember_spam where sp_id = ".$_POST['num'];
	mysql_query($sql, $connect);
	
	echo 0;



}else if ($_POST['mode'] == "feedback"){

	$sql = "update remember_spam set sp_feedback_date = now(), ";
	$sql .= "sp_feedback = '".$_POST['feedback']."' ";
	$sql .= "where sp_id = ".$_POST['num'];
	mysql_query($sql, $connect);

	echo 0;

}




mysql_close();

?>