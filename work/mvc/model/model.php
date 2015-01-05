<?php
class Model{
    protected $pdo;
    public function  __construct() {
        try {
            require 'config/sql.php';
            $this->pdo=new PDO('mysql:host='.$host.';dbname='.$dbase."; charset=".$charset, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(DBException $e) {
            echo 'The connect can not create: ' . $e->getMessage();
        }
    }
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