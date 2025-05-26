<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>





</div>
		<div id="sidebar">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><a href="/help"><img src="/skin/<? echo $common_skin ?>/img/menu_main_1.jpg" title="도움말" /></a></td>
				</tr>
                <? if (!$_SESSION['user']) { ?>
				<tr>
					<td><? echo ($_SERVER["SCRIPT_NAME"] == "/process/short.php") ? "<a href=\"/?mode=create\">" : "<a href=\"#\" id=\"create-user-a\">" ?><img src="/skin/<? echo $common_skin ?>/img/menu_main_2_0.jpg" title="회원가입" /></a></td>
				</tr>
				<tr>
					<td><? echo ($_SERVER["SCRIPT_NAME"] == "/process/short.php") ? "<a href=\"/\">" : "<a href=\"#\" id=\"login-user-a\">" ?><img src="/skin/<? echo $common_skin ?>/img/menu_main_3_0.jpg" title="로그인" /></a></td>
				</tr>
				<tr>
					<td><img src="/skin/<? echo $common_skin ?>/img/menu_main_4_1.jpg" /></td>
				</tr>
                <? }else{ ?>
                <tr><?
                    if ($_SESSION['fb_facebook'] == 1) $mypage = "-fb";
                    else if ($_SESSION['fb_facebook'] == 2) $mypage = "-tw";
					else if ($_SESSION['fb_facebook'] == 3) $mypage = "-gg";
                    else $mypage = "";
                    ?><td><a href="#" id="mypage<? echo $mypage ?>-a"><img src="/skin/<? echo $common_skin ?>/img/menu_main_2_1.jpg" title="마이페이지" /></a></td>
				</tr>
				<tr>
					<td><a href="#" id="set-a"><img src="/skin/<? echo $common_skin ?>/img/menu_main_3_1.jpg" title="설정" /></a></td>
				</tr>
                	<? if ($_SESSION['set_user_url'] == ""){ ?>
                    <tr>
                        <td><a href="#" id="logout-a"><img src="/skin/<? echo $common_skin ?>/img/menu_main_5_0.jpg" title="로그아웃" /></a></td>
                    </tr>
                    <tr>
                        <td><img src="/skin/<? echo $common_skin ?>/img/menu_main_6_1.jpg" /></td>
                    </tr>
                    <? }else{ ?>
                    <tr>
                        <td><a href="<? echo "/".$_SESSION['set_user_url']; ?>"><img src="/skin/<? echo $common_skin ?>/img/menu_main_4_0.jpg" title="공개주소" /></a></td>
                    </tr>
                    <tr>
                        <td><a href="#" id="logout-a"><img src="/skin/<? echo $common_skin ?>/img/menu_main_5_1.jpg" title="로그아웃" /></a></td>
                    </tr>
                    <? } ?>
                <? } ?>
			</table>
			<? if (isset($_SESSION['user'])){ ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td id="box3"><a href="#" id="toolbar_listview"><img src="/skin/<? echo $common_skin ?>/img/listview_main.gif" title="리스트뷰: <? echo get_listview($_SESSION['user']) ?>개" /></a><br />
                    	<a href="#" id="toolbar_memo_recv"><img src="/skin/<? echo $common_skin ?>/img/memo.gif" title="<? echo get_message($_SESSION['user']) ?>" /></a><br />
                    <? if (get_recycle_bin($_SESSION['user']) != 0){ ?><a href="#" id="toolbar_recycle_bin"><img style="padding-top:4px;" src="/skin/<? echo $common_skin ?>/img/icon_recycle_bin.gif" title="휴지통: <? echo get_recycle_bin($_SESSION['user']) ?>개" /></a><? } ?></td>
				</tr>
			</table>
            <? } ?>
		</div>
		<div class="clearfix bottom">&nbsp;</div>
	</div>
    <? 
	if (isset($_SESSION['user'])){ 
		$tmp_sql = "select ad_id, ad_name from remember_advertisement order by ad_id desc";
		$tmp_result = mysql_query($tmp_sql, $connect);
	?>
        <div id="box4" class="container">
            <div class="bgtop">&nbsp;</div>
            <div class="content">
            	<div class="ticker" rel="fade">
    				<ul><?
						while ($tmp_row = mysql_fetch_array($tmp_result)){
							$ad_id = $tmp_row['ad_id'];
							$ad_name = $tmp_row['ad_name']; ?>
                                <li><a href="/process/ad.php?num=<? echo $ad_id ?>" target="_blank">[ad] <? echo $ad_name ?></a></li>
					<? } ?>
					</ul>
				</div>
            </div>
            <div class="bgbtm">&nbsp;</div>
        </div>
    <? } ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" id="footer">
		<tr>
			<td><p>Internet Explorer 7.0 or higher / Copyright&copy; 2012<? echo (date("Y") != 2012) ? "-".date("Y") : "" ?> <? echo $common_title_tail ?>. All Rights Reserved.</strong><!--<a href="http://twitter.com/<? echo $common_tweet_id ?>" title="@<? echo $common_tweet_id ?>" target="_blank">Follow me on Twitter!</a>-->&nbsp;<a href="http://twitter.com/<? echo $common_tweet_id ?>" title="@<? echo $common_tweet_id ?>" target="_blank"><img src="/skin/<? echo $common_skin ?>/img/tail_twitter.png" title="twitter" align="top" /></a>&nbsp;<a href="http://www.facebook.com/pages/Postszcom/375037475849219" target="_blank"><img src="/skin/<? echo $common_skin ?>/img/tail_facebook.png" title="facebook" align="top" /></a>&nbsp;<a href="/dev/openapi.xml?key=<? echo (!isset($_SESSION['set_openapikey'])) ? $common_open_api_demo_key : $_SESSION['set_openapikey'] ?>" target="_blank"><img src="/skin/<? echo $common_skin ?>/img/tail_rss.png" title="rss" align="top" /></a><br /><a href="#" class="contactme"><? echo $common_email ?></a>&nbsp;|&nbsp;<a href="/developers" title="open API">API</a>&nbsp;|&nbsp;<a href="/feedback" title="피드백">Feedback</a>&nbsp;|&nbsp;<a href="/donate" title="후원">Donate</a></p></td>
		</tr>
	</table>
