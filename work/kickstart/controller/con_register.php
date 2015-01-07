<?php
if (isset($_POST['register'])) {
    include_once 'model/mod_register.php';
    $register = new Model_Register_Connect();
    $arr_res = $register->checkUser('users', $_POST);
    if ($arr_res[0] === true) {
        include_once 'view/vie_register.php';
        $view = new View_Register_Connect();
        $view->successShow($arr_res);
    } else {
        include_once 'view/vie_register.php';
        $view = new View_Register_Connect();
        $view->errorShow($arr_res);
    }
    //var_dump($res);
    //echo 'correct';
    //include 'view/vie_register.php';    
} elseif(isset($_GET['action'])) {
    /**
     * Activation user account
     *
     * @boolean
     */
    if ($_GET['action'] == 'activate' && !empty($_GET['token'])) {
        $token = $_GET['token'];
        include_once 'model/mod_register.php';
        $activation = new Model_Register_Connect();
        $res = $activation->activationAccount('users', $token);
        //--
        include_once 'view/vie_register.php';
        $view = new View_Register_Connect();
        $view->activationShow($res);
    } elseif($_GET['action'] == 'register') {
        include_once 'view/vie_register.php';
        $view = new View_Register_Connect();
        $view = new View_Register_Connect();
        $ret = $view->registerFacebook();
        if (is_array($ret)) {
            var_dump($ret);
        } else {
            echo $ret;
        }
    } elseif($_GET['action'] == 'facebook') {
        // include_once 'model/mod_register.php';
        // $activation = new Model_Register_Connect();
        // $res = $activation->facebookSetting();
        // include_once 'view/vie_register.php';
        // $view = new View_Register_Connect();
        // $view->registerFacebook();
        // if (isset($_GET['reguest'])) {
            // if ($_GET['reguest'] == 'add') {
                // include_once 'model/mod_register.php';
                // $activation = new Model_Register_Connect();
            // }
        // } else {

        // }
        include 'model/mod_facebook.php';
    }
} else {
    include_once 'view/vie_register.php';
    $view = new View_Register_Connect();
    //$view->registerForm();
    $view->register();
}

