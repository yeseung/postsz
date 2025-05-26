<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


//한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
function get_paging($write_pages, $cur_page, $total_page, $url){
	$str = "";
	
	if ($cur_page > 1) $str .= "<a href='".$url."1'>처음</a>";
	
	$start_page = (floor(($cur_page - 1) / $write_pages)) * $write_pages + 1;
	$end_page = $start_page + $write_pages - 1;
	
	if ($total_page <= $end_page) $end_page = $total_page; 
	
	if ($start_page > 1) {
		$prev_page = $start_page - 1;
		$str .= "&nbsp;<a href='".$url.$prev_page."'>이전</a> ";
	}
	for ($i=$start_page; $i<=$end_page; $i++) {
		if ($cur_page == $i) $str .= "&nbsp;<strong><a href='".$url.$i."'>".$i."</a></strong> ";
		else $str .= "&nbsp;<a href='".$url.$i."'>".$i."</a> ";    
	}
	if ($end_page < $total_page) {
		$next_page = $end_page + 1;
		$str .= "&nbsp;<a href='".$url.$next_page."'>다음</a>";
	}
	if ($cur_page < $total_page) $str .= "&nbsp;<a href='".$url.$total_page."'>맨끝</a>";
	
	$str .= "";
	
	return $str;
}


//header("location:URL") 을 대체
function goto_url($url){
    echo "<script type='text/javascript'>location.replace('".$url."');</script>";
    exit;
}


//마이크로 타임을 얻어 계산 형식으로 만듦
function get_microtime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}


//rand
function get_rand($len, $str="upper"){
	if ($str == "upper"){
		$feed = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	}else if ($str == "lower"){
		$feed = "0123456789qwertyuiopasdfghjklzxcvbnm";
	}else if ($str == "num"){
		$feed = "0123456789";
	}
	/*for ($i=0 ; $i<$len ; $i++)
    	$rand_str .= substr($feed, rand(0, strlen($feed)-1), 1);  
	return $rand_str;*/
	return substr(str_shuffle($feed), 0, $len);
}





//130623 그누보드 4.36.22


// TEXT 형식으로 변환
function get_text($str, $html=0)
{
    /* 3.22 막음 (HTML 체크 줄바꿈시 출력 오류때문)
    $source[] = "/  /";
    $target[] = " &nbsp;";
    */

    // 3.31
    // TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
    if ($html == 0) {
        $str = html_symbol($str);
    }

    $source[] = "/</";
    $target[] = "&lt;";
    $source[] = "/>/";
    $target[] = "&gt;";
    //$source[] = "/\"/";
    //$target[] = "&#034;";
    $source[] = "/\'/";
    $target[] = "&#039;";
    //$source[] = "/}/"; $target[] = "&#125;";
    if ($html) {
        $source[] = "/\n/";
        $target[] = "<br/>";
    }

    return preg_replace($source, $target, $str);
}


// TEXT 형식으로 변환 <br>
function get_text_index($str)
{

    $source[] = "/</";
    $target[] = "&lt;";
    $source[] = "/>/";
    $target[] = "&gt;";
    //$source[] = "/\"/";
    //$target[] = "&#034;";
    $source[] = "/\'/";
    $target[] = "&#039;";
    //$source[] = "/}/"; $target[] = "&#125;";

    return preg_replace($source, $target, $str);
}



// 3.31
// HTML SYMBOL 변환
// &nbsp; &amp; &middot; 등을 정상으로 출력
function html_symbol($str)
{
    return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
}


