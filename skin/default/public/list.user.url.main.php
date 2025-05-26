<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<p id="list_user_url">
    <a href="/dev/openapi.xml?key=<? echo $public_openapikey ?>"><img src="/skin/<? echo $public_skin ?>/img/rss.png" title="rss" /></a>&nbsp;<a href="<? echo $common_path.$public_user_url ?>" id="shorturl"><? echo $common_path.$public_user_url ?></a>&nbsp;<a href="#" id="copy-shorturl">(copy)</a>&nbsp;/&nbsp;hits : <? echo $public_hit ?>
	
	<?
   	if (isset($_SESSION['user'])) {
		if ($_SESSION['user'] != $_GET['user']) {
			$tmp_sql = "select count(*) as cnt from remember_myfriends where mb_user='".trim($_SESSION['user'])."' and fr_target_user='".trim($_GET['user'])."'";
			$tmp_result = mysql_query($tmp_sql, $connect);
			$tmp_row = mysql_fetch_array($tmp_result);
			$friend_cnt = $tmp_row['cnt']; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span style="font-size:11px; font-style:normal">
            	<a href="#" id="profile_tosend" title="<? echo $_GET['user'] ?>">쪽지보내기</a>&nbsp;
				<? if ($friend_cnt == 1){ ?>
                    <a href="#" id="friend_del">친구해제</a>
                <? }else{ ?>
                    <a href="#" id="friend_add">친구추가</a>
                <? } ?>
                <? echo get_myfriend($_SESSION['user'], $_GET['user']) ?></span>
	<? }} ?>    
   
    
    <!--<? if ($mb_facebook == 1){ ?>
        <a href="http://www.facebook.com/profile.php?id=<? echo $_GET['user'] ?>&sk=info" target="_blank"><img src="https://graph.facebook.com/<? echo $_GET['user'] ?>/picture" title="Profile" align="right"></a>
    <? }else{ ?>    
    	<img src="http://chart.apis.google.com/chart?cht=qr&chs=50x50&choe=UTF-8&chld=H&chl=<? echo $common_path.$public_user_url ?>&chld=L|0" title="<? echo $common_path.$public_user_url ?>" align="right">
   	<? } ?>-->
    
    
    <? if ($mb_facebook == 1){ ?>
    	<a href="http://www.facebook.com/profile.php?id=<? echo $_GET['user'] ?>&sk=info" target="_blank"><!--<a href="/<? echo $public_user_url ?>">--><img src="https://graph.facebook.com/<? echo $_GET['user'] ?>/picture" title="<? echo $public_title ?>" align="right" /></a>
    <? }else if ($mb_facebook == 2){ ?>
	<a href="http://twitter.com/<? echo $public_twitter_user ?>" target="_blank"><img src="<? echo $public_thumbnail ?>" title="<? echo $public_title ?>" align="right" /></a>
    <? }else{ 
		if ($public_thumbnail != ""){ ?>
			<a href="/<? echo $public_user_url ?>"><img src="<? echo $public_thumbnail ?>" title="<? echo $public_title ?>" align="right" /></a>
		<? }else{ ?>
			<a href="/<? echo $public_user_url ?>"><img src="/skin/<? echo $public_skin ?>/img/person.png" title="<? echo $public_title ?>" align="right" /></a>   
	<? }} ?>
    
    
</p>

<div class="addthis_toolbox addthis_default_style" addthis:url="<? echo $common_path.$public_user_url ?>" addthis:title="<? echo $common_title." - ".$public_title ?>">
<a class="addthis_button_facebook_like" fb:like:layout="button_count" fb:like:url="<? echo $common_path.$public_user_url ?>"></a>
<a class="addthis_button_tweet" tw:via="<? echo $common_tweet_id ?>"></a>
<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
<a class="addthis_button_compact"></a>
<!--<a href="http://twitter.com/share" class="twitter-share-button" data-text="<? echo $common_tweet_via ?> <? echo $common_path.$public_user_url ?>" data-url="<? echo $common_path.$public_user_url ?>" data-count="horizontal" data-lang="en">Tweet</a>-->
</div>

<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f1af0ac56cc4abd"></script>
<!--<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>-->



<? if (isset($_SESSION['user'])) { ?>

<script type="text/javascript"> 
//<![CDATA[ 

$(document).ready(function(){

	<? if ($friend_cnt == 1){ ?>
	$( "a#friend_del" ).click(function() {							   
		$.post('/process/myfriends.php', { mode:"del", target_user:"<? echo $_GET['user'] ?>" }, function(data) {
			//alert(data);
			self.location.reload();
		});			   
	});
	<? }else{ ?>
	$( "a#friend_add" ).click(function() {							   
		$.post('/process/myfriends.php', { mode:"add", target_user:"<? echo $_GET['user'] ?>" }, function(data) {
			//alert(data);
			if (data == 0){
				alert("잘못된 접근입니다.");
			}else if (data == 1){
				self.location.reload();
			}
		});			   
	});
	<? } ?>

});

//]]> 
</script>

<? } ?>