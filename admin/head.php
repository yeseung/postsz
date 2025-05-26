<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="/img/postsz.ico" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<title><? echo $common_title ?> - 관리자</title>

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
<script type="text/javascript" src="/js/autoresize.jquery.js"></script>
<script type="text/javascript" src="/js/jquery.cluetip.js" ></script>

<link rel="stylesheet" href="/admin/css/jquery.ui.all.css">
<link rel="stylesheet" href="/admin/css/default.css">
<link rel="stylesheet" href="/skin/<? echo $common_skin ?>/css/jquery.cluetip.css" type="text/css" />
<!--<link rel="stylesheet" href="/css/style.css">
<script type="text/javascript" src="/skin/<? echo $common_skin ?>/js/jquery.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>-->



</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="10" id="tb">
  <tr>
  	<td width="80"><a href="/admin"><img src="/img/postsz.png" width="70" /></a></td>
    <td><strong><a href="/admin">초기화면</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=member">회원관리</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=visit">접속자현황</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=current">현재접속자</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="/admin/?mode=counter">카운터</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
        <a href="/admin/?mode=url">공개주소</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=friend">친구</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=memo">쪽지</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=history">로그인기록</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=search">검색</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=spam">신고</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
        <a href="/admin/?mode=point">포인트</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=scrap">스크랩</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=ad">광고</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!--<a href="/admin/?mode=twlink">트위터연동</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
        <a href="/admin/?mode=auth">인증메일</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=email">회원메일발송</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=db">db수정</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/admin/?mode=notice">공지사항</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!--<a href="http://webmail.postsz.com/" target="_blank">메일</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
        <a href="/admin/?mode=feedback">Feedback</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<? echo $common_adm_contact_me ?>" target="_blank">Contact Us</a></strong></td>
  	<td valign="bottom" align="center" style="padding-bottom:30px"><strong><a href="#" id="logout-a">로그아웃</a></strong></td>      
  </tr>
  <tr>  
    <td colspan="3" style="padding-top:15px;">
  

