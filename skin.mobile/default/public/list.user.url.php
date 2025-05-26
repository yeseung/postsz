<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<div data-role="page" data-theme="a" id="view">
    <div data-role="header" data-position="inline">
    	<a href="<? echo $common_path ?>" rel="external" data-ajax="false">HOME</a>
        <h1><? if (isset($public_title)) echo get_mb_strimwidth($public_title, 30); ?></h1>
    </div>

    <div style="padding:5px 7px 5px 7px;">
    

        
        <div style="float:left;">
            <div style="padding-top:13px;" class="addthis_toolbox addthis_default_style" addthis:url="<? echo $common_path.$public_user_url ?>" addthis:title="<? echo get_mb_strimwidth($bo_content_title, 30) ?>">
            <a class="addthis_button_facebook_like" fb:like:layout="button_count" fb:like:url="<? echo $common_path.$public_user_url ?>"></a>
            <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f1af0ac56cc4abd"></script>
            </div>
            <span style="font-size:9px;color:#999999; border:0; padding:12px 0 0 2px;"><a href="<? echo $common_path.$public_user_url ?>" rel="external" data-ajax="false" style="text-decoration: none; color:#999999; font-size:11px"><? echo $common_path.$public_user_url ?></a>&nbsp;hits:<? echo $public_hit ?></span>
        </div>
        
        <div style="float: right; width:50px;">
        	<? if ($mb_facebook == 1){ ?>
                <a href="/<? echo $public_user_url ?>" rel="external" data-ajax="false"><img src="https://graph.facebook.com/<? echo $_GET['user'] ?>/picture" title="<? echo $public_title ?>" align="right" /></a>
            <? }else{ 
                if ($public_thumbnail != ""){ ?>
                    <a href="/<? echo $public_user_url ?>" rel="external" data-ajax="false"><img src="<? echo $public_thumbnail ?>" title="<? echo $public_title ?>" align="right" /></a>
                <? }else{ ?>
                    <a href="/<? echo $public_user_url ?>" rel="external" data-ajax="false"><img src="/skin/<? echo $public_skin ?>/img/person.png" title="<? echo $public_title ?>" align="right" /></a>   
            <? }} ?>
        </div>    
            
        <br clear="all" />
        
    </div>

    <div style="padding:5px 5px 5px 5px;">
     
    <?
    
    $page = $_GET['page']; 
    if (!$page)	{ $page = 1; $_GET['page'] = 1; }
    
    $sql = "select bo_id, bo_public, su_short_url, bo_content from remember_board_".trim($_GET['user'])." where bo_recycle_bin != 9 and bo_public = 1 order by bo_id desc";
    //$url_view = "/user.url.php?user=".$_GET['user']."&page=".$_GET['page']."&id=";
    $url_page = "/user.url.php?user=".$_GET['user']."&";
    
    $result = mysql_query($sql, $connect);
    $total_record = mysql_num_rows($result);
	
	if ($total_record == 0) { ?>
        <div align="center" style="padding-top:30px; padding-bottom:50px"><img src="/skin.mobile/<? echo $public_skin_m ?>/img/public_num_m.png" width="308" /></div>
    <? }
    
    $scale = $common_public_rows_m;
    if ($total_record % $scale == 0){
        $total_page = floor($total_record/$scale);
    }else{
        $total_page = floor($total_record/$scale) + 1;
    }
    
    $start = ($page - 1) * $scale;
    $number = $total_record - $start; ?>
    
    <ul data-role="listview" data-inset="true" >
    <? for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
        mysql_data_seek($result, $i); 
        $row = mysql_fetch_array($result);
    
        $bo_id = $row['bo_id'];
        //$bo_public = $row['bo_public'];
        $su_short_url = $row['su_short_url'];
        //$bo_content = get_text_index(trim(htmlspecialchars($row['bo_content'])));
        //$bo_content = htmlspecialchars($row['bo_content']);
		$bo_content = strip_tags($row['bo_content']);
        //$common_content_len_ten_m = $common_content_len_m - 5; ?>
        
        <li data-icon="false"><a href="<? echo $common_path.$su_short_url ?>" rel="external" data-ajax="false"><? echo get_mb_strimwidth($bo_content, 120) ?></a></li>
            
    <?	
        $number--;
    } //for ($i=$start; $i<$start+$scale && $i < $total_record; $i++){
    ?>
    </ul>
    </div>
    
    
    
    <?
    if ($total_record > $scale){ 
    ?>
    
    <div style="padding:0;">            
    <fieldset class="ui-grid-a">
    <?
    $start_page = floor($page-1);
    $end_page = $start_page + 1;
    
    if ($total_page <= $end_page) $end_page = $total_page; 
    
    if ($start_page>0) {
        //$prev_page = $start_page - 1;
        $prev_page = $start_page;
        echo "<div class=\"ui-block-a\"><a href=\"".$url_page."page=".$prev_page."\" data-ajax=\"false\" data-role=\"button\">이전</a></div>";
    }else{
        echo "<div class=\"ui-block-a\"><a href=\"#\" data-role=\"button\"><font color=\"#999999\">이전</font></a></div>";	
    }
    
    if ($end_page < $total_page) {
        $next_page = $end_page + 1;
        echo "<div class=\"ui-block-b\"><a href=\"".$url_page."page=".$next_page."\" data-ajax=\"false\" data-role=\"button\">다음</a></div>";
    }else{
        echo "<div class=\"ui-block-b\"><a href=\"#\" data-role=\"button\"><font color=\"#999999\">다음</font></a></div>";
    }
    ?>
    </fieldset>
    </div>
    
    <? } ?>


</div>