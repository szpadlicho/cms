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
//FacebookSession::setDefaultApplication('336607323190430', '5c5992964eab69ea089f1c62f8b69328');
FacebookSession::setDefaultApplication('336602646524231', '05b6c7811be542c1a18e036b3c4c24e6');

// login helper with redirect_uri

$helper = new FacebookRedirectLoginHelper('http://localhost/htdocs/cms/work/kickstart/index.php?con=register&action=facebook' );// do edit

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
  //var_dump($graphObject);
  $graphObject['verified'] == true ? $active = 1 : $active = 0;
  include_once 'mod_register.php';
  $register = new Model_Register_Connect();
    $arr_val = array(
        'first_name'    => $graphObject['first_name'],
        'last_name'     => $graphObject['last_name'],
        'email'         => $graphObject['email'],
        /*
        'password'      =>'VARCHAR(50)',
        'phone'         =>'VARCHAR(50)',
        'country'       =>'VARCHAR(50)',
        'post_code'     =>'VARCHAR(50)',
        'town'          =>'VARCHAR(50)',    
        'street'        =>'VARCHAR(50)',
        */
        'active'        => $active,
        /*
        'pref'          =>'VARCHAR(50)',
        'create_data'   =>'DATETIME NOT NULL',
        'update_data'   =>'DATETIME NOT NULL',
        */
        'facebook_id'   => $graphObject['id'],
        'facebook_link' => $graphObject['link']
    );
  $arr_res = $register->addUserFromFacebook('users', $arr_val);
  if ($arr_res[0] === true) {
        include_once 'view/vie_register.php';
        $view = new View_Register_Connect();
        $view->successShow($arr_res);
    } else {
        include_once 'view/vie_register.php';
        $view = new View_Register_Connect();
        $view->errorShow($arr_res);
    }
  //header ('Location: index.php');
  
  //return $graphObject;
  // print data
  //echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
} else {
  // show login url
  echo '<a href="' . $helper->getLoginUrl(array( 'email', 'user_hometown' )) . '">Login</a>';//'user_friends', 'public_profile', 'user_likes', 'user_location',
  //header ('Location: '.$helper->getLoginUrl(array( 'email', 'user_hometown' )));
}

?>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '336602646524231',
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
<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>