// 내용을 변환
function conv_content($content, $html)
{
    global $config, $board;

    if ($html)
    {
        $source = array();
        $target = array();

        $source[] = "//";
        $target[] = "";

        if ($html == 2) { // 자동 줄바꿈
            $source[] = "/\n/";
            $target[] = "<br/>";
        }

        // 테이블 태그의 갯수를 세어 테이블이 깨지지 않도록 한다.
        $table_begin_count = substr_count(strtolower($content), "<table");
        $table_end_count = substr_count(strtolower($content), "</table");
        for ($i=$table_end_count; $i<$table_begin_count; $i++)
        {
            $content .= "</table>";
        }

        //$content = preg_replace_callback("/<([^>]+)>/s", 'bad130128', $content); 

        $content = preg_replace($source, $target, $content);

        // XSS (Cross Site Script) 막기
        // 완벽한 XSS 방지는 없다.
        
        // 이런 경우를 방지함 <IMG STYLE="xss:expr/*XSS*/ession(alert('XSS'))">
        //$content = preg_replace("#\/\*.*\*\/#iU", "", $content);
        // 위의 정규식이 아래와 같은 내용을 통과시키므로 not greedy(비탐욕수량자?) 옵션을 제거함. ignore case 옵션도 필요 없으므로 제거
        // <IMG STYLE="xss:ex//*XSS*/**/pression(alert('XSS'))"></IMG>
        $content = preg_replace("#\/\*.*\*\/#", "", $content);

        // object, embed 태그에서 javascript 코드 막기
        //$content = preg_replace_callback("#<(object|embed)([^>]+)>#i", "bad120422", $content);

        $content = preg_replace("/(on)([a-z]+)([^a-z]*)(\=)/i", "&#111;&#110;$2$3$4", $content);
        $content = preg_replace("/(dy)(nsrc)/i", "&#100;&#121;$2", $content);
        $content = preg_replace("/(lo)(wsrc)/i", "&#108;&#111;$2", $content);
        $content = preg_replace("/(sc)(ript)/i", "&#115;&#99;$2", $content);
        $content = preg_replace_callback("#<([^>]+)#", create_function('$m', 'return "<".str_replace("<", "&lt;", $m[1]);'), $content);
        //$content = preg_replace("/\<(\w|\s|\?)*(xml)/i", "", $content);
        $content = preg_replace("/\<(\w|\s|\?)*(xml)/i", "_$1$2_", $content);

        // 플래시의 액션스크립트와 자바스크립트의 연동을 차단하여 악의적인 사이트로의 이동을 막는다.
        // value="always" 를 value="never" 로, allowScriptaccess="always" 를 allowScriptaccess="never" 로 변환하는데 목적이 있다.
        $content = preg_replace("/((?<=\<param|\<embed)[^>]+)(\s*=\s*[\'\"]?)always([\'\"]?)([^>]+(?=\>))/i", "$1$2never$3$4", $content);

        // 이미지 태그의 src 속성에 삭제등의 링크가 있는 경우 게시물을 확인하는 것만으로도 데이터의 위변조가 가능하므로 이것을 막음
        $content = preg_replace("/<(img[^>]+delete\.php[^>]+bo_table[^>]+)/i", "*** CSRF 감지 : &lt;$1", $content);
        $content = preg_replace("/<(img[^>]+delete_comment\.php[^>]+bo_table[^>]+)/i", "*** CSRF 감지 : &lt;$1", $content);
        $content = preg_replace("/<(img[^>]+logout\.php[^>]+)/i", "*** CSRF 감지 : &lt;$1", $content);
        $content = preg_replace("/<(img[^>]+download\.php[^>]+bo_table[^>]+)/i", "*** CSRF 감지 : &lt;$1", $content);

        $content = preg_replace_callback("#style\s*=\s*[\"\']?[^\"\']+[\"\']?#i",
                    create_function('$matches', 'return str_replace("\\\\", "", stripslashes($matches[0]));'), $content);

        $pattern = "";
        $pattern .= "(e|&#(x65|101);?)";
        $pattern .= "(x|&#(x78|120);?)";
        $pattern .= "(p|&#(x70|112);?)";
        $pattern .= "(r|&#(x72|114);?)";
        $pattern .= "(e|&#(x65|101);?)";
        $pattern .= "(s|&#(x73|115);?)";
        $pattern .= "(s|&#(x73|115);?)";
        //$pattern .= "(i|&#(x6a|105);?)";
        $pattern .= "(i|&#(x69|105);?)";
        $pattern .= "(o|&#(x6f|111);?)";
        $pattern .= "(n|&#(x6e|110);?)";
        //$content = preg_replace("/".$pattern."/i", "__EXPRESSION__", $content);
        $content = preg_replace("/<[^>]*".$pattern."/i", "__EXPRESSION__", $content); 
        // <IMG STYLE="xss:e\xpression(alert('XSS'))"></IMG> 와 같은 코드에 취약점이 있어 수정함. 121213
        $content = preg_replace("/(?<=style)(\s*=\s*[\"\']?xss\:)/i", '="__XSS__', $content); 
        $content = bad_tag_convert($content);
    }
    else // text 이면
    {
        // & 처리 : &amp; &nbsp; 등의 코드를 정상 출력함
        $content = html_symbol($content);

        // 공백 처리
		//$content = preg_replace("/  /", "&nbsp; ", $content);
		$content = str_replace("  ", "&nbsp; ", $content);
		$content = str_replace("\n ", "\n&nbsp;", $content);

        $content = get_text($content, 1);

        $content = url_auto_link($content);
    }

    return $content;
}


// way.co.kr 의 wayboard 참고
function url_auto_link($str)
{
    // 속도 향상 031011
    $str = preg_replace("/&lt;/", "\t_lt_\t", $str);
    $str = preg_replace("/&gt;/", "\t_gt_\t", $str);
    $str = preg_replace("/&amp;/", "&", $str);
    $str = preg_replace("/&quot;/", "\"", $str);
    $str = preg_replace("/&nbsp;/", "\t_nbsp_\t", $str);
    $str = preg_replace("/([^(http:\/\/)]|\(|^)(www\.[^[:space:]]+)/i", "\\1<A HREF=\"http://\\2\" TARGET='_blank'>\\2</A>", $str);
    //$str = preg_replace("/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,]+)/i", "\\1<A HREF=\"\\2\" TARGET='$config[cf_link_target]'>\\2</A>", $str);
    // 100825 : () 추가
    // 120315 : CHARSET 에 따라 링크시 글자 잘림 현상이 있어 수정
    if (strtoupper($g4['charset']) == 'UTF-8') {
        $str = preg_replace("/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i", "\\1<A HREF=\"\\2\" TARGET='_blank'>\\2</A>", $str);
    } else {
        $str = preg_replace("/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i", "\\1<A HREF=\"\\2\" TARGET='_blank'>\\2</A>", $str);
    }
    // 이메일 정규표현식 수정 061004
    //$str = preg_replace("/(([a-z0-9_]|\-|\.)+@([^[:space:]]*)([[:alnum:]-]))/i", "<a href='mailto:\\1'>\\1</a>", $str);
    $str = preg_replace("/([0-9a-z]([-_\.]?[0-9a-z])*@[0-9a-z]([-_\.]?[0-9a-z])*\.[a-z]{2,4})/i", "<a href='mailto:\\1'>\\1</a>", $str);
    $str = preg_replace("/\t_nbsp_\t/", "&nbsp;" , $str);
    $str = preg_replace("/\t_lt_\t/", "&lt;", $str);
    $str = preg_replace("/\t_gt_\t/", "&gt;", $str);

    return $str;
}

// 악성태그 변환
function bad_tag_convert($code)
{
	//$code = preg_replace_callback("#(\<(embed|object)[^\>]*)\>(\<\/(embed|object)\>)?#i",
	// embed 또는 object 태그를 막지 않는 경우 필터링이 되도록 수정
	$code = preg_replace_callback("#(\<(embed|object)[^\>]*)\>?(\<\/(embed|object)\>)?#i",
				create_function('$matches', 'return "<div class=\"embedx\">보안문제로 인하여 관리자 아이디로는 embed 또는 object 태그를 볼 수 없습니다. 확인하시려면 관리권한이 없는 다른 아이디로 접속하세요.</div>";'),
				$code);

    //return preg_replace("/\<([\/]?)(script|iframe)([^\>]*)\>/i", "&lt;$1$2$3&gt;", $code);
    // script 나 iframe 태그를 막지 않는 경우 필터링이 되도록 수정
    return preg_replace("/\<([\/]?)(script|iframe|form)([^\>]*)\>?/i", "&lt;$1$2$3&gt;", $code);
}



