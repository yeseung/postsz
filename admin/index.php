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


include_once ("head.php");


switch($_GET['mode']){
	case "member" :
		include_once ("member.php");
		break;
	case "visit" :
		include_once ("visit.php");
		break;
	case "counter" :
		include_once ("visit.cnt.php");
		break;
	case "current" :
		include_once ("visitor.current.php");
		break;	
	case "url" :
		include_once ("open.url.php");
		break;
	case "friend" :
		include_once ("myfriends.php");
		break;
	case "memo" :
		include_once ("memo.php");
		break;
	case "history" :
		include_once ("history.php");
		break;			
	/*case "email" :
		include_once ("open.email.php");
		break;*/
	case "search" :
		include_once ("search.php");
		break;	
	case "spam" :
		include_once ("spam.php");
		break;
	case "point" :
		include_once ("point.php");
		break;	
	case "scrap" :
		include_once ("scrap.php");
		break;	
	case "ad" :
		include_once ("ad.php");
		break;
	case "twlink" :
		include_once ("tw.link.php");
		break;			
	case "email" :
		include_once ("email.php");
		break;
	case "db" :
		include_once ("db.php");
		break;
	case "notice" :
		include_once ("notice.php");
		break;
	case "feedback" :
		include_once ("feedback.php");
		break;
	case "auth" :
		include_once ("email.auth.php");
		break;		
	default:
		include_once ("main.php");
		break;	
}



include_once ("tail.php");


//현재접속자
get_login();


//로그인 기록
get_logout_history();

?>
