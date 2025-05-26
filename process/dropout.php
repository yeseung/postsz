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

if ($_POST['mode'] == "dropout") {

	$passwd = trim($_POST['dropout_password']);
	$tmp_sql = "select password('".$passwd."') as db_passwd";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	
	$sql = "select mb_password, mb_level from remember_member where mb_user='".trim($_SESSION['user'])."'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);
	$mb_password = $row['mb_password'];
	
	if ($tmp_row['db_passwd'] == $mb_password){
	
		if ($row['mb_level'] == $common_admin_level) { //관리자
			echo 2;
			exit;
		}else{
		
			//회원탈퇴
			get_dropout(trim($_SESSION['user']));
			
			session_unset();
			session_destroy();
			
			echo 0;
			exit;
		}
		
	}else{
		echo 1; //비밀번호가 틀립니다.";
		exit;
	}




}else if ($_POST['mode'] == "dropout_fb"){

	$sql = "select mb_level from remember_member where mb_user='".trim($_SESSION['user'])."'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);

	if ($row['mb_level'] == $common_admin_level) { //관리자
		echo 2;
		exit;
	}else{
	
		//회원탈퇴
		get_dropout(trim($_SESSION['user']));
		
		session_unset();
		session_destroy();
		
		echo 0;
		exit;

	}

}

mysql_close();



	

?>