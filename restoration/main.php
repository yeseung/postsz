<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Restoration</title>


<script type="text/javascript"> 
//<![CDATA[ 

function validateType(f){
	f = f.elements;
	if(/.*\.(xls)$/.test(f['excel[0]'].value.toLowerCase())){
		return true;
 	}
	alert("xls 파일만 올릴수 있습니다.");
	f['excel[0]'].focus();
	return false;
}

//]]> 
</script> 


</head>

<body>

<form name="upload" action="/process/restoration.php" method="post" onsubmit="return validateType(this);" enctype="multipart/form-data">
<table width="484" align="center" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><input type="file" name="excel[0]" /></td>
    <td align="right" width="80"><select name="public" style="padding:2px;">
<option value="0" selected="selected">비공개</option>
<option value="1">공개</option>
</select></td>
    <td align="right" width="50"><input type="image" src="/restoration/img/submit.png" value="확인" /></td>
  </tr>
  <tr>
    <td colspan="3" ><div style="font-size:11px; color:#999999; padding:5px 0 0 3px;">example : </div>
<img src="/restoration/img/res.png" border="0" /></td>
  </tr>
</table>
</form>


</body>
</html>
