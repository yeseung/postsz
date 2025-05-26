<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/img/postsz.ico" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<title>쪽지함</title>

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

<link rel="stylesheet" href="/skin/<? echo $common_skin ?>/css/jquery.ui.all.css">
<link rel="stylesheet" href="/skin/<? echo $common_skin ?>/memo/css/default.css">
<link rel="stylesheet" href="/skin/<? echo $common_skin ?>/css/jquery.cluetip.css" type="text/css" />


</head>

<body>


<!--<div style="padding-bottom:10px">-->
<?
if ($_GET['mode'] == "" or $_GET['mode'] == "recv" or $_GET['mode'] == "recv_view"){
	echo "<img src=\"/skin/{$common_skin}/img/memo_a2.gif\" />";
}else if ($_GET['mode'] =="send" or $_GET['mode'] == "send_view"){
	echo "<img src=\"/skin/{$common_skin}/img/memo_a3.gif\" />";
}else if ($_GET['mode'] == "write"){
	echo "<img src=\"/skin/{$common_skin}/img/memo_a4.gif\" />";
}
?>
<!--</div>-->

<div id="button" style="padding: 0 0 5px 0;">
<button id="memo_recv" title="받은쪽지" style="font-size:11px;">받은쪽지</button>
<button id="memo_send" title="보낸쪽지" style="font-size:11px;">보낸쪽지</button>
<button id="memo_write" title="쪽지쓰기" style="font-size:11px;">쪽지쓰기</button>
<button id="memo_write_mine" title="<? echo $_SESSION['user'] ?>" style="font-size:11px;">내게쓰기</button>
</div>