</div>

<div id="contactme-modal-content" style="display:none;">
	<iframe src="<? echo $common_contact_me ?>" width="620" height="560" frameborder="0" scrolling="no"></iframe>
</div></p>
<div style="display:none;">
<script id="_wauery">var _wau = _wau || []; _wau.push(["small", "xax5o5e9ikae", "ery"]);(function() { var s=document.createElement("script"); s.async=true; s.src="http://widgets.amung.us/small.js";document.getElementsByTagName("head")[0].appendChild(s);})();</script>
</div>

<? if (!(isset($_SESSION['user']))){ ?>
<div id="dialog-form" title="Create new user" style="display:none">
<div id="left">    
    <table class="fbConnect" align="center" border="0" cellspacing="0" cellpadding="0">
  		<tr>
    		<td><img src="/skin/<? echo $common_skin ?>/img/fb_tw_gg_register_01.gif" border="0" /><br /><a href="/redirect.php"><img src="/skin/<? echo $common_skin ?>/img/fb_tw_gg_register_02.gif" border="0" /></a>&nbsp;<a href="<? echo $fb_loginUrl ?>"><img src="/skin/<? echo $common_skin ?>/img/fb_tw_gg_register_03.gif" border="0" /></a>&nbsp;<a href="<? echo $authUrl ?>"><img src="/skin/<? echo $common_skin ?>/img/fb_tw_gg_register_04.gif" border="0" /></a></td>
    		<td width="65" align="right"><img src="/skin/<? echo $common_skin ?>/img/fb_tw_login_03.gif" border="0" /></td>
  		</tr>            
	</table>
</div>
<div id="right">
	<p class="validateTips">All form fields are required.</p>
	<form>
	<fieldset>
		<label for="id"><strong>ID</strong></label>
		<input type="text" name="id" id="id" maxlength="15" class="text ui-widget-content ui-corner-all" />
		<label for="email"><strong>Email</strong></label>
		<input type="text" name="email" id="email" maxlength="50" class="text ui-widget-content ui-corner-all" />
		<label for="password"><strong>Password</strong></label>
		<input type="password" name="password" id="password" maxlength="15" class="text ui-widget-content ui-corner-all" />
        <input type="checkbox" id="check" /><label for="check">회원가입약관 동의</label><button id="register">회원가입약관</button>
	</fieldset>
	</form>
</div>    
</div>
<div id="dialog-login" title="Login" style="display:none">
<div align="center" style="padding:10px 0 20px 0"><img src="/img/login_about.png" border="0" width="500" height="200" /></div>
<div id="left">
	<table class="fbConnect" align="center" border="0" cellspacing="0" cellpadding="0">
    	<td><img src="/skin/<? echo $common_skin ?>/img/fb_tw_gg_login_01.gif" border="0" /><br /><a href="/redirect.php"><img src="/skin/<? echo $common_skin ?>/img/fb_tw_gg_login_02.gif" border="0" /></a>&nbsp;<a href="<? echo $fb_loginUrl ?>"><img src="/skin/<? echo $common_skin ?>/img/fb_tw_gg_login_03.gif" border="0" /></a>&nbsp;<a href="<? echo $authUrl ?>"><img src="/skin/<? echo $common_skin ?>/img/fb_tw_gg_login_04.gif" border="0" /></a></td>
        <td width="60" align="right"><img src="/skin/<? echo $common_skin ?>/img/fb_tw_login_03.gif" border="0" /></td>
	</table>
</div>
<div id="right">
	<form>
	<fieldset>
		<label for="id"><strong>ID</strong></label>
		<input type="text" name="id" id="login_id" class="text ui-widget-content ui-corner-all" maxlength="15"/>
		<label for="password"><strong>Password</strong></label>
		<input type="password" name="password" id="login_password" value="" class="text ui-widget-content ui-corner-all" maxlength="15" />
        <input type="checkbox" id="remember" /><span id="dialog_login_pass"><label for="remember">ID 저장</label>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/forget">아이디/비밀번호 찾기</a></span>
	</fieldset>
	</form>
</div>    
</div>
<div id="hidden-message-intro" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 80px 0;"></span>회원가입을 진심으로 축하합니다.<br />
    회원님의 패스워드는 암호화 코드로 저장되므로 안심하셔도 좋습니다.<br />
    회원의 탈퇴는 언제든지 가능하며 탈퇴 후, <br />회원님의 모든 소중한 정보는 삭제하고 있습니다.<br/>
    감사합니다.</p>
</div>
<div id="hidden-message-ip" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>같은 IP주소로 3번을 초과하여 가입하실 수 없습니다.</p>
</div>
<div id="hidden-message-id" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>이미 사용중인 아이디 입니다.</p>
</div>
<div id="hidden-message-email" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>이미 존재하는 E-mail 주소입니다.</p>
</div>
<div id="hidden-message-join" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>가입된 회원이 아닙니다. 다시 가입하세요.</p>
</div>
<div id="hidden-message-login-id" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>아이디를 입력하세요.</p>
</div>
<div id="hidden-message-login-pass" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>비밀번호를 입력하세요.</p>
</div>
<div id="hidden-message-checked" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.</p>
</div>


<div id="hidden-message-register" title="회원가입약관" style="display:none">
	<p style="text-align:center"><? if(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE){ ?><textarea style="height:163px;" class="ui-widget-content ui-corner-all" /><? @readfile('lib/join_license.txt'); ?></textarea><? }else{ ?><textarea style="height:163px;" class="ui-widget-content ui-corner-all" id="join_license" /></textarea><? } ?></p>
</div>

<? } ?>


