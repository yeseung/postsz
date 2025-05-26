<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

include_once ("skin/{$common_skin}/scrap/head.php");


switch($_GET['mode']){
	/*case "" :
		include_once ("skin/{$common_skin}/scrap/.php");
		break;*/
	default:
		include_once ("skin/{$common_skin}/scrap/scrap.list.php");
		break;
}


include_once ("skin/{$common_skin}/scrap/tail.php");
?>