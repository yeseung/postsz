<?
if (!defined("_REMEMBER_")) exit; // ���� ������ ���� �Ұ�


//�α��� ��� �ڵ� ����
$tmp_sql = "delete from remember_login_history where mb_user = '".trim($_SESSION['user'])."' and ";
$tmp_sql .= "lh_datetime_login < date_add(now(), interval - ".$common_history_auto_del." day)";
mysql_query($tmp_sql, $connect);
//echo $tmp_sql;


include_once ("skin/{$common_skin}/history/head.php");


switch($_GET['mode']){
	/*case "" :
		include_once ("skin/{$common_skin}/point/.php");
		break;*/
	default:
		include_once ("skin/{$common_skin}/history/history.list.php");
		break;
}


include_once ("skin/{$common_skin}/history/tail.php");
?>