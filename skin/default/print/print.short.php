<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link type="text/css" href="/skin/<? echo $common_skin ?>/print/css/default.css" rel="stylesheet" media="all" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

</head>

<body>

<div id="print">
	<div id="top">
		<a href="javascript:window.print()"><img src="/skin/<? echo $common_skin ?>/img/icon_print.png" title="프린트" border="0" /></a>
	</div>
    
    <div id="middle">
    
		<?    
        $sql = "select * from remember_board_".trim($_GET['user'])." where bo_recycle_bin != 9 and bo_id = ".$_GET['id']." and bo_public = 1";
        $result = mysql_query($sql, $connect);
        $row = mysql_fetch_array($result);
        
        $su_short_url = $row['su_short_url'];
        $bo_id = $row['bo_id'];
		$bo_option_explode = explode("|", $row['bo_option']);
		$use_html_temp = $bo_option_explode[4];
		if ($use_html_temp == 1){
			$use_html = 0;
		}else if ($use_html_temp == 0){
			$use_html = 1;
		}
        $bo_content = $row['bo_content'];
        //$bo_content_title = get_text_index($bo_content);
		$bo_content_title = strip_tags($bo_content);
        $bo_content_str = conv_content($bo_content, $use_html);
		$bo_public = $row['bo_public'];
        $bo_ip = $row['bo_ip'];
        $bo_date = $row['bo_date'];
        echo "<title>".$common_title." - ".get_mb_strimwidth($bo_content_title, 25)."</title>";
        
        ?> 
    	<h1><? echo get_mb_strimwidth($bo_content_title, 27) ?></h1>
        
        <p id="short_date">
        	Post by <? echo trim($_GET['user']) ?> at <? echo $bo_date ?>
			<? if ($bo_public == 1) { ?> / <a href="<? echo $common_path.$su_short_url ?>" target="_blank"><? echo $common_path.$su_short_url ?></a><? } ?>&nbsp;
            <img src="/skin/<? echo $common_skin ?>/img/lock<? echo ($bo_public == 1) ? "" : "ed" ?>.png" /></p>
        <p><? echo $bo_content_str ?></p>
    
    </div>
    
    <div id="bottom"></div>
  
</div>     

</body>
</html>