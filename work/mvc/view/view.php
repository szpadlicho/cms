<?php
class View{
    public function index($res /*moze tu byc title keyword content itp do header w zaleznosci co wygeneruje model*/) {
        include 'templates/header.html.php';
        include 'templates/index.html.php';
        include 'templates/footer.html.php';
        // $art=$this->loadModel('articles');
        // $this->set('articles', $art->getAll());
        // $this->render('indexArticle');
    }
    public function  one() {
        $art=$this->loadModel('articles');
        $this->set('articles', $art->getOne($_GET['id']));
        $this->render('oneArticle');
    }
    public function add() {
        $cat=$this->loadModel('categories');
        $this->set('catsData', $cat->getAll());
        $this->render('addArticle');
    }
}