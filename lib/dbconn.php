<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
$connect = mysql_connect($common_host, $common_id, $common_pass) or die('SQL server에 연결할 수 없습니다.');
mysql_select_db($common_db_name, $connect);
?>