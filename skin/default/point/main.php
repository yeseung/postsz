<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

//include_once ("skin/{$common_skin}/point/point.clear.php"); //포인트 정리
include_once ("skin/{$common_skin}/point/head.php");


switch($_GET['mode']){
	/*case "" :
		include_once ("skin/{$common_skin}/point/.php");
		break;*/
	default:
		include_once ("skin/{$common_skin}/point/point.list.php");
		break;
}


include_once ("skin/{$common_skin}/point/tail.php");
?>