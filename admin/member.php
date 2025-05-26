<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가


$page = $_GET['page'];
if (!$page) $page = 1;



switch ($_GET['type']){
	case 1: $sql = "select * from remember_member order by mb_login_cnt desc"; break;
	case 2: $sql = "select * from remember_member order by mb_user"; break;
	case 3: $sql = "select * from remember_member order by mb_email desc"; break;
	case 4: $sql = "select * from remember_member order by mb_date desc"; break;
	case 5: $sql = "select * from remember_member order by mb_facebook desc"; break;
	case 6: $sql = "select * from remember_member order by mb_level desc"; break;
	default: $sql = "select * from remember_member order by mb_updated_date desc";			
}


$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

//$scale = $common_admin_rows_member;
$scale = $common_admin_rows;

if ($total_record % $scale == 0){ 
	$total_page = floor($total_record/$scale); 
}else{
	$total_page = floor($total_record/$scale) + 1;
}

$start = ($page - 1) * $scale; 
$number = $total_record - $start;

$url_type_page = $common_path."admin/?mode=".$_GET['mode'];

?>

사용자 : <? echo $total_record ?>명<br />

<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
  	<td><strong>번호</strong></td>
  	<td><strong>아이디<a href="<? echo $url_type_page."&type=2&page=".$page ?>">▲</a></strong></td>
    <td><strong>별명</strong></td>
    <td align="center"><strong>사진</strong></td>
    <td><strong>e-메일<a href="<? echo $url_type_page."&type=3&page=".$page ?>">▲</a></strong></td>
    <td align="center"><strong>회원가입일<a href="<? echo $url_type_page."&page=".$page ?>">▲</a></strong></td>
    <td align="center"><strong>최근접속일<a href="<? echo $url_type_page."&type=4&page=".$page ?>">▲</a></strong></td>
    <td align="center"><strong>아이피</strong></td>
    <td align="center"><strong>운영체제</strong></td>
    <td align="center"><strong>브라우저</strong></td>
    <td align="center"><strong>횟수<a href="<? echo $url_type_page."&type=1&page=".$page ?>">▲</a><!--<a href="<? echo $url_type_page."&type=2&page=".$page ?>">▼</a>--></strong></td>
    <td align="center"><strong>메모장</strong></td>
    <td align="center"><strong>조회수</strong></td>
    <!--<td><strong>공개주소</strong></td>-->
    <td align="center"><strong>포인트</strong></td>
    <td align="center"><strong>공개</strong></td>
    <td align="center"><strong>수신</strong></td>
    <td align="center"><strong>권한<a href="<? echo $url_type_page."&type=6&page=".$page ?>">▲</a></strong></td>
    <td align="center"><strong><!--방법--><a href="<? echo $url_type_page."&type=5&page=".$page ?>">▲</a></strong></td>
    <td align="center"><strong>수정</strong></td>
    <td align="center"><strong>삭제</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$mb_user = $row['mb_user'];
	$mb_email = $row['mb_email'];
	//$mb_updated_date = $row['mb_updated_date'];
	//$mb_date = $row['mb_date'];
	$mb_updated_date = str_replace("-", "/", (substr($row['mb_updated_date'], 2, 14)));
	$mb_date = str_replace("-", "/", (substr($row['mb_date'], 2, 14)));
	$mb_level = $row['mb_level'];
	
	$mb_ip = $row['mb_ip'];
	//$mb_agent = $row['mb_agent'];
	//$mb_agent = substr($row['mb_agent'], 12);
	$brow = get_brow($row['mb_agent']);
    $os = get_os($row['mb_agent']);
	$mb_login_cnt = $row['mb_login_cnt'];
	$mb_open_mailling_explode = explode("|", $row['mb_open_mailling']);
	$mb_open = $mb_open_mailling_explode[0];
	$mb_mailling = $mb_open_mailling_explode[1];
	$mb_facebook = $row['mb_facebook'];
	$profile = $row['mb_profile'];
	$thumbnail = $row['mb_thumbnail'];
	
	/*$sql = "select bs_user_url, bs_hit from remember_boardset where mb_user = '".trim($mb_user)."'";
	$tmp_result = mysql_query($sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$bs_user_url = $tmp_row['bs_user_url'];
	$bs_hit = $tmp_row['bs_hit'];*/
