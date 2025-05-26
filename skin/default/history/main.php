<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


//로그인 기록 자동 삭제
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