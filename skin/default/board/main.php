<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

/*if (!$_SESSION['user']){
	echo("<script>
		window.alert('로그인을 하셔야 이용하실 수 있습니다.')
		history.go(-1)
		</script>");
	exit;
}


$tmp_sql = "select count(*) as cnt from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_GET['id'];
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$cnt = $tmp_row['cnt'];

if ($cnt == 0){ 
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");
}else{*/

	include_once ("skin/{$common_skin}/index/head.php");

	if ($_SESSION['set_wysiwyg'] == 0){
		if ($_SESSION['post_twitter'] == 1){
			include_once ("skin/{$common_skin}/board/write.post.php");
		}else{
			include_once ("skin/{$common_skin}/board/write.php");
		}
		/*if ($_SESSION['set_security'] == 0){
			include_once ("skin/{$common_skin}/board/write.php");
		}else if ($_SESSION['set_security'] == 1){
			include_once ("skin/{$common_skin}/board/write.security.php");
		}*/	
	}else if ($_SESSION['set_wysiwyg'] == 1){
		if ($_SESSION['post_twitter'] == 1){
			include_once ("skin/{$common_skin}/board/write.wysiwyg.post.php");
		}else{
			include_once ("skin/{$common_skin}/board/write.wysiwyg.php");
		}
		/*if ($_SESSION['set_security'] == 0){
			include_once ("skin/{$common_skin}/board/write.wysiwyg.php");
		}else if ($_SESSION['set_security'] == 1){
			include_once ("skin/{$common_skin}/board/write.wysiwyg.security.php");
		}*/	
	}
	include_once ("skin/{$common_skin}/board/view.php");
	
	include_once ("skin/{$common_skin}/index/tail.php");

//}




?>