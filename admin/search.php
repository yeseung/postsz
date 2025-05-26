<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
  	<td><strong>일간 인기 검색어</strong></td>
    <td><strong>주간 인기 검색어</strong></td>
    <td><strong>월간 인기 검색어</strong></td>
  </tr>
  <tr>  
    <td valign="top">
    	<?
        $sql = "select se_word, count(se_word) as cnt from remember_search where se_date > date_add(now(), interval - 1 day) group by se_word order by count(se_word) desc limit ".$common_admin_search;	 
        $result = mysql_query($sql, $connect);
        while ($row = mysql_fetch_array($result)){  
            $word = htmlspecialchars($row['se_word']);
            $cnt = $row['cnt'];
            $num ++;
            echo $num.". ".$word." (".$cnt.")<br />"; 
        }
        $num = 0;
        ?>	
	</td>
    <td valign="top">
		<?
        $sql = "select se_word, count(se_word) as cnt from remember_search where se_date > date_add(now(), interval - 7 day) group by se_word order by count(se_word) desc limit ".$common_admin_search;	 
        $result = mysql_query($sql, $connect);
        while ($row = mysql_fetch_array($result)){  
            $word = htmlspecialchars($row['se_word']);
            $cnt = $row['cnt'];
            $num ++;
            echo $num.". ".$word." (".$cnt.")<br />";
        }
        $num = 0;
        ?>
	</td>
    <td valign="top">
		<?
        $sql = "select se_word, count(se_word) as cnt from remember_search where se_date > date_add(now(), interval - 1 month) group by se_word order by count(se_word) desc limit ".$common_admin_search;	 
        $result = mysql_query($sql, $connect);
        while ($row = mysql_fetch_array($result)){  
            $word = htmlspecialchars($row['se_word']);
            $cnt = $row['cnt'];
            $num ++;
            echo $num.". ".$word." (".$cnt.")<br />";
        }	
        $num = 0;
        ?>
    </td>
  </tr>
</table>

<br /><br />

<?

$page = $_GET[page];
if (!$page) $page = 1;

$sql = "select * from remember_search order by se_id desc";
$result = mysql_query($sql, $connect);
$total_record = mysql_num_rows($result);

$scale = $common_admin_rows;

if ($total_record % $scale == 0){ 
	$total_page = floor($total_record/$scale); 
}else{
	$total_page = floor($total_record/$scale) + 1;
}

$start = ($page - 1) * $scale; 
$number = $total_record - $start;
?>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
  	<td><strong>번호</strong></td>
    <td><strong>검색어</strong></td>
    <td><strong>아이디</strong></td>
    <!--<td><strong>사진</strong></td>-->
    <td><strong>날짜</strong></td>
    <td><strong>IP</strong></td>
    <td><strong>운영체제</strong></td>
    <td><strong>브라우저</strong></td>
    <td><strong>삭제</strong></td>
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$se_id = $row['se_id'];
	$mb_user = $row['mb_user'];
	
	/*$tmp_sql = "select mb_facebook from remember_member where mb_user = '".$mb_user."'";
	$tmp_result = mysql_query($tmp_sql, $connect);
	$tmp_row = mysql_fetch_array($tmp_result);
	$mb_facebook = $tmp_row['mb_facebook'];*/
	
	$se_word = htmlspecialchars($row['se_word']);
	$se_date = $row['se_date'];
	$se_ip = $row['se_ip'];
	$brow = get_brow($row['se_agent']);
    $os = get_os($row['se_agent']);
?>
	<tr>
    	<td><? echo $number ?></td>
        <td><? echo $se_word ?></td>
        <!--<td><? echo get_member_user_url($mb_user) ?></td>-->
        <td><? echo get_profile($mb_user) ?></td>
        <!--<td><? echo $mb_facebook == 1 ? "<a href=\"http://www.facebook.com/profile.php?id=".$mb_user."&sk=info\" target=\"_blank\"><img src=\"https://graph.facebook.com/".$mb_user."/picture\" title=\"Profile\" width=\"22\"></a>" : "&nbsp;" ?><? //echo get_member_thumbnail($mb_user) ?></td>-->
        <td><? echo $se_date ?></td>
        <!--<td><a href="javascript:IPSearch_KR('<? echo $se_ip ?>');"><? echo $se_ip ?></a></td>-->
        <td><? echo get_ip_search($se_ip) ?></td>
        <td><? echo $os ?></td>
        <td><? echo $brow ?></td>
        <td><button id="search_del" title="<? echo $se_id ?>">delete</button></td>
	</tr>
<?
	$number--;
} //for
?>
</table>

<br />
<div align="center">
<? echo get_paging($common_admin_list_block, $page, $total_page, $common_path."admin/?mode=".$_GET['mode']."&page="); ?>
</div>
<br />



<!--<div id="hidden-message-search-del" style="display:none">
	<p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 25px 0;"></span>한번 삭제한 자료는 복구할 방법이 없습니다.<br />정말 삭제하시겠습니까?</p>
    <form id="search_del">
    	<input type="hidden" value="del" name="mode" />
    	<input type="hidden" id="search_del" name="num"  />
    </form>
</div>-->
