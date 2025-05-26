<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("lib/common.php");
include_once ("lib/dbconn.php");
include_once ("lib/function.php");
require_once 'lib/google/src/Google_Client.php';
require_once 'lib/google/src/contrib/Google_Oauth2Service.php';

$client = new Google_Client();
$client->setClientId($common_google_setClientId);
$client->setClientSecret($common_google_setClientSecret);
$client->setRedirectUri($common_google_setRedirectUri);

$oauth2 = new Google_Oauth2Service($client);

if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['token'] = $client->getAccessToken();
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	return;
}
if (isset($_SESSION['token'])) {
	$client->setAccessToken($_SESSION['token']);
}
if ($client->getAccessToken()) {
	$gg_user = $oauth2->userinfo->get();
			
	$_SESSION['gg_id'] = $gg_user['id'];
	$_SESSION['gg_email'] = $gg_user['email'];
	$_SESSION['gg_name'] = $gg_user['name'];
	$_SESSION['gg_picture'] = $gg_user['picture']."?sz=50";
	$_SESSION['gg_gender'] = $gg_user['gender'];
	$_SESSION['fb_facebook'] = 3;
	//$_SESSION['token'] = $client->getAccessToken(); //The access token may have been updated lazily.
	
	include_once ("process/login.google.php");

	
}else{
	die("Error");
}	
?>