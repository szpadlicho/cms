<?php
include_once '../classes/connect.php';
class Connect_Load extends Connect
{
    private $table;
    public function __setTable($tab_name)
    {
        $this->table=$tab_name;
    }
    public function loadIndex()
    {
        $con=$this->connectDB();
        $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`='1'");/*zwraca false jesli tablica nie istnieje*/
        unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        return $q;
    }
    public function metaDataProduct($id)
    {
        $con=$this->connectDB();
        $q = $con->query("SELECT `product_title`,`product_description`,`product_keywords` FROM `".$this->table."` WHERE `id`='".$id."'");/*zwraca false jesli tablica nie istnieje*/
        unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        return $q;
    }
    public function metaDataCategory($name)
    {
        $con=$this->connectDB();
        $q = $con->query("SELECT `title`,`description`,`keywords` FROM `".$this->table."` WHERE `product_category_main`='".$name."'");/*zwraca false jesli tablica nie istnieje*/
        unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        return $q;
    }
    public function globalMetaData()
    {
        $con=$this->connectDB();
        $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`='1'");/*zwraca false jesli tablica nie istnieje*/
        unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        return $q;
    }
}