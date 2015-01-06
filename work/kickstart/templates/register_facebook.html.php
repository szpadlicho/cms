<!--
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '336607323190430',
      xfbml      : true,
      version    : 'v2.2'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<!--
<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>
-->
<?php
session_start();
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
// added in v4.0.0
require_once './php-sdk/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
//use Facebook\GraphUser;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

// start session
//unset($session);
// init app with app id and secret
FacebookSession::setDefaultApplication('336607323190430', '5c5992964eab69ea089f1c62f8b69328');

// login helper with redirect_uri

$helper = new FacebookRedirectLoginHelper('http://localhost/htdocs/cms/work/kickstart/index.php?con=register&action=facebook' );

try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}

// see if we have a session

if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();

  // print data
  //echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
  var_dump($graphObject);
} else {
  // show login url
  echo '<a href="' . $helper->getLoginUrl(array( 'email', 'user_hometown' )) . '">Login</a>';//'user_friends', 'public_profile', 'user_likes', 'user_location',
}
