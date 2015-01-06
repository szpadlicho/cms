<?php
abstract class Connect
{   
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
    function __construct()
    {
        try {
            require 'sql.php';
            $this->pdo=new PDO('mysql:host='.$host.';dbname='.$dbase."; charset=".$charset, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(DBException $e) {
            echo 'The connect can not create: ' . $e->getMessage();
        }
    }
}