//url http
function gethttp($url)
{
    if (!trim($url)) return;
    if (!preg_match("/^(http|https|ftp|telnet|news|mms)\:\/\//i", $url))
        $url = "http://" . $url;
    return $url;
}



/**
* cut string in utf-8
* @author gony (http://mygony.com)
* @param $str     source string
* @param $len     cut length
* @param $checkmb if this argument is true, the function treats multibyte character as two bytes. default value is false.
* @param $tail    abbreviation symbol
* @return string  processed string


function strcut_utf8($str, $len, $checkmb=false, $tail='...') {
    //preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
 	preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
 
    $m    = $match[0];
    $slen = strlen($str);  // length of source string
    $tlen = strlen($tail); // length of tail string
    $mlen = count($m); // length of matched characters
 
    if ($slen <= $len) return $str;
    if (!$checkmb && $mlen <= $len) return $str;
 
    $ret   = array();
    $count = 0;
 
    for ($i=0; $i < $len; $i++) {
        $count += ($checkmb && strlen($m[$i]) > 1)?2:1;
 
        if ($count + $tlen > $len) break;
        $ret[] = $m[$i];
    }
 
    return join('', $ret).$tail;
}
*/



function get_os($agent){

    $agent = strtolower($agent);
    //echo $agent; echo "<br/>";

    if (preg_match("/windows 98/", $agent))                 { $s = "98"; }
    else if(preg_match("/iphone/", $agent))                 { $s = "iPhone"; } //iPhone
    else if(preg_match("/ipad/", $agent))                   { $s = "iPad"; } //iPad
    else if(preg_match("/iPod/", $agent))                   { $s = "iPod"; } //iPod
    else if(preg_match("/android/", $agent))                { $s = "Android"; } //Android
    else if(preg_match("/psp/", $agent))                    { $s = "PSP"; } //PSP
    else if(preg_match("/playstation/", $agent))            { $s = "PLAYSTATION"; } //PLAYSTATION
    else if(preg_match("/berry/", $agent))                  { $s = "BlackBerry"; } //BlackBerry
    else if(preg_match("/symbian/", $agent))                { $s = "Symbian"; } //Symbian
    else if(preg_match("/ericsson/", $agent))               { $s = "SonyEricsson"; } //SonyEricsson
    else if(preg_match("/nokia/", $agent))                  { $s = "Nokia"; } //Nokia
    else if(preg_match("/sph/", $agent))                    { $s = "애니콜"; } //삼성폰
    else if(preg_match("/sgh/", $agent))                    { $s = "옴니아"; } //옴니아
    else if(preg_match("/sch/", $agent))                    { $s = "T*옴니아"; } //T*옴니아
    else if(preg_match("/im-s/", $agent))                   { $s = "스카이폰"; } //스카이폰
    else if(preg_match("/lgtelecom/", $agent))              { $s = "LG 사이언"; } //LG 사이언
    else if(preg_match("/windows 95/", $agent))             { $s = "95"; }
    else if(preg_match("/windows nt 4\.[0-9]*/", $agent))   { $s = "NT"; }
    else if(preg_match("/windows nt 5\.0/", $agent))        { $s = "2000"; }
    else if(preg_match("/windows nt 5\.1/", $agent))        { $s = "XP"; }
    else if(preg_match("/windows nt 5\.2/", $agent))        { $s = "2003"; }
    else if(preg_match("/windows nt 6\.0/", $agent))        { $s = "Vista"; }
    else if(preg_match("/windows nt 6\.1/", $agent))        { $s = "Windows7"; }
    else if(preg_match("/windows 9x/", $agent))             { $s = "ME"; }
    else if(preg_match("/windows ce/", $agent))             { $s = "CE"; }
    else if(preg_match("/linux/", $agent))                  { $s = "Linux"; }
    else if(preg_match("/sunos/", $agent))                  { $s = "sunOS"; }
    else if(preg_match("/irix/", $agent))                   { $s = "IRIX"; }
    else if(preg_match("/phone/", $agent))                  { $s = "Phone"; }
    //else if(preg_match("/bot|slurp/", $agent))              { $s = "Robot"; }
    else if(preg_match("/internet explorer/", $agent))      { $s = "IE"; }
    else if(preg_match("/mozilla/", $agent))                { $s = "Mozilla"; }
    else if(preg_match("/macintosh/", $agent))              { $s = "Mac"; }
	
	else if(preg_match("/phone|skt|lge|0450/", $agent))     { $s = "Mobile"; } 
    else if(preg_match("/naver|yeti/", $agent))             { $s = "NAVER Robot"; } //네이버로봇 
    else if(preg_match("/mediapartners/", $agent))          { $s = "Google AdSense"; } //구글애드센스 
    else if(preg_match("/google/", $agent))                 { $s = "Google Robot"; } //구글로봇 
    else if(preg_match("/msn/", $agent))                    { $s = "Microsoft Robot"; } //MSN로봇 
    else if(preg_match("/yahoo/", $agent))                  { $s = "Yahoo! Robot"; } //야후!로봇 
    else if(preg_match("/daum/", $agent))                   { $s = "DAUM Robot"; } //다음로봇 
    else if(preg_match("/empas/", $agent))                  { $s = "Empas Robot"; } //네이트로봇 
    else if(preg_match("/rss/", $agent))                    { $s = "RSS Reader"; } //RSS리더 
    else if(preg_match("/bot|slurp|scrap|spider|crawl/", $agent))              { $s = "Robot"; } //기타로봇
    else { $s = "기타"; }

    return $s;
}

