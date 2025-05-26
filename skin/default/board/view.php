<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

if (isset($_GET['search'])) {
	$url_page = "?search=".$_GET['search']."&id=".$_GET['id'];
}else{
	$url_page = "?id=".$_GET['id'];
}

$sql = "select * from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_GET['id'];
//$sql = "select *, DATE_FORMAT(bo_date, '%M %d, %Y %H:%i') as bo_date_format from remember_board_".trim($_SESSION['user'])." where bo_id = ".$_GET['id'];
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);

if ($_COOKIE["view_{$_GET[id]}"] != $_GET['id']){
	$sql = "update remember_board_".trim($_SESSION['user'])." set bo_hit = bo_hit + 1 where bo_id = ".$_GET['id'];
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
//$bo_ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", "\\1.xxx.\\3.\\4", $row['bo_ip']);
$bo_ip = $row['bo_ip'];
$bo_date = str_replace("-", "/", (substr($row['bo_date'], 2, 14)));
//$bo_date_format = $row['bo_date_format'];
$short_url = $common_path.$row['su_short_url'];
$bo_good = $row['bo_good'];
$bo_nogood = $row['bo_nogood'];
$bo_hit = $row['bo_hit'] + 1;
$bo_security_pass = $row['bo_security_pass'];
$bo_content = $row['bo_content'];
$bo_content_title = get_text_index($bo_content);
$bo_content_str = conv_content($bo_content, $use_html);
//echo "<title>".$common_title." - ".strcut_utf8($bo_content_title, 15)."</title>";

?>

<br clear="all" />

<div id="date_ip">
    <div id="nav">
		<p><? echo $bo_date ?>&nbsp;<? echo $bo_ip ?>&nbsp;<span title="조회수"><? echo $bo_hit ?></span><? if ($bo_public == 1){ ?>/<span title="스크랩"><? echo get_scrap_num($su_short_url) ?></span><? } ?>&nbsp;<img src="/skin/<? echo $common_skin ?>/img/lock<? echo ($bo_public == 1) ? "" : "ed" ?>.png" /></p>
	</div>    
</div>

<!--<div id="short">
    <div id="nav">
		<p><a href="<? echo $short_url ?>" id="shorturl"><? echo $short_url ?></a> <a href="#" id="copy-shorturl">(copy)</a></p>
	</div>    
</div>-->


<div id="cont">
	<? if (!(isset($bo_security_pass))){ ?>
    	<div id="contentstr" style="word-wrap:break-word;"><? echo $bo_content_str ?></div>
    <? }else{ ?>
    	<form id="decryption">
        <input type="password" id="decryption_pass" maxlength="6" style="width:50px;font-size:10.3px;background:none;border:1px solid #CCCCCC;" class="text ui-widget-content ui-corner-all" />&nbsp;<input type="submit" value="복호화" /></form>
    	<div id="contentstr" style="word-break:break-all;"><? echo $bo_content_str ?></div>
    <? } ?>    
    <p id="shorturlstr"><? if ($bo_public == 1) { ?><a href="<? echo $short_url ?>" id="shorturl"><? echo $short_url ?></a> <a href="#" id="copy-shorturl">(copy)</a><? } ?></p>
    
	<? if (($bo_public == 1) and ($use_recommendations == 0)) { ?>
    <div id="no_good">
        <p id="goodstr"><a name="nogood"></a>+<a href="#nogood" id="good"><? echo $bo_good ?></a></p>
        <p id="nogoodstr">-<a href="#nogood" id="nogood"><? echo $bo_nogood ?></a></p>
    </div><? } ?>
    
    <div id="url_qrcode">
    	<div id="url">
			<!--<? if ($bo_public == 1) { ?>
                <p><a href="<? echo $short_url ?>" id="shorturl"><? echo $short_url ?></a> <a href="#" id="copy-shorturl">(copy)</a></p>
            <? } ?>-->
            <a name="set"></a>
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td background="/skin/<? echo $common_skin ?>/img/icon_copy.png" width="48" height="48" id="copy_table"><a href="#set" id="copy-content">&nbsp;&nbsp;copy</a></td>
                <td><? if ($bo_public == 1){ ?><? if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) { ?><a href="#set" onClick="window.external.AddFavorite('<? echo $short_url ?>', '<? echo $common_title." - ".get_mb_strimwidth($bo_content_title, 30) ?>')"><img src="/skin/<? echo $common_skin ?>/img/icon_add.png" title="즐겨찾기" /></a><? }} ?>
            <a href="#set" onclick="MM_openBrWindow('/print.php?id=<? echo $bo_id ?>','print','scrollbars=yes,width=550,height=650')" ><img src="/skin/<? echo $common_skin ?>/img/icon_print.png" title="인쇄" /></a>
            <? if ($bo_public == 1){ ?><a href="#" id="closed"><img src="/skin/<? echo $common_skin ?>/img/icon_lock.png" title="공개" /></a>
            <? }else if ($bo_public == 0){ ?><a href="#" id="public"><img src="/skin/<? echo $common_skin ?>/img/icon_locked.png" title="비공개" /></a><? } ?>
            <? if ($bo_public == 1){ ?><a href="#set" id="option"><img src="/skin/<? echo $common_skin ?>/img/icon_set.png" title="옵션" /></a><? } ?>
            <? if ($_SESSION['set_recycle_bin'] == 1){ ?><a href="#set" id="del"><img src="/skin/<? echo $common_skin ?>/img/icon_del<? echo ($bo_public == 1) ? "" : "_b" ?>.png" title="삭제" /></a><? }else if ($_SESSION['set_recycle_bin'] == 0){ ?><a href="#set" id="recycle_bin"><img src="/skin/<? echo $common_skin ?>/img/icon_recycle_bin.png" title="휴지통" /></a><? } ?></td>
              </tr>
            </table>
         </div>
         <? if (($bo_public == 1) and ($use_qrcode == 0)) { ?>
            <div id="qr_code">
                <img src="http://chart.apis.google.com/chart?cht=qr&chs=80x80&choe=UTF-8&chld=H&chl=<? echo urlencode($short_url) ?>&chld=L|0" title='<? echo get_mb_strimwidth($bo_content_title, 20) ?>'>
            </div>    
         <? } ?>
         
    </div> 
