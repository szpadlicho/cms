<?php
/**
 * @author Łukasz Socha <kontakt@lukasz-socha.pl>
 * @version: 1.0
 * @license http://www.gnu.org/copyleft/lesser.html
 */
 
/**
 * This class includes methods for models.
 *
 * @abstract
 */
abstract class Model{
    /**
     * object of the class PDO
     *
     * @var object
     */
    protected $pdo;
 
    /**
     * It sets connect with the database.
     *
     * @return void
     */
    public function  __construct() {
        try {
            require 'config/sql.php';
            $this->pdo=new PDO('mysql:host='.$host.';dbname='.$dbase, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(DBException $e) {
            echo 'The connect can not create: ' . $e->getMessage();
        }
    }
    /**
     * It loads the object with the model.
     *
     * @param string $name name class with the class
     * @param string $path pathway to the file with the class
     *
     * @return object
     */
    public function loadModel($name, $path='model/') {
        $path=$path.$name.'.php';
        $name=$name.'Model';
        try {
            if(is_file($path)) {
                require $path;
                $ob=new $name();
            } else {
                throw new Exception('Can not open model '.$name.' in: '.$path);
            }
        }
        catch(Exception $e) {
            echo $e->getMessage().'<br />
                File: '.$e->getFile().'<br />
                Code line: '.$e->getLine().'<br />
                Trace: '.$e->getTraceAsString();
            exit;
        }
        return $ob;
    }
    /**
     * It selects data from the database.
     *
     * @param string $from Table
     * @param <type> $select Records to select (default * (all))
     * @param <type> $where Condition to query
     * @param <type> $order Order ($record ASC/DESC)
     * @param <type> $limit LIMIT
     * @return array
     */
    public function select($from, $select='*', $where=NULL, $order=NULL, $limit=NULL) {
        $query='SELECT '.$select.' FROM '.$from;
        if($where!=NULL)
            $query=$query.' WHERE '.$where;
        if($order!=NULL)
            $query=$query.' ORDER BY '.$order;
        if($limit!=NULL)
            $query=$query.' LIMIT '.$limit;
 
        $select=$this->pdo->query($query);
        foreach ($select as $row) {
            $data[]=$row;
        }
        $select->closeCursor();
 
        return $data;
    }
}