<?php
/**
 * @author Łukasz Socha <kontakt@lukasz-socha.pl>
 * @version: 1.0
 * @license http://www.gnu.org/copyleft/lesser.html
 */
 
include 'controller/controller.php';
 
class CategoriesController extends Controller{
    public function index() {
        $view=$this->loadView('categories');
        $view->index();
    }
    public function add() {
        $view=$this->loadView('categories');
        $view->add();
    }
    public function insert() {
        $model=$this->loadModel('categories');
        $model->insert($_POST);
        $this->redirect('?task=categories&action=index');
    }
    public function delete() {
        $model=$this->loadModel('categories');
        $model->delete($_GET['id']);;
        $this->redirect('?task=categories&action=index');
    }
}