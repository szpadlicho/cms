<?php
//$_GET['con'] = null;
if (isset($_GET['con'])) {
    if ($_GET['con'] == 'register') {
        include 'controller/con_register.php';
    } else {
        include 'controller/con_index.php';
    }
} else {
    include 'controller/con_index.php';
}