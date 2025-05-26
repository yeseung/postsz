<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

include_once ("skin/{$common_skin}/listview/head.php");


switch($_GET['mode']){
	/*case "" :
		include_once ("skin/{$common_skin}/scrap/.php");
		break;*/
	default:
		include_once ("skin/{$common_skin}/listview/listview.php");
		break;
}


include_once ("skin/{$common_skin}/listview/tail.php");
?>