function get_brow($agent){

    $agent = strtolower($agent);

    if (preg_match("/msie 5.0[0-9]*/", $agent))         { $s = "MSIE 5.0"; }
    else if(preg_match("/msie 5.5[0-9]*/", $agent))     { $s = "MSIE 5.5"; }
    else if(preg_match("/msie 6.0[0-9]*/", $agent))     { $s = "MSIE 6.0"; }
    else if(preg_match("/msie 7.0[0-9]*/", $agent))     { $s = "MSIE 7.0"; }
    else if(preg_match("/msie 8.0[0-9]*/", $agent))     { $s = "MSIE 8.0"; }
	else if(preg_match("/msie 9.0[0-9]*/", $agent))     { $s = "MSIE 9.0"; }
    else if(preg_match("/msie 4.[0-9]*/", $agent))      { $s = "MSIE 4.x"; }
    else if(preg_match("/firefox/", $agent))            { $s = "FireFox"; }
    else if(preg_match("/chrome/", $agent))             { $s = "Chrome"; }
    else if(preg_match("/x11/", $agent))                { $s = "Netscape"; }
    else if(preg_match("/opera/", $agent))              { $s = "Opera"; }
    else if(preg_match("/gec/", $agent))                { $s = "Gecko"; }
    else if(preg_match("/bot|slurp/", $agent))          { $s = "Robot"; }
    else if(preg_match("/internet explorer/", $agent))  { $s = "IE"; }
    else if(preg_match("/mozilla/", $agent))            { $s = "Mozilla"; }
    else { $s = "기타"; }

    return $s;
}



// 특수문자 변환 
function specialchars_replace($str, $len=0) { 
    if ($len) { 
        $str = substr($str, 0, $len); 
    } 
    $str = preg_replace("/&/", "&amp;", $str); 
    $str = preg_replace("/</", "&lt;", $str); 
    $str = preg_replace("/>/", "&gt;", $str); 
    return $str; 
}


// 금지어
function cautionWords($parseStr) {
	global $common_cautionWords;
	$cautionWords=str_replace(", +",",",$common_cautionWords); 
	$parseStr=ereg_replace(" +"," ",$parseStr);
	$cautionArr=explode(",",$cautionWords);
	if(count($cautionArr)==0) return false;
	for($i=0;$i<count($cautionArr);$i++) {
		if(@strpos(" ".$parseStr,$cautionArr[$i])>0) return 0;
	}
	return 1;
}



//10.05.16 자동방지
function getCode($len){
	$SID = md5(uniqid(rand()));
	$code = substr($SID, 0, $len);
	return $code;
}
$common_code = getCode($common_auto_code); //자동방지




function diffDate($sDate){

	$date[0]=strtotime($sDate);
	$date[1]=strtotime(date('Y-m-d H:i:s'));
	if($date[0] >= $date[1]){
		return false;
	}
	$date[2]=strtotime(date('Y-m-d H:i:s',$date[1] - $date[0]));

	$Y=date('Y',$date[2])-1970;
	$m=date('n',$date[2])-1;
	$d=date('j',$date[2])-1;
	$H=intval(date('H',$date[2]))-9;
	$i=intval(date('i',$date[2]));
	$s=intval(date('s',$date[2]));
	
	if($H<0){ $H+=24; $d--; }
	
	if($Y){
		$returnDate= $Y;
		$returnDate.= '년 전';
	}else if($m){
		$returnDate= $m;
		$returnDate.= '달 전';
	}else if($d){
		$returnDate= $d;
		$returnDate.= '일 전';
	}else if($H){
		$returnDate= $H;
		$returnDate.= '시간 전';
	}else if($i){
		$returnDate= $i;
		$returnDate.= '분 전';
	}else{
		$returnDate= $s;
		$returnDate.= '초 전';
	}
	return $returnDate;
}

//echo diffDate('2011-12-22 11:12:00');




//데이터 암호화 함수
function mcrypt_encryption($plain_data){
	global $key;
	$iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$encrypted_data_on_binary = mcrypt_encrypt(MCRYPT_3DES, $key, $plain_data, MCRYPT_MODE_ECB, $iv);
	$encrypted_data = base64_encode($encrypted_data_on_binary);
	return $encrypted_data;
}

//데이터 복호화 함수
function mcrypt_decryption($encrypted_data){
	global $key;
	$decrypted_data_on_binary = base64_decode($encrypted_data);
	$iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$plain_data = mcrypt_decrypt(MCRYPT_3DES, $key, $decrypted_data_on_binary, MCRYPT_MODE_ECB, $iv);
	return $plain_data;
}




