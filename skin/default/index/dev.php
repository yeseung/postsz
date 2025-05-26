<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<span style="font-size:11px">

<!--<p><strong>외부 개발자 및 사용자에게 XML 형식으로 전달하는 API 서비스입니다.</strong></p>-->


<h4>1. 요청 URL (request url)</h4>
<p style="padding-bottom:20px"><? echo $common_path ?>dev/openapi.xml</p>

<h4>2. 요청 변수 (request parameter)</h4>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="27" width="110"><b>요청 변수</b></td>
    <td width="200"><b>값</b></td>
    <td><b>설명</b></td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">key</td>
    <td>string (필수)</td>
    <td>발급받은 인증키(apikey)</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">result</td>
    <td>integer : 기본값 10, 최소 1, 최대 20</td>
    <td>한 페이지에 출력될 결과수</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">page</td>
    <td>integer : 기본값 1</td>
    <td>페이지 번호</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
</table>
<br />

<h4> - 샘플 페이지</h4>
<p><? echo $common_path ?>dev/openapi.xml?key=<? echo (!isset($_SESSION['set_openapikey'])) ? $common_open_api_demo_key : $_SESSION['set_openapikey'] ?>&amp;result=10&amp;page=1</p>
<iframe src="/dev/openapi.xml?key=<? echo (!isset($_SESSION['set_openapikey'])) ? $common_open_api_demo_key : $_SESSION['set_openapikey'] ?>&result=10&page=1" frameborder="0" width="521" height="270" scrolling="yes" style="border:1px solid #999999"></iframe>
<br /><br /><br />


<h4>3. 출력 결과 필드 (response field)</h4>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="27" width="110"><b>출력 변수</b></td>
    <td width="110"><b>값</b></td>
    <td><b>설명</b></td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">channel</td>
    <td>-</td>
    <td>title, link, description 등의 항목은 참고용</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <!--<tr>
    <td height="25">hit</td>
    <td>integer</td>
    <td>조회수</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>-->
  <tr>
    <td height="25">totalCount</td>
    <td>integer</td>
    <td>결과의 수</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">pageCount</td>
    <td>integer</td>
    <td>결과의 페이지수</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">result</td>
    <td>integer</td>
    <td>한 페이지에 출력될 결과수</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">page</td>
    <td>integer</td>
    <td>페이지 번호</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">item</td>
    <td>-</td>
    <td>정보</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">title</td>
    <td>string</td>
    <td>제목</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">link</td>
    <td>string</td>
    <td>서비스 URL</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">description</td>
    <td>string</td>
    <td>본문 요약</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">author</td>
    <td>string</td>
    <td>저자 정보</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">pubDate</td>
    <td>string</td>
    <td>등록일</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="3"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
</table>
<br /><br />


<h4>4. 비고/에러 메시지</h4>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="27" width="35%"><b>error_code</b></td>
    <td><b>message</b></td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="2"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr> 
  <tr>
    <td height="25">401</td>
    <td>등록되지 않은 키입니다.</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="2"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>  
  <tr>
    <td height="25">403</td>
    <td>잘못된 쿼리요청입니다.</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="2"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
    <td height="25">404</td>
    <td>등록된 게시글이 없습니다.</td>
  </tr>
  <tr>
    <td bgcolor="#999999" colspan="2"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
</table>
<br /><br />


<h4>* 활용하기</h4>
<p><a href="/dev/ex.openapi.php" target="_blank">PHP를 이용한 오픈API 사용하기</a></p>
<br />

<? //echo "openapikey : ".$_SESSION['set_openapikey']." / openapisecret : ".$_SESSION['set_openapisecret']." / openapi_hit : ".$_SESSION['set_openapi_hit']; ?>
</span>