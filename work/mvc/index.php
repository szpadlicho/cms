<?php
$_GET['controller'] = null;
if($_GET['controller']=='categories') {
    include 'controller/categories.php';
    $ob = new CategoriesController();
    $ob->$_GET['action']();
} else if($_GET['controller']=='articles') {
    include 'controller/articles.php';
    $ob = new ArticlesController();
    $ob->$_GET['action']();
} else {
    include 'controller/controller.php';
}