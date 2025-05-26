<? 
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

if ($total_record > $scale){ 


if (isset($_GET['search'])) {
        $search_page = "?search=".$_GET['search']."&";
    }else{
        $search_page = "?";
    }

?>

<div style="padding:0;">            
<fieldset class="ui-grid-a">
<?
$start_page = floor($page-1);
$end_page = $start_page + 1;

if ($total_page <= $end_page) $end_page = $total_page; 

if ($start_page>0) {
    //$prev_page = $start_page - 1;
	$prev_page = $start_page;
	echo "<div class=\"ui-block-a\"><a href=\"".$search_page."page=".$prev_page."\" data-ajax=\"false\" data-role=\"button\">이전</a></div>";
}else{
    echo "<div class=\"ui-block-a\"><a href=\"#\" data-role=\"button\"><font color=\"#999999\">이전</font></a></div>";	
}

if ($end_page < $total_page) {
    $next_page = $end_page + 1;
	echo "<div class=\"ui-block-b\"><a href=\"".$search_page."page=".$next_page."\" data-ajax=\"false\" data-role=\"button\">다음</a></div>";
}else{
    echo "<div class=\"ui-block-b\"><a href=\"#\" data-role=\"button\"><font color=\"#999999\">다음</font></a></div>";
}
?>
</fieldset>
</div>

<? } ?>

