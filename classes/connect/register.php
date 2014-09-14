<?php
include_once '../classes/connect.php';
class Connect_Register extends Connect
{
	private $table;
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
	}
    public function addUser($arr_val)
    {
        $con = $this->connectDB();
        $res = $con->query(
            "SELECT `email` 
            FROM ".$this->table." 
            WHERE `email` = '".$arr_val['email']."'"
            );// sprawdzam czy już istniej jeśli nie zwraca false
        $res = $res->fetch(PDO::FETCH_ASSOC);
        if (!empty($arr_val) && ! $res) {
            $field='';
            $value='';
            foreach ($arr_val as $name => $val) {
                $field .= '`'.$name.'`,';
                $value .= "'".$val."',";
            }
            // Create record
            $res = $con->query(
                "INSERT INTO `".$this->table."`(
                ".$field."
                `mod`
                ) VALUES (
                ".$value."
                '0' )"
                ); 
            // Zwraca false lub id
            return $res ? (int)$con->lastInsertId() : false;
        } else {
            return false;
        }
        unset ($con);
    }
    public function updateUser($arr_val, $id)
    {
        $con = $this->connectDB();
		$res = $con->query(
            "SELECT 1 
            FROM ".$this->table
            );// Zwraca false jeśli tablica nie istnieje
        if (!empty($arr_val) && $res != false) {
            $commit='';
            foreach ($arr_val as $name => $val) {
                $commit .= "`".$name."` = '".$val."',";
            }
            $res = $con->query(
                "UPDATE `".$this->table."` SET 
                ".$commit."
                `mod` = '0'
                WHERE 
                `id` = '".$id."'"
                );
            $res = $res->rowCount();// Jeśli dodał zwraca 1 jeśli nie zwraca 0//returns the number of rows affected by the last DELETE, INSERT, or UPDATE statement executed by the corresponding PDOStatement object
            return $res ? true : false;
        } else {
            return false;
        }
    }
}