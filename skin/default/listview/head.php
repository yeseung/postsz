<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/img/postsz.ico" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<title>리스트뷰 보기</title>

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
<link rel="stylesheet" href="/skin/<? echo $common_skin ?>/listview/css/default.css">
<link rel="stylesheet" href="/skin/<? echo $common_skin ?>/css/jquery.cluetip.css" type="text/css" />


</head>

<body>


<? //echo "<strong>".$_SESSION['user']."</strong><br>"; ?>

<div style="padding-bottom:15px"><a href="/listview.php"><img src="/skin/<? echo $common_skin ?>/img/listview.gif" /></a></div>