?>
	<tr>
    	<td><? echo $number ?></td>
    	<td><? echo get_member_post($mb_user) ?></td>
        <td><? echo get_profile($mb_user) ?></td>
		<!--<td><?
        	/*if ($mb_facebook == 0){ 
				if ($thumbnail != ""){
					echo "<img src=\"".$thumbnail."\" />"; 
				}
			}else if ($mb_facebook == 1){ 
				echo "<a href=\"http://www.facebook.com/profile.php?id=".$mb_user."&sk=info\" target=\"_blank\"><img src=\"https://graph.facebook.com/".$mb_user."/picture\" title=\"Profile\"></a>";
			}*/
			?><? //echo get_thumbnail($mb_user) ?></td>-->
        <td align="center"><? echo get_member_thumbnail($mb_user, 20, 20) ?></td>   
        <td><? echo $mb_email ?></td>
        <td><? echo $mb_updated_date ?></td>
        <td align="center"><? echo $mb_date ?></td>
        <!--<td><a href="javascript:IPSearch_KR('<? echo $mb_ip ?>');"><? echo $mb_ip ?></a></td>-->
        <td align="center"><? echo get_ip_search($mb_ip) ?></td>
        <td align="center"><? echo $os ?></td>
        <td align="center"><? echo $brow ?></td>
        <td align="center"><? echo $mb_login_cnt ?></td>
        <td align="center"><? echo get_member_cnt_board($mb_user)." (".get_member_cnt_board_public($mb_user)."/".get_member_cnt_board_private($mb_user).")" ?></td>
        <td align="center"><? echo get_post_sum($mb_user). " (".get_post_sum_public($mb_user)."/".get_post_sum_private($mb_user).")" ?></td>
        <td align="right"><? echo get_point_sum($mb_user) ?>p</td>
        <!--<td><a href="/<? //echo $bs_user_url ?>" target="_blank"><? //echo $bs_user_url ?></a> (<? //echo $bs_hit ?>)</td>-->
        <td align="center"><? //echo ($mb_open == 0) ? "√" : "" ?><input type="checkbox" <? echo ($mb_open == 0) ? "checked" : "" ?> disabled /></td>
        <td align="center"><? //echo ($mb_mailling == 0) ? "√" : "" ?><input type="checkbox" <? echo ($mb_mailling == 0) ? "checked" : "" ?> disabled /></td>
        <td align="center"><? echo get_level($mb_level) ?></td>
        <td align="center"><? echo get_login_method($mb_facebook) ?></td>
        <td align="center"><button id="set" title="<? echo $mb_user ?>">set</button></td>
        <td align="center"><? if ($mb_level != $common_admin_level){ ?><button id="delete" title="<? echo $mb_user ?>">delete</button><? } ?></td>
	</tr>
<?
	$number--;
} //for
?>
</table>
<br />
<div align="center">
<? echo get_paging($common_admin_list_block, $page, $total_page, $common_path."admin/?mode=".$_GET['mode']."&type=".$_GET['type']."&page="); ?>
</div>
<br />





<div id="hidden-message-delete" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>한번 삭제한 자료는 복구할 방법이 없습니다.<br />정말 삭제하시겠습니까?</p>
    <form id="delete">
    	<input type="hidden" value="del" name="mode" />
    	<input type="hidden" id="delete" name="id"  />
    </form>
</div>


