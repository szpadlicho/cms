<?php
include_once '../../connect.php';
class Img_Set_Size extends Connect
{
	// private $host='localhost';
	// private $port='';
	// private $dbname='szpadlic_cms';
	// private $charset='utf8';
	// private $user='user';
	// private $pass='user';
	private $table;
	private $admin;
	private $autor;
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
	}
	// public function connectDB()
    // {
		// $con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		// return $con;
		// unset ($con);
	// }
    public function __setRow($arr_val, $id)
    {
        $record='';
        foreach ($arr_val as $name => $val) {
            $record .= "`".$name."` = '".$val."',";
        }
        /*zapis*/
		$con=$this->connectDB();
		$res=$con->exec(
            "UPDATE `".$this->table."` 
            SET ".$record." `mod` = '0'
			WHERE `id` = '".$id."' "
            );
        if ($res) {
            echo "<div class=\"center\" >Zapis: OK!</div>";
        } else {
            echo "<div class=\"center\" >Zapis: ERROR!</div>";
        }
    }
    public function __getRow($id)
    {
        $con=$this->connectDB();
        $q = $con->query(
            "SELECT * 
            FROM `".$this->table."` 
            WHERE `id`='".$id."'"
            );
        unset ($con);
        if ($q) {
            $q = $q->fetch(PDO::FETCH_ASSOC);
            return $q;
        } else {
            echo 'ERROR SELECT __getRow()';
        }
    }
}
?>