<? 
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

//$sql = "select * from remember_short_url where su_blacklist_date = '0000-00-00 00:00:00' order by su_id desc limit 20";
$sql = "select * from remember_short_url order by su_id desc limit 20";
$result = mysql_query($sql, $connect); 

Header("Content-type: text/xml"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 
 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; 
echo "<rss version=\"2.0\">\n"; 
//echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n"; 

echo "<channel>\n"; 
echo "\t<title>".$common_title."</title>\n"; 
echo "\t<link>".$common_path."</link>\n"; 
echo "\t<description>".$common_help_title."</description>\n"; 
//echo "\t<language>ko</language>\n";
//echo "\t<webMaster>".$common_email."</webMaster>\n";

while ($row = mysql_fetch_array($result)){
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
	$bo_content = strip_tags($row1['bo_content']);

	echo "\t<item>\n"; 
	//echo "<title><![CDATA[".get_mb_strimwidth($bo_content, 40)."]]></title>\n";
	echo "\t\t<title><![CDATA[".get_mb_strimwidth($bo_content, 80)."]]></title>\n"; 
	//echo "<link>".$common_path.$su_short_url."</link>\n"; 
	echo "\t\t<link>".htmlentities($common_path."process/view.sns.php?short=".$su_short_url)."</link>\n"; 
	//echo "<description><![CDATA[".$bo_content."]]></description>\n";
	echo "\t\t<description><![CDATA[]]></description>\n"; 
	echo "\t\t<author>".$mb_user."</author>\n"; 	
	echo "\t\t<pubDate>".$su_date."</pubDate>\n"; 
	echo "\t</item>\n";
	
} 

echo "</channel>\n"; 
echo "</rss>\n"; 
?>