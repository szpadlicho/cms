<?php
include_once '../config.php';
class Connect
{
    // private $host='localhost';
    // private $port='';
    // private $dbname='szpadlic_cms';
    // private $charset='utf8';
    // private $user='user';
    // private $pass='user';
	private $host       = DB_HOST;
    private $port       = DB_PORT;
    private $dbname     = DB_NAME;
    private $dbname_sh  = DB_SCHEMA;
    private $charset    = DB_CHARSET;
    private $user       = DB_USER;
    private $pass       = DB_PASSWORD; 
    public function connectDB()
    {
        $con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
        return $con;
        unset ($con);
    }
}