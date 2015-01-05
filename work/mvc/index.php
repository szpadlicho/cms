<?php
 
if($_GET['task']=='categories') {
    include 'controller/categories.php';
    $ob = new CategoriesController();
    $ob->$_GET['action']();
} else if($_GET['task']=='articles') {
    include 'controller/articles.php';
    $ob = new ArticlesController();
    $ob->$_GET['action']();
} else {
    include 'controller/articles.php';
    $ob = new ArticlesController();
    $ob->index();
}