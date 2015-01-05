<?php
// to zawiera sie w controller pliku jesli podaje cos to wywoluje dokladnie te pliki z tymi metodami i o tych parametrach wejsciowych
// w klasie to moze byc wywoluwane z metody construct bez zadnych dodatkowych parametrow
include 'model/model.php'; // default action
$model = new Model();
$res = $model->select('articles');
//var_dump($res);
include 'view/view.php'; //defaukt action
$view = new View();
$view->index($res /*moze tu byc title keyword content itp do header*/);
//$view = new View();
//echo $view->__showAll($res);
//koniec pliku controller/controller.php