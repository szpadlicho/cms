<?php
include_once '../classes/connect.php';
class Connect_General extends Connect
{
    private $table;
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
	}
    public function __setRow($arr_val, $id)
    {
        $record='';
        foreach ($arr_val as $name => $val) {
            $record .= "`".$name."` = '".$val."',";
        }
        /*zapis*/
		$con=$this->connectDB();
		$res=$con->query(
            "UPDATE `".$this->table."` 
            SET ".$record." `mod` = '1'
			WHERE `id` = '".$id."'"
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