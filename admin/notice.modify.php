<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("../lib/common.php");
include_once ("../lib/dbconn.php");
include_once ("../lib/function.php");

//echo "하예승 : ".$_GET['id'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>공지사항 수정하기</title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script> 



</head>

<body>


<?

$sql = "select * from remember_notice_board where nb_id = ".trim($_GET['id']);
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);
$nb_id = $row['nb_id'];
$mb_user = $row['mb_user'];
$nb_subject = $row['nb_subject'];
$nb_content = $row['nb_content'];
$nb_date = $row['nb_date'];
$nb_updated_date = $row['nb_updated_date'];
$nb_file_name = $row['nb_file_name'];
$nb_file_size = $row['nb_file_size'];
$nb_link_1 = $row['nb_link_1'];
$nb_link_2 = $row['nb_link_2'];
$nb_link_hit_1 = $row['nb_link_hit_1'];
$nb_link_hit_2 = $row['nb_link_hit_2'];
$nb_ip = $row['nb_ip'];
$nb_hit = $row['nb_hit'];
$nb_setting = $row['nb_setting'];
$nb_recycle_bin = $row['nb_recycle_bin'];
$nb_recycle_bin_date = $row['nb_recycle_bin_date'];

?>


<form id="nb_modify">
<input type="hidden" name="id" value="<? echo trim($_GET['id']) ?>" />
<input type="hidden" name="mode" value="modify" />
<table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td align="right" width="20%" style="font-size:11px">제목&nbsp;</td>
        <td><input type="text" name="subject" style="width:99%;" value="<? echo $nb_subject ?>" /></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">내용&nbsp;</td>
        <td><textarea name="content" style="height:120px; width:99%;" /><? echo $nb_content ?></textarea></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">날짜&nbsp;</td>
        <td><input type="text" name="date" style="width:99%;" value="<? echo $nb_date ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">최종업데이트 날짜&nbsp;</td>
        <td><input type="text" name="updated_date" style="width:99%;" value="<? echo $nb_updated_date ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">첨부파일 저장된 파일명&nbsp;</td>
        <td><input type="text" name="file_name" style="width:99%;" value="<? echo $nb_file_name ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">첨부파일 크기&nbsp;</td>
        <td><input type="text" name="file_size" style="width:99%;" value="<? echo $nb_file_size ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">링크1&nbsp;</td>
        <td><input type="text" name="link_1" style="width:99%;" value="<? echo $nb_link_1 ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">링크2&nbsp;</td>
        <td><input type="text" name="link_2" style="width:99%;" value="<? echo $nb_link_2 ?>" /></td></td>
    </tr>
	<tr>
        <td align="right" style="font-size:11px">링크 조회수1&nbsp;</td>
        <td><input type="text" name="link_hit_1" style="width:99%;" value="<? echo $nb_link_hit_1 ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">링크 조회수2&nbsp;</td>
        <td><input type="text" name="link_hit_2" style="width:99%;" value="<? echo $nb_link_hit_2 ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">ip&nbsp;</td>
        <td><input type="text" name="ip" style="width:99%;" value="<? echo $nb_ip ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">조회수&nbsp;</td>
        <td><input type="text" name="hit" style="width:99%;" value="<? echo $nb_hit ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">설정&nbsp;</td>
        <td><input type="text" name="setting" style="width:99%;" value="<? echo $nb_setting ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">휴지통&nbsp;</td>
        <td><input type="text" name="recycle_bin" style="width:99%;" value="<? echo $nb_recycle_bin ?>" /></td></td>
    </tr>
    <tr>
        <td align="right" style="font-size:11px">삭제날짜&nbsp;</td>
        <td><input type="text" name="recycle_bin_date" style="width:99%;" value="<? echo $nb_recycle_bin_date ?>" /></td></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" value="글쓰기" style="padding:5px; font-size:15px;" /></td>
    </tr>
</table>   
</form>




<script type="text/javascript"> 
//<![CDATA[ 
$(document).ready(function() { 

	$("form#nb_modify").submit(function() {
		$.post('/process/adm.notice.php', $("form#nb_modify").serialize(), function(data){
			self.location.reload();
		});
		return false;
	});

}); 
//]]> 
</script>


</body>
</html>