</div> 

<br clear="all" />

<div style="padding-top:5px"></div>

<? if ($bo_public == 1){ ?>
	<? if ($use_sns == 0){ ?>
		<div style="padding-top:1px;" class="addthis_toolbox addthis_default_style" addthis:url="<? echo $short_url ?>" addthis:title="<? echo get_mb_strimwidth($bo_content_title, 40) ?>">
        <a class="addthis_button_facebook_like" fb:like:layout="button_count" fb:like:url="<? echo $short_url ?>"></a>
        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
        <a href="http://twitter.com/share" class="twitter-share-button" data-text="<? echo $common_tweet_via ?> <? echo get_mb_strimwidth($bo_content_title, 40) ?>" data-url="<? echo $short_url ?>" data-count="horizontal" data-lang="en">Tweet</a>
        <a href="javascript:pstMe2Day('<? echo get_mb_strimwidth($bo_content_title, 40) ?>', '<? echo $short_url ?>')"><img src="/skin/<? echo $common_skin ?>/img/icon_me2day.png" /></a>
        <a href="javascript:pstYozmDaum('<? echo $short_url ?>','<? echo get_mb_strimwidth($bo_content_title, 40) ?>','<? echo $common_path ?>');return false;"><img src="/skin/<? echo $common_skin ?>/img/icon_yozm.png" /></a>
        </div>
        <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f1af0ac56cc4abd"></script>
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    <? } ?>

    <? if ($use_comments == 0){ ?>
    
    	<div id="disqus_thread"></div>
        <script type="text/javascript">
			var disqus_config = function() {
    			this.page.url = "<? echo $common_path."process/view.sns.php?short=".$su_short_url ?>";
			}
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'postsz'; // required: replace example with your forum shortname
            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        
        <!--<div style="padding-top:1px;" class="fb-comments" data-href="<? echo $common_path."process/view.sns.php?short=".$su_short_url ?>" data-num-posts="12" data-width="521"></div>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>-->
    <? } ?>
<? } //if ($bo_public == 1){ ?>





<? include_once ("skin/{$common_skin}/board/prev.next.php"); ?>




<script type="text/javascript">
//<![CDATA[

function pstMe2Day(msg, url) {
	var href = "http://me2day.net/posts/new?new_post[body]=" + encodeURIComponent(msg) + " " + encodeURIComponent(url);
	var a = window.open(href, 'me2Day', '');
	if ( a ) {
		a.focus();
	}
}

function pstYozmDaum(url, prefix, parameter){
	var href = "http://yozm.daum.net/api/popup/prePost?link=" + encodeURIComponent(url) + "&prefix=" + encodeURIComponent(prefix) + "&parameter=" + encodeURIComponent(parameter);
	var a = window.open(href, 'yozm', 'width=466, height=356');
	if( a ){
		a.focus();
	}
}


