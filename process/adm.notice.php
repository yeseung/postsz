<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if ($_SESSION['level'] != $common_admin_level){
	echo("<script>
		window.alert('관리자 메뉴입니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");			
	exit;	
}

if ($_SERVER['REMOTE_ADDR'] != $common_my_ip){ //my com
	echo("<script>
		window.alert('허용된 IP주소가 아닙니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");			
	exit;
}

/*echo $_SERVER["DOCUMENT_ROOT"];
echo "<pre>";  
print_r($_FILES);  
echo "</pre>"; 
exit;*/







if ($_POST['mode'] == "write"){

	if ((!$_POST['sub']) or (!$_POST['cont'])){
		echo("<script>
			window.alert('제목, 내용을 입력하세요.');
			</script>");
		echo ("<meta http-equiv=\"refresh\" content=\"0; url=/admin/?mode=notice\">");			
		exit;	
	}

	//디렉토리 생성
	$dir_y = date(Y); $dir_m = date(m); $dir_d = date(d);
	$dirRoot = $_SERVER["DOCUMENT_ROOT"];
	if(!is_dir($dirRoot."/process/data/".$dir_y)) @mkdir($dirRoot."/process/data/".$dir_y, 0777);
	if (!is_dir($dirRoot."/process/data/".$dir_y."/".$dir_m)) @mkdir($dirRoot."/process/data/".$dir_y."/".$dir_m, 0777);
	if (!is_dir($dirRoot."/process/data/".$dir_y."/".$dir_m."/".$dir_d)) @mkdir($dirRoot."/process/data/".$dir_y."/".$dir_m."/".$dir_d, 0777);
	
	//파일 업로드
	$tmp_file_name = "";
	$tmp_file_size = "";
	$save_path = "data/".$dir_y."/".$dir_m."/".$dir_d."/";
	
	for($i=0; $i<count($_FILES[files][name]); $i++) { 
		if($_FILES[files][size][$i] && !$_FILES[files][error][$i]) { 
	
			$file_name[$i] = $_FILES[files][name][$i]; 
			$file_tmp_name[$i] = $_FILES[files][tmp_name][$i]; 
			$file_size[$i] = $_FILES[files][size][$i];
			
			if ((($_FILES[files][type][$i] == "image/gif") || ($_FILES[files][type][$i] == "image/jpeg") || ($_FILES[files][type][$i] == "image/pjpeg") || ($_FILES[files][type][$i] == "image/x-png") || ($_FILES[files][type][$i] == "image/png")) && ($_FILES[files][size][$i] < 1024000)){
			
				if (!file_exists($save_path.$file_name[$i])) { 
					move_uploaded_file($file_tmp_name[$i],$save_path.$file_name[$i]); 
				}else{ 
					$file_name[$i] = time()."_".$file_name[$i];
					move_uploaded_file($file_tmp_name[$i],$save_path.$file_name[$i]); 
				}
				
				$tmp_file_name .= $save_path.$file_name[$i]."|";
				$tmp_file_size .= $file_size[$i]."|";
	
			}else{
				echo("<script>
					window.alert('1MB 이하의 GIF, PNG, JPEG 형식의 파일만 업로드 할 수 있습니다.');
					history.go(-1);
					</script>");
				exit;
			}	
		}
	}

	//echo $_POST['sub']." / ".$_POST['cont']." / ".$tmp_file_name." / ".$tmp_file_size."<br><br>";
		
	$tmp_sql = "select max(nb_id) as max_nb_id from remember_notice_board";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$nb_id = $tmp_row['max_nb_id'] + 1;
			
	$sql = "insert into remember_notice_board (nb_id, mb_user, nb_subject, nb_content, nb_date, nb_updated_date, nb_file_name, nb_file_size, nb_link_1, nb_link_2, nb_ip) ";
	$sql .= "values (".$nb_id.", '".trim($_SESSION['user'])."', '".trim($_POST['sub'])."', '".trim($_POST['cont'])."', now(), now(), '".$tmp_file_name."', '".$tmp_file_size."', '".gethttp(trim($_POST['link1']))."', '".gethttp(trim($_POST['link2']))."', '".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sql, $connect);
		
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/admin/?mode=notice\">");			
	exit;
	




}else if ($_POST['mode'] == "del"){
	
	for($i=0; $i<count($_POST['del']); $i++) {
		$sql = "delete from remember_notice_board where nb_id = ".$_POST['del'][$i];
		mysql_query($sql, $connect);
	}
		





}else if ($_POST['mode'] == "modify"){

	//echo $_POST['id']." / ".$_POST['subject']." / ".$_POST['content']." / ".$_POST['date']." / ".$_POST['updated_date']." / ".$_POST['file_name']." / ".$_POST['file_size']." / ".$_POST['link_1']." / ".$_POST['link_2']." / ".$_POST['link_hit_1']." / ".$_POST['link_hit_2']." / ".$_POST['ip']." / ".$_POST['hit']." / ".$_POST['setting'];
	
	$sql = "update remember_notice_board 
				set mb_user = '".$_SESSION['user']."',
					nb_subject = '".$_POST['subject']."',
					nb_content = '".$_POST['content']."',
					nb_date = '".$_POST['date']."',
					nb_updated_date = '".$_POST['updated_date']."',
					nb_file_name = '".$_POST['file_name']."',
					nb_file_size = '".$_POST['file_size']."',
					nb_link_1 = '".$_POST['link_1']."',
					nb_link_2 = '".$_POST['link_2']."',
					nb_link_hit_1 = ".$_POST['link_hit_1'].",
					nb_link_hit_2 = ".$_POST['link_hit_2'].",
					nb_ip = '".$_POST['ip']."',
					nb_hit = '".$_POST['hit']."',
					nb_setting = '".$_POST['setting']."',
					nb_recycle_bin = '".$_POST['recycle_bin']."',
					nb_recycle_bin_date = '".$_POST['recycle_bin_date']."'
				where nb_id = ".$_POST['id'];
	mysql_query($sql, $connect);





}else if ($_POST['mode'] == "strike"){

	//echo "temp : ".$_POST['id'];
	
	$tmp_sql = "select count(*) as cnt from remember_notice_board where nb_recycle_bin = 9 and nb_id = ".$_POST['id'];
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	
	if ($tmp_row['cnt'] == 0){
		$sql = "update remember_notice_board set nb_recycle_bin = 9, nb_recycle_bin_date = now() where nb_id = ".$_POST['id'];
		mysql_query($sql, $connect);
	}else{
		$sql = "update remember_notice_board set nb_recycle_bin = 0, nb_recycle_bin_date = '' where nb_id = ".$_POST['id'];
		mysql_query($sql, $connect);
	}
	




}






mysql_close();
?>