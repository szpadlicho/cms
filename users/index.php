<?php
header('Content-Type: text/html; charset=utf-8');
//session_start();
class Users
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
	}
	public function connectDB()
    {
		$con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset, $this->user, $this->pass );
		return $con;
		unset ($con);
	}
    public function deleteTb()
    {
        $con = $this->connectDB();
        $res = $con->query('DROP TABLE `'.$this->table.'`');
        return $res ? true : false;
    }
    public function createTbDynamicRow($arr_row,$arr_val)
    {
        // Tworze tabele tylko raz co pozwala klikać install bez konsekwencji
		$con = $this->connectDB();
		$res = $con->query(
            "SELECT 1 
            FROM ".$this->table
            );// Zwraca false jesli tablica nie istnieje
		if (!$res) {
            $columns='';
            foreach ($arr_row as $name => $val) {
                $columns .= '`'.$name.'` '.$val.',';
            }
            // Create table
			$res = $con->query(
                "CREATE TABLE IF NOT EXISTS `".$this->table."`(
                `id` INTEGER AUTO_INCREMENT,            
                ".$columns."
                `mod` INTEGER(10),
                PRIMARY KEY(`id`)
                )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1"
                );
            return $res ? true : false;
            if (!empty($arr_val)) {
                $field='';
                $value='';
                foreach ($arr_val as $name => $val) {
                    $field .= '`'.$name.'`,';
                    $value .= "'".$val."',";
                }
                // Create default record 
                $res = $con->query(
                    "INSERT INTO `".$this->table."`(
                    ".$field."
                    `mod`
                    ) VALUES (
                    ".$value."
                    '0'
                    )"
                    );
                return $res ? true : false;
            }
		} else {
			return false;
		}
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
            return $res ? true : false;
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

$obj_users = new Users;
if (isset($_POST['createTb'])) {// To do instalacji przenieść !!
    $obj_users->__setTable('users');
    $arr_row = array(
        'login'  =>'VARCHAR(50) NOT NULL UNIQUE', 
        'password'  =>'VARCHAR(50) NOT NULL', 
        'email'   =>'VARCHAR(50) NOT NULL UNIQUE',                     
        'create_data'  =>'DATETIME NOT NULL',
        'update_data'  =>'DATETIME NOT NULL',
        'first_name'  =>'VARCHAR(50) NOT NULL',
        'last_name'  =>'VARCHAR(50) NOT NULL',
        'phone'  =>'VARCHAR(50) NOT NULL',
        'country'  =>'VARCHAR(50) NOT NULL',
        'town'  =>'VARCHAR(50) NOT NULL',
        'post_code'  =>'VARCHAR(50) NOT NULL',
        'street'  =>'VARCHAR(50) NOT NULL'
        );
    $arr_val = array();
    $return = $obj_users->createTbDynamicRow($arr_row, $arr_val);
}
if (isset($_POST['dropTb'])) {
    $obj_users->__setTable('users');
    $return = $obj_users->deleteTb();
}
if (isset($_POST['addUser'])) {
    $obj_users->__setTable('users');
    $arr_val = array(
        'login'  =>'user', 
        'password'  =>'user', 
        'email'   =>'email@gmail.com',                     
        'create_data'  => date('Y-m-d H:i:s'),
        'update_data'  => date('Y-m-d H:i:s'),
        'first_name'  =>'Piotrek',
        'last_name'  =>'Szpanelewski',
        'phone'  =>'888958277',
        'country'  =>'Polska',
        'town'  =>'Częstochowa',
        'post_code'  =>'42-200',
        'street'  =>'Garibaldiego 16 m. 23'
        );
    $return = $obj_users->addUser($arr_val);
}
if (isset($_POST['updateUser'])) {
    $obj_users->__setTable('users');
    $arr_val = array(
        'login'  =>'user2', 
        'password'  =>'user', 
        'email'   =>'email2@gmail.com',                     
        'update_data'  => date('Y-m-d H:i:s'),
        'first_name'  =>'Piotrek',
        'last_name'  =>'Szpanelewski',
        'phone'  =>'888958277',
        'country'  =>'Polska',
        'town'  =>'Częstochowa',
        'post_code'  =>'42-200',
        'street'  =>'Garibaldiego 16 m. 23'
        );
    $return = $obj_users->updateUser($arr_val, 1);    
}
if (isset($return)) {
    echo $return ? 'ok' : 'error';
}
//if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) {
//do something
//}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
<title>Users</title>

</head>
<body>
    <form method="POST" >
        <input type="submit" name="createTb" value="create" />
        <input type="submit" name="addUser" value="add" />
        <input type="submit" name="dropTb" value="drop" />
        <input type="submit" name="updateUser" value="update" />
    </form>
</body>
</html>