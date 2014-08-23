<?php
//zrobic zeby usuwalo tylko zmienne sesyjne z tego progamu a nie wszystkie
session_start();
if($_POST['value']=='sub')
{
    unset($_SESSION['sub']);
}
else if($_POST['value']=='all')
{
    session_unset();
}
//$_SESSION['pff'] = $_POST['value'];
?>