<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
echo '<div class="catch">';
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
		$con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
    public function deleteTb()
    {
        $con = $this->connectDB();
        $res = $con->query('DROP TABLE IF EXISTS `'.$this->table.'`');
        if ($res) {
			echo "<div class=\"center\" >Deleted ({$this->table})</div>";
		} else {
			echo "<div class=\"center\" >Error ({$this->table})</div>";
		}
    }
    public function createTbDynamicRow($arr_row,$arr_val)
    {
        /*tworze tabele tylko raz co pozwala klikać install bez konsekwencji*/
		$con = $this->connectDB();
		$res = $con->query("SELECT 1 FROM ".$this->table);/*zwraca false jesli tablica nie istnieje*/	
		if (!$res) {
            $columns='';
            foreach ($arr_row as $name => $val) {
                $columns .= '`'.$name.'` '.$val.',';
            }
            // Create table
			$result=$con->exec("CREATE TABLE IF NOT EXISTS `".$this->table."`(
                `id` INTEGER AUTO_INCREMENT,            
                ".$columns."
                `mod` INTEGER(10),
                PRIMARY KEY(`id`)
                )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1");
                echo "<div class=\"center\" >Utworzyłem tabelę: {$this->table}</div>";
            
            if (!empty($arr_val)) {
                $field='';
                $value='';
                foreach ($arr_val as $name => $val) {
                    $field .= '`'.$name.'`,';
                    $value .= "'".$val."',";
                }
                // Create default record 
                $res=$con->query("INSERT INTO `".$this->table."`(
                    ".$field."
                    `mod`
                    ) VALUES (
                    ".$value."
                    '0'
                    )");
            }
		} else {
			echo "<div class=\"center\" >Tabela już istnieje</div>";
		}
    }
    public function addUser($arr_val)
    {
        $con = $this->connectDB();
        if (!empty($arr_val)) {
                $field='';
                $value='';
                foreach ($arr_val as $name => $val) {
                    $field .= '`'.$name.'`,';
                    $value .= "'".$val."',";
                }
                // Create default record 
                $res=$con->query("INSERT INTO `".$this->table."`(
                    ".$field."
                    `mod`
                    ) VALUES (
                    ".$value."
                    '0'
                    )");
            }
    }
}

$obj_users = new Users;
if (isset($_POST['installTb'])) {
    $obj_users->__setTable('users');
    $arr_row = array('login'  =>'VARCHAR(50) NOT NULL', 
                    'password'  =>'VARCHAR(50) NOT NULL', 
                    'email'   =>'VARCHAR(50) NOT NULL',                     
                    'create_data'  =>'DATETIME NOT NULL',
                    'first_name'  =>'VARCHAR(50) NOT NULL',
                    'last_name'  =>'VARCHAR(50) NOT NULL',
                    'phone'  =>'VARCHAR(50) NOT NULL',
                    'country'  =>'VARCHAR(50) NOT NULL',
                    'town'  =>'VARCHAR(50) NOT NULL',
                    'post_code'  =>'VARCHAR(50) NOT NULL',
                    'street'  =>'VARCHAR(50) NOT NULL'
                    );
    $arr_val = array();
    $obj_users->createTbDynamicRow($arr_row, $arr_val);
}
if (isset($_POST['addUser'])) {
    $obj_users->__setTable('users');
    $arr_val = array('login'  =>'user', 
                    'password'  =>'user', 
                    'email'   =>'email@gmail.com',                     
                    'create_data'  => date('Y-m-d H:i:s'),
                    'first_name'  =>'Piotrek',
                    'last_name'  =>'Szpanelewski',
                    'phone'  =>'888958277',
                    'country'  =>'Polska',
                    'town'  =>'Częstochowa',
                    'post_code'  =>'42-200',
                    'street'  =>'Garibaldiego 16 m. 23'
                    );
    $obj_users->addUser($arr_val);
}
if (isset($_POST['dropTb'])) {
    $obj_users->__setTable('users');
    $obj_users->deleteTb();
}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
<title>Users</title>

</head>
<body>
    <form method="POST" >
        <input type="submit" name="installTb" value="install" />
        <input type="submit" name="addUser" value="add" />
        <input type="submit" name="dropTb" value="drop" />
    </form>
</body>
</html>