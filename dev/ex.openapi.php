<? 
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP를 이용한 오픈API 사용하기</title>
</head>

<body>

<p> 스누피 클래스(Snoopy Class) 다운로드 <br />
  <a href="http://sourceforge.net/projects/snoopy/" target="_blank">http://sourceforge.net/projects/snoopy/</a><br />
  <br />
</p>
<p>&lt;?php<br />
header(&quot;content-type:text/html; charset=utf-8&quot;);</p>
<p>//version : 1.0.0</p>
<p>$apikey = &quot;<? echo (!isset($_SESSION['set_openapikey'])) ? $common_open_api_demo_key : $_SESSION['set_openapikey'] ?>&quot;; //open API Key<br />
$result = 10; //한 페이지에 출력될 결과수<br />
$page = 1; //페이지 번호</p>
<p>require &quot;Snoopy.class.php&quot;; <br />
  ini_set(&quot;allow_url_fopen&quot;,&quot;1&quot;);</p>
<p>$url = &quot;<? echo $common_path ?>dev/openapi.xml?key=&quot;.$apikey.&quot;&amp;result=&quot;.$result.&quot;&amp;page=&quot;.$page;<br />
  $snoopy = new Snoopy; <br />
  $snoopy-&gt;fetch($url); <br />
$xml = @simplexml_load_string($snoopy-&gt;results); </p>
<p>/*foreach($xml-&gt;channel-&gt;item as $item) { <br />
  &nbsp;&nbsp;&nbsp;&nbsp;echo &quot;&lt;h3&gt;&quot;.$item-&gt;title.&quot;&lt;/h3&gt;\n&quot;; <br />
  &nbsp;&nbsp;&nbsp;&nbsp;echo &quot;&lt;p&gt;&quot;.$item-&gt;description.&quot;&lt;/p&gt;\n&quot;; <br />
  &nbsp;&nbsp;&nbsp;&nbsp;echo &quot;&lt;p&gt;&quot;.$item-&gt;author.&quot; / &quot;.date(&quot;Y-m-d H:i:s&quot;, strtotime($item-&gt;pubDate)).&quot; / &quot;;<br />
  &nbsp;&nbsp;&nbsp;&nbsp;echo &quot;&lt;a href=\&quot;&quot;.$item-&gt;link.&quot;\&quot; target=\&quot;_blank\&quot;&gt;more Info&lt;/a&gt;&lt;/p&gt;&lt;hr&gt;\n&quot;;<br />
  }*/</p>
<p>echo &quot;&lt;pre&gt;&quot;;<br />
print_r($xml);<br />
echo &quot;&lt;/pre&gt;&quot;;</p>
<p>?&gt;</p>


</body>
</html>
