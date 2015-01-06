<?php
//header('Content-Type: text/html; charset=utf-8');
class Install
{
    protected $pdo;
    
    public function  __construct() 
    {
        try {
            require 'sql.php';
            
            $this->pdo = new PDO('mysql:host='.$host, $user, $pass);
            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS ".$dbase." charset=".$charset);

            unset($this->pdo);

            $this->pdo=new PDO('mysql:host='.$host.';dbname='.$dbase."; charset=".$charset, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(DBException $e) {
            echo 'The connect can not create: ' . $e->getMessage();
        }
    }
    public function deleteDB()
    {
        require 'sql.php';
		$result = $this->pdo->exec("DROP DATABASE `".$dbase."`"); //usowanie
		unset ($this->pdo);
		if($result) {
			return true;
		} else {
			return false;
		}
	}
    public function installTB($table, $arr_row, $arr_val = null)
    {
        $columns='';
        foreach ($arr_row as $name => $type) {
            $columns .= '`'.$name.'` '.$type.',';
        }
        //$sec = $this->pdo;
        $this->pdo->query(
            'CREATE TABLE IF NOT EXISTS `'.$table.'` (
            '.$columns.'

            primary key(id)
            )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1'
            );
        if ($arr_val != null) {
            
            $field='';
            $value='';
            foreach ($arr_val as $name => $val) {
                $field .= '`'.$name.'`,';
                $value .= "'".$val."',";
            }
            // Remove last coma from string
            $field = rtrim($field, ",");
            $value = rtrim($value, ",");
            // echo $field;
            // echo '<br />';
            // echo $value;
            // echo $wyn;
            $this->pdo->query(
                "INSERT INTO `".$table."`(
                ".$field."
                ) VALUES (
                ".$value."
                )"
                );
        }
    }
}
include 'prefix.php';
$install = new Install();
$arr_row = array(
    'id'            => 'integer auto_increment',
    'first_name'    =>'VARCHAR(50) NOT NULL',
    'last_name'     =>'VARCHAR(50) NOT NULL',
    'email'         =>'VARCHAR(50) NOT NULL UNIQUE',
    'password'      =>'VARCHAR(50) NOT NULL',
    'phone'         =>'VARCHAR(50) NOT NULL',
    'country'       =>'VARCHAR(50) NOT NULL',
    'post_code'     =>'VARCHAR(50) NOT NULL',
    'town'          =>'VARCHAR(50) NOT NULL',    
    'street'        =>'VARCHAR(50) NOT NULL',
    'active'        =>'VARCHAR(50) NOT NULL',
    'pref'          =>'VARCHAR(50) NOT NULL',
    'create_data'   =>'DATETIME NOT NULL',
    'update_data'   =>'DATETIME NOT NULL'
    );
$arr_val = null;
$install->installTB($pref.'users', $arr_row, $arr_val);
if (isset($_GET['deleteDB'])) {
    $install->deleteDB();
}
// if (isset($_GET['updateDB'])) {
    // $install->updateTB();
// }
// $arr_row = array (
    // 'id' => 'integer auto_increment',
    // 'title' => 'varchar(100)',
    // 'content' => 'text',
    // 'date_add' => 'datetime',
    // 'autor' => 'varchar(100)',
    // 'id_categories' => 'integer'
// );
// $arr_val = array (
    // 'title' => 'PHP dla profesjonalistów',
    // 'content' => 'Tworząc różnego rodzaju aplikacje natrafiamy na poważny problem utrzymania dobrej organizacji kodu – przejrzystej oraz łatwej w rozbudowie. Z pomocą przychodzą nam wzorce projektowe, które wymuszają na nas pewną organizację kodu aplikacji. W świecie aplikacji www najbardziej popularny jest wzorzec MVC. Jego ideę pokażę w praktyce – pisząc prosty system artykułów. Żeby w pełni zrozumieć ideę tego wzorca projektowego czytelnik musi mieć solidne podstawy znajomości PHP oraz potrafić programować obiektowo.',
    // 'date_add' => date('Y-m-d H:i:s'),
    // 'autor' => 'Piotr Szpanelewski',
    // 'id_categories' => 1
// );
// $install->installTB('articles', $arr_row, $arr_val);