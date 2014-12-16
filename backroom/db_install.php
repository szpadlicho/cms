<?php
header('Content-Type: text/html; charset=utf-8');
class DatabaseInstall
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	//private $dbname_sh='information_schema';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;
	//private $table_sh='SCHEMATA';
	private $admin;
	private $autor;
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
		//echo $this->table."<br />";
	}
	public function connect()
    {
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
	public function connectDb()
    {
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
	public function checkDb()
    {
		$con=$this->connect();
		$ret = $con->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '".$this->dbname."'");/*sprawdzam czy baza istnieje*/
		$res = $ret->fetch(PDO::FETCH_ASSOC);
		return $res ?  true : false;
	}
	public function createDb()
    {
		if ($this->checkDb()=== false) {
			$con=$this->connect();		
			$con->exec("CREATE DATABASE IF NOT EXISTS ".$this->dbname." charset=".$this->charset);
			unset ($con);
			return true;
		} elseif ($this->checkDb()=== true) {
			return false;
		}
	}
	public function deleteDb()
    {
		$con=$this->connect();
		$result=$con->exec("DROP DATABASE `".$this->dbname."`"); //usowanie
		unset ($con);
		if($result) {
			return true;
		} else {
			return false;
		}
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
                `mod` INTEGER(2),
                PRIMARY KEY(`id`)
                )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1"
                );
            ////nie może tu byc return bo sie dalej nie wykona
            //setcookie("TestCookie", 'asd', time()+3600);
            if (! empty($arr_val)) {
                
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
            } else {
                return $res ? true : false;
            }
		} else {
			return false;
		}
    }
    public function deleteTb($table)
    {
        $con = $this->connectDB();
        $res = $con->query('DROP TABLE `'.$table.'`');
        return $res ? true : false;
    }
}
$obj_install = new DatabaseInstall;
if (isset($_POST['del'])) {
    $return = array();// array initiate
	$return['delete'] = $obj_install->deleteDb();
}
if (isset($_POST['crt'])) {
    $return = array();// array initiate
    $return['data_base'] = $obj_install->createDb();      
	
	$obj_install->__setTable('product_tab');
    $arr_row = array(
        'product_name'              =>'TEXT', 
        'product_price'             =>'VARCHAR(20)',
        'amount'                    =>'INTEGER(10) UNSIGNED', 
        'product_category_main'     =>'TEXT',
        'product_category_sub'      =>'TEXT',
        'product_description_small' =>'TEXT',
        'product_description_large' =>'TEXT',
        'product_foto_mini'         =>'TEXT',
        'product_foto_large'        =>'TEXT',
        'file_name'                 =>'TEXT',
        'product_title'             =>'TEXT',
        'product_description'       =>'TEXT',
        'product_keywords'          =>'TEXT',
        'shipping_mod'              =>'INTEGER(1) UNSIGNED', 
        'predefined'                =>'VARCHAR(50)',
        'predefined_d'              =>'VARCHAR(50)',
        'weight'                    =>'INTEGER(100) UNSIGNED', 
        'allow_prepaid'             =>'INTEGER(1) UNSIGNED',
        'price_prepaid'             =>'VARCHAR(20)',
        'allow_ondelivery'          =>'INTEGER(1) UNSIGNED',
        'price_ondelivery'          =>'VARCHAR(20)',
        'package_share'             =>'INTEGER(1) UNSIGNED',
        'max_item_in_package'       =>'INTEGER(100) UNSIGNED',
        'connect_package'           =>'INTEGER(1) UNSIGNED',
        'only_if_the_same'          =>'INTEGER(1) UNSIGNED'
        );
    $arr_val = array();
	$return['product_tab'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);

	$obj_install->__setTable('product_category_main');
    $arr_row = array(
        'product_category_main'      =>'TEXT', 
        'file_name_category_main'    =>'TEXT', 
        'title'                      =>'TEXT', 
        'description'                =>'TEXT',
        'keywords'                   =>'TEXT'
        );
    $arr_val = array();
	$return['product_category_main'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);

	$obj_install->__setTable('product_category_sub');
    $arr_row = array(
        'product_category_sub'      =>'TEXT', 
        'file_name_category_sub'    =>'TEXT', 
        'title'                     =>'TEXT', 
        'description'               =>'TEXT',
        'keywords'                  =>'TEXT'
        );
    $arr_val = array();
	$return['product_category_sub'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    
    $obj_install->__setTable('setting_img');
    $arr_row = array(
        'small_width'   =>'INT(5) UNSIGNED', 
        'small_height'  =>'INT(5) UNSIGNED', 
        'large_width'   =>'INT(5) UNSIGNED', 
        'large_height'  =>'INT(5) UNSIGNED'
        );
    $arr_val = array(
        'small_width'   =>200,  
        'small_height'  =>300,  
        'large_width'   =>700,  
        'large_height'  =>700
        );
	$return['setting_img'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    
    $obj_install->__setTable('setting_seo');
    $arr_row = array(
        'global_title_index'            =>'TEXT', 
        'global_keywords_index'         =>'TEXT', 
        'global_description_index'      =>'TEXT', 
        'global_title_category'         =>'TEXT',
        'global_keywords_category'      =>'TEXT',
        'global_description_category'   =>'TEXT',
        'global_title_product'          =>'TEXT',
        'global_keywords_product'       =>'TEXT',
        'global_description_product'    =>'TEXT'
        );
    $arr_val = array(
        'global_title_index'            =>'Globalny tytuł strony głównej', 
        'global_keywords_index'         =>'globalne,słowa,keywords,strony,głównej', 
        'global_description_index'      =>'Globalny opis strony głównej dodać max znaków', 
        'global_title_category'         =>'Globalny tytuł strony kategorii',
        'global_keywords_category'      =>'globalne,słowa,keywords,strony,kategorii',
        'global_description_category'   =>'Globalny opis strony kategorii dodać max znaków',
        'global_title_product'          =>'Globalny tytuł strony towaru',
        'global_keywords_product'       =>'globalne,słowa,keywords,strony,towaru',
        'global_description_product'    =>'Globalny opis strony towaru dodać max znaków'
        );
	$return['setting_seo'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);

    $obj_install->__setTable('users');
    $arr_row = array(
        'login'         =>'VARCHAR(50) NOT NULL UNIQUE', 
        'password'      =>'VARCHAR(50) NOT NULL', 
        'email'         =>'VARCHAR(50) NOT NULL UNIQUE',                     
        'create_data'   =>'DATETIME NOT NULL',
        'update_data'   =>'DATETIME NOT NULL',
        'first_name'    =>'VARCHAR(50) NOT NULL',
        'last_name'     =>'VARCHAR(50) NOT NULL',
        'phone'         =>'VARCHAR(50) NOT NULL',
        'country'       =>'VARCHAR(50) NOT NULL',
        'town'          =>'VARCHAR(50) NOT NULL',
        'post_code'     =>'VARCHAR(50) NOT NULL',
        'street'        =>'VARCHAR(50) NOT NULL',
        'active'        =>'VARCHAR(50) NOT NULL',
        'pref'          =>'VARCHAR(50) NOT NULL'
        );
    $arr_val = array();
    $return['users'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    
    $obj_install->__setTable('setting_gen');
    $arr_row = array(
        'background_mod'         =>'VARCHAR(50)'
        );
    $arr_val = array(
        'background_mod'         =>'one'
        );
    $return['setting_gen'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
}
if (isset($_POST['delete'])) {
    $res = $obj_install->deleteTb($_POST['delete_this']);    
}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Install</title>
	<?php include ("meta5.html"); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
    <section id="place-holder">
		<?php include ('backroom-top-menu.php'); ?>
    
        <div class="center">
            Zarządzanie Bazą Danych
            <form enctype="multipart/form-data" action="" method="POST">
                    <input class="input_cls" type="submit" name="del" value="Delete DB" />
                    <input class="input_cls" type="submit" name="crt" value="Create" />
            <p></p>
            <br />
            <?php
            if (isset($res)) {
                echo 'Delete ';
                echo $res ? 'ok' : 'error';
            }
            if (isset($return)) {
                foreach ($return as $key => $val) {
                    echo $key.' - ';
                    echo $val ? 'ok' : 'error';
                    ?>
                    <input class="input_cls" type="submit" name="delete" value="Del TB" />
                    <input class="input_cls" type="hidden" name="delete_this" value="<?php echo $key; ?>" />
                    <br />
                    <?php
                }
                //var_dump($return);
            }
            ?>
            </form>
        </div>
    </section>
</body>
</html>