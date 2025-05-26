<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
include_once ("skin/{$common_skin}/index/head.php");

switch($_GET['mode']){
	case "test" :
		include_once ("skin/{$common_skin}/index/test.php");
		break;
	case "dropout" :
		include_once ("skin/{$common_skin}/index/dropout.php");
		break;
	case "initialize" :
		include_once ("skin/{$common_skin}/index/initialize.php");
		break;	
	case "help" :
		include_once ("skin/{$common_skin}/index/help.php");
		include_once ("skin/{$common_skin}/index/sns.php");
		include_once ("skin/{$common_skin}/index/open.php");
		break;
	case "dev" :
		include_once ("skin/{$common_skin}/index/dev.php");
		break;	
	case "friend" :
		if (!(isset($_SESSION['user']))){		
			echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
			exit;
		}else if (isset($_SESSION['user'])){
			include_once ("skin/{$common_skin}/index/friend.php");
			include_once ("skin/{$common_skin}/index/sns.php");
			//include_once ("skin/{$common_skin}/index/public.memo.php");
			break;	
		}	
	case "feedback" :
		include_once ("skin/{$common_skin}/index/feedback.php");
		break;
	case "donate" :
		include_once ("skin/{$common_skin}/index/donate.php");
		break;
	case "forget" :
		include_once ("skin/{$common_skin}/index/password.forget.php");
		break;				
	/*case "trash" :
		include_once ("skin/{$common_skin}/board/trash.php");
		break;	*/
	default:
		//include_once ("skin/{$common_skin}/index/index.php");
		//break;
		
		if (!(isset($_SESSION['user']))){		
			include_once ("skin/{$common_skin}/index/index.php");
			include_once ("skin/{$common_skin}/index/sns.php");
			//include_once ("skin/{$common_skin}/index/public.memo.php");
			break;
		}else if (isset($_SESSION['user'])){
			/*if (!$_SESSION[session_user]){
				echo("<script>
					window.alert('로그인을 하셔야 이용하실 수 있습니다.')
					history.go(-1)
					</script>");
				exit;
			}*/
			
			//검색
			if (isset($_GET['search'])){ 
				if ($_COOKIE["search"] != $_GET['search']){
					$tmp_sql = "select max(se_id) as max_se_id from remember_search";
					$tmp_result = mysql_query($tmp_sql, $connect);
					$tmp_row = mysql_fetch_array($tmp_result);
					$se_id = $tmp_row['max_se_id'] + 1;
				
					$sql = "insert into remember_search (se_id, mb_user, se_word, se_date, se_ip, se_agent) ";
					$sql .= "values(".$se_id.", '".$_SESSION['user']."', '".$_GET['search']."', now(), '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['HTTP_USER_AGENT']."')"; 
					mysql_query($sql, $connect);
					setcookie("search", "{$_GET['search']}", time() + 3600);
				}
			}
			
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
			
			if ($_SESSION['set_scrolling'] == 0){
				include_once ("skin/{$common_skin}/board/list.php");
			}else if ($_SESSION['set_scrolling'] == 1){
				include_once ("skin/{$common_skin}/board/list.jquery.php");
			}
			include_once ("skin/{$common_skin}/index/open.php");
			break;
		}

}


include_once ("skin/{$common_skin}/index/tail.php");


//쪽지
if (isset($_SESSION['user'])){
	$tmp_sql = "select count(*) as cnt from remember_memo where mm_send_user = '".trim($_SESSION['user'])."' and mm_read_date = '0000-00-00 00:00:00'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_memo_cnt = $tmp_row['cnt'];
	if ($_COOKIE["memo"] != $tmp_memo_cnt){
		if ($tmp_memo_cnt != "0"){
			setcookie("memo", "{$tmp_memo_cnt}", time() + 10000);
			echo ("<script>
				alert('".$tmp_memo_cnt."개 쪽지가 전달되었습니다.');
				</script>");
		}		
	}
}




?>