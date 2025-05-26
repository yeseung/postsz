<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("lib/common.php");
include_once ("lib/dbconn.php");
include_once ("lib/function.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>google 맞춤검색</title>
</head>

<body>

&nbsp;&nbsp;&nbsp;<a href="/search.php"><img src="/img/postsz.png" width="70" title="<? echo $common_title ?> - 맞춤검색" /></a>

<!--<h1>공개 맞춤검색 - <? echo $common_path ?></h1>-->

<div id="cse" style="width: 100%;">Loading</div>
<script src="http://www.google.co.kr/jsapi" type="text/javascript"></script>
<script type="text/javascript"> 
  google.load('search', '1', {language : 'ko', style : google.loader.themes.V2_DEFAULT});
  google.setOnLoadCallback(function() {
    var customSearchOptions = {};  var customSearchControl = new google.search.CustomSearchControl(
      '015109247256087221019:dy8dmsmhy5g', customSearchOptions);
    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
    customSearchControl.draw('cse');
  }, true);
</script>


</body>
</html>
