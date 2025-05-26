<? 
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

Header("Content-type: text/xml"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");

if (!(get_openapi_key($_GET['key']))){
	echo get_openapi_error("등록되지 않은 키입니다.", "401");
	exit;
}else{
	if ($common_open_api_demo_key != $_GET['key']){
		$tmp_sql = "update remember_boardset set bs_openapi_hit = bs_openapi_hit + 1 where bs_openapikey = '".$_GET['key']."'";
		mysql_query($tmp_sql, $connect);
	}
}

if (isset($_GET['result'])){
	if (eregi("[^0-9]", $_GET['result'])){
		echo get_openapi_error("잘못된 쿼리요청입니다.", "403");
		exit;
	}else if (($_GET['result'] < 2) || ($_GET['result'] > 20)){
		echo get_openapi_error("잘못된 쿼리요청입니다.", "403");
		exit;
	}
}

if (isset($_GET['page'])){
	if (eregi("[^0-9]", $_GET['page'])){
		echo get_openapi_error("잘못된 쿼리요청입니다.", "403");
		exit;
	}
}

$page = $_GET['page']; 
if (!$page)	{ $page = 1; $_GET['page'] = 1; }

$scale = $_GET['result'];
if (!$scale) { $scale = 10; }

if($common_open_api_demo_key == $_GET['key']){
	$sql = "select * from remember_short_url order by su_id desc";
}else{
	$sql = "select * from remember_short_url where mb_user = '".get_openapi_key($_GET['key'])."' order by su_id desc";
}
$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

if ($total_record % $scale == 0){
	$total_page = floor($total_record/$scale);
}else{
	$total_page = floor($total_record/$scale) + 1;
}

$start = ($page - 1) * $scale;
$number = $total_record - $start;

if ( $total_page == 0 ){
	echo get_openapi_error("등록된 게시글이 없습니다.", "404");
	exit;
} 

if ( $total_page < $page ){
	echo get_openapi_error("잘못된 쿼리요청입니다.", "403");
	exit;
}

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; 
echo "<rss version=\"2.0\">\n"; 

echo "<channel>\n"; 
if($common_open_api_demo_key == $_GET['key']){
	echo "\t<title>".$common_open_api_title."</title>\n"; 
	echo "\t<link>".$common_open_api_link."</link>\n"; 
}else{
	$tmp_sql = "select a.mb_email, a.mb_updated_date, b.bs_subject, b.bs_user_url, b.bs_hit from remember_member as a join remember_boardset as b on a.mb_user = b.mb_user where a.mb_user = '".trim(get_openapi_key($_GET['key']))."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_email = trim($tmp_row['mb_email']);
	$tmp_updated_date = date('r', strtotime($tmp_row['mb_updated_date']));
	$tmp_subject = trim(strip_tags($tmp_row['bs_subject']));
	$tmp_user_url = trim(strip_tags($tmp_row['bs_user_url']));
	$tmp_hit = $tmp_row['bs_hit'];
	echo "\t<title>".$tmp_subject."</title>\n"; 
	echo "\t<link>".$common_path.$tmp_user_url."</link>\n"; 
	echo "\t<author>".get_openapi_key($_GET['key'])."</author>\n";
	echo "\t<hit>".$tmp_hit."</hit>\n";
	echo (!isset($tmp_email)) ? "\t<email>".$tmp_email."</email>\n" : "";
	echo "\t<pubDate>".$tmp_updated_date."</pubDate>\n"; 
}
echo "\t<description>".$common_open_api_description."</description>\n"; 
echo "\t<totalCount>".$total_record."</totalCount>\n";
echo "\t<pageCount>".$total_page."</pageCount>\n";
echo "\t<page>".$page."</page>\n";
echo "\t<result>".$scale."</result>\n";

for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i); 
	$row = mysql_fetch_array($result);

	$su_id = $row['su_id'];
	$su_short_url = $row['su_short_url'];
	$mb_user = $row['mb_user'];
	$bo_id = $row['bo_id'];
	$su_date = $row['su_date'];
	$su_date = date('r', strtotime($su_date));
	
	$sql1 = "select left(bo_content, ".$common_content_len.") as bo_content from remember_board_".$mb_user." where bo_public = 1 and bo_id = ".$bo_id." order by bo_id desc";
	$result1 = mysql_query($sql1, $connect); 
	$row1 = mysql_fetch_array($result1);
	//$bo_content = $row1['bo_content'];
	//$bo_content = get_text_index($bo_content);
	//$bo_content = conv_content($row1['bo_content'], 0);
	$bo_content = get_mb_strimwidth(strip_tags($row1['bo_content']), 300);
	//$bo_content = strip_tags($row1['bo_content']);

	echo "\t<item>\n"; 
	//echo "<title><![CDATA[".get_mb_strimwidth($bo_content, 40)."]]></title>\n";
	echo "\t\t<title><![CDATA[".get_mb_strimwidth($bo_content, 50)."]]></title>\n"; 
	//echo "<link>".$common_path.$su_short_url."</link>\n"; 
	//echo "<link><![CDATA[".$common_path."process/view.sns.php?short=".$su_short_url."]]></link>\n";
	//echo "<link><![CDATA[".$common_path.$su_short_url."]]></link>\n";
	echo "\t\t<link>".htmlentities($common_path.$su_short_url)."</link>\n"; 
	echo "\t\t<description><![CDATA[".$bo_content."]]></description>\n";
	//echo "<description><![CDATA[]]></description>\n"; 
	echo "\t\t<author>".$mb_user."</author>\n"; 	
	echo "\t\t<pubDate>".$su_date."</pubDate>\n"; 
	echo "\t</item>\n";
	
} 

echo "</channel>\n"; 
echo "</rss>\n"; 
?>