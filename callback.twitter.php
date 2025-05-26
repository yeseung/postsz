<?
session_start();
ob_start();
header("content-type:text/html; charset=utf-8");
include_once ("lib/common.php");
include_once ("lib/dbconn.php");
include_once ("lib/function.php");
require_once('lib/twitteroauth.php');
require_once('lib/config.twitter.php');

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: ./logout.php');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);


/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $access_token;

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {
  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';
  
		
		/* If method is set change API call made. Test is called by default. */
		$content = $connection->get('account/verify_credentials');

		$_SESSION['tw_id'] = $content->id;
		$_SESSION['tw_screen_id'] = $content->screen_name;
		$_SESSION['tw_name'] = $content->name;
		$_SESSION['tw_profile_image'] = $content->profile_image_url;
		$_SESSION['tw_profile'] = $content->description;
		$_SESSION['fb_facebook'] = 2;
		include_once ("process/login.twitter.php");
		//echo $_SESSION['tw_id']." - ".$_SESSION['tw_screen_id']." - ".$tw_user. " / ".$tw_name." / ".$tw_screen_user." / ".$tw_profile_image." / ".$tw_profile;

  
  
  
  
  //header('Location: ./index.php');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  header('Location: ./logout.php');
}


?>