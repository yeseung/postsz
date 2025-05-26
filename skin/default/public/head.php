<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="/img/postsz.ico" />
<link rel ="alternate" type="application/rss+xml" href="/dev/openapi.xml?key=<? echo $public_openapikey ?>" title="RSS feed" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<? 
if (isset($public_title)){
	echo "<title>".$common_title." - ".$public_title."</title>";
}
/*else{
	echo "<title>".$common_title."</title>";
}*/
?>

<script type="text/javascript" src="/js/jquery-1.6.2.js"></script>
<script type="text/javascript" src="/js/jquery.bgiframe-2.1.2.js"></script>
<script type="text/javascript" src="/js/jquery.ui.core.js"></script>
<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/js/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="/js/jquery.ui.button.js"></script>
<script type="text/javascript" src="/js/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="/js/jquery.ui.position.js"></script>
<script type="text/javascript" src="/js/jquery.ui.resizable.js"></script>
<script type="text/javascript" src="/js/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="/js/jquery.effects.core.js"></script>
<script type="text/javascript" src="/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/js/jquery.formtips.1.2.5.js"></script>
<script type="text/javascript" src="/js/jquery.maxlength.js"></script>
<script type="text/javascript" src="/js/jquery.zclip.js"></script>
<script type="text/javascript" src="/js/jquery.simplemodal.js"></script>
<script type="text/javascript" src="/js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="/js/jquery.pngFix.js"></script>
<script type="text/javascript" src="/js/jquery.cluetip.js" ></script>
<script type="text/javascript" src="/js/jquery.ticker.js"></script>
<script type="text/javascript" src="/js/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" href="/skin/<? echo $public_skin ?>/css/jquery.ui.all.css">
<link rel="stylesheet" href="/skin/<? echo $public_skin ?>/css/style.css">
<link rel="stylesheet" href="/skin/<? echo $public_skin ?>/css/default.css">
<link rel="stylesheet" href="/skin/<? echo $public_skin ?>/css/fg.menu.css">
<link rel="stylesheet" href="/skin/<? echo $public_skin ?>/css/jcarousel.css">
<link rel="stylesheet" href="/skin/<? echo $public_skin ?>/css/jquery.cluetip.css" type="text/css" />
<link rel="stylesheet" href="/skin/<? echo $public_skin ?>/css/toolbar.css">
<script type="text/javascript" src="/skin/<? echo $public_skin ?>/js/fg.menu.js"></script>
<script type="text/javascript" src="/skin/<? echo $public_skin ?>/js/jquery.js"></script>

</head>
<body>

<div class="toolbar_box">
    <div id="payHeader" class="TP12">
        <div id="Header">
            <!--<div class="top_logo"><a href="/">test</a></div>-->
            <div class="loginMenu">
                <li class="login_menu1"><a href="/help"></a></li>
                <? if (!(isset($_SESSION['user']))) { ?>
                    <li class="login_menu2"><? echo ($_SERVER["SCRIPT_NAME"] == "/process/short.php") ? "<a href=\"/\">" : "<a href=\"#\" id=\"log-menu-login-user-a\">" ?></a></li>
                    <li class="login_menu3"><? echo ($_SERVER["SCRIPT_NAME"] == "/process/short.php") ? "<a href=\"/?mode=create\">" : "<a href=\"#\" id=\"log-menu-create-user-a\">" ?></a></li>
                <? }else{ ?>
                    <!--<li class="login_menu5"><a href="#"></a></li>
                    <li class="login_menu6"><a href="#"></a></li>
                    <li class="login_menu7"><a href="#"></a></li>-->
                    <li class="login_menu4"><a href="#" id="log-menu-logout-a"></a></li>
                <? } ?>
            </div>
            <div class="headMenu">
                <div id="miniPaper_nav">
                    <ul id="nav" class="droppy">				
                        <li ><a href="/">초기화면</a></li>
                        <li><a href="#" id="toolbar_notice">공지사항</a></li>
                        <!--<li ><a href="#" onclick="javascript:alert('구현 중입니다. 빠른 시일내에 구현하도록 하겠습니다.')">커뮤니티</a></li>-->
                        <? if (isset($_SESSION['user'])) { ?>
                        	<li><a href="<? echo "/".$_SESSION['set_user_url'] ?>">공개주소</a>
                            <li><a href="#" id="toolbar_listview">리스트뷰</a></li>
                        	<li><a href="#" id="toolbar_memo_recv">쪽지함</a></li>
                            <li><a href="#" id="toolbar_point">포인트</a></li>
                            <li><a href="#" id="toolbar_history">로그인기록</a></li>
                            <li><a href="#" id="toolbar_scrap">스크랩</a></li>
                            <? if (get_recycle_bin($_SESSION['user']) != 0){ ?><li><a href="#" id="toolbar_recycle_bin">휴지통</a></li><? } ?>
                        <? } ?>
                        <!--<li><a href="/feedback">Feedback</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="control_box">
    <div id="tb_control" class="btn2"><a href="#"><img src="/skin/<? echo $public_skin ?>/img/toolbar_menu.png" /></a></div>
</div>






<div id="wrapper">

    <div id="header">
    
    	<? 
		if (isset($public_title)){
			//echo "<h1 id=\"logo_sub\"><a href=\"/".$public_user_url."\">".$public_title."</a></h1>";
			echo "<h1 id=\"logo_sub\"><a href=\"javascript:history.go(-1)\">".$public_title."</a></h1>";
		}
		/*else{
			echo "<h1 id=\"logo\"><a href=\"/".$public_user_url."\"><img src=\"/skin/".$public_skin."/img/logo.png\" title=\"".$common_title."\" /></a></h1>";
		}*/
		?>
    
    	
    	<div id="favorite">
        
        <?
		$sql = "select fr_target_user from remember_myfriends where mb_user ='".trim($_SESSION['user'])."' order by fr_id desc LIMIT ".$common_limit_myfriends;
		$result = mysql_query($sql, $connect);
		
		$tmp_sql = "select count(*) as cnt from remember_myfriends where mb_user ='".trim($_SESSION['user'])."' order by fr_id desc LIMIT ".$common_limit_myfriends;
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$total_record = $tmp_row['cnt'];
		
		if ($total_record != 0){ ?>
        
            <a tabindex="0" href="#search-engines" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-all" id="flat"><span class="ui-icon ui-icon-triangle-1-s"></span>My Friendz</a>
            <div id="search-engines" class="hidden">
            <ul>
            <?
            while ($row = mysql_fetch_array($result)){ 
				$fr_target_user = $row['fr_target_user'];
				
				$tmp_sql = "select bs_subject, bs_user_url from remember_boardset where mb_user = '".$fr_target_user."'";
				$tmp_result = mysql_query($tmp_sql, $connect);
				$tmp_row = mysql_fetch_array($tmp_result);
				$target_subject = strip_tags($tmp_row['bs_subject']);
				$target_user_url = $tmp_row['bs_user_url'];
			?>
                <li><a href="/<? echo $target_user_url ?>"><? echo $target_subject ?></a></li>
            <? } ?>    
                <li><a href="/friend">더보기...</a></li>
            </ul>
            </div>
            
        <? } ?>    
        	
        </div>
    </div>


	<div id="page" class="container">
		<div id="content">
			
