<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
include_once ("skin.mobile/{$common_skin_m}/index/head.php");
?>





<div data-role="page" data-theme="a" id="home">
    <div data-role="header" data-position="inline">
    	<? if (!(isset($_SESSION['user']))) { ?> 
    	<a href="#register">Register</a>
        <? }else{ ?>
        <a href="#mypage">My page</a>
        <? } ?>
        <h1><?
			if (isset($_GET['search'])){
				echo strip_tags(conv_content($_GET['search'], 0));
			}else{	
				/*if (isset($_SESSION['set_subject_short'])){
					echo strip_tags(conv_content($_SESSION['set_subject_short'], 0));
				}else */if (isset($_SESSION['set_subject'])){
					echo strip_tags(conv_content($_SESSION['set_subject'], 0));
				}else{
					echo $common_title;
				}
			}	
            ?></h1>
        <? if (isset($_SESSION['user'])) { ?> 
        <a href="#search">Search</a>
        <? }else{ ?>
        <a href="#login">Login</a>
        <? } ?>
    </div>
	<? 
    if (isset($_SESSION['user'])) {	
	
		if (isset($_GET['search'])){ 
			if ($_COOKIE["search"] != $_GET['search']){
				$sql = "insert into remember_search (mb_user, se_word, se_date, se_ip, se_agent) ";
				$sql .= "values('".$_SESSION['user']."', '".$_GET['search']."', now(), '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['HTTP_USER_AGENT']."')"; 
				mysql_query($sql, $connect);
				setcookie("search", "{$_GET['search']}", time() + 3600);
			}
		}
	
        include_once ("skin.mobile/{$common_skin_m}/board/write.php");
        include_once ("skin.mobile/{$common_skin_m}/board/list.php");
        include_once ("skin.mobile/{$common_skin_m}/board/page.php");	
    }else{
        include_once ("skin.mobile/{$common_skin_m}/index/index.php");
    }
    ?>
    <div style="padding:10px 5px 0 5px;">
        <ul data-role="listview" data-inset="true"> 
            <li data-icon="home"><a href="#" data-ajax="false" id="home_m">초기화면</a></li>
            <? if (!(isset($_SESSION['user']))) {?>
            <li data-icon="false"><a href="#login">로그인</a></li>
            <li data-icon="false"><a href="#register">회원가입</a></li>
            <li data-icon="false"><a href="#help">도움말</a></li>
            <? }else{ ?>
            <li data-icon="gear"><a href="#set">설정</a></li>
            	<? if ($_SESSION['set_user_url'] != ""){ ?>
            		<li data-icon="false"><a href="/<? echo $_SESSION['set_user_url'] ?>" data-ajax="false">공개주소</a></li>
                <? } ?>    
            <? if ($_SESSION['level'] == $common_admin_level){ ?><li data-icon="false"><a href="/adm" data-ajax="false">관리자</a></li><? } ?>
            <li data-icon="false"><a href="#help">도움말</a></li>
            <li data-icon="false"><a href="#" data-ajax="false" id="logout_m">로그아웃</a></li>
            <? } ?>
        </ul>
    </div>
    <div style="padding:0 5px 0 5px;">
    <p style="font-size:10px; text-align:center">Copyright&copy; 2012<? echo (date("Y") != 2012) ? "-".date("Y") : "" ?> All Rights Reserved. <br />
            <a target="_blank" href="http://twitter.com/<? echo $common_tweet_id ?>" title="@<? echo $common_tweet_id ?>">Follow me on Twitter!</a><br />
            e-mail : <? echo $common_email ?></p>
    </div>
      
</div>






