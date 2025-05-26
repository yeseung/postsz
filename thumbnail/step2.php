<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

if (!$_SESSION['user']){
	echo("<script>
		window.alert('로그인을 하셔야 이용하실 수 있습니다.');
		</script>");
	echo ("<meta http-equiv=\"refresh\" content=\"0; url=/\">");	
	exit;
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>썸네일 만들기 step 2</title>

<script type="text/javascript" src="/js/jquery-1.6.2.js"></script>
<script type="text/javascript" src="/js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="/thumbnail/css/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript"> 
//<![CDATA[ 

$(function(){
	$('#cropbox').Jcrop({
		aspectRatio: 1,
		onSelect: updateCoords
	});
});

function updateCoords(c){
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#w').val(c.w);
	$('#h').val(c.h);
};

function checkCoords(){
	if (parseInt($('#w').val())) return true;
	alert('Please select a crop region then press submit.');
	return false;
};

//]]> 
</script> 
</head>

<body>



<?

define("save_path","temp/"); 
for($i=0; $i<count($_FILES[img][name]); $i++) { 
	if($_FILES[img][size][$i] && !$_FILES[img][error][$i]) { 

		$file_name[$i] = $_FILES[img][name][$i]; 
		$file_tmp_name[$i] = $_FILES[img][tmp_name][$i]; 
		$file_size[$i] = $_FILES[img][size][$i];
		
		if ((($_FILES[img][type][$i] == "image/gif") || ($_FILES[img][type][$i] == "image/jpeg") || ($_FILES[img][type][$i] == "image/pjpeg") || ($_FILES[img][type][$i] == "image/x-png") || ($_FILES[img][type][$i] == "image/png")) && ($_FILES[img][size][$i] < 1024000)){
		
			if (!file_exists(save_path.$file_name[$i])) { 
				move_uploaded_file($file_tmp_name[$i],save_path.$file_name[$i]); 
			}else{ 
				$file_name[$i] = time()."_".$file_name[$i]; 
				move_uploaded_file($file_tmp_name[$i],save_path.$file_name[$i]); 
			}
			
		}else{
			echo("<script>
				window.alert('1MB 이하의 GIF, PNG, JPEG 형식의 파일만 업로드 할 수 있습니다.');
				history.go(-1);
				</script>");
			exit;
		}	
	}
}
//echo "<img src=\"".save_path.$file_name[0]."\" />";
    
?>


<?php

/**
 * Jcrop image cropping plugin for jQuery
 * Example cropping script
 * @copyright 2008-2009 Kelly Hallman
 * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
 */

//if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if ($_POST['upload'] == "upload"){
	$targ_w = $targ_h = 50;
	$jpeg_quality = 100;

	//$src = 'demo_files/flowers.jpg';
	$src = $_POST['upload_img'];
	
	$img_r = imagecreatefromjpeg($src);
	//$img_r = imagecreatefromgif($src);
	//$img_r = imagecreatefrompng($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
	
	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	//header('Content-type: image/jpeg');
	//imagejpeg($dst_r,null,$jpeg_quality);
	
	//$thumb_date = date("ymdHi");
		
	imagejpeg($dst_r, "picture/".$_SESSION['user'].".jpg",$jpeg_quality);
	//imagejpeg($dst_r, "picture/".$thumb_date."_thumbnail.jpg",$jpeg_quality);
	//imagepng($dst_r, "profile/".$thumb_date."_thumbnail.png");
	
	
	$sql = "update remember_member set mb_thumbnail = '/thumbnail/picture/".$_SESSION['user'].".jpg' ";
	$sql .= "where mb_user = '".trim($_SESSION['user'])."'";
	mysql_query($sql, $connect);
	


	
	echo "<img src=\"picture/".$_SESSION['user'].".jpg\" />";
	//echo $sql;
	//echo "<img src=\"profile/".$thumb_date."_thumbnail.png\" />";
	
	?>
<script language="JavaScript"> 
	//setTimeout("self.close()", 2000);
	window.opener.location.href='<? echo $common_path ?>?mode=mypage';
	//setTimeout("window.close();", 200);
	window.close();
</script> 

<!--2초 후 자동으로 종료합니다.
<a href=javascript:close()>[닫기]</a>-->

	<?
	exit;
}


// If not a POST request, display page below:

?>

<!-- This is the image we're attaching Jcrop to 
<img src="demo_files/flowers.jpg" id="cropbox" />-->
<img src="<? echo save_path.$file_name[0] ?>" id="cropbox" />

<!-- This is the form that our event handler fills -->
<form action="/thumbnail/step2.php" method="post" onSubmit="return checkCoords();">
<input type="hidden" name="upload" value="upload" />
<input type="hidden" name="upload_img" value="<? echo save_path.$file_name[0] ?>" />
    <input type="hidden" id="x" name="x" />
    <input type="hidden" id="y" name="y" />
    <input type="hidden" id="w" name="w" />
    <input type="hidden" id="h" name="h" />
    <input type="submit" value="썸네일 만들기" />
</form>


</body>

</html>