<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가



if (isset($_GET['search'])){
	if (!$_GET['date']){
		$sql = "select bo_id from remember_board_".trim($_SESSION['user'])." where bo_id < ".$_GET['id']." and bo_content like '%".htmlspecialchars($_GET['search'])."%' order by bo_id desc limit 1";
	}else{
		$sql = "select bo_id from remember_board_".trim($_SESSION['user'])." where bo_id < ".$_GET['id']." and bo_content like '%".htmlspecialchars($_GET['search'])."%' and left(bo_date,10) = '".get_date_time($_GET['date'])."' order by bo_id desc limit 1";
	}	
}else{
	if (!$_GET['date']){
		$sql = "select bo_id from remember_board_".trim($_SESSION['user'])." where bo_id < ".$_GET['id']." order by bo_id desc limit 1";
	}else{
		$sql = "select bo_id from remember_board_".trim($_SESSION['user'])." where bo_id < ".$_GET['id']." and left(bo_date,10) = '".get_date_time($_GET['date'])."' order by bo_id desc limit 1";
	}	
}
$result_prev = mysql_query($sql, $connect);
$row_prev = mysql_fetch_array($result_prev);
$bo_id_prev = $row_prev['bo_id'];


if (isset($_GET['search'])){
	if (!$_GET['date']){
		$sql = "select bo_id from remember_board_".trim($_SESSION['user'])." where bo_id > ".$_GET['id']." and bo_content like '%".htmlspecialchars($_GET['search'])."%' order by bo_id limit 1";
	}else{
		$sql = "select bo_id from remember_board_".trim($_SESSION['user'])." where bo_id > ".$_GET['id']." and bo_content like '%".htmlspecialchars($_GET['search'])."%' and left(bo_date,10) = '".get_date_time($_GET['date'])."' order by bo_id limit 1";
	}	
}else{
	if (!$_GET['date']){
		$sql = "select bo_id from remember_board_".trim($_SESSION['user'])." where bo_id > ".$_GET['id']." order by bo_id limit 1";
	}else{
		$sql = "select bo_id from remember_board_".trim($_SESSION['user'])." where bo_id > ".$_GET['id']." and left(bo_date,10) = '".get_date_time($_GET['date'])."' order by bo_id limit 1";
	}	
}
$result_next = mysql_query($sql, $connect);
$row_next = mysql_fetch_array($result_next);
$bo_id_next = $row_next['bo_id'];


if (isset($_GET['search'])){
	if (!$_GET['date']){
		$url_page_search = "?search=".htmlspecialchars($_GET['search'])."&";
	}else{
		$url_page_search = "?date=".$_GET['date']."&search=".htmlspecialchars($_GET['search'])."&";
	}
}else{
	if (!$_GET['date']){
		$url_page_search = "?";
	}else{
		$url_page_search = "?date=".$_GET['date']."&";
	}	
}

if (isset($_GET['page'])){
	if (!($_GET['search'])){
		if (!$_GET['date']){
			$url_page = $common_path."?page=".$_GET['page'];
		}else{
			$url_page = $common_path."?date=".$_GET['date']."&page=".$_GET['page'];
		}
	}else{
		if (!$_GET['date']){
			$url_page = $common_path."?search=".htmlspecialchars($_GET['search'])."&page=".$_GET['page'];
		}else{
			$url_page = $common_path."?date=".$_GET['date']."&search=".htmlspecialchars($_GET['search'])."&page=".$_GET['page'];
		}
	}		
}else{
	if (!($_GET['search'])){
		if (!$_GET['date']){
			$url_page = $common_path;
		}else{
			$url_page = $common_path."?date=".$_GET['date'];
		}
	}else{
		if (!$_GET['date']){
			$url_page = $common_path."?search=".htmlspecialchars($_GET['search']);
		}else{
			$url_page = $common_path."?date=".$_GET['date']."&search=".htmlspecialchars($_GET['search']);
		}
	}		
}

?>




<div id="prev_next_list">
    <p id="prev_next"><? if (isset($bo_id_prev)){ ?><a href="/view.php<? echo $url_page_search ?>id=<? echo $bo_id_prev ?>"><img src="/skin/<? echo $common_skin ?>/img/icon_prev.png" title="이전글" class="png24" /></a><? } ?><? if (isset($bo_id_next)){ ?><a href="/view.php<? echo $url_page_search ?>id=<? echo $bo_id_next ?>"><img src="/skin/<? echo $common_skin ?>/img/icon_next.png" title="다음글" class="png24" /></a><? } ?></p>
    <p id="list"><a href="<? echo $url_page ?>"><img src="/skin/<? echo $common_skin ?>/img/icon_list.png" title="목록" class="png24" /></a></p>
</div>

