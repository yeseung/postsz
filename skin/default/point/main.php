<?
if (!defined("_REMEMBER_")) exit; // ���� ������ ���� �Ұ�

//include_once ("skin/{$common_skin}/point/point.clear.php"); //����Ʈ ����
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