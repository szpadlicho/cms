<?php
/**
 * @author Łukasz Socha <kontakt@lukasz-socha.pl>
 * @version: 1.0
 * @license http://www.gnu.org/copyleft/lesser.html
 */
 
include 'view/view.php';
 
class CategoriesView extends View{
    public function  index() {
        $cat=$this->loadModel('categories');
        $this->set('catsData', $cat->getAll());
        $this->render('indexCategory');
    }
    public function  add() {
        $this->render('addCategory');
    }
}