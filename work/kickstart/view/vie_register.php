<?php
include_once 'config/connect.php';
class View_Register_Connect extends Connect
{
    function register()
    {
        include 'templates/register.html.php';
    }
    function registerForm()
    {
        include 'templates/register_form.html.php';
    }
    function registerFacebook()
    {
        include 'model/mod_facebook.php';
    }
    function showFacebook($data)
    {
        include 'templates/register_facebook_show.html.php';
    }
    function successShow($data)
    {
        include 'templates/register_success.html.php';
    }
    function errorShow($data)
    {
        include 'templates/register_error.html.php';
    }
    function activationShow($data)
    {
        include 'templates/register_activation.html.php';
    }
}
