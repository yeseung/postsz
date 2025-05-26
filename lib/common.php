<?
define("_REMEMBER_", TRUE); // 이 상수가 정의되지 않으면 각각의 개별 페이지는 별도로 실행될 수 없음

$common_my_ip = ""; //my com

$common_date_since = date("Y") - 2012; //since 2012
$common_date_ymd = date("Y-m-d");

$common_host = "localhost"; // 호스트명
$common_id = ""; // 계정아이디
$common_pass = ""; // 계정비밀번호
$common_db_name = ""; // 데이터베이스명

$common_path = "http://".$_SERVER['HTTP_HOST']."/"; //path
$common_title = "온라인 메모장 포스트제트"; //title
$common_title_tail = "postsz.com β"; //title tail

$common_logo = $common_path."img/logo_50.png"; //logo

$common_facebook_app_id = ""; //페이스북 ID/API 키
$common_facebook_app_secret = ""; //페이스북 시크릿 코드

$common_google_setClientId = ""; //google API
$common_google_setClientSecret = "";
$common_google_setRedirectUri = $common_path."callback.google.php";
//$common_google_setDeveloperKey = "AIzaSyCnDfZERtZBDk10zx8v0IOxysYSZIcVxjY";

$publickey = ""; //reCAPTCHA 공개키
$privatekey = ""; //reCAPTCHA 비공개키

$common_pbank_donate = ""; //p뱅킹 후원

$common_email_from = "포스트제트"; //보내는 분
//$common_email = ""; //e-메일
$common_email_reply_to = "noreply@untitle.com"; //반송될 주소

$common_admin = "admin"; //관리자
$common_admin_level = 127; //관리자 level 

$common_resize_img = 650; //이미지 리사이즈

$common_ip_exceed = 3; //아이디 같은 IP주소로 3번을 초과

$common_point_register = 100; //포인트 회원가입
$common_point_login = 10; //포인트 로그인
$common_point_write = 10; //포인트 글쓰기
$common_point_email_auth = 100; //메일 인증

$common_point_clear = 50; //포인트 정리 - 최근 50건 이전의 포인트 부여 내역

$common_memo_auto_del = 30; //읽은 쪽지 자동 삭제
$common_history_auto_del = 90; //로그인 기록 자동 삭제
$common_email_auth_del = 10; //인증 메일 자동 삭제

$common_current_visitor = 10; //현재 접속자 자동 삭제

$common_path_str = "postsz_com"; //process/excel.php
$common_date = date("ymdHi"); //process/excel.php

if (isset($_SESSION['user'])){
	$common_skin = $_SESSION['set_skin']; //web skin
	$common_skin_m = $_SESSION['set_skin_m']; //mobile skin
}else{
	$common_skin = "default"; //web skin
	$common_skin_m = "default"; //mobile skin
}

//$common_cautionWords = "test";
$common_cautionWords = "help,friend,admin,open,openapi,dev,developers,adm,administrator,img,js,lib,print,process,rails,rss,skin,skin.mobile,thumbnail,tinymce,angel,1004,zzang,jjang,test,temp,webmaster,manager,root,sysop,guest,donate,feedback,forget,restoration"; //금지어

$common_open_api_demo_key = "";
$common_open_api_title = "";
$common_open_api_link = $common_path."developers";
$common_open_api_description = "";

$common_public_rows = 10; //공개 주소 목록수
$common_public_rows_m = 10; //공개 주소 모바일 목록수

$common_limit_myfriends = 10; //친구들 목록수
	
$common_short_url = 6; //짧은 주소
$common_subject_len = 50; //list.php 제목 길이
$common_content_len = 400; //list.php 내용 길이
$common_content_len_m = 300; //skin.mobile list.php 내용 길이
$common_list_block = 7; // 한페이지에 보여지는 페이지수
$common_auto_code = 5; //자동방지

$common_admin_list_block = 10; // 관리자 한페이지에 보여지는 페이지수
$common_admin_rows = 15; //관리자 목록수
$common_admin_rows_member = 10; //관리자 멤버 목록수
$common_admin_public = 1; //공개
$common_admin_search = 10; //인기 검색어
$common_admin_content_len = 50; //public.url.php 내용 길이

$common_help_title = "온라인 메모장 웹/모바일 서비스 - 나만의 아이디어와 생각들, 간단한 메모, 기록을 좋아하시는 분이나, 업무/학업상 평소에 메모를 많이 하시던 분, 수집광 등. SNS 연동 서비스 제공.";

$common_tweet_id = "postsz"; // 트위터 아이디
$common_tweet_via = "#postsz"; // 트위터 via

$common_email = "webmaster(at)postsz.com"; //e-메일
$common_contact_me = "https://docs.google.com/spreadsheet/viewform?formkey="; //Contact Me
$common_adm_contact_me = "https://docs.google.com/spreadsheet/ccc?key="; //관리자 Contact Me

?>