<?php
class Connect
{
    private $host='sql.bdl.pl';
    private $port='';
    private $dbname='szpadlic_cms';
    private $charset='utf8';
    private $user='szpadlic_baza';
    private $pass='haslo';
    public function connectDB()
    {
        $con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
        return $con;
        unset ($con);
    }
}