//친구추가/해제
function get_myfriend($mb_user, $user){
	global $connect;
	
	$tmp_sql = "select count(*) as cnt from remember_myfriends where mb_user ='".trim($mb_user)."' and fr_target_user='".trim($user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$mb_user_cnt = $tmp_row['cnt'];
	
	$tmp_sql = "select count(*) as cnt from remember_myfriends where mb_user ='".trim($user)."' and fr_target_user='".trim($mb_user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$fr_target_user_cnt = $tmp_row['cnt'];
	
	if (($mb_user_cnt == 1) and ($fr_target_user_cnt == 0)){
		return "◐";
	}else if (($fr_target_user_cnt == 1) and ($mb_user_cnt == 0)){
		return "◑";
	}else if (($mb_user_cnt == 1) and ($fr_target_user_cnt == 1)){
		return "◆";
	}
}




//문자열 끊기
function get_mb_strimwidth($content, $num){
	return mb_strimwidth($content, 0, $num, "...", "UTF-8");
}





//메모장 cnt
function get_member_cnt_board($user){
	global $connect;
	$tmp_sql = "select count(*) as cnt from remember_board_".trim($user);
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	return $tmp_row['cnt'];
}

//메모장 공개 cnt
function get_member_cnt_board_public($user){
	global $connect;
	$tmp_sql = "select count(*) as cnt from remember_board_".trim($user)." where bo_public = 1";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	return $tmp_row['cnt'];
}

//메모장 비공개 cnt
function get_member_cnt_board_private($user){
	global $connect;
	$tmp_sql = "select count(*) as cnt from remember_board_".trim($user)." where bo_public = 0";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	return $tmp_row['cnt'];
}




//썸네일
function get_member_thumbnail($user, $width=50, $height=50){
	global $connect;
	global $common_skin;
	$tmp_sql = "select a.mb_facebook, a.mb_thumbnail, b.bs_subject, b.bs_user_url from remember_member as a join remember_boardset as b on a.mb_user = b.mb_user where a.mb_user = '".trim($user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_facebook = $tmp_row['mb_facebook'];
	$tmp_thumbnail = $tmp_row['mb_thumbnail'];
	$tmp_subject = $tmp_row['bs_subject'];
	$tmp_user_url = $tmp_row['bs_user_url'];
	if ($tmp_facebook == 0){ 
		if ($tmp_thumbnail != ""){
			return "<a href=\"/".$tmp_user_url."\"><img src=\"".$tmp_thumbnail."\" title=\"".$tmp_subject."\" width=\"".$width."\" height=\"".$height."\" /></a>";
		}else{
			return "<a href=\"/".$tmp_user_url."\"><img src=\"/skin/".$common_skin."/img/person.png\" title=\"".$tmp_subject."\" width=\"".$width."\" height=\"".$height."\" /></a>";   
		}
	}else if ($tmp_facebook == 1){ 
		return "<a href=\"/".$tmp_user_url."\"><img src=\"https://graph.facebook.com/".trim($user)."/picture\" title=\"".$tmp_subject."\" width=\"".$width."\" height=\"".$height."\" /></a>";
	}else if ($tmp_facebook == 2 || $tmp_facebook == 3){ 
		return "<a href=\"/".$tmp_user_url."\"><img src=\"".$tmp_thumbnail."\" title=\"".$tmp_subject."\" width=\"".$width."\" height=\"".$height."\" /></a>";
	}	
}



//공개주소
function get_member_user_url($user){
	global $connect;
	$tmp_sql = "select bs_subject, bs_user_url from remember_boardset where mb_user = '".trim($user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_subject = $tmp_row['bs_subject'];
	$tmp_user_url = $tmp_row['bs_user_url'];
	return "<a href=\"/".$tmp_user_url."\" target=\"_blank\" title=\"".$tmp_subject."\">".trim($user)."</a>";
}



//
function get_member_post($user){
	//return trim($user);
	return "<a href=\"#\" onclick=\"MM_openBrWindow('/admin/member.post.php?user=".trim($user)."','post','scrollbars=yes,width=900,height=600')\" >".trim($user)."</a>";
}	



//nickname
function get_member_nickname($user){
	global $connect;
	$tmp_sql = "select mb_nick from remember_member where mb_user = '".trim($user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$mb_nick = $tmp_row['mb_nick'];
	if ($mb_nick != ""){
		return $mb_nick;
	}else{
		return $user;
	}
}



//공개제목
function get_member_subject($user){
	global $connect;
	$tmp_sql = "select bs_subject from remember_boardset where mb_user = '".trim($user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_subject = $tmp_row['bs_subject'];
	return get_mb_strimwidth(strip_tags($tmp_subject), 30);
}



//쪽지
function get_message($user){
	global $connect;
	$tmp_sql = "select count(*) as cnt from remember_memo where mm_send_user = '".trim($user)."' and mm_read_date = '0000-00-00 00:00:00'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_memo_cnt = $tmp_row['cnt'];
	//return $tmp_memo_cnt."개 쪽지가 전달되었습니다.";
	return "쪽지: ".$tmp_memo_cnt."개";
}



//프로필
function get_profile($user){
	return "<a class=\"jt\" href=\"#\" rel=\"/profile.php?user=".trim($user)."\" title=\"Member Information\">".get_member_nickname(trim($user))."</a>";
	//return "<a class=\"jt\" href=\"#\" rel=\"/profile.php?user=".trim($user)."\" title=\"".get_member_subject(trim($user))."\">".get_member_nickname(trim($user))."</a>";
}



//메모장 합계
function get_post_sum($user){
	global $connect;
	$tmp_sql = "select sum(bo_hit) as cnt from remember_board_".trim($user);
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_post_sum = $tmp_row['cnt'];
	if ($tmp_post_sum == "") $tmp_post_sum = 0;
	return $tmp_post_sum;
}


//메모장 공개 합계
function get_post_sum_public($user){
	global $connect;
	$tmp_sql = "select sum(bo_hit) as cnt from remember_board_".trim($user)." where bo_public = 1";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_post_sum_public = $tmp_row['cnt'];
	if ($tmp_post_sum_public == "") $tmp_post_sum_public = 0;
	return $tmp_post_sum_public;
}

//메모장 비공개 합계
function get_post_sum_private($user){
	global $connect;
	$tmp_sql = "select sum(bo_hit) as cnt from remember_board_".trim($user)." where bo_public = 0";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_post_sum_private = $tmp_row['cnt'];
	if ($tmp_post_sum_private == "") $tmp_post_sum_private = 0;
	return $tmp_post_sum_private;
}





//포인트
function get_point($user, $point, $content=''){
	global $connect;
	global $common_admin_level;
	
	if ($_SESSION['level'] != $common_admin_level){
		$tmp_sql = "select max(po_id) as max_po_id from remember_point";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$po_id = $tmp_row['max_po_id'] + 1;
		
		$sql = "insert into remember_point (po_id, mb_user, po_point, po_content, po_date) ";
		$sql .= "values (".$po_id.", '".trim($user)."', ".$point.", '".addslashes($content)."', now())";
		mysql_query($sql, $connect);
		
		$_SESSION['point'] = get_point_sum(trim($user)); //포인트 합계
		//return 1;
	}	
}



//포인트 합계
/*function get_point_sum($user){
	global $connect;
	$tmp_sql = "select sum(po_point) as point_sum from remember_point where mb_user = '".trim($user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	return number_format($tmp_row['point_sum']);
}*/

//포인트 합계
function get_point_sum($user, $point=0, $num=0){
	global $connect;
	if ($num != 0) $tmp_sql = "select sum(po_point) as point_sum from remember_point where mb_user = '".trim($user)."' and po_id < ".$num;
	else $tmp_sql = "select sum(po_point) as point_sum from remember_point where mb_user = '".trim($user)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$tmp_point_sum = $tmp_row['point_sum'] + ($point);
	return number_format($tmp_point_sum);
}



//회원탈퇴
function get_dropout($user){
	global $connect;
	//게시판
	$sql = "DROP TABLE remember_board_".trim($user);
	mysql_query($sql, $connect);
	//단축url
	$sql = "delete from remember_short_url where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	//설정
	$sql = "delete from remember_boardset where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	//멤버
	$sql = "delete from remember_member where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	//친구
	$sql = "delete from remember_myfriends where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	$sql = "delete from remember_myfriends where fr_target_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	//쪽지
	$sql = "delete from remember_memo where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	$sql = "delete from remember_memo where mm_send_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	//포인트
	$sql = "delete from remember_point where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	//스크랩
	$sql = "delete from remember_scrap where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	$sql = "delete from remember_scrap where sc_table_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	//로그인기록
	$sql = "delete from remember_login_history where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	/*트위터
	$sql = "delete from remember_twitter_post where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);*/
	//임시 인증 메일
	$sql = "delete from remember_tmp_email_auth where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
}


//메모장 삭제
function get_initialize($user, $nick){
	global $connect;
	global $common_short_url;
	
	//메모장 DROP
	$sql = "DROP TABLE remember_board_".trim($user);
	mysql_query($sql, $connect);
	
	//단축url
	$sql = "delete from remember_short_url where mb_user = '".trim($user)."'";
	mysql_query($sql, $connect);
	
	//메모장 CREATE
	$sql = "CREATE TABLE `remember_board_".trim($user)."` (";
	$sql .= "  `bo_id` int(11) NOT NULL auto_increment,";
	$sql .= "  `bo_public` tinyint(1) NOT NULL default '0',";
	$sql .= "  `su_short_url` varchar(20) NOT NULL default '',";
	$sql .= "  `ct_category_code` char(4) default NULL,";
	$sql .= "  `bo_content` longtext default NULL,";
	$sql .= "  `bo_date` datetime NOT NULL default '0000-00-00 00:00:00',";
	$sql .= "  `bo_hit` int(11) NOT NULL default '0',";
	$sql .= "  `bo_ip` varchar(50) default NULL,";
	$sql .= "  `bo_good` int(11) NOT NULL default '0',";
	$sql .= "  `bo_nogood` int(11) NOT NULL default '0',";
	$sql .= "  `bo_option` varchar(25) NOT NULL default '0|0|0|0|1|0|0|0|0|0|0|0|0',";
	$sql .= "  `bo_security_pass` varchar(255) default NULL,";
	$sql .= "  `bo_recycle_bin` tinyint(1) NOT NULL default '0',";
	$sql .= "  `bo_recycle_bin_date` datetime NOT NULL default '0000-00-00 00:00:00',";
	$sql .= "  PRIMARY KEY  (`bo_id`),";
	$sql .= "  UNIQUE KEY (`su_short_url`)";
	$sql .= ") ENGINE=MyISAM";
	mysql_query($sql, $connect);
	
	$short_url_random = get_rand($common_short_url);
	
	$sql = "insert into remember_board_".trim($user)." (bo_id, bo_public, su_short_url, bo_content, bo_date, bo_ip, bo_option) ";
	$sql .= "values (1, 0, '".$short_url_random."', '<strong>".trim($nick)."님, 환영합니다.</strong><br /><br />";
	$sql .= "<strong>너무 간단한 무료 가입</strong><br />페이스북/트위터 연동하기.<br />";
	$sql .= "또는<br />아이디, e-메일, 비밀번호. 딱 셋가지만.<br /><br />";
	$sql .= "<strong>깔끔해진 메모 관리 웹/모바일 서비스</strong><br />나만의 아이디어와 생각들, 간단한 메모, 일기쓰기, 여행기록, 체크리스트, 쇼핑리스트, ";
	$sql .= "기록을 좋아하시는 분이나, 업무/학업상 평소에 메모를 많이 하시던 분, 수집광 등. <br /><br />";
	$sql .= "<strong>주요기능</strong><br />개인PC와 모바일 환경 사용이 가능. (동기화가 없습니다.) <br />자신만의 공간.<br />비공개로 메모 작성.<br />메모 검색.<br />";
	$sql .= "인쇄하기.<br />공유하기. (짧은 주소 사용, SNS 바로 보내기, 리플, QR코드 등 사용)<br /><br />";
	$sql .= "<strong>사용자 인터페이스</strong><br />쉽고 편한 사용법.<br />가로보기 지원. (모바일웹)<br /><br />";
	$sql .= "<strong>비밀번호나 계좌번호를 비롯한 중요한 개인 정보 보안에 유의하시기 바랍니다.</strong>', ";
	$sql .= "now(), '".$_SERVER['REMOTE_ADDR']."', '0|0|0|0|0|0|0|0|0|0|0|0|0')";
	mysql_query($sql, $connect);
}




//스크랩 내용
function get_scrap_content($user, $id, $num){
	global $connect;
	$tmp_sql = "select count(*) as cnt from remember_board_".trim($user)." where bo_id = ".$id;
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	if ($tmp_row['cnt'] == 0){
		return "본 페이지는 열람하실 수 없습니다.";
	}else{
		$tmp_sql = "select bo_content from remember_board_".trim($user)." where bo_id = ".$id;
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		return get_mb_strimwidth(trim(strip_tags(get_text($tmp_row['bo_content']))), $num);
	}
}



//스크랩수
function get_scrap_num($open_url){
	global $connect;
	$tmp_sql = "select count(*) as cnt from remember_scrap where su_short_url = '".trim($open_url)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	return number_format($tmp_row['cnt']);
}


//리스트뷰보기
function get_listview($user){
	global $connect;
	$tmp_sql = "select count(*) as cnt from remember_board_".trim($user)." where bo_recycle_bin != 9";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	return $tmp_row['cnt'];
}


//휴지통
function get_recycle_bin($user){
	global $connect;
	$tmp_sql = "select count(*) as cnt from remember_board_".trim($user)." where bo_recycle_bin = 9";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	return $tmp_row['cnt'];
}



//쪽지 보내기 (기본, 공지사항)
function get_notice_str($int){
	if ($int == 0){
		$notice_str = "";
	}else if ($int == 1){
		$notice_str = "<strong>[공지]</strong>&nbsp;";
	}else if ($int == 2){
		$notice_str = "<strong><font color=\"#FF0000\">[긴급]</font></strong>&nbsp;";
	}
	return $notice_str;
}



//open api
function get_openapi($openapi, $str="key"){
	global $connect;
	if ($str == "key"){ $tmp_api = "key"; }else if($str == "secret"){ $tmp_api = "secret"; }
	$tmp_sql = "select count(*) as cnt from remember_boardset where bs_openapi".$tmp_api." = '".trim($openapi)."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$openapi_cnt = $tmp_row['cnt'];
	if ($openapi_cnt == 1){
		return 1;
	}else{
		return $openapi;
	}
}



//open api key
function get_openapi_key($key){
	global $connect;
	global $common_open_api_demo_key;
	if ($common_open_api_demo_key == $key){
		return $common_open_api_demo_key;
	}else{
		$tmp_sql = "select mb_user from remember_boardset where bs_openapikey = '".trim($key)."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		return trim($tmp_row['mb_user']);
	}
}



//open api error
function get_openapi_error($message, $error_code){
	return ("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<rss version=\"2.0\">\n<channel>\n<error>\n\t<error_code><![CDATA[".$error_code."]]></error_code>\n\t<message><![CDATA[".$message."]]></message>\n</error>\n</channel>\n</rss>\n");
}



//타이틀
/*function get_location($user, $remote_addr, $id=''){
	global $connect;
	//if (strpos($remote_addr, '/?mode=help') !== false){
	if ($remote_addr == "/?mode=help"){
		return "Help";
	}else if ($remote_addr == "/?mode=friend"){
		return "Friend";
	}else if ($remote_addr == "/?mode=dev"){
		return "Developers";
	}else if (strpos($remote_addr, "/admin") !== false){
		return "Admin";
	}else if (strpos($remote_addr, "/view.php") !== false){
		return get_member_subject($user)." > ".get_member_title($user, $id);
	}else if (strpos($remote_addr, "search=") !== false){
		return get_member_subject($user)." > 검색";
	}else if (strpos($remote_addr, "date=") !== false){
		return get_member_subject($user)." > 날짜";
	}else if ($remote_addr == "/"){
		if (isset($user)){
			$tmp_sql = "select bs_subject from remember_boardset where mb_user = '".trim($user)."'";
			$tmp_result = mysql_query($tmp_sql, $connect);
			$tmp_row = mysql_fetch_array($tmp_result);
			return get_mb_strimwidth(strip_tags($tmp_row['bs_subject']), 30);
		}else{
			return "초기화면";
		}
	}else{
		$remote_addr_str = substr($remote_addr, 1);
		$tmp_sql = "select mb_user from remember_boardset where bs_user_url = '".$remote_addr_str."'";
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		if (isset($tmp_row['mb_user'])) {
			return get_member_subject($tmp_row['mb_user']);
		}else{		
			$tmp_sql = "select mb_user, bo_id from remember_short_url where su_short_url = '".$remote_addr_str."' order by su_id desc";
			$tmp_result = mysql_query($tmp_sql, $connect);
			$tmp_row = mysql_fetch_array($tmp_result);
			$mb_user = $tmp_row['mb_user'];
			$bo_id = $tmp_row['bo_id'];
				return get_member_subject($mb_user)." > ".get_member_title($mb_user, $bo_id);
		}
	}
}


//제목
function get_member_title($user, $id){
	global $connect;
	$tmp_sql = "select bo_content from remember_board_".trim($user)." where bo_public = 1 and bo_id = ".$id;
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$bo_content = $tmp_row['bo_content'];
	if (isset($bo_content)){
		return get_mb_strimwidth(trim(strip_tags($bo_content)), 50);
	}else{
		return "비공개";
	}
	//return "....////";
}*/



//주소
function get_url($user, $remote_addr, $id=''){
	global $connect;
	global $common_path;
	if ($remote_addr == "/?mode=help"){
		return "/help";
	}else if ($remote_addr == "/?mode=friend"){
		return "/friend";
	}else if ($remote_addr == "/?mode=dev"){
		return "/developers";
	}else if (strpos($remote_addr, "/admin") !== false){
		return "/admin";
	}else if (strpos($remote_addr, "/view.php") !== false){
		$tmp_sql = "select su_short_url from remember_board_".trim($user)." where bo_public = 1 and bo_id = ".$id;
		$tmp_result = mysql_query($tmp_sql, $connect);
		$tmp_row = mysql_fetch_array($tmp_result);
		$su_short_url = $tmp_row['su_short_url'];
		return isset($su_short_url) ? "/".$su_short_url : ""; //비공개 URL
	}else{
		//$remote_addr_str = substr($remote_addr, 1);
		return $remote_addr;
	}
}		





//로그인 기록
function get_login_history($id){
	global $connect;
	global $common_admin_level;
	if (isset($_SESSION['user'])){ //사용자
		if ($_SESSION['level'] != $common_admin_level){ //관리자
		
			$lh_ip = $_SERVER['REMOTE_ADDR'];
			$lh_agent = $_SERVER['HTTP_USER_AGENT'];
			$lh_datetime = date("Y-m-d H:i:s");
			
			$tmp_sql = "select max(lh_id) as max_lh_id from remember_login_history";
			$tmp_result = mysql_query($tmp_sql, $connect);
			$tmp_row = mysql_fetch_array($tmp_result);
			$lh_id = $tmp_row['max_lh_id'] + 1;
			$sql = "insert into remember_login_history (lh_id, mb_user, lh_ip, lh_agent, lh_datetime_login) ";
			$sql .= "values (".$lh_id.", '".$id."', '".$lh_ip."', '".$lh_agent."', '".$lh_datetime."')";
			mysql_query($sql, $connect);
			
			$_SESSION['ip'] = $lh_ip;
			$_SESSION['datetime'] = $lh_datetime;
			$_SESSION['agent'] = $lh_agent;		
		}	
	}
}
function get_logout_history(){
	global $connect;
	global $common_admin_level;
	if (isset($_SESSION['user'])){ //사용자
		if ($_SESSION['level'] != $common_admin_level){ //관리자
			$tmp_sql = "update remember_login_history set lh_datetime_logout = now() where mb_user = '".$_SESSION['user']."' ";
			$tmp_sql .= "and lh_ip = '".$_SESSION['ip']."' and lh_datetime_login = '".$_SESSION['datetime']."'";
			mysql_query($tmp_sql, $connect);
		}	
	}
}


//현재접속자
function get_login(){
	global $connect;
	global $common_current_visitor;
	$tmp_sql = "select count(*) as cnt from remember_login where lo_ip = '".$_SERVER['REMOTE_ADDR']."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	if ($tmp_row['cnt']){
		$tmp_sql = "update remember_login set mb_user = '".$_SESSION['user']."', ";
		$tmp_sql .= "lo_date = now(), lo_location = '', ";
		$tmp_sql .= "lo_url = '".$_SERVER['REQUEST_URI']."' where lo_ip = '".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($tmp_sql, $connect);
	}else{
		$tmp_sql = "insert into remember_login (lo_ip, mb_user, lo_date, lo_location, lo_url) values(";
		$tmp_sql .= "'".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['user']."', now(), ";
		$tmp_sql .= "'', ";
		$tmp_sql .= "'".$_SERVER['REQUEST_URI']."')";
		mysql_query($tmp_sql, $connect);
	}
	$tmp_sql = "delete from remember_login where lo_date < date_add(now(), INTERVAL - ".$common_current_visitor." minute)"; //지난 접속 삭제
	mysql_query($tmp_sql, $connect);
}


//유지 시간
function get_time_keep($login, $logout){
	$login = strtotime($login);
	$logout = strtotime($logout);
	
	if ($login == $logout) return "-";

	$elapse = $logout - $login;
	$_hr = 0;$_mi = 0;$_se = 0;
	
	$_hr = floor($elapse/3600);
	if($_hr>1) $elapse -= $_hr*3600;
	
	$_mi = floor(($elapse-$_hr*3600)/60);
	if($_mi>1) $elapse -= $_mi*60;
	
	$_se = $elapse;
	
	if($_hr>1) $_elapse .= $_hr."시간 ";
	if($_mi>1) $_elapse .= $_mi."분 ";
	if($_se>1) $_elapse .= $_se."초 ";
	
	return $_elapse;	
}


//날짜기간
function get_date_period($sdate){
	$dateperiod = intval((strtotime(date("Y-m-d")) - strtotime($sdate)) / 86400);
	return $dateperiod;	
}




//날짜
function get_date_time($date){
	return substr($date, 0, 4)."-".substr($date, 4, 2)."-".substr($date, 6, 4);
}


//빈문자 ex) get_bin_str("박지연") -> ♥지연
function get_bin_str($str,$num="0", $bin="♥"){
	preg_match_all('/./u',$str,$temp); $temp[0][$num] = $bin;  
	return implode('',$temp[0]);  
}


//숫자 1을 01로 표시. 공간 채워넣기
function get_str_pad_left($num){
	return str_pad($num, 2, '0', STR_PAD_LEFT);
}



function get_ip_search($ip){
	return "<a href='http://whois.domaintools.com/".$ip."' target='_blank'>".$ip."</a>";
}


//@ -> (at)
function get_email_at($email){
	return preg_replace("/@/", "(at)", $email);
}


//트위터ID
function get_twitter_id($id){
	return "<a href='http://twitter.com/".$id."' target='_blank'>".$id."</a>";
}


//파일 크기 단위 변환
function get_file_size($size, $float=0) { 
    $unit = array('Byte', 'KB', 'MB', 'GB', 'TB'); 
    for ($L = 0; intval($size / 1024) > 0; $L++, $size/= 1024); 
    if (($float === 0) && (intval($size) != $size)) $float = 2; 
    return number_format($size, $float, '.', ',') .' '. $unit[$L]; 
}


//메일 보내기
//type : text=0, html=1, text+html=2
function get_mailer($fname, $fmail, $to, $subject, $content, $type=0, $cc="", $bcc="") {

    $fname   = "=?utf-8?B?" . base64_encode($fname) . "?=";
    $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

    $header  = "Return-Path: <$fmail>\n";
    $header .= "From: $fname <$fmail>\n";
    $header .= "Reply-To: <$fmail>\n";
    if ($cc)  $header .= "Cc: $cc\n";
    if ($bcc) $header .= "Bcc: $bcc\n";
    $header .= "MIME-Version: 1.0\n";
	//$header .= "X-Mailer: SIR Mailer 0.92 (sir.co.kr) : $_SERVER[SERVER_ADDR] : $_SERVER[REMOTE_ADDR] : $g4[url] : $_SERVER[PHP_SELF] : $_SERVER[HTTP_REFERER] \n"; //UTF-8 관련 수정

    if ($type) {
        $header .= "Content-Type: TEXT/HTML; charset=utf-8\n";
        if ($type == 2)
            $content = nl2br($content);
    } else {
        $header .= "Content-Type: TEXT/PLAIN; charset=utf-8\n";
        $content = stripslashes($content);
    }
    $header .= "Content-Transfer-Encoding: BASE64\n\n";
    $header .= chunk_split(base64_encode($content)) . "\n";

    @mail($to, $subject, "", $header);
}


//비밀번호
function get_password($str){
	global $connect;
	$tmp_sql = "select password('".$str."') as db_passwd";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	return $tmp_row['db_passwd'];
}


//이메일 주소 보호, http://www.maurits.vdschee.nl/php_hide_email/
function hide_email($email){
	$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
	$key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
	for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];
	$script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
	$script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
	$script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
	$script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
	$script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
	return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
}


//로그인 방법
function get_login_method($int) { 
	switch($int) { 
		case 1 : 
			return "<img src='/img/mem_fb.png' />";
			break; 
		case 2 : 
			return "<img src='/img/mem_tw.png' />";
			break;
		case 3 : 
			return "<img src='/img/mem_gg.png' />";
			break; 	
		default:
			return "<img src='/img/mem_pz.png' />";
			break;	
	} 
}


function get_level($int) { 
	switch($int) { 
		case 127 : 
			return "<span style='color:#FF0000'>관리자</span>";
			break; 
		case 0 : 
			return "<span style='color:#999999'>준회원</span>";
			break;
		case 1 : 
			return "<span style='color:#0000FF'>정회원</span>";
			break; 	
		default:
			break;	
	} 
}





?>
