<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

include_once ("skin/{$common_skin}/recycle.bin/head.php");


switch($_GET['mode']){
	/*case "" :
		include_once ("skin/{$common_skin}/recycle.bin/.php");
		break;*/
	default:
		include_once ("skin/{$common_skin}/recycle.bin/recycle.bin.list.php");
		break;
}


include_once ("skin/{$common_skin}/recycle.bin/tail.php");
?>