<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if (!$_SESSION['user']){
	echo("<script>
		window.alert('로그인을 하셔야 이용하실 수 있습니다.')
		history.go(-1)
		</script>");
	exit;
}

if (($_POST['public'] != "0") and ($_POST['public'] != "1")){
	echo("<script>
		window.alert('잘못된 접근입니다.')
		history.go(-1)
		</script>");
	exit;
}

$save_path = "data/temp/";

$file_name = $_FILES[excel][name][0]; 
$file_tmp_name = $_FILES[excel][tmp_name][0]; 
$file_type = $_FILES[excel][type][0];
$file_size = $_FILES[excel][size][0];
$file_error = $_FILES[excel][error][0];

if($file_size && !$file_error) { 
		
	if (($file_type == "application/vnd.ms-excel") && ($file_size < 1024000)){
		if (!file_exists($save_path.$file_name)) { 
			move_uploaded_file($file_tmp_name,$save_path.$file_name); 
		}else{ 
			$file_name = time()."_".$file_name;
			move_uploaded_file($file_tmp_name,$save_path.$file_name); 
		}		
	}else{
		die("Error");
		/*echo("<script>
			window.alert('잘못된 백업파일입니다. 다시 등록해주세요.');
			history.go(-1);
			</script>");*/
		exit;
	}
}		

$tmp_excel = $_SERVER["DOCUMENT_ROOT"]."/process/".$save_path.$file_name;
//echo $tmp_excel."<br><br>";

$tmp_sql = "select max(su_id) as max_su_id from remember_short_url";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$max_su_id = $tmp_row['max_su_id'];

require_once "../lib/excel.reader.php";
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding("UTF-8//IGNORE");
$tmp_read = $data->read($tmp_excel);

for ($i =  1; $i <= $data->sheets[0]["numRows"]; $i++) {
	$content = $data->sheets[0]["cells"][$i][1];
	//echo $content."<br>";
	$short_url_random = get_rand($common_short_url);

	$sql = "insert into remember_board_".trim($_SESSION['user'])." (bo_public, su_short_url, bo_content, bo_date, bo_ip) ";
	$sql .= "values (".$_POST['public'].", '".$short_url_random."', '".$content."', now(), '".$_SERVER['REMOTE_ADDR']."')";
	mysql_query($sql, $connect);
	//echo $sql."<br><br>";
	
	$tmp_sql = "select last_insert_id()"; //최근 auto_increment
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$last_insert_id = $tmp_row[0]; 
	
	if ($_POST['public'] == 1){ //공개
		$sql = "insert into remember_short_url (su_id, su_short_url, mb_user, bo_id, su_date) ";
		$sql .= "values (".($max_su_id + $i).", '".$short_url_random."', '".trim($_SESSION['user'])."', ".$last_insert_id.", now())";
		mysql_query($sql, $connect);
		//echo $sql."<br><br>";
	}
	
}


echo("<script>
	opener.document.location.href='/';
	window.close(); 
	</script>");

//echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");			
exit;

?>