$(document).ready(function(){

	$( "form#decryption" ).submit(function() {
		$.post('/process/decryption.php', {user:"<? echo trim($_SESSION['user']) ?>", num:<? echo $_GET['id'] ?>, pass:$("#decryption_pass").val() }, function(data) {
			//alert(data);
			$("#contentstr").text(data);
		});
		return false;
	});


	$( "a#closed" ).click(function() {
		if ($.cookie('cookie') != 'public'){
			$.post('/process/public.php', {mode:"closed", num:<? echo $_GET['id'] ?>},
				function(data){
					if (data == 0){
						$.cookie('cookie', 'public', { expires: 10*1000 });
						self.location.href = '/view.php?id=<? echo $_GET['id'] ?>';
						//self.location.reload();
					}else if (data == 1){
						$( "#hidden-message-error" ).dialog({
							resizable: false,
							width: 400,
							modal: true,
							buttons: {
								"확인": function() {
									$( this ).dialog( "close" );
								}
							}
						});
					}	
			});
		}else{
			$( "#hidden-message-ten" ).dialog( "open" );	
			$( "#hidden-message-ten" ).dialog({
				resizable: false,
				width: 400,
				modal: true,
				buttons: {
					"확인": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}		
		return false;	
	});
	
	$( "a#public" ).click(function() {
		if ($.cookie('cookie') != 'public'){
			$.post('/process/public.php', {mode:"public", num:<? echo $_GET['id'] ?>},
				function(data){
					if (data == 0){
						$.cookie('cookie', 'public', { expires: 10*1000 });
						self.location.reload();
					}else if (data == 1){
						$( "#hidden-message-error" ).dialog({
							resizable: false,
							width: 400,
							modal: true,
							buttons: {
								"확인": function() {
									$( this ).dialog( "close" );
								}
							}
						});
					}
			});	
		}else{
			$( "#hidden-message-ten" ).dialog({
				resizable: false,
				width: 400,
				modal: true,
				buttons: {
					"확인": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}		
		return false;
	});	



	





	$( "a#good" ).click(function() {
		if ($.cookie('cookie') != 'nogood_<? echo $_GET['id'] ?>'){
			$.post('/process/nogood.php', {mode:"good", user:"<? echo $_SESSION['user'] ?>", num:<? echo $_GET['id'] ?>},
				function(data){
					$.cookie('cookie', 'nogood_<? echo $_GET['id'] ?>', { expires: 60*60*1000 });
					$( "#hidden-message-good" ).dialog({
						resizable: false,
						width: 400,
						modal: true,
						buttons: {
							"확인": function() {
								var plus = parseInt( $("#good").text() ) + 1;
								$( "#good" ).text( "" );
								$( "#good" ).after( plus );	
								$( this ).dialog( "close" );
								//self.location.reload();
							}
						}
					});	
			});
		}else{
			$( "#hidden-message-cookie-nogood" ).dialog({
				resizable: false,
				width: 400,
				modal: true,
				buttons: {
					"확인": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}	
	});	
	
	$( "a#nogood" ).click(function() {
		if ($.cookie('cookie') != 'nogood_<? echo $_GET['id'] ?>'){
			$.post('/process/nogood.php', {mode:"nogood", user:"<? echo $_SESSION['user'] ?>", num:<? echo $_GET['id'] ?>},
				function(data){
					$.cookie('cookie', 'nogood_<? echo $_GET['id'] ?>', { expires: 60*60*1000 });
					$( "#hidden-message-nogood" ).dialog({
						resizable: false,
						width: 400,
						modal: true,
						buttons: {
							"확인": function() {
								var minus = parseInt( $("#nogood").text() ) + 1;
								$( "#nogood" ).text( "" );
								$( "#nogood" ).after( minus );	
								$( this ).dialog( "close" );
								//self.location.reload();
							}
						}
					});
			});
		}else{
			$( "#hidden-message-cookie-nogood" ).dialog({
				resizable: false,
				width: 400,
				modal: true,
				buttons: {
					"확인": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}	
	});	
	
	
	
	<? if ($_SESSION['set_recycle_bin'] == 1){ ?>
	
		$( "#hidden-message-del" ).dialog({
			autoOpen: false,
			resizable: false,
			width: 400,
			modal: true,
			buttons: {
				"확인": function() {
					$.post('/process/delete.php', $("form#delete").serialize(), function(data) {
						//alert(data);
						$( this ).dialog( "close" );
						self.location.href = '/';
					});
				},
				"취소": function() {
					$( this ).dialog( "close" );
				}
			}
		});	
			
		$( "a#del" ).click(function() {
			$( "#hidden-message-del" ).dialog( "open" );					   
		});
	
	<? }else if ($_SESSION['set_recycle_bin'] == 0){ ?>
	
		$( "#hidden-message-recycle_bin" ).dialog({
			autoOpen: false,
			resizable: false,
			width: 400,
			modal: true,
			buttons: {
				"확인": function() {
					$.post('/process/delete.php', $("form#delete").serialize(), function(data) {
						//alert(data);
						$( this ).dialog( "close" );
						self.location.href = '/';
					});
				},
				"취소": function() {
					$( this ).dialog( "close" );
				}
			}
		});	
	
		$( "a#recycle_bin" ).click(function() {
			$( "#hidden-message-recycle_bin" ).dialog( "open" );					   
		});
	
	<? } ?>
	
	
	
	
	


});




//]]>
</script>


<div id="hidden-message-cookie-nogood" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>이미 추천/비추천 하신 글 입니다.</p>
</div>
<div id="hidden-message-good" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>추천 되었습니다.</p>
</div>
<div id="hidden-message-nogood" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>비추천 되었습니다.</p>
</div>



<div id="hidden-message-option" title="Option" style="display:none">
    <form id="option">
    <input type="hidden" value="<? echo $_GET['id'] ?>" name="num"  />
    <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr>
            <td width="35%" align="right"><strong>댓글 : </strong>&nbsp;</td>
            <td><input type="checkbox" id="comments" <? echo ($use_comments == 0) ? "checked" : "" ?> /><label for="comments">댓글 잠금</label><input type="hidden" id="comments" value="<? echo ($use_comments == 0) ? "0" : "1" ?>" name="comments" /></td>
        </tr>
        <tr>
            <td align="right"><strong>추천 : </strong>&nbsp;</td>
            <td><input type="checkbox" id="recommendations" <? echo ($use_recommendations == 0) ? "checked" : "" ?> /><label for="recommendations">추천 사용</label><input type="hidden" id="recommendations" value="<? echo ($use_recommendations == 0) ? "0" : "1" ?>" name="recommendations" /></td>
        </tr>
        <tr>
            <td align="right"><strong>스크랩 : </strong>&nbsp;</td>
            <td><input type="checkbox" id="sns" <? echo ($use_sns == 0) ? "checked" : "" ?> /><label for="sns">SNS 스크랩 사용</label><input type="hidden" id="sns" value="<? echo ($use_sns == 0) ? "0" : "1" ?>" name="sns" /></td>
        </tr>
        <tr>
            <td align="right"><strong>QR code : </strong>&nbsp;</td>
            <td><input type="checkbox" id="qrcode" <? echo ($use_qrcode == 0) ? "checked" : "" ?> /><label for="qrcode">QR코드 사용</label><input type="hidden" id="qrcode" value="<? echo ($use_qrcode == 0) ? "0" : "1" ?>" name="qrcode" /></td>
        </tr>
        <tr>
            <td align="right"><strong>HTML : </strong>&nbsp;</td>
            <td><input type="checkbox" id="html" <? echo ($use_html_temp == 0) ? "checked" : "" ?> /><label for="html">HTML소스 사용</label><input type="hidden" id="html" value="<? echo ($use_html_temp == 0) ? "0" : "1" ?>" name="html" /></td>
        </tr>
    </table>
    </form>
</div>

<? if ($_SESSION['set_recycle_bin'] == 1){ ?>
<div id="hidden-message-del" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>글을 삭제하시면 다시 복구할 수 없습니다.<br />
삭제하시겠습니까?</p>
    <form id="delete">
    <input type="hidden" name="mode" value="no_recycle_bin" />
    <input type="hidden" name="num" value="<? echo $_GET['id'] ?>" />
    </form>
</div>
<? }else if ($_SESSION['set_recycle_bin'] == 0){ ?>
<div id="hidden-message-recycle_bin" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>휴지통으로 이동하시겠습니까?</p>
    <form id="delete">
    <input type="hidden" name="mode" value="recycle_bin" />
    <input type="hidden" name="num" value="<? echo $_GET['id'] ?>" />
    </form>
</div>
<? } ?>