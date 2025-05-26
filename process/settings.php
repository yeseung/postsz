<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if (!$_SESSION['user']){
	echo("<script>
		window.alert('잘못된 접근입니다.')
		history.go(-1)
		</script>");
	exit;
}

//if( ($_POST['user_url'] == "") && (ereg("[^a-z0-9$]",$_POST['user_url'])) ){
if (ereg("[^a-z0-9$]",$_POST['user_url'])) {
	echo("<script>
		window.alert('잘못된 접근입니다..');
		location.href = '/';
		</script>");
	exit;
}

//echo "user_url : ".$_POST['user_url'];
//exit;

$useragent = $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
	//$user_url_check = $_POST['user_url'];
	
	if ($_POST['user_url'] == $_POST['user_url_text']){
		$user_url_check = $_POST['user_url'];
	}else{
		$user_url = cautionWords(trim($_POST['user_url']));
		if ($user_url == 0){
			echo 2;
			exit;
		}else if ($user_url == 1){
			$tmp_sql = "select count(*) as cnt from remember_boardset where bs_user_url = '".trim($_POST['user_url'])."'";
			$tmp_result = mysql_query($tmp_sql, $connect);
			$tmp_row = mysql_fetch_array($tmp_result);
			$user_url_cnt = $tmp_row['cnt'];
			if ($user_url_cnt == 1){
				echo 0;
				exit;
			}else{
				$tmp_sql = "select count(*) as cnt from remember_short_url where su_short_url = '".trim($_POST['user_url'])."'";
				$tmp_result = mysql_query($tmp_sql, $connect);
				$tmp_row = mysql_fetch_array($tmp_result);
				$short_url_cnt = $tmp_row['cnt'];
				if ($short_url_cnt == 1){
					echo 0;
					exit;
				}else{
					$user_url_check = trim($_POST['user_url']);
				}
			}
		}
	}
	
	
	
	
	
	
	
}else{

	if ($_POST['user_url'] != ""){
		if ($_POST['user_url'] == $_POST['user_url_text']){
			$user_url_check = $_POST['user_url'];
		}else if ($_POST['user_url'] != $_POST['user_url_text']){
			$user_url = cautionWords(trim($_POST['user_url']));
			if ($user_url == 0){
				echo 2;
				exit;
			}else if ($user_url == 1){
				$tmp_sql = "select count(*) as cnt from remember_boardset where bs_user_url = '".trim($_POST['user_url'])."'";
				$tmp_result = mysql_query($tmp_sql, $connect);
				$tmp_row = mysql_fetch_array($tmp_result);
				$user_url_cnt = $tmp_row['cnt'];
				if ($user_url_cnt == 1){
					echo 0;
					exit;
				}else{
					$tmp_sql = "select count(*) as cnt from remember_short_url where su_short_url = '".trim($_POST['user_url'])."'";
					$tmp_result = mysql_query($tmp_sql, $connect);
					$tmp_row = mysql_fetch_array($tmp_result);
					$short_url_cnt = $tmp_row['cnt'];
					if ($short_url_cnt == 1){
						echo 0;
						exit;
					}else{
						$user_url_check = trim($_POST['user_url']);
					}
				}
			}
		}
	}
}
//exit;

//echo "post_twitter_text : ".$_POST['post_twitter_text'];
//exit;


if ($_POST['post_twitter_text'] == 1){
	$sql = "delete from remember_twitter_post where mb_user = '".trim($_SESSION['user'])."'";
	mysql_query($sql, $connect);
	$_SESSION['post_twitter'] = NULL;
	$_SESSION['post_oauth_token'] = NULL;
	$_SESSION['post_oauth_token_secret'] = NULL;
	$_SESSION['post_user_id'] = NULL;
	$_SESSION['post_screen_name'] = NULL;
}


$rows = $_POST['rows']."|".$_POST['rows_m'];
//$setting = $_POST['scrolling_text']."|0|0|0|0|0|0|0|0|0|0|0|0";
$setting = $_POST['scrolling_text']."|".$_POST['wysiwyg_text']."|".$_POST['security_text']."|".$_POST['openset_text']."|".$_POST['recycle_bin_text']."|0|0|0|0|0|0|0|0";

$sql = "update remember_boardset set bs_subject = '".$_POST['subject']."', ";
$sql .= "bs_setting = '".$setting."', ";
$sql .= "bs_rows = '".$rows."', ";
if ($_POST['user_url'] != ""){
	$sql .= "bs_user_url = '".$user_url_check."', ";
}else{
	$sql .= "bs_user_url = NULL, ";
}
$sql .= "bs_openapikey = '".$_POST['openapikey']."', ";
$sql .= "bs_openapisecret = '".$_POST['openapisecret']."' ";
$sql .= "where mb_user = '".trim($_SESSION['user'])."'";
mysql_query($sql, $connect);

//echo $sql;
//exit;

$_SESSION['set_subject'] = $_POST['subject'];
$_SESSION['set_scrolling'] = $_POST['scrolling_text'];
$_SESSION['set_wysiwyg'] = $_POST['wysiwyg_text'];
$_SESSION['set_security'] = $_POST['security_text'];
$_SESSION['set_open'] = $_POST['openset_text'];
$_SESSION['set_recycle_bin'] = $_POST['recycle_bin_text'];
$_SESSION['set_rows'] = $_POST['rows'];
$_SESSION['set_rows_m'] = $_POST['rows_m'];
$_SESSION['set_user_url'] = $user_url_check;
$_SESSION['set_openapikey'] = $_POST['openapikey'];
$_SESSION['set_openapisecret'] = $_POST['openapisecret'];

echo 1;

mysql_close();



?>