<? if (!(isset($_SESSION['user']))){ ?>



<div data-role="page" data-theme="a" id="login" data-title="<? echo $common_title ?> - 로그인">
    <div data-role="header" data-position="inline">
        <h1>로그인</h1>
        <a href="#home">Back</a>
    </div>
    <div data-role="content" data-theme="a">
    	<p style="font-size:16px; list-style:1.0px; text-align:center;">페이스북/트위터 계정으로<br>바로 사용하세요!</p>
        <p style="text-align:center"><a href="<? echo $fb_loginUrl ?>"><img src="/skin.mobile/<? echo $common_skin_m ?>/img/cn_fb.png" width="60%" title=""  border="0"></a></p>
        <p style="padding-bottom:7px; text-align:center"><a href="/redirect.php" data-ajax="false"><img src="/skin.mobile/<? echo $common_skin_m ?>/img/cn_tw.png" width="60%" title=""  border="0"></a></p>
        
        <p><img src="/skin.mobile/<? echo $common_skin_m ?>/img/fb_or.png" width="100%" title=""  border="0"></p>
    	<form>
        <label for="user" class="ui-hidden-accessible">아이디 :</label>
		<input type="text" id="login_id" value="" placeholder="아이디" maxlength="15" />
		<label for="passwd" class="ui-hidden-accessible">비밀번호 :</label>
		<input type="password" id="login_password" value="" placeholder="비밀번호" maxlength="15" />
        <div style="float:left; width:70%">
        <input type="checkbox" id="remember" data-role="none" />&nbsp;<label for="remember">ID 저장</label>
        </div>
        <div style="float:right; width:30%; padding-top:3px; text-align:right"><input type="image" src="/skin.mobile/<? echo $common_skin_m ?>/img/login_m.png" data-role="none" id="login_m" /></div>
        </form>
    </div>
</div>

<script type="text/javascript"> 
//<![CDATA[ 

$(document).ready(function(){
	if ($.cookie('id_cookie')){
		$("input#login_id").val( $.cookie('id_cookie') );
		$("input#remember").attr("checked", "checked");
	}
});

//]]> 
</script>



<div data-role="page" data-theme="a" id="register" data-title="<? echo $common_title ?> - 회원가입">
    <div data-role="header" data-position="inline">
        <h1>회원가입</h1>
        <a href="#home">Back</a>
    </div>
    <div data-role="content" data-theme="a">
    	<p style="font-size:16px; list-style:2.5px; text-align:center;">회원가입 없이<br>페이스북/트위터 계정으로<br>바로 사용하세요!</p>
        <p style="text-align:center"><a href="<? echo $fb_loginUrl ?>"><img src="/skin.mobile/<? echo $common_skin_m ?>/img/cn_fb.png" width="60%" title=""  border="0"></a></p>
        <p style="padding-bottom:7px; text-align:center"><a href="/redirect.php" data-ajax="false"><img src="/skin.mobile/<? echo $common_skin_m ?>/img/cn_tw.png" width="60%" title=""  border="0"></a></p>
        <p><img src="/skin.mobile/<? echo $common_skin_m ?>/img/fb_or.png" width="100%" title=""  border="0"></p>
        <form>
        <label for="user" class="ui-hidden-accessible">아이디 :</label>
		<input type="text" id="id" value="" placeholder="아이디" maxlength="15" />
        <label for="email" class="ui-hidden-accessible">e-메일 :</label>
		<input type="email" id="email" value="" placeholder="e-메일" maxlength="50" />
		<label for="passwd" class="ui-hidden-accessible">비밀번호 :</label>
		<input type="password" id="password" value="" placeholder="비밀번호" maxlength="15" />
        <div style="text-align:right"><input type="image" src="/skin.mobile/<? echo $common_skin_m ?>/img/join_m.png" data-role="none" id="register_m" /></div>
        </form>
    </div>
</div>






<? }else if (isset($_SESSION['user'])){ ?>



<div data-role="page" data-theme="a" id="search" data-title="<? echo $common_title ?> - 검색">
    <div data-role="header" data-position="inline">
        <h1>검색</h1>
        <a href="#home">Back</a>
    </div>
    <div style="padding:10px 10px 5px 5px;">
        <form>
            <input type="text" id="qsearch" value="<? echo $_GET['search'] ?>" placeholder="Type to search, then press enter." maxlength="25" />
            <div style="text-align:right"><input type="image" src="/skin.mobile/<? echo $common_skin_m ?>/img/search_m.png" data-role="none" id="search_m" /></div>
        </form>
    </div>
</div>



<div data-role="page" data-theme="a" id="mypage" data-title="<? echo $common_title ?> - 마이페이지">
    <div data-role="header" data-position="inline">
        <h1>마이페이지</h1>
        <a href="#home">Back</a>
    </div>
    
    <div style="padding:10px 10px 5px 5px;">
	<?
    if (isset($_SESSION['user'])){ 
        $sql = "select * from remember_member where mb_user ='".trim($_SESSION['user'])."'";
        $result = mysql_query($sql, $connect);
        $row = mysql_fetch_array($result);
        
        $password = $row['mb_password'];
        $email = $row['mb_email'];
        /*$updated_date = $row['mb_updated_date'];
        $updated_date_y = substr($updated_date, 0, 4);
        $updated_date_m = substr($updated_date, 5, 2);
        $updated_date_d = substr($updated_date, 8, 2);
        $updated_time_h = substr($updated_date, 11, 2);
        $updated_time_m = substr($updated_date, 14, 2);
        $updated_date_str = "(".$updated_date_y."년 ".$updated_date_m."월 ".$updated_date_d."일 ".$updated_time_h."시 ".$updated_time_m."분에 가입)";*/
		$updated_date = sscanf($row['mb_updated_date'], "%d-%d-%d %d:%d:%d");
		$updated_date_str = "(".substr($updated_date[0], 2, 4)."년 ".$updated_date[1]."월 ".$updated_date[2]."일 ".$updated_date[3]."시 ".$updated_date[4]."분에 가입)";
        $open_mailling_explode = explode("|", $row['mb_open_mailling']);
        $facebook = $row['mb_facebook'];
		$profile = $row['mb_profile'];
		$thumbnail = $row['mb_thumbnail'];
    }
	if ($facebook == 1){ ?>
        <form>
        <p><img src="https://graph.facebook.com/<? echo $_SESSION['fb_id'] ?>/picture" align="right">
        	ID : <? echo $_SESSION['user'] ?><br />
        	이름 : <? echo $_SESSION['fb_name'] ?><br />
            성별 : <? echo $_SESSION['fb_gender'] == "male" ? "남성" : "여성" ?><br />
            e-메일 : <? echo get_email_at($_SESSION['fb_email']) ?><br />
			<? echo $updated_date_str ?></p>
        <!--<label for="email">e-메일</label>
        <input type="email" id="mypage_email" maxlength="50" value="<? echo $email ?>" placeholder="e-메일 주소를 입력하세요." />-->
        <label for="nick">별명</label>
        <input type="text" id="mypage_nick" maxlength="15" value="<? echo $_SESSION['nick'] ?>" placeholder="별명을 입력하세요." />
        <label for="profile">프로필</label>
        <textarea id="profile" maxlength="100" placeholder="프로필을 입력하세요." /><? echo $profile ?></textarea>
        <fieldset data-role="controlgroup">
            <label for="mailling">메일 수신</label>
            <input type="checkbox" id="mailling" <? echo ($open_mailling_explode[1] == 0) ? "checked" : "" ?> />
            <input type="hidden" id="mailling_text" name="mailling_text" value="<? echo ($open_mailling_explode[1] == 0) ? "0" : "1" ?>" />
            <label for="open">정보 공개</label>
            <input type="checkbox" id="open" <? echo ($open_mailling_explode[0] == 0) ? "checked" : "" ?> />
            <input type="hidden" id="open_text" name="open_text" value="<? echo ($open_mailling_explode[0] == 0) ? "0" : "1" ?>" />
        </fieldset>
        <div style="text-align:right"><input type="image" src="/skin.mobile/<? echo $common_skin_m ?>/img/save_m.png" data-role="none" id="mypage_fb_m" /></div>
        </form>
        
        
    <? }else if ($facebook == 0){ ?>
        <form>
        <p><? if ($thumbnail != ""){ ?><img src="<? echo $thumbnail ?>" align="right" /><? } ?>
        ID : <? echo $_SESSION['user'] ?><br />
		<? if ($_SESSION['level'] != 0){ ?>e-메일 : <? echo get_email_at($email) ?><input type="hidden" id="mypage_email" value="<? echo $email ?>" /><br /><? } ?><? echo $updated_date_str ?></p>
        <? if ($_SESSION['level'] == 0){ ?>
        <label for="email">e-메일</label>
        <input type="email" id="mypage_email" maxlength="50" value="<? echo $email ?>" placeholder="e-메일 주소를 입력하세요." />
        <? } ?>
        <label for="nick">별명</label>
        <input type="text" id="mypage_nick" maxlength="15" value="<? echo $_SESSION['nick'] ?>" placeholder="별명을 입력하세요." />
        <label for="profile">프로필</label>
        <textarea id="profile" maxlength="100" placeholder="프로필을 입력하세요." /><? echo $profile ?></textarea>
		<label for="password">비밀번호</label>
        <input type="password" id="mypage_password" maxlength="15" />
        <label for="password_confirm">비밀번호 확인</label>
        <input type="password" id="mypage_password_confirm" maxlength="15" />
        <fieldset data-role="controlgroup">
            <label for="mailling">메일 수신</label>
            <input type="checkbox" id="mailling" <? echo ($open_mailling_explode[1] == 0) ? "checked" : "" ?> />
            <input type="hidden" id="mailling_text" name="mailling_text" value="<? echo ($open_mailling_explode[1] == 0) ? "0" : "1" ?>" />
            <label for="open">정보 공개</label>
            <input type="checkbox" id="open" <? echo ($open_mailling_explode[0] == 0) ? "checked" : "" ?> />
            <input type="hidden" id="open_text" name="open_text" value="<? echo ($open_mailling_explode[0] == 0) ? "0" : "1" ?>" />
        </fieldset>
        <div style="text-align:right"><input type="image" src="/skin.mobile/<? echo $common_skin_m ?>/img/save_m.png" data-role="none" id="mypage_m" /></div>
        </form>
    <? }else if ($facebook == 2){ ?>
    
        <form>
        <p><img src="<? echo $thumbnail ?>" align="right" />
            로그인 : <? echo $_SESSION['tw_screen_id'] ?><br />
            이름 : <? echo $_SESSION['tw_name'] ?><br />
            <? if ($_SESSION['level'] != 0){ ?>e-메일 : <? echo get_email_at($email) ?><input type="hidden" id="mypage_email" value="<? echo $email ?>" /><br /><? } ?><? echo $updated_date_str ?></p>
        <? if ($_SESSION['level'] == 0){ ?>
        <label for="email">e-메일</label>
        <input type="email" id="mypage_email" maxlength="50" value="<? echo $email ?>" placeholder="e-메일 주소를 입력하세요." />
        <? } ?>
        <label for="nick">별명</label>
        <input type="text" id="mypage_nick" maxlength="15" value="<? echo $_SESSION['nick'] ?>" placeholder="별명을 입력하세요." />
        <label for="profile">프로필</label>
        <textarea id="profile" maxlength="100" placeholder="프로필을 입력하세요." /><? echo $profile ?></textarea>
        <fieldset data-role="controlgroup">
                <label for="mailling">메일 수신</label>
                <input type="checkbox" id="mailling" <? echo ($open_mailling_explode[1] == 0) ? "checked" : "" ?> />
                <input type="hidden" id="mailling_text" name="mailling_text" value="<? echo ($open_mailling_explode[1] == 0) ? "0" : "1" ?>" />
                <label for="open">정보 공개</label>
                <input type="checkbox" id="open" <? echo ($open_mailling_explode[0] == 0) ? "checked" : "" ?> />
                <input type="hidden" id="open_text" name="open_text" value="<? echo ($open_mailling_explode[0] == 0) ? "0" : "1" ?>" />
            </fieldset>
            <div style="text-align:right"><input type="image" src="/skin.mobile/<? echo $common_skin_m ?>/img/save_m.png" data-role="none" id="mypage_tw_m" /></div>
		</form>
	
	<? } ?>    
    
	</div>    

</div>



<div data-role="page" data-theme="a" id="set" data-title="<? echo $common_title ?> - 설정">
    <div data-role="header" data-position="inline">
        <h1>설정</h1>
        <a href="#home">Back</a>
    </div>
	<div style="padding:10px 10px 5px 5px;">
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
        //$scrolling = $row['bs_scrolling'];
        //$rows = $row['bs_rows'];
		$rows_explode = explode("|", $row['bs_rows']);
		$user_url = $row['bs_user_url'];
		$openapikey = $row['bs_openapikey'];
		$openapisecret = $row['bs_openapisecret'];
    }
    ?>	
        <form>
        <label for="subject">제목</label>
        <input type="text" id="subject" maxlength="30" value="<? echo $subject ?>" />
        <label for="public">공개주소</label>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="140"><? echo $common_path ?></td>
          	<td><input type="text" id="user_url" value="<? echo $user_url ?>" style="width:95%;"/><input type="hidden" id="user_url_text" value="<? echo $user_url ?>" /></td>
          </tr>
        </table>
		<label for="rows">목록수</label>
        <select id="rows_m">
            <option <? echo ($rows_explode[1] == 5) ? "selected" : "" ?>>5</option>
            <option <? echo ($rows_explode[1] == 6) ? "selected" : "" ?>>6</option>
            <option <? echo ($rows_explode[1] == 7) ? "selected" : "" ?>>7</option>
            <option <? echo ($rows_explode[1] == 8) ? "selected" : "" ?>>8</option>
            <option <? echo ($rows_explode[1] == 9) ? "selected" : "" ?>>9</option>
            <option <? echo ($rows_explode[1] == 10) ? "selected" : "" ?>>10</option>
            <option <? echo ($rows_explode[1] == 11) ? "selected" : "" ?>>11</option>
            <option <? echo ($rows_explode[1] == 12) ? "selected" : "" ?>>12</option>
            <option <? echo ($rows_explode[1] == 13) ? "selected" : "" ?>>13</option>
            <option <? echo ($rows_explode[1] == 14) ? "selected" : "" ?>>14</option>
            <option <? echo ($rows_explode[1] == 15) ? "selected" : "" ?>>15</option>
            <option <? echo ($rows_explode[1] == 20) ? "selected" : "" ?>>20</option>
            <option <? echo ($rows_explode[1] == 25) ? "selected" : "" ?>>25</option>
            <option <? echo ($rows_explode[1] == 30) ? "selected" : "" ?>>30</option>
        </select><input type="hidden" id="rows" name="rows" value="<? echo $rows_explode[0] ?>" />
        <input type="hidden" id="openset_text" value="<? echo ($open == 0) ? "0" : "1" ?>" />
        <input type="hidden" id="scrolling_text" value="<? echo ($scrolling == 0) ? "0" : "1" ?>" />
        <input type="hidden" id="wysiwyg_text" value="<? echo ($wysiwyg == 0) ? "0" : "1" ?>" />
        <input type="hidden" id="security_text" value="<? echo ($security == 0) ? "0" : "1" ?>" />
        <input type="hidden" id="recycle_bin_text" value="<? echo ($recycle_bin == 0) ? "0" : "1" ?>" />
        <input type="hidden" id="openapikey" value="<? echo $openapikey ?>" />
        <input type="hidden" id="openapisecret" value="<? echo $openapisecret ?>" />
        
        <div style="text-align:right"><input type="image" src="/skin.mobile/<? echo $common_skin_m ?>/img/save_m.png" data-role="none" id="set_m" /></div>
        </form>
	</div>          
</div>

<? } ?>


<div data-role="page" data-theme="a" id="help" data-title="<? echo $common_title ?> - 도움말">
    <div data-role="header" data-position="inline">
        <h1>도움말</h1>
        <a href="#home">Back</a>
    </div>
    <div data-role="content" data-theme="a">
    	<p style="font-size:14px;">

            <strong>너무 간단한 무료 가입</strong><br />
            페이스북/트위터 연동하기.<br />
            또는<br />
            아이디, e-메일, 비밀번호. 딱 셋가지만.<br /><br />
            
            <strong>깔끔해진 메모 관리 웹/모바일 서비스</strong><br />
            나만의 아이디어와 생각들, 간단한 메모, 일기쓰기, 여행기록, 체크리스트, 쇼핑리스트, 기록을 좋아하시는 분이나, 업무/학업상 평소에 메모를 많이 하시던 분, 수집광 등.<br /><br /> 
            
            <strong>주요기능</strong><br />
            개인PC와 모바일 환경 사용이 가능. (동기화가 없습니다)<br />
            자신만의 공간.<br />
            비공개로 메모 작성.<br />
            메모 검색.<br />
            인쇄하기.<br />
            공유하기. (짧은 주소 사용, SNS 바로 보내기, 리플, QR코드 등 사용)<br /><br />
            
            <strong>사용자 인터페이스</strong><br />
            쉽고 편한 사용법.<br />
            가로보기 지원. (모바일웹)<br /><br />
            
            비밀번호나 계좌번호를 비롯한 중요한 개인 정보 보안에 유의하시기 바랍니다.

    		
        </p>
        
        <br />
    	<img src="/img/main.png" border="0" width="98%" />
        
        <br /><br />
		<!--<img src="/img/index_m.png" width="100%" border="0" />-->
        <img src="/img/index_cloud.png" width="97%" border="0" />
        <br /><br />
		
		<? //echo "<br><br>openapikey : ".$_SESSION['set_openapikey']." / openapisecret : ".$_SESSION['set_openapisecret']."<br><br>"; ?>
        
    </div>
</div>











<?
include_once ("skin.mobile/{$common_skin_m}/index/tail.php");
?>