<?php
    session_start();
    //$folder = $_POST['folder'];//dodalem
    $folder='../data2/'.$_SESSION['id_post'].'2/mini2/1';
    if (!file_exists($folder)) {
        $cr = mkdir($folder, 0777, true);
    }
    
    //is_dir() 
    //$cr = explode('/', $folder);
    
    var_dump($cr);