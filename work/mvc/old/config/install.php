<?php
class install
{
    protected $pdo;
    
    public function  __construct() 
    {
        try {
            require 'sql.php';
            
            $this->pdo = new PDO('mysql:host='.$host, $user, $pass);
            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS ".$dbase." charset=".$charset);

            unset($this->pdo);

            $this->pdo=new PDO('mysql:host='.$host.';dbname='.$dbase, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(DBException $e) {
            echo 'The connect can not create: ' . $e->getMessage();
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
$install = new install();
$arr_row = array (
    'id' => 'integer auto_increment',
    'name' => 'varchar(100)'
);
$arr_val = array (
    'name' => 'akcja'
);
$install->installTB('categories', $arr_row, $arr_val);
$arr_row = array (
    'id' => 'integer auto_increment',
    'title' => 'varchar(100)',
    'content' => 'text',
    'date_add' => 'datetime',
    'autor' => 'varchar(100)',
    'id_categories' => 'integer'
);
$arr_val = array (
    'title' => 'PHP dla profesjonalistów',
    'content' => 'Tworząc różnego rodzaju aplikacje natrafiamy na poważny problem utrzymania dobrej organizacji kodu – przejrzystej oraz łatwej w rozbudowie. Z pomocą przychodzą nam wzorce projektowe, które wymuszają na nas pewną organizację kodu aplikacji. W świecie aplikacji www najbardziej popularny jest wzorzec MVC. Jego ideę pokażę w praktyce – pisząc prosty system artykułów. Żeby w pełni zrozumieć ideę tego wzorca projektowego czytelnik musi mieć solidne podstawy znajomości PHP oraz potrafić programować obiektowo.',
    'date_add' => date('Y-m-d H:i:s'),
    'autor' => 'Piotr Szpanelewski',
    'id_categories' => 1
);
$install->installTB('articles', $arr_row, $arr_val);