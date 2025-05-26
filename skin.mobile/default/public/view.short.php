<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
//include_once ("skin.mobile/{$common_skin_m}/index/head.php");


$sql = "select * from remember_board_".$_GET['user']." where bo_recycle_bin != 9 and bo_public = 1 and bo_id = ".$_GET['id'];
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);

if ($_SESSION['user'] != $_GET['user']) {	
	$tmp_sql = "select bs_subject from remember_boardset where mb_user = '".trim($_GET['user'])."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$_SESSION['set_subject_short'] = $tmp_row['bs_subject'];
}

if ($_COOKIE["view_{$_GET[id]}"] != $_GET['id']){
	$sql = "update remember_board_".$_GET['user']." set bo_hit = bo_hit + 1 where bo_id = ".$_GET['id'];
	mysql_query($sql, $connect);
	setcookie("view_{$_GET[id]}", "{$_GET[id]}", time() + 3600);
}

$bo_id = $row['bo_id'];
$bo_option_explode = explode("|", $row['bo_option']);
$use_comments = $bo_option_explode[0];
$use_recommendations = $bo_option_explode[1];
$use_sns = $bo_option_explode[2];
$use_qrcode = $bo_option_explode[3];
$use_html_temp = $bo_option_explode[4];
if ($use_html_temp == 1){
	$use_html = 0;
}else if ($use_html_temp == 0){
	$use_html = 1;
}
$bo_public = $row['bo_public'];
$su_short_url = $row['su_short_url'];
$bo_ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", "\\1.xxx.\\3.\\4", $row['bo_ip']);
//$bo_ip = $row['bo_ip'];
$bo_date = $row['bo_date'];
//$bo_date = str_replace("-", ".", (substr($row['bo_date'], 2, 14)));
//$bo_date_format = $row['bo_date_format'];
$short_url = $common_path.$row['su_short_url'];
$bo_good = $row['bo_good'];
$bo_nogood = $row['bo_nogood'];
$bo_hit = $row['bo_hit'] + 1;
$bo_security_pass = $row['bo_security_pass'];
$bo_content = $row['bo_content'];
//$bo_content_title = get_text_index(htmlspecialchars($bo_content));
$bo_content_title = get_text_index(strip_tags($bo_content));
$bo_content_str = conv_content($bo_content, $use_html);
//echo "<title>".$common_title." - ".strcut_utf8($bo_content_title, 15)."</title>";
?>    


<?
//echo $_GET['user']." / ".$_GET['id']." / ".$_GET['short']."<br><br>";
?>
  
<div data-role="page" data-theme="a" id="view">
    <div data-role="header" data-position="inline">
    	<a href="<? echo $common_path.$public_user_url ?>" rel="external" data-ajax="false">HOME</a>
        <h1><? if (isset($public_title)) echo get_mb_strimwidth($public_title, 30); ?></h1>
    </div>
    
    <? //include_once ("skin.mobile/{$common_skin_m}/board/write.php") ?>
    
    <div style="padding:5px 10px 20px 10px; border-bottom:1px solid #CCCCCC; background-color:#FFFFFF;">
        
        <? if (!(isset($bo_security_pass))){ ?>
            <p style="word-wrap:break-word;"><? echo $bo_content_str ?></p>
        <? }else{ ?>
            <form id="decryption"><input type="password" id="decryption_pass" maxlength="6" /><input type="submit" value="복호화" /></form>
            <p id="contentstr" style="word-wrap:break-word;"><? echo $bo_content_str ?></p>
        <? } ?>
        
        <p style="text-align:right; font-size:10px; color:#999999;">
            <? if ($bo_public == 1){ ?><a href="<? echo $short_url ?>" rel="external" data-ajax="false" target="_blank" style="text-decoration: none; color:#999999; font-size:13px"><? echo $short_url ?></a><br /><? } ?>
            <? echo diffDate($bo_date) ?>, <? echo $bo_ip ?>, hits : <? echo $bo_hit ?> <img src="/skin/<? echo $common_skin ?>/img/lock<? echo ($bo_public == 1) ? "" : "ed" ?>.png" />
        </p>
        
		<? if ($bo_public == 1){ ?>
        	<? if ($use_sns == 0){ ?>
                <div style="padding-bottom:3px; padding-left:2px;" class="addthis_toolbox addthis_default_style" addthis:url="<? echo $short_url ?>" addthis:title="<? echo get_mb_strimwidth($bo_content_title, 30) ?>">
                <a class="addthis_button_facebook_like" fb:like:layout="button_count" fb:like:url="<? echo $short_url ?>"></a>
                <!--<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                <a href="http://twitter.com/share" class="twitter-share-button" data-text="<? echo get_mb_strimwidth($bo_content_title, 30) ?>" data-url="<? echo $short_url ?>" data-count="horizontal" data-lang="en">Tweet</a>-->
                </div>
                <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f1af0ac56cc4abd"></script>
                <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            <? } ?>
        
            <? if ($use_comments == 0){ ?>   
            <ul data-role="listview" data-inset="true"> 
                <li data-icon="arrow-r"><a href="/comment.disqus.short.php?user=<? echo $_GET['user'] ?>&id=<? echo $_GET['id'] ?>&short=<? echo $su_short_url ?>" rel="external" data-ajax="false">댓글쓰기</a></li>
            </ul>
            <? } ?>
        <? } //if ($bo_public == 1){ ?>
    
    </div>

</div>


<script type="text/javascript">
//<![CDATA[

$(document).ready(function(){

	$( "form#decryption" ).submit(function() {
		//alert($("#decryption_pass").val());
		$.post('/process/decryption.php', {user:"<? echo trim($_GET['user']) ?>", num:<? echo $_GET['id'] ?>, pass:$("#decryption_pass").val() }, function(data) {
			//alert(data);
			$("#contentstr").text(data);
		});
		return false;
	});

});

//]]>
</script>


<?
//include_once ("skin.mobile/{$common_skin_m}/index/tail.php");
?>