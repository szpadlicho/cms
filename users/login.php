<?php
/* 
* Class Connect_Login
* if email not exist -                  return boolean false
* if email exist and wrong password     return boolean true
* if email exist and correct pasword    return integer id
* WARNING VARIABLE TYPE IS IMPORTANT !!!
*/
include_once '../classes/connect/login.php';
$login = new Connect_Login();
$login->__setTable('users');
$check = $login->__getUserId('email@gmail.com', 'user');
var_dump($check);