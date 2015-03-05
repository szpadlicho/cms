<?php
session_start();
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

// ini_set('xdebug.var_display_max_depth', -1);
// ini_set('xdebug.var_display_max_children', -1);
// ini_set('xdebug.var_display_max_data', -1);
// added in v4.0.0


// start session
//unset($session);
// init app with app id and secret
FacebookSession::setDefaultApplication('336607323190430', '5c5992964eab69ea089f1c62f8b69328');

// login helper with redirect_uri

$helper = new FacebookRedirectLoginHelper('http://localhost/htdocs/cms/work/kickstart/index.php?con=register&action=facebook&request=add' );// do edit

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
  $graphObject = $response->getGraphObject()->asArray();
  var_dump($graphObject);
  //return $graphObject;
  // print data
  //echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
} else {
  // show login url
  //echo '<a href="' . $helper->getLoginUrl(array( 'email', 'user_hometown' )) . '">Login</a>';//'user_friends', 'public_profile', 'user_likes', 'user_location',
  header ('Location: '.$helper->getLoginUrl(array( 'email', 'user_hometown' )));
}

?>