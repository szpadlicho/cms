<?php
session_start();
if ($_POST['value']=='sub') {
    unset($_SESSION['sub']);
} elseif($_POST['value']=='main') {
    //session_unset();
    unset($_SESSION['main']);
}
?>