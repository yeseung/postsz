<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

//읽은 쪽지 자동 삭제
$tmp_sql = "delete from remember_memo where mb_user = '".trim($_SESSION['user'])."' and ";
$tmp_sql .= "mm_read_date != '0000:00:00 00:00:00' and mm_read_date < date_add(now(), interval - ".$common_memo_auto_del." day)";
mysql_query($tmp_sql, $connect);
//echo $tmp_sql;

include_once ("skin/{$common_skin}/memo/head.php");


switch($_GET['mode']){
	case "write" :
		/*if ($_SESSION['user'] == urldecode($_GET['to'])){
			echo("<script>
				window.alert('자신의 메일주소를 입력되었습니다.')
				history.go(-1)
				</script>");
			exit;
		}else{*/
			include_once ("skin/{$common_skin}/memo/memo.form.php");
			break;
		//}
	case "recv" :
		include_once ("skin/{$common_skin}/memo/memo.list.php");
		break;
	case "send" :
		include_once ("skin/{$common_skin}/memo/memo.list.php");
		break;
	case "recv_view" :
		include_once ("skin/{$common_skin}/memo/memo.view.php");
		break;
	case "send_view" :
		include_once ("skin/{$common_skin}/memo/memo.view.php");
		break;			
	default:
		$_GET['mode'] = "recv";
		include_once ("skin/{$common_skin}/memo/memo.list.php");
		break;
}


include_once ("skin/{$common_skin}/memo/tail.php");
?>