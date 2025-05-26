<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

$short_exp = explode("/", $_SERVER['REQUEST_URI']);

for ($i=2; $i<count($short_exp); $i++) {
	//echo $short_exp[$i]."<br>";
	echo ("<script>
		window.alert('웹 페이지를 표시할 수 없습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");
	exit;
}


switch ($short_exp[1]){
	case "dropout" :
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/?mode=dropout\">");
		exit;
		break;
	case "initialize" :
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/?mode=initialize\">");
		exit;
		break;
	case "help" :
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/?mode=help\">");
		exit;
		break;	
	case "friend" :
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/?mode=friend\">");
		exit;
		break;	
	case "adm" :
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/admin\">");
		exit;
		break;
	case "developers" :
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/?mode=dev\">");
		exit;
		break;
	case "feedback" :
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/?mode=feedback\">");
		exit;
		break;
	case "donate" :
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/?mode=donate\">");
		exit;
		break;
	case "forget" :
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/?mode=forget\">");
		exit;
		break;	
	default:
	
		//http://postsz.com/내아이디
		$tmp_sql = "select mb_user from remember_boardset where bs_user_url = '".$short_exp[1]."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$mb_user = $tmp_row['mb_user'];
		
		
		
		if (isset($mb_user)) {
			
			//$original_url = "/user.url.php?user=".$mb_user."&url=".$short_exp[1];
			$original_url = "/user.url.php?user=".$mb_user;
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
				echo ("<meta http-equiv=\"refresh\" content=\"0; url=".$original_url."\">");
				exit;
			}else{
				$_GET['user'] = $mb_user;
				//$_GET['url'] = $short_exp[1];
				include_once ("../user.url.php");
				break;
				exit;
			}
		
		}else{
		
			//공개주소
			$sql = "select mb_user, bo_id, su_blacklist_date from remember_short_url where su_short_url = '".$short_exp[1]."' order by su_id desc";
			$result = mysql_query($sql, $connect);
			$row = mysql_fetch_array($result);
			$bo_id = $row['bo_id'];
			$mb_user = $row['mb_user'];
			$su_blacklist_date = $row['su_blacklist_date'];
			
			if ( (!$bo_id) && (!$mb_user) ) {
				echo ("<script>
					window.alert('웹 페이지를 표시할 수 없습니다.');
					</script>");
				echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
				exit;
					
			}else if ($su_blacklist_date != "0000-00-00 00:00:00"){
				echo ("<script>
					window.alert('본 페이지는 블랙 리스트 입니다.');
					</script>");
				echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
				exit;
	
			}else{
			
				if ($_COOKIE["view_{$short_exp[1]}"] != $short_exp[1]){
					//조회수
					$sql = "update remember_short_url set su_hit = su_hit + 1 where su_short_url = '".$short_exp[1]."'";
					mysql_query($sql, $connect);
					setcookie("view_{$short_exp[1]}", "{$short_exp[1]}", time() + 3600);
				}
			
				$original_url = "/view.short.php?user=".$mb_user."&id=".$bo_id;
				
				$useragent = $_SERVER['HTTP_USER_AGENT'];
				if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
					echo ("<meta http-equiv=\"refresh\" content=\"0; url=".$original_url."\">");
					exit;
				}else{
					$_GET['user'] = $mb_user;
					$_GET['id'] = $bo_id;
					$_GET['short'] = $short_exp[1];
					include_once ("../view.short.php");
					break;
					exit;
				}
	
			}
		
		} //if (isset($mb_user)) {
		break;		  

}


mysql_close();


?>
