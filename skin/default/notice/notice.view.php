<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

$sql = "select * from remember_notice_board where nb_id = ".trim($_GET['id']);
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);
$mb_user = $row['mb_user'];
$nb_subject = $row['nb_subject'];
$nb_content = conv_content($row['nb_content'], 0);
$nb_date = str_replace("-", "/", (substr($row['nb_date'], 0, 16)));
//$nb_updated_date = str_replace("-", "/", (substr($row['nb_updated_date'], 2, 14)));
$nb_file_name = $row['nb_file_name'];
//$nb_file_size = $row['nb_file_size'];
$tmp_file_name_explode = explode("|", $nb_file_name);
//$tmp_file_size_explode = explode("|", $nb_file_size);
$nb_link_1 = $row['nb_link_1'];
$nb_link_2 = $row['nb_link_2'];
$nb_link = $nb_link_1."|".$nb_link_2;
$nb_link_explode = explode("|", $nb_link);
$nb_link_hit_1 = $row['nb_link_hit_1'];
$nb_link_hit_2 = $row['nb_link_hit_2'];
$nb_link_hit = $nb_link_hit_1."|".$nb_link_hit_2;
$nb_link_hit_explode = explode("|", $nb_link_hit);
//$nb_ip = $row['nb_ip'];
//$nb_hit = $row['nb_hit'];

if ($_COOKIE["nb_{$_GET[id]}"] != $_GET['id']){
	$sql = "update remember_notice_board set nb_hit = nb_hit + 1 where nb_id = ".trim($_GET['id']);
	mysql_query($sql, $connect);
	setcookie("nb_{$_GET[id]}", "{$_GET[id]}", time() + 3600);
}

//echo $nb_subject." / ".$nb_content." / ".$nb_date." / ".$nb_updated_date." / ".$nb_file_name." / ".$nb_file_size." / ".$nb_ip." / ".$nb_hit."<br><br><br>";
//echo $nb_subject." / ".$nb_content." / ".$nb_date." / ".$nb_updated_date." / ".$nb_ip." / ".$nb_hit."<br><br><br>";
?>




<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="/skin/<? echo $common_skin ?>/img/memo_bg.gif" align="center" height="40"><span style="font-size:15px; font-weight:bold"><? echo get_mb_strimwidth($nb_subject, 160) ?></span></td>
  </tr>
  <tr>
	<td bgcolor="#F0F0F0" height="1"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <? for($i=0; $i<count($nb_link_explode); $i++) {
    if ($nb_link_explode[$i] != "") { ?>
      <tr>
         <td style="padding:7px;"><span style="color:#999999">link#<? echo $i+1 ?></span>&nbsp;<a href="/process/link.php?id=<? echo trim($_GET['id']) ?>&no=<? echo $i+1 ?>" target="_blank"><? echo $nb_link_explode[$i] ?></a><? if ($_SESSION['level'] == $common_admin_level) echo "&nbsp;(".$nb_link_hit_explode[$i].")" ?></td>
      </tr>
      <tr>
        <td bgcolor="#F0F0F0" height="1"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
      </tr>
  <? }} ?>
  <tr>
  	<td style="padding:7px;">
	
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<? for($i=0; $i<count($tmp_file_name_explode)-1; $i++) { ?>
            <tr>
                <td style="padding:0 0 10px 0;"><img src="/process/<? echo $tmp_file_name_explode[$i] ?>" name="target_resize_image[]" onclick="image_window(this);" style="cursor:pointer;" /><? //echo get_file_size($tmp_file_size_explode[$i]) ?></td>
            </tr>
        <? } ?>
    </table>
    
    
    </td>
  </tr>
  <tr>
  	<td style="padding:10px;"><span style="line-height:16px;"><? echo $nb_content ?></span></td>
  </tr>
  <tr>
	<td bgcolor="#F0F0F0" height="1"><img src="/skin/<? echo $common_skin ?>/img/memo_bin.gif" /></td>
  </tr>
  <tr>
  	<td>
    
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
		<tr>
        	<td style="padding-top:2px;"><a href="javascript:history.go(-1)" style="font-size:24px"><img src="/skin/<? echo $common_skin ?>/img/nb_list.gif" border="0" title="목록"/></a></td>
            <td align="right" style="padding:5px;"><span style="color:#CCCCCC; font-size:10px"><? echo $nb_date ?></span></td>
        </tr>
    </table>    
          
    </td>
  </tr>
</table> 

<br />

<script type="text/javascript"> 
//<![CDATA[ 

window.onload=function() {
    resizeBoardImage(<? echo $common_resize_img ?>);
}

function resizeBoardImage(imageWidth) {

    var target = document.getElementsByName('target_resize_image[]');
    var imageHeight = 0;

    if (target) {
        for(i=0; i<target.length; i++) { 
            // 원래 사이즈를 저장해 놓는다
            target[i].tmp_width  = target[i].width;
            target[i].tmp_height = target[i].height;
            // 이미지 폭이 테이블 폭보다 크다면 테이블폭에 맞춘다
            if(target[i].width > imageWidth) {
                imageHeight = parseFloat(target[i].width / target[i].height)
                target[i].width = imageWidth;
                target[i].height = parseInt(imageWidth / imageHeight);
                target[i].style.cursor = 'pointer';

                // 스타일에 적용된 이미지의 폭과 높이를 삭제한다
                target[i].style.width = '';
                target[i].style.height = '';
            }
        }
    }
}

// 이미지의 크기에 따라 새창의 크기가 변경
function image_window(img){

	var w = img.tmp_width; 
	var h = img.tmp_height; 
	var winl = (screen.width-w)/2; 
	var wint = (screen.height-h)/3; 

	if (w >= screen.width) winl = 0; h = (parseInt)(w * (h / w)); 
	if (h >= screen.height) wint = 0; w = (parseInt)(h * (w / h)); 
	
	var settings;
	if (navigator.userAgent.toLowerCase().indexOf("gecko") != -1) {
		settings  ='width='+(w+10)+','; 
		settings +='height='+(h+10)+','; 
	} else {

		settings  ='width='+w+','; 
		settings +='height='+h+','; 
	}
	settings +='top='+wint+','; 
	settings +='left='+winl+','; 
	settings +='scrollbars=no,'; 
	settings +='resizable=yes,'; 
	settings +='status=no'; 

	win = window.open("img.win.php?src=" + img.src,"image_window",settings); 
	if(parseInt(navigator.appVersion) >= 4){win.window.focus();} 
}



	

//]]> 
</script>







