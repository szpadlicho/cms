<?php
//zrobic zeby usuwalo tylko zmienne sesyjne z tego progamu a nie wszystkie
session_start();
if ($_POST['value']=='sub') {
    unset($_SESSION['sub']);
} elseif($_POST['value']=='main') {
    //session_unset();
    unset($_SESSION['menu_id']);
}
//$_SESSION['pff'] = $_POST['value'];
?>