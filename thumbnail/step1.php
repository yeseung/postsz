<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>썸네일 만들기 step 1</title>

<script type="text/javascript"> 
//<![CDATA[ 

function validateType(f){
	f = f.elements;
	//if(/.*\.(gif)|(jpeg)|(jpg)|(png)$/.test(f['img[0]'].value.toLowerCase())){
	if(/.*\.(jpeg)|(jpg)$/.test(f['img[0]'].value.toLowerCase())){
		return true;
 	}
	//alert('Please upload gif or jpg or png image only.');
	//alert("gif, jpeg, jpg, png 파일만 올릴수 있습니다.");
	alert("jpg / jpeg 파일만 올릴수 있습니다.");
	f['img[0]'].focus();
	return false;
}

//]]> 
</script> 
</head>

<body>


<span style="font-size:11px;">이미지 파일(jpg, jpeg)을 선택하세요. (최대 1MB)</span><br /><br />

<form name="upload" action="/thumbnail/step2.php" method="post" onsubmit="return validateType(this);" enctype="multipart/form-data">
<input type="file" name="img[0]" />
<input type="submit" value="확인" />
</form>
       

</body>
</html>