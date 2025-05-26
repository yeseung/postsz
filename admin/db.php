<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가

/*
echo "<strong>회원</strong><br />";
$sql = "select * from remember_member";
$result = mysql_query($sql, $connect);
$fetch_assoc_member = mysql_fetch_assoc($result);
print_r($fetch_assoc_member);
echo "<br><br>";


echo "<strong>메모 게시판</strong><br />";
$sql = "select * from remember_board_admin";
$result = mysql_query($sql, $connect);
$fetch_assoc_board_admin = mysql_fetch_assoc($result);
print_r($fetch_assoc_board_admin);
echo "<br><br>";


echo "<strong>설정</strong><br />";
$sql = "select * from remember_boardset";
$result = mysql_query($sql, $connect);
$fetch_assoc_boardset = mysql_fetch_assoc($result);
print_r($fetch_assoc_boardset);
echo "<br><br>";


echo "<strong>공개</strong><br />";
$sql = "select * from remember_short_url";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>친구</strong><br />";
$sql = "select * from remember_myfriends";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>쪽지</strong><br />";
$sql = "select * from remember_memo";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>광고</strong><br />";
$sql = "select * from remember_advertisement";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>검색</strong><br />";
$sql = "select * from remember_search";
$result = mysql_query($sql, $connect);
$fetch_assoc_boardset = mysql_fetch_assoc($result);
print_r($fetch_assoc_boardset);
echo "<br><br>";


echo "<strong>신고</strong><br />";
$sql = "select * from remember_spam";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>포인트</strong><br />";
$sql = "select * from remember_point";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>스크랩</strong><br />";
$sql = "select * from remember_scrap";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>현재접속자</strong><br />";
$sql = "select * from remember_login";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>로그인기록</strong><br />";
$sql = "select * from remember_login_history";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>트위터 등록</strong><br />";
$sql = "select * from remember_twitter_post";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<strong>공지사항</strong><br />";
$sql = "select * from remember_notice_board";
$result = mysql_query($sql, $connect);
$fetch_assoc_short_url = mysql_fetch_assoc($result);
print_r($fetch_assoc_short_url);
echo "<br><br>";


echo "<br><br>";
*/

?>




<strong>db Table Column Alter</strong>
<form>
alter table <select name="table" id="table">
    <option selected>-------------------------------------------</option>
    <option>remember_member</option>
    <option>remember_board_{mb_user}</option>
    <option>remember_boardset</option>
    <option>remember_short_url</option>
    <option>remember_myfriends</option>
    <option>remember_memo</option>
    <option>remember_advertisement</option>
    <option>remember_search</option>
    <option>remember_spam</option>
    <option>remember_point</option>
    <option>remember_scrap</option>
    <option>remember_login</option>
    <option>remember_login_history</option>
    <option>remember_twitter_post</option>
    <option>remember_notice_board</option>
    
</select> <select name="amcd" id="amcd">
    <option selected>-------------------------------------------</option>
    <option value="add">컬럼추가 add</option>
    <option value="modify">컬럼타입 변경 modify</option>
    <option value="change">변경change</option>
    <option value="drop">삭제 drop</option>
</select> column <input type="text" name="column" id="column" style="width:500px">&nbsp;
<a href="#" id="submit_db">확인</a>
</form>
<br>
<!--<textarea id="wrdLatest" style="width:100%; height:100px;display:none"></textarea>-->
<div class="wrdLatest"></div>

<br><br>







