<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>




<p style="font-size:12px;">




<strong>너무 간단한 무료 가입</strong><br />
페이스북/트위터 연동하기.<br />
또는<br />
아이디, e-메일, 비밀번호. 딱 셋가지만.<br /><br />

<strong>깔끔해진 메모 관리 웹/모바일 서비스</strong><br />
나만의 아이디어와 생각들, 간단한 메모, 일기쓰기, 여행기록, 체크리스트, 쇼핑리스트, 기록을 좋아하시는 분이나, 업무/학업상 평소에 메모를 많이 하시던 분, 수집광 등.<br /><br /> 

<strong>주요기능</strong><br />
개인PC와 모바일 환경 사용이 가능. (동기화가 없습니다) <br />
자신만의 공간.<br />
비공개로 메모 작성.<br />
메모 검색.<br />
인쇄하기.<br />
공유하기. (짧은 주소 사용, SNS 바로 보내기, 리플, QR코드 등 사용)<br />
<!--암호화 사용.<br />--><br />

<strong>사용자 인터페이스</strong><br />
쉽고 편한 사용법.<br />
가로보기 지원. (모바일웹)<br /><br />

<strong>비밀번호나 계좌번호를 비롯한 중요한 개인 정보 보안에 유의하시기 바랍니다.</strong>



</p>



<div align="center" style="padding-bottom:30px;"><img src="/img/main.png" border="0" /></div>
<!--<img src="/img/index_m.png" width="100%" border="0" />-->
<img src="/img/index_cloud.png" width="97%" border="0" />









<div style="padding-top:45px;" class="addthis_toolbox addthis_default_style" addthis:url="<? echo $common_path."help" ?>" addthis:title="<? echo $common_help_title ?>">
<!--<a class="addthis_button_facebook_like" fb:like:layout="button_count" fb:like:url="<? echo $common_path."help" ?>"></a>
<a class="addthis_button_tweet" tw:via="<? echo $common_tweet_id ?>"></a>-->
<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
<a class="addthis_button_email"></a>
<a class="addthis_button_gmail"></a>
<a class="addthis_button_favorites"></a>
<a class="addthis_button_print"></a>
<a class="addthis_button_compact"></a>
<a href="http://twitter.com/share" class="twitter-share-button" data-text="<? echo $common_tweet_via ?> <? echo $common_help_title ?>" data-url="<? echo $common_path."help" ?>" data-count="horizontal" data-lang="en">Tweet</a>
<a href="javascript:pstMe2Day('<? echo $common_help_title ?>', '<? echo $common_path."help" ?>')"><img src="/skin/<? echo $common_skin ?>/img/icon_me2day.png" /></a>
<a href="javascript:pstYozmDaum('<? echo $common_path."help" ?>','<? echo $common_help_title ?>','<? echo $common_path ?>');return false;"><img src="/skin/<? echo $common_skin ?>/img/icon_yozm.png" /></a>
</div>

<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f1af0ac56cc4abd"></script>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>


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

//]]>
</script>