<? if (isset($_SESSION['user'])){ ?>

<div id="hidden-message-content" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>내용을 입력하세요.</p>
</div>
<div id="hidden-message-error" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>에러가 발생하였습니다.<br />문제가 계속되는 경우에는 시스템 관리자에게 문의하십시오.</p>
</div>


<div id="hidden-message-set" title="Settings" style="display:none">
<?
if (isset($_SESSION['user'])){ 
	$sql = "select * from remember_boardset where mb_user ='".trim($_SESSION['user'])."'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);
	
	$subject = conv_content($row['bs_subject'], 0);
	$setting_explode = explode("|", $row['bs_setting']);
	$scrolling = $setting_explode[0];
	$wysiwyg = $setting_explode[1];
	$security = $setting_explode[2];
	$open = $setting_explode[3];
	$recycle_bin = $setting_explode[4];
	$rows_explode = explode("|", $row['bs_rows']);
	$user_url = $row['bs_user_url'];
	$openapikey = $row['bs_openapikey'];
	$openapisecret = $row['bs_openapisecret'];
}
?>
    <form id="set">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td width="22%" align="right"><strong>제목 : </strong>&nbsp;</td>
            <td><input type="text" name="subject" id="subject" maxlength="30" style="width:215px;" value="<? echo strip_tags($subject) ?>" class="text ui-widget-content ui-corner-all subject" />&nbsp;<span class="charsLeft">30</span></td>
        </tr>
        <tr>
            <td align="right"><strong>공개주소 : </strong>&nbsp;</td>
            <td><span><? echo $common_path ?></span>&nbsp;<input type="text" name="user_url" id="user_url" maxlength="18" style="width:126px;" value="<? echo strip_tags($user_url) ?>" class="text ui-widget-content ui-corner-all" /><input type="hidden" name="user_url_text" id="user_url_text" value="<? echo strip_tags($user_url) ?>" /></td>
        </tr>
        <tr>
            <td align="right"><strong>목록수 : </strong>&nbsp;</td>
            <td><select name="rows" id="set" class="text ui-widget-content ui-corner-all">
            		<option <? echo ($rows_explode[0] == 5) ? "selected" : "" ?>>5</option>
                    <option <? echo ($rows_explode[0] == 6) ? "selected" : "" ?>>6</option>
                    <option <? echo ($rows_explode[0] == 7) ? "selected" : "" ?>>7</option>
                    <option <? echo ($rows_explode[0] == 8) ? "selected" : "" ?>>8</option>
                    <option <? echo ($rows_explode[0] == 9) ? "selected" : "" ?>>9</option>
            		<option <? echo ($rows_explode[0] == 10) ? "selected" : "" ?>>10</option>
                    <option <? echo ($rows_explode[0] == 11) ? "selected" : "" ?>>11</option>
                    <option <? echo ($rows_explode[0] == 12) ? "selected" : "" ?>>12</option>
                    <option <? echo ($rows_explode[0] == 13) ? "selected" : "" ?>>13</option>
                    <option <? echo ($rows_explode[0] == 14) ? "selected" : "" ?>>14</option>
					<option <? echo ($rows_explode[0] == 15) ? "selected" : "" ?>>15</option>
                    <option <? echo ($rows_explode[0] == 20) ? "selected" : "" ?>>20</option>
                    <option <? echo ($rows_explode[0] == 30) ? "selected" : "" ?>>30</option>
                    <option <? echo ($rows_explode[0] == 40) ? "selected" : "" ?>>40</option>
                    <option <? echo ($rows_explode[0] == 50) ? "selected" : "" ?>>50</option>
                    <option <? echo ($rows_explode[0] == 70) ? "selected" : "" ?>>70</option>
                    <option <? echo ($rows_explode[0] == 80) ? "selected" : "" ?>>80</option>
                    <option <? echo ($rows_explode[0] == 90) ? "selected" : "" ?>>90</option>
				</select><input type="hidden" id="rows_m" name="rows_m" value="<? echo $rows_explode[1] ?>" /></td>
        </tr>
        <tr>
            <td align="right"><strong>기본 : </strong>&nbsp;</td>
            <td><input type="radio" id="open_private" name="open" <? echo ($open == 0) ? "checked" : "" ?> />비공개&nbsp;&nbsp;<input type="radio" id="open_public" name="open" <? echo ($open == 1) ? "checked" : "" ?> />공개<input type="hidden" id="openset_text" name="openset_text" value="<? echo ($open == 0) ? "0" : "1" ?>" /></td>
        </tr>
        
        
        
        
        
        
        
        <tr>
            <td align="right"><strong>스크롤 : </strong>&nbsp;</td>
            <td><input type="checkbox" id="scrolling" <? echo ($scrolling == 1) ? "checked" : "" ?> /><label for="scrolling">자동스크롤 사용</label><input type="hidden" id="scrolling_text" name="scrolling_text" value="<? echo ($scrolling == 0) ? "0" : "1" ?>" /></td>
        </tr>
        <tr>
            <td align="right"><strong>위지윅 : </strong>&nbsp;</td>
            <td><input type="checkbox" id="wysiwyg" <? echo ($wysiwyg == 1) ? "checked" : "" ?> <? echo ($security == 1) ? "disabled" : "" ?> /><label for="wysiwyg">WYSIWYG 에디터 사용</label><input type="hidden" id="wysiwyg_text" name="wysiwyg_text" value="<? echo ($wysiwyg == 0) ? "0" : "1" ?>" /></td>
        </tr>
        <!--<tr>
            <td align="right"><strong>보안 : </strong>&nbsp;</td>
            <td><input type="checkbox" id="security" <? echo ($security == 1) ? "checked" : "" ?> <? echo ($wysiwyg == 1) ? "disabled" : "" ?> /><label for="security">암호화 사용</label><input type="hidden" id="security_text" name="security_text" value="<? echo ($security == 0) ? "0" : "1" ?>" /></td>
        </tr>-->
        <tr>
            <td align="right"><strong>휴지통 : </strong>&nbsp;</td>
            <td><input type="checkbox" id="recycle_bin" <? echo ($recycle_bin == 0) ? "checked" : "" ?> /><label for="recycle_bin">휴지통 사용</label><input type="hidden" id="recycle_bin_text" name="recycle_bin_text" value="<? echo ($recycle_bin == 0) ? "0" : "1" ?>" /></td>
        </tr>
        <tr>
            <td align="right"><strong>API Key : </strong>&nbsp;</td>
            <td><input type="text" name="openapikey" id="openapikey" style="width:177px;" value="<? echo $openapikey ?>" class="text ui-widget-content ui-corner-all" readonly="readonly" />&nbsp;<button id="openapi_reset">Reset</button><input type="hidden" id="openapisecret" name="openapisecret" value="<? echo $openapisecret ?>" /></td>
        </tr>
        <!--<tr>
            <td align="right"><strong>API Secret : </strong>&nbsp;</td>
            <td><input type="text" name="_openapisecret" id="_openapisecret" style="width:215px;" value="<? //echo $openapisecret ?>" class="text ui-widget-content ui-corner-all" readonly="readonly" /></td>
        </tr>-->
    </table>
	</form>
</div>
<div id="hidden-message-set-subject" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>제목을 입력하세요.</p>
</div>
<div id="hidden-message-set-user-url" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>공개주소를 입력하세요. (영문자, 숫자 만. 최소 3자이상)</p>
</div>
<div id="hidden-message-set-user-url-ing" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>이미 사용중인 공개주소입니다.</p>
</div>
<div id="hidden-message-set-user-url-res" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>예약어로 사용할 수없는 공개주소입니다.</p>
</div>
<div id="hidden-message-set-backup" title="Backup" style="display:none">
<style type="text/css">
<!--
.ui-datepicker { font:12px dotum; }
.ui-datepicker select.ui-datepicker-month, 
.ui-datepicker select.ui-datepicker-year { width: 70px;}
.ui-datepicker select { padding: .25em;}
.ui-datepicker-trigger { margin:0 0 -4px 5px; }
-->
</style>
<script type="text/javascript">
/* Korean initialisation for the jQuery calendar extension. */
/* Written by DaeKwon Kang (ncrash.dk@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월',
		'7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ko']);

    $('#fr_date, #to_date').datepicker({
        showOn: 'button',
		buttonImage: '/skin/<? echo $common_skin ?>/img/calendar.gif',
		buttonImageOnly: true,
        buttonText: "달력",
        changeMonth: true,
		changeYear: true,
        showButtonPanel: false,
        yearRange: 'c-<? echo $common_date_since ?>:c+<? echo $common_date_since ?>',
        maxDate: '+0d'
    }); 
});
</script>    
<div align="center" style="margin:18px 0 0 0"><form id="backup">
<input type="text" id="fr_date" name="fr_date" size="11" maxlength="10" value="<? echo substr($_SESSION['updated_date'], 0, 10); ?>" style="width:70px;" class="datepicker text ui-widget-content ui-corner-all" readonly="readonly" />&nbsp;&nbsp;~&nbsp;&nbsp;<input type="text" id="to_date" name="to_date" size="11" maxlength="10" value="<? echo $common_date_ymd ?>" style="width:70px;" class="datepicker text ui-widget-content ui-corner-all" readonly="readonly" /></form></div>
</div>



<?
if (isset($_SESSION['user'])){ 
	$sql = "select * from remember_member where mb_user ='".trim($_SESSION['user'])."'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_array($result);
	
	$password = $row['mb_password'];
	$email = $row['mb_email'];
	//$updated_date = sscanf($row['mb_updated_date'], "%d-%d-%d %d:%d:%d");
	//$updated_date_str = "(".$updated_date[0]."년 ".$updated_date[1]."월 ".$updated_date[2]."일 ".$updated_date[3]."시 ".$updated_date[4]."분에 가입)";
	$updated_date_period = get_date_period(substr($row['mb_updated_date'], 0, 10));
	$updated_date_str = str_replace("-", ".", (substr($row['mb_updated_date'], 0, 19)))." (".$updated_date_period."일전)";
	$open_mailling_explode = explode("|", $row['mb_open_mailling']);
	$facebook = $row['mb_facebook'];
	$profile = $row['mb_profile'];
	$thumbnail = $row['mb_thumbnail'];
	
}
?>

<? if ($facebook == 1){ ?>
    <div id="hidden-message-mypage-fb" title="My Page" style="display:none">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
        	<tr>
            	<td valign="top" width="320">
                    <form id="mypage_fb">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td width="20%" align="right" valign="top"><strong>로그인 : </strong>&nbsp;</td>
                            <td><a href="#" id="toolbar_history" title="로그인 기록"><? echo $_SESSION['user'] ?></a></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><strong>가입일 : </strong>&nbsp;</td>
                            <td><? echo $updated_date_str ?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>이름 : </strong>&nbsp;</td>
                            <td><? echo $_SESSION['fb_name'] ?></td>
                        </tr>
                        <!--<tr>
                            <td width="20%" align="right"><strong>성별 : </strong>&nbsp;</td>
                            <td><? //echo $_SESSION['fb_gender'] == "male" ? "남성" : "여성" ?></td>
                        </tr>-->
                        <tr>
                            <td width="20%" align="right"><strong>e-메일 : </strong>&nbsp;</td>
                            <td><? echo get_email_at($email) ?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>포인트 : </strong>&nbsp;</td>
                            <td><a href="#" id="toolbar_point" title="포인트 내역"><? echo $_SESSION['point'] ?> point</a></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>사진 : </strong>&nbsp;</td>
                            <td><img src="https://graph.facebook.com/<? echo $_SESSION['fb_id'] ?>/picture"></td>
                        </tr>
                        
                        <tr>
                            <td width="20%" align="right"><strong>별명 : </strong>&nbsp;</td>
                            <td><input type="text" name="nickname" id="nickname" maxlength="15" style="width:220px;" value="<? echo $_SESSION['nick'] ?>" class="text ui-widget-content ui-corner-all" /></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>프로필 : </strong>&nbsp;</td>
                            <td><textarea name="profile" id="profile" maxlength="100" style="height:65px; width:220px;" class="ui-widget-content ui-corner-all profile" /><? echo $profile ?></textarea><span class="charsLeft" style="display:none">100</span></td>
                        </tr>
                        <tr>
                            <td align="right">&nbsp;</td>
                            <td><input type="checkbox" id="mailling" <? echo ($open_mailling_explode[1] == 0) ? "checked" : "" ?> /><label for="mailling">메일 수신</label><input type="hidden" id="mailling_text" name="mailling_text" value="<? echo ($open_mailling_explode[1] == 0) ? "0" : "1" ?>" /><input type="checkbox" id="open" <? echo ($open_mailling_explode[0] == 0) ? "checked" : "" ?> /><label for="open">정보 공개</label><input type="hidden" id="open_text" name="open_text" value="<? echo ($open_mailling_explode[0] == 0) ? "0" : "1" ?>" /></td>
                        </tr>
                    </table>
                    </form>
                </td> 
                
                
                
<? }else if ($facebook == 2){ ?>
    <div id="hidden-message-mypage-tw" title="My Page" style="display:none">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
        	<tr>
            	<td valign="top" width="320">
                    <form id="mypage_tw">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td width="20%" align="right" valign="top"><strong>로그인 : </strong>&nbsp;</td>
                            <td><a href="#" id="toolbar_history" title="로그인 기록"><? echo $_SESSION['tw_screen_id'] ?></a></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><strong>가입일 : </strong>&nbsp;</td>
                            <td><? echo $updated_date_str ?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>이름 : </strong>&nbsp;</td>
                            <td><? echo $_SESSION['tw_name'] ?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>포인트 : </strong>&nbsp;</td>
                            <td><a href="#" id="toolbar_point" title="포인트 내역"><? echo $_SESSION['point'] ?> point</a></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>사진 : </strong>&nbsp;</td>
                            <td><img src="<? echo $thumbnail ?>" align="top" /></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>e-메일 : </strong>&nbsp;</td>
                            <td><? if ($_SESSION['level'] == 0){ ?><input type="text" name="email" id="email" style="width:167px;" maxlength="50" style="width:220px;" value="<? echo $email ?>" class="text ui-widget-content ui-corner-all" />&nbsp;<button id="email_certify" title="인증메일">인증</button><? }else{ ?><? echo get_email_at($email) ?><input type="hidden" name="email" id="email" value="<? echo $email ?>" /><? } ?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>별명 : </strong>&nbsp;</td>
                            <td><input type="text" name="nickname" id="nickname" maxlength="15" style="width:220px;" value="<? echo $_SESSION['nick'] ?>" class="text ui-widget-content ui-corner-all" /></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>프로필 : </strong>&nbsp;</td>
                            <td><textarea name="profile" id="profile" maxlength="100" style="height:65px; width:220px;" class="ui-widget-content ui-corner-all profile" /><? echo $profile ?></textarea><span class="charsLeft" style="display:none">100</span></td>
                        </tr>
                        <tr>
                            <td align="right">&nbsp;</td>
                            <td><input type="checkbox" id="mailling" <? echo ($open_mailling_explode[1] == 0) ? "checked" : "" ?> /><label for="mailling">메일 수신</label><input type="hidden" id="mailling_text" name="mailling_text" value="<? echo ($open_mailling_explode[1] == 0) ? "0" : "1" ?>" /><input type="checkbox" id="open" <? echo ($open_mailling_explode[0] == 0) ? "checked" : "" ?> /><label for="open">정보 공개</label><input type="hidden" id="open_text" name="open_text" value="<? echo ($open_mailling_explode[0] == 0) ? "0" : "1" ?>" /></td>
                        </tr>
                    </table>
                    </form>
                </td>                
                



<? }else if ($facebook == 3){ ?>

<div id="hidden-message-mypage-gg" title="My Page" style="display:none">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
        	<tr>
            	<td valign="top" width="320">
                    <form id="mypage_gg">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td width="20%" align="right" valign="top"><strong>로그인 : </strong>&nbsp;</td>
                            <td><a href="#" id="toolbar_history" title="로그인 기록"><? echo $_SESSION['user'] ?></a></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><strong>가입일 : </strong>&nbsp;</td>
                            <td><? echo $updated_date_str ?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>이름 : </strong>&nbsp;</td>
                            <td><? echo $_SESSION['gg_name'] ?></td>
                        </tr>
                        <!--<tr>
                            <td width="20%" align="right"><strong>성별 : </strong>&nbsp;</td>
                            <td><? //echo $_SESSION['gg_gender'] == "male" ? "남성" : "여성" ?></td>
                        </tr>-->
                        <tr>
                            <td width="20%" align="right"><strong>e-메일 : </strong>&nbsp;</td>
                            <td><? echo get_email_at($_SESSION['gg_email']) ?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>포인트 : </strong>&nbsp;</td>
                            <td><a href="#" id="toolbar_point" title="포인트 내역"><? echo $_SESSION['point'] ?> point</a></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>사진 : </strong>&nbsp;</td>
                            <td><img src="<? echo $_SESSION['gg_picture'] ?>" align="top" /></td>
                        </tr>
                        
                        <tr>
                            <td width="20%" align="right"><strong>별명 : </strong>&nbsp;</td>
                            <td><input type="text" name="nickname" id="nickname" maxlength="15" style="width:220px;" value="<? echo $_SESSION['nick'] ?>" class="text ui-widget-content ui-corner-all" /></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>프로필 : </strong>&nbsp;</td>
                            <td><textarea name="profile" id="profile" maxlength="100" style="height:65px; width:220px;" class="ui-widget-content ui-corner-all profile" /><? echo $profile ?></textarea><span class="charsLeft" style="display:none">100</span></td>
                        </tr>
                        <tr>
                            <td align="right">&nbsp;</td>
                            <td><input type="checkbox" id="mailling" <? echo ($open_mailling_explode[1] == 0) ? "checked" : "" ?> /><label for="mailling">메일 수신</label><input type="hidden" id="mailling_text" name="mailling_text" value="<? echo ($open_mailling_explode[1] == 0) ? "0" : "1" ?>" /><input type="checkbox" id="open" <? echo ($open_mailling_explode[0] == 0) ? "checked" : "" ?> /><label for="open">정보 공개</label><input type="hidden" id="open_text" name="open_text" value="<? echo ($open_mailling_explode[0] == 0) ? "0" : "1" ?>" /></td>
                        </tr>
                    </table>
                    </form>
                </td>



                      

        
<? }else if ($facebook == 0){ ?>
    <div id="hidden-message-mypage" title="My Page" style="display:none">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
        	<tr>
            	<td valign="top" width="320">
                    <form id="mypage">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td width="20%" align="right" valign="top"><strong>로그인 : </strong>&nbsp;</td>
                            <td><a href="#" id="toolbar_history" title="로그인 기록"><? echo $_SESSION['user'] ?></a></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><strong>가입일 : </strong>&nbsp;</td>
                            <td><? echo $updated_date_str ?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>포인트 : </strong>&nbsp;</td>
                            <td><a href="#" id="toolbar_point" title="포인트 내역"><? echo $_SESSION['point'] ?> point</a></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>e-메일 : </strong>&nbsp;</td>
                            <td><? if ($_SESSION['level'] == 0){ ?><input type="text" name="email" id="email" style="width:167px;" maxlength="50" style="width:220px;" value="<? echo $email ?>" class="text ui-widget-content ui-corner-all" />&nbsp;<button id="email_certify" title="인증메일">인증</button><? }else{ ?><? echo get_email_at($email) ?><input type="hidden" name="email" id="email" value="<? echo $email ?>" /><? } ?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>별명 : </strong>&nbsp;</td>
                            <td><input type="text" name="nickname" id="nickname" maxlength="15" style="width:220px;" value="<? echo $_SESSION['nick'] ?>" class="text ui-widget-content ui-corner-all" /></td>
                        </tr>   
                        <tr>
                            <td width="20%" align="right"><strong>사진 : </strong>&nbsp;</td>
                            <td><? if ($thumbnail != ""){ ?><img src="<? echo $thumbnail ?>" align="top" />&nbsp;<? } ?><input type="submit" value="수정" id="thumbnail" /></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right"><strong>프로필 : </strong>&nbsp;</td>
                            <td><textarea name="profile" id="profile" maxlength="100" style="height:60px; width:220px;" class="ui-widget-content ui-corner-all profile" /><? echo $profile ?></textarea><span class="charsLeft" style="display:none">100</span></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>비밀번호 : </strong>&nbsp;</td>
                            <td><input type="password" name="password" id="password" maxlength="15" style="width:220px;" class="text ui-widget-content ui-corner-all" /></td>
                        </tr>
                        <tr>
                            <td align="right"><strong>확인 : </strong>&nbsp;</td>
                            <td><input type="password" name="password_confirm" id="password_confirm" maxlength="15" style="width:220px;" class="text ui-widget-content ui-corner-all" /></td>
                        </tr>
                        <tr>
                            <td align="right">&nbsp;</td>
                            <td><input type="checkbox" id="mailling" <? echo ($open_mailling_explode[1] == 0) ? "checked" : "" ?> /><label for="mailling">메일수신</label><input type="hidden" id="mailling_text" name="mailling_text" value="<? echo ($open_mailling_explode[1] == 0) ? "0" : "1" ?>" />&nbsp;&nbsp;<input type="checkbox" id="open" <? echo ($open_mailling_explode[0] == 0) ? "checked" : "" ?> /><label for="open">정보공개</label><input type="hidden" id="open_text" name="open_text" value="<? echo ($open_mailling_explode[0] == 0) ? "0" : "1" ?>" /><? if ($thumbnail != ""){ ?>&nbsp;&nbsp;<input type="checkbox" id="thumbnail_del" />사진삭제<input type="hidden" id="thumbnail_del_text" name="thumbnail_del_text" /><? } ?></td>
                        </tr>
                    </table>
                    </form>
                </td>        
<? } //}else if ($facebook == 0){ ?>
        <td valign="top">
            <?
			$sql = "select fr_target_user from remember_myfriends where mb_user ='".trim($_SESSION['user'])."' order by fr_id desc limit 8";
			$result = mysql_query($sql, $connect);
			
			$tmp_sql = "select count(*) as cnt from remember_myfriends where mb_user ='".trim($_SESSION['user'])."' order by fr_id desc";
			$tmp_result = mysql_query($tmp_sql, $connect);
			$tmp_row = mysql_fetch_array($tmp_result);
			$total_record = $tmp_row['cnt'];
			$a = 0; ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
            	<tr>
                	<td style="padding-top:4px;"><span style="font-size:11px;"><strong><? echo (!($_SESSION['nick'])) ? ( (!($_SESSION['fb_name'])) ? $_SESSION['user'] : $_SESSION['fb_name'] ) : $_SESSION['nick'] ?>의 친구들</strong>&nbsp;(<? echo $total_record ?>명)</span></td>
                </tr>
                <tr>
                	<td>    			
					<? while ($row = mysql_fetch_array($result)){ 
                        $fr_target_user = $row['fr_target_user'];
                        $ano = $a % 4;
                        echo ($ano == 0) ? "<br />" : "";
						echo get_member_thumbnail($fr_target_user)."&nbsp";
						echo ($ano == 4) ? "<br />" : "";
                        $a++;
                    }
                    ?></td>
                 </td>       
			<?
            $sql = "select mb_user from remember_myfriends where fr_target_user ='".trim($_SESSION['user'])."' order by fr_id desc limit 8";
            $result = mysql_query($sql, $connect);
            
            $tmp_sql = "select count(*) as cnt from remember_myfriends where fr_target_user ='".trim($_SESSION['user'])."' order by fr_id desc";
            $tmp_result = mysql_query($tmp_sql, $connect);
            $tmp_row = mysql_fetch_array($tmp_result);
            $total_record = $tmp_row['cnt'];            
            $a = 0; ?>
            	<tr>
                	<td style="padding-top:20px;"><span style="font-size:11px;"><strong>나를 친구로 추가한 친구들</strong>&nbsp;(<? echo $total_record ?>명)</span></td>
                </tr>
                <tr>
                	<td>
					<? while ($row = mysql_fetch_array($result)){ 
                        $target_mb_user = $row['mb_user'];
                    	$ano = $a % 4;
                        echo ($ano == 0) ? "<br />" : "";
						echo get_member_thumbnail($target_mb_user)."&nbsp";
                        echo ($ano == 4) ? "<br />" : "";
                        $a++;
                    }
                    ?></td>
                </td>
                <tr>
                	<td align="right" style="padding:10px 20px 0 0;"><a href="/friend">더보기..</a></td>
                </tr>    
            </table>         
        </td>
    </tr>
</table>
</div>


<div id="hidden-message-password-confirm" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>비밀번호가 일치하지 않습니다. 다시 입력해주세요.</p>
</div>
<div id="hidden-message-email-none" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>e-메일 주소를 입력하세요.</p>
</div>
<div id="hidden-message-nickname-none" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>별명을 입력하세요.</p>
</div>
<div id="hidden-message-password-none" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>비밀번호를 입력하세요.</p>
</div>
<div id="hidden-message-initialize" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>메모장이 모두 삭제됩니다. 메모장을 삭제하시겠습니까?<br />비밀번호 확인 : </p>
    <div style="margin-left:23px"><form id="initialize">
    <input type="hidden" id="mode" name="mode" value="initialize" />
    <input type="password" id="initialize_password" name="initialize_password" maxlength="15" style="width:250px;" class="text ui-widget-content ui-corner-all" />
    </form></div>
</div>
<div id="hidden-message-dropout" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>계정을 삭제하시겠습니까?<br />
계정 삭제시 <strong>모든 개인정보와 데이터가 삭제</strong>되며, <br />삭제된 데이터는 복구할 수 없습니다.<br />비밀번호 확인 : </p>
    <div style="margin-left:23px">
    <form id="dropout">
    <input type="hidden" id="mode" name="mode" value="dropout" />
    <input type="password" id="dropout_password" name="dropout_password" maxlength="15" style="width:250px;" class="text ui-widget-content ui-corner-all" />
    </form></div>
</div>

<div id="hidden-message-initialize-ok" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>메모장을 모두 삭제하였습니다.</p>
</div>
<div id="hidden-message-dropout-ok" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>정상적으로 탈퇴가 되었습니다.</p>
</div>
<div id="hidden-message-level" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>게시판관리자 또는 서버관리자에게 문의 바랍니다.</p>
</div>
<div id="hidden-message-auto" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>자동 등록 방지 입력되지 않았습니다.</p>
</div>
<div id="hidden-message-search" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>검색어를 입력하세요.</p>
</div>
<div id="hidden-message-email-same" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>동일한 메일주소가 2개 이상 존재합니다.</p>
</div>
<div id="hidden-message-email-ok" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>인증메일이 전송되었습니다.<!--메일을 발송하였습니다.--></p>
</div>

<? } //if ($_SESSION['user']){ ?>


<div id="hidden-message-cookie" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.</p>
</div>
<div id="hidden-message-ten" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>10초이상이 지나야 가능합니다.</p>
</div>
<div id="hidden-message-password" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>비밀번호가 틀립니다. 비밀번호는 대소문자를 구분합니다.</p>
</div>
	
<script type="text/javascript"> 
//<![CDATA[ 

$(document).ready(function(){

<? if ((!(isset($_SESSION['user']))) and ($_SERVER["SCRIPT_NAME"] != "/process/short.php") and ($_SERVER["REQUEST_URI"] != "/help") and ($_SERVER["REQUEST_URI"] != "/?mode=help") and ($_SERVER["REQUEST_URI"] != "/developers") and ($_SERVER["REQUEST_URI"] != "/?mode=dev") and ($_SERVER["REQUEST_URI"] != "/feedback") and ($_SERVER["REQUEST_URI"] != "/?mode=feedback") and ($_SERVER["REQUEST_URI"] != "/donate") and ($_SERVER["REQUEST_URI"] != "/?mode=donate") and ($_SERVER["REQUEST_URI"] != "/forget") and ($_SERVER["REQUEST_URI"] != "/?mode=forget")){ ?>		
	<? if ($_GET['mode'] != "create"){?>
		$( "#dialog-login" ).dialog( "open" );	
	<? }else if ($_GET['mode'] == "create"){ ?>
		$( "#dialog-form" ).dialog( "open" );	
	<? } ?>
<? } ?>

<? if ( (isset($_SESSION['user'])) and ($_GET['mode'] == "mypage") ){
		if ($_SESSION['fb_facebook'] == 0){ ?>
			$( "#hidden-message-mypage" ).dialog( "open" );
		<? }else if ($_SESSION['fb_facebook'] == 1){ ?>
			$( "#hidden-message-mypage-fb" ).dialog( "open" );
<? }} ?>

<? if ( (isset($_SESSION['user'])) and ($_GET['mode'] == "set") ){ ?>
	$( "#hidden-message-set" ).dialog( "open" );
<? } ?>

<? if (!(isset($_SESSION['user']))){ ?>
	if ($.cookie('id_cookie')){
		$("input#login_id").val( $.cookie('id_cookie') );
		$("input#remember").attr("checked", "checked");
	}
	
	$.ajax('lib/join_license.txt', {
		success: function (data) {
			$('#join_license').append(data);
		}
	});
<? } ?>	
		
});

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//]]> 
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30952305-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


<div id="temp" style="display:none">RUN TIME : <? echo get_microtime() - $begin_time ?></div>
<div style="display:none;" class="nav_up" id="nav_up"></div>


</body>
</html>



<?


//현재접속자
get_login();


//로그인 기록
get_logout_history();


?>