<? if (isset($_GET['user'])){  ?>
<div id="hidden-message-set" title="<? echo $_GET['user'] ?>" style="display:none">
<?
//$sql = "select * from remember_member where mb_user ='".trim($_GET['user'])."'";
$sql = "select a.*, b.* from remember_member as a join remember_boardset as b on a.mb_user = b.mb_user where a.mb_user = '".trim($_GET['user'])."'";
$tmp_result = mysql_query($sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);

$mb_email = $tmp_row['mb_email'];
$mb_updated_date = $tmp_row['mb_updated_date'];
$mb_date = $tmp_row['mb_date'];
$mb_ip = $tmp_row['mb_ip'];
$mb_level = $tmp_row['mb_level'];
$mb_blacklist_date = $tmp_row['mb_blacklist_date'];
$mb_open_mailling_explode = explode("|", $tmp_row['mb_open_mailling']);
$mb_open = $mb_open_mailling_explode[0];
$mb_mailling = $mb_open_mailling_explode[1];
$mb_facebook = $tmp_row['mb_facebook'];
$mb_login_cnt = $tmp_row['mb_login_cnt'];
$mb_nick = $tmp_row['mb_nick'];
$bs_subject = $tmp_row['bs_subject'];
$bs_setting_explode = explode("|", $tmp_row['bs_setting']);
$bs_scrolling = $bs_setting_explode[0];
$bs_wysiwyg = $bs_setting_explode[1];
$bs_rows_explode = explode("|", $tmp_row['bs_rows']);
$bs_rows_web = $bs_rows_explode[0];
$bs_rows_mobile = $bs_rows_explode[1];
//$bs_skin = $tmp_row['bs_skin'];
$bs_skin_explode = explode("|", $tmp_row['bs_skin']);
$bs_skin_web = $bs_skin_explode[0];
$bs_skin_mobile = $bs_skin_explode[1];
$bs_user_url = $tmp_row['bs_user_url'];
//echo $_GET['user']." / ".$mb_email." / ".$mb_updated_date." / ".$mb_date." / ".$mb_ip." / ".$mb_level." / ".$mb_blacklist_date." / ".$mb_open." / ".$mb_mailling." / ".$mb_facebook." / ".$mb_login_cnt." / ".$bs_subject." / ".$bs_setting." / ".$bs_rows_web." / ".$bs_rows_mobile;

?>
<form id="set">
<input type="hidden" name="mode" value="set" />
<input type="hidden" name="user" value="<? echo $_GET['user'] ?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tb_11">
	<tr>
        <td width="25%" align="right">e-메일 : &nbsp;</td>
        <td><input type="text" name="email" value="<? echo $mb_email ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td width="25%" align="right">별명 : &nbsp;</td>
        <td><input type="text" name="nickname" value="<? echo $mb_nick ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">회원가입일 : &nbsp;</td>
        <td><input type="text" name="updated_date" value="<? echo $mb_updated_date ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">최근접속일 : &nbsp;</td>
        <td><input type="text" name="date" value="<? echo $mb_date ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">IP : &nbsp;</td>
        <td><input type="text" name="ip" value="<? echo $mb_ip ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">회원권한 : &nbsp;</td>
        <td><input type="text" name="level" value="<? echo $mb_level ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>       
    <tr>
        <td align="right">제재일시 : &nbsp;</td>
        <td><input type="text" name="blacklist_date" value="<? echo $mb_blacklist_date ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">정보공개 : &nbsp;</td>
        <td><input type="text" name="open" value="<? echo $mb_open ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">메일수신 : &nbsp;</td>
        <td><input type="text" name="mailling" value="<? echo $mb_mailling ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">페이스북 : &nbsp;</td>
        <td><input type="text" name="facebook" value="<? echo $mb_facebook ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">로그인횟수 : &nbsp;</td>
        <td><input type="text" name="login_cnt" value="<? echo $mb_login_cnt ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">게시판제목 : &nbsp;</td>
        <td><input type="text" name="subject" value="<? echo $bs_subject ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">자동스크롤 : &nbsp;</td>
        <td><input type="text" name="scrolling" value="<? echo $bs_scrolling ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">위지윅 : &nbsp;</td>
        <td><input type="text" name="wysiwyg" value="<? echo $bs_wysiwyg ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">PC목록수 : &nbsp;</td>
        <td><input type="text" name="rows" value="<? echo $bs_rows_web ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
        <td align="right">모바일목록수 : &nbsp;</td>
        <td><input type="text" name="rows_m" value="<? echo $bs_rows_mobile ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
    	<td align="right">PC스킨 : &nbsp;</td>
        <td><input type="text" name="skin" value="<? echo $bs_skin_web ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
    	<td align="right">모바일스킨 : &nbsp;</td>
        <td><input type="text" name="skin_m" value="<? echo $bs_skin_mobile ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>
    <tr>
    	<td align="right">공개주소 : &nbsp;</td>
        <td><input type="text" name="user_url" value="<? echo $bs_user_url ?>" class="text ui-widget-content ui-corner-all" /></td>
    </tr>   
</table>   
</form>
</div>
<? } //if (isset($_GET['user'])){ ?>











<!--<?
$sql = "select * from remember_member order by mb_updated_date desc limit 100";
$result = mysql_query($sql, $connect); 
?>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
<?
while ($row = mysql_fetch_array($result)){
	$mb_user = $row['mb_user'];
	$mb_updated_date = $row['mb_updated_date'];
	$mb_date = $row['mb_date'];
	$mb_ip = $row['mb_ip'];
?>
	<tr>
    	<td><? echo $mb_user ?></td>
        <td><? echo $mb_updated_date ?></td>
        <td><? echo $mb_date ?></td>
        <td><? echo $mb_ip ?></td>
	</tr>
<? } ?>
</table>-->


