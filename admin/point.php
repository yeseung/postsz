<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

//포인트 정리
$tmp_sql = "select mb_user from remember_member order by mb_updated_date"; 
$tmp_result = mysql_query($tmp_sql, $connect); 

while ($tmp_row = mysql_fetch_array($tmp_result)){ 
	$tmp_mb_user = $tmp_row['mb_user'];
	
	$tmp_sql1 = "select count(*) as cnt from remember_point where mb_user = '".$tmp_mb_user."' order by po_id desc";
	$tmp_result1 = mysql_query($tmp_sql1, $connect);
	$tmp_row1 = mysql_fetch_array($tmp_result1);
	$tmp_point_cnt = $tmp_row1['cnt'];
	
	if ($tmp_point_cnt >= $common_point_clear){
		
		$tmp_sql2 = "select sum(po_point) as point_sum from remember_point where mb_user = '".$tmp_mb_user."'";
		$tmp_result2 = mysql_query($tmp_sql2, $connect);
		$tmp_row2 = mysql_fetch_array($tmp_result2);
		$tmp_point_sum = $tmp_row2['point_sum'];
		
		if ($tmp_point_sum){
			$sql = "delete from remember_point where mb_user = '".$tmp_mb_user."'"; 
			mysql_query($sql, $connect); 
			
			$sql = "insert into remember_point (mb_user, po_point, po_content, po_date) "; 
			$sql .= "values ('".$tmp_mb_user."', ".$tmp_point_sum.", '포인트 정리', now())"; 
			mysql_query($sql, $connect); 
		}
		//echo $tmp_mb_user." / ".$tmp_point_cnt." / ".$common_point_clear." / ".$sql."<br>";	
	}
	
}
?>

			
<form id="insert_point">
<input type="hidden" name="mode" value="write">
<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td><strong>회원아이디</strong></td>
    <td><strong>포인트 내용</strong></td>
    <td><strong>포인트</strong></td>
    <td><strong>입력</strong></td>
    <td><strong>정리</strong></td>
  </tr>
  <tr>
    <td><input type="text" name="user" id="user" style="width:200px"></td>
    <td><input type="text" name="content" id="content" style="width:500px"></td>
    <td><input type="text" name="point" id="point" style="width:200px"></td>
    <td><a href="#" id="submit_point">확인</a></td>
    <td><a href="#" id="update_point">포인트 정리</a></td>
  </tr>
</table>
</form>

<br /><br />

<form id="del_point">
<input type="hidden" name="mode" value="del">

<?
$page = $_GET[page];
if (!$page) $page = 1;

//$sql = "select distinct mb_user from remember_point order by mb_user desc";
$sql = "select * from remember_point order by po_id desc";
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

$tmp_sql = "select sum(po_point) as point_all_sum from remember_point";
$tmp_result = mysql_query($tmp_sql, $connect);
$tmp_row = mysql_fetch_array($tmp_result);
$point_all_sum = number_format($tmp_row['point_all_sum']);
?>

전체 포인트 합계 : <? echo $point_all_sum ?> point<br />

<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
  	<td><input type="checkbox" id="total" /><!--<strong>번호</strong>--></td>
    <td><strong>아이디</strong></td>
    <td><strong>일시</strong></td>
    <td><strong>포인트 내용</strong></td>
    <td><strong>포인트</strong></td>
    <td><strong>포인트 합계</strong></td>
    <!--<td><strong>삭제</strong></td>-->
  </tr>
<?
for ($i = $start ; $i < $start + $scale && $i < $total_record ; $i++){
	mysql_data_seek($result, $i);
	$row = mysql_fetch_array($result);
	$po_id = $row['po_id'];
	$mb_user = $row['mb_user'];
	$po_point = $row['po_point'];
	$po_content = $row['po_content'];
	$po_date = str_replace("-", "/", (substr($row['po_date'], 2, 14)));
	
?>
	<tr>
    	<td><input type="checkbox" id="del[]" name="del[]" value="<? echo $po_id ?>"><? //echo $number ?></td>
        <td><? echo get_profile($mb_user) ?></td>
        <td><? echo $po_date ?></td>
        <td><? echo $po_content ?></td>
        <td><? echo $po_point ?></td>
        <td><? echo get_point_sum($mb_user, $po_point, $po_id) ?> point</td>
        <!--<td><button id="point_del" title="<? echo $po_id ?>">delete</button></td>-->
	</tr>
<?
	$number--;
} //for
?>
</table>
<input type="submit" value="삭제" style="font-size:11px;" />
</form>


<br />
<div align="center">
<? echo get_paging($common_admin_list_block, $page, $total_page, $common_path."admin/?mode=".$_GET['mode']."&page="); ?>
</div>
<br />


</div>



<script type="text/javascript"> 
//<![CDATA[ 

$(document).ready(function() { 

	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "input:submit, button" ).button();
	$( "#button" ).buttonset();

	
	$('#total').click(function(){
		if ($("input#total").is(":checked")) { 
			$('input:checkbox[id^=del[]]:not(checked)').attr("checked", true); 
		} else { 
			$('input:checkbox[id^=del[]]:checked').attr("checked", false); 
		} 	
	}); 

	$( "form#del_point" ).submit(function() {
		var answer = confirm ('선택된 포인트를 삭제하시겠습니까?');
  		if(answer){
			$.post('/process/adm.point.php', $("form#del_point").serialize(), function(data) {
				//alert(data);
				self.location.reload();
			});
			return false;
		}else{
			return false;
		}
	});

});

//]]> 
</script>
