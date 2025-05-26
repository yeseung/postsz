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
	$sql = "select mb_level from remember_member where mb_user='".trim($_POST['id'])."'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);
	
	if ($row['mb_level'] == $common_admin_level) { //관리자
		echo 1;
		exit;
	}else{
	
		//회원탈퇴
		get_dropout(trim($_POST['id']));
		
		echo 0;
		exit;
	}



	
}else if ($_POST['mode'] == "set"){
	//echo $_POST['user']." | ".$_POST['email']." | ".$_POST['updated_date']." | ".$_POST['date']." | ".$_POST['ip']." | ".$_POST['level']." | ".$_POST['blacklist_date']." | ".$_POST['open']." | ".$_POST['mailling']." | ".$_POST['facebook']." | ".$_POST['login_cnt']." | ".$_POST['subject']." | ".$_POST['scrolling']." | ".$_POST['rows']." | ".$_POST['rows_m'];
	//exit;
	
	$open_mailling = $_POST['open']."|".$_POST['mailling'];
	
	$sql = "update remember_member set mb_email = '".$_POST['email']."', ";
	$sql .= "mb_updated_date = '".$_POST['updated_date']."', ";
	$sql .= "mb_date = '".$_POST['date']."', ";
	$sql .= "mb_ip = '".$_POST['ip']."', ";
	$sql .= "mb_level = ".$_POST['level'].", ";
	$sql .= "mb_blacklist_date = '".$_POST['blacklist_date']."', ";
	$sql .= "mb_open_mailling = '".$open_mailling."', ";
	$sql .= "mb_facebook = ".$_POST['facebook'].", ";
	$sql .= "mb_login_cnt = ".$_POST['login_cnt'].", ";
	$sql .= "mb_nick = '".$_POST['nickname']."' ";	
	$sql .= "where mb_user = '".trim($_POST['user'])."'";
	mysql_query($sql, $connect);
	
	$rows = $_POST['rows']."|".$_POST['rows_m'];
	$setting = $_POST['scrolling']."|".$_POST['wysiwyg']."|0|0|0|0|0|0|0|0|0|0|0";
	$skin = $_POST['skin']."|".$_POST['skin_m'];
	
	$sql = "update remember_boardset set bs_subject = '".$_POST['subject']."', ";
	$sql .= "bs_setting = '".$setting."', ";
	$sql .= "bs_rows = '".$rows."', ";
	$sql .= "bs_skin = '".$skin."', ";
	$sql .= "bs_user_url = '".$_POST['user_url']."' ";
	$sql .= "where mb_user = '".trim($_POST['user'])."'";
	mysql_query($sql, $connect);
	
	echo 0;
	exit;
	

}


mysql_close();

?>