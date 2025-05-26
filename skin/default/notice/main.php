<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

include_once ("skin/{$common_skin}/notice/head.php");


switch($_GET['mode']){
	case "list" :
		include_once ("skin/{$common_skin}/notice/notice.list.php");
		break;
	case "view" :
		include_once ("skin/{$common_skin}/notice/notice.view.php");
		break;
	default:
		include_once ("skin/{$common_skin}/notice/notice.list.php");
		break;
}


include_once ("skin/{$common_skin}/notice/tail.php");
?>