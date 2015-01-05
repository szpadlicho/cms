<?php
/**
 * @author Łukasz Socha <kontakt@lukasz-socha.pl>
 * @version: 1.0
 * @license http://www.gnu.org/copyleft/lesser.html
 */
 
include 'controller/controller.php';
 
class ArticlesController extends Controller{
 
    public function index() {
        $view=$this->loadView('articles');
        $view->index();
    }
    public function one() {
        $view=$this->loadView('articles');
        $view->one();
    }
    public function add() {
        $view=$this->loadView('articles');
        $view->add();
    }
    public function insert() {
        $model=$this->loadModel('articles');
        $model->insert($_POST);
        $this->redirect('?task=articles&action=index');
    }
    public function delete() {
        $model=$this->loadModel('articles');
        $model->delete($_GET['id']);
        $this->redirect('?task=articles&action=index');
    }
}