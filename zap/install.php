<html lang="pl">
<?php
class InstallCls{
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
	public function _setTable($tab_name)
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
	public function connectDB()
    {
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
	public function checkDB()
    {
		$con=$this->connect();
		$ret = $con->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '".$this->dbname."'");/*sprawdzam czy baza istnieje*/
		$res = $ret->fetch(PDO::FETCH_ASSOC);
		return $res ?  1 :  0;
	}
	public function createDB()
    {
		if($this->checkDB()==0)
        {
			$con=$this->connect();		
			$con->exec("CREATE DATABASE IF NOT EXISTS ".$this->dbname." charset=".$this->charset);
			unset ($con);
			echo "<div class=\"center\" >Utworzyłem bazę</div>";
		}
		else if($this->checkDB()==1)
        {
			echo "<div class=\"center\" >Baza istnieje</div>";
		}
	}
	public function deleteDB()
    {
		$con=$this->connect();
		$result=$con->exec("DROP DATABASE `".$this->dbname."`"); //usowanie
		unset ($con);
		if($result)
        {
			echo "<div class=\"center\" >Deleted ({$result})</div>";
		}
		else{
			echo "<div class=\"center\" >Error ({$result})</div>";
		}
	}
	public function createTB()
    {
		/*tworze tabele tylko raz co pozwala klikać install bez konsekwencji*/
		$con=$this->connectDB();
		$res = $con->query("SELECT 1 FROM ".$this->table);/*zwraca false jesli tablica nie istnieje*/	
		if(!$res)
        {
			$result=$con->exec("CREATE TABLE IF NOT EXISTS `".$this->table."`(
			`id` INTEGER AUTO_INCREMENT, 
			`product_name` TEXT, 
			`product_price` VARCHAR(10), 
			`product_number` INTEGER(10),
			`product_category_main` TEXT,
			`product_category_sub` TEXT,
			`product_description_small` TEXT,
			`product_description_large` TEXT,
			`product_foto_mini` TEXT,
			`product_foto_large` TEXT,
			`mod` INTEGER(10),
            `file_name` TEXT,
            `product_title` TEXT,
            `product_description` TEXT,
            `product_keywords` TEXT,
			PRIMARY KEY(`id`)
			)ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1");
			echo "<div class=\"center\" >Utworzyłem tabelę: {$this->table}</div>";
		}
		else
        {
			echo "<div class=\"center\" >Tabela już istnieje</div>";
		}
	}
    public function createTBCategory($file_name_row, $title, $description, $keywords)
    {
		/*tworze tabele tylko raz co pozwala klikać install bez konsekwencji*/
		$con=$this->connectDB();
		$res = $con->query("SELECT 1 FROM ".$this->table);/*zwraca false jesli tablica nie istnieje*/	
		if(!$res)
        {
			$result=$con->exec("CREATE TABLE IF NOT EXISTS `".$this->table."`(
			`id` INTEGER AUTO_INCREMENT,
			`".$this->table."` TEXT,
            `".$file_name_row."` TEXT,
            `mod` INT(10),
            `".$title."` TEXT,
            `".$description."` TEXT,
            `".$keywords."` TEXT,
			PRIMARY KEY(`id`)
			)ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1");
			echo "<div class=\"center\" >Utworzyłem tabelę: {$this->table}</div>";
		}
		else
        {
			echo "<div class=\"center\" >Tabela już istnieje</div>";
		}
	}
    public function createForeignKey($pr)
    {
        /*tworze tabele tylko raz co pozwala klikać install bez konsekwencji*/
		$con=$this->connectDB();
		$res = $con->query("SELECT 1 FROM ".$this->table);/*zwraca false jesli tablica nie istnieje*/	
		if($res)
        {           
            //$result=$con->exec("ALTER TABLE `".$pr."` ADD `".$this->table."` INT NOT NULL");
            //$result=$con->exec("ALTER TABLE `".$pr."` ADD INDEX (`".$this->table."`)");
            //$result=$con->exec("ALTER TABLE `".$this->table."` ADD `".$this->table."` INT NOT NULL");
            //$result=$con->exec("ALTER TABLE `".$this->table."` ADD INDEX (`".$this->table."`)");
            //$result=$con->query("ALTER TABLE `".$pr."` ADD FOREIGN KEY `".$this->table."` REFERENCES `".$this->table."` (`id`)");
            ////$result=$con->query("ALTER TABLE `product_tab` ADD CONSTRAINT `fk_pk` FOREIGN KEY (`product_category_main`) REFERENCES `szpadlic_cms`.`product_category_main`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT");
            //$result=$con->query("ALTER TABLE `product_tab` ADD CONSTRAINT `fk_pk` FOREIGN KEY (`product_category_main`) REFERENCES `product_category_main` (`id`)ON DELETE RESTRICT ON UPDATE RESTRICT");
            if($res)
            {
                echo "<div class=\"center\" >good</div>";
            }
            else
            {
                echo "<div class=\"center\" >bad</div>";
            }
		}
		else
        {
			echo "<div class=\"center\" >bład</div>";
		}
    }
	// public function createREC(){
		// /*zapis do tablei tylko raz*/
		// $con=$this->connectDB();
		// $q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		// $count = $q -> fetch();/*konwertor na tablice*/
		// if(!$count){
			// $con->exec("INSERT INTO `".$this->table."`(
			// `now`, 
			// `what`, 
			// `mod`, 
			// `text`
			// ) VALUES (
			// 'rec', 
			// 'rec',  
			// 'rec'
			// '0',
			// )");
			// echo "<div class=\"center\" >zapis udany</div>";
		// }
		// else{
			// echo "<div class=\"center\" >zapis już istnieje</div>";
		// }		
		// unset ($con);	
	// }
    public function createTBDynamicRow($arr_row,$arr_val)
    {
        /*tworze tabele tylko raz co pozwala klikać install bez konsekwencji*/
		$con=$this->connectDB();
		$res = $con->query("SELECT 1 FROM ".$this->table);/*zwraca false jesli tablica nie istnieje*/	
		if(!$res)
        {
            $columns='';
            foreach($arr_row as $name => $val){
                $columns .= '`'.$name.'` '.$val.',';
            }
            // Create table
			$result=$con->exec("CREATE TABLE IF NOT EXISTS `".$this->table."`(
			`id` INTEGER AUTO_INCREMENT,            
            ".$columns."
            `mod` INT(10),
			PRIMARY KEY(`id`)
			)ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1");
			echo "<div class=\"center\" >Utworzyłem tabelę: {$this->table}</div>";
            
            $field='';
            $value='';
            foreach($arr_val as $name => $val){
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
		else
        {
			echo "<div class=\"center\" >Tabela już istnieje</div>";
		}
    }
}
$install = new InstallCls();
if(isset($_POST['del']))
{
	$install->deleteDB();
}
if(isset($_POST['crt']))
{

    $install->createDB();      
	
	$install->_setTable('product_tab');
	$install->createTB();

	$install->_setTable('product_category_main');
	$install->createTBCategory('file_name_category_main', 'title', 'description', 'keywords'); 

	$install->_setTable('product_category_sub');
	$install->createTBCategory('file_name_category_sub', 'title', 'description', 'keywords');
    
    //$install->_setTable('product_category_main');
    //$install->createForeignKey('product_tab');
    
    $install->_setTable('setting_img');
    $arr_row = array('small_width'=>'TEXT', 'small_height'=>'TEXT', 'large_width'=>'TEXT', 'large_height'=>'TEXT');
    $arr_val = array('small_width'=>'200',  'small_height'=>'300',  'large_width'=>'700',  'large_height'=>'700');
	$install->createTBDynamicRow($arr_row, $arr_val);
}
//$install->check();
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
    <div class="center">
        Zarządzanie Bazą Danych
        <form enctype="multipart/form-data" action="" method="POST">
				<input class="input_cls" type="submit" name="del" value="Delete" />
				<input class="input_cls" type="submit" name="crt" value="Create" />
		</form>
    </div>
<section id="place-holder">
		<?php include ('menu_zap.php'); ?>
</section>
	<?php
// function is_table_exist($query){
// $q = "SELECT * FROM $query;";
// $i=mysql_query($q);
// if( (integer)$i )     //rzutowanie na integer
    // return 1;    //tabela $query istnieje w bazie
// else
    // return 0;    //tabela $query nie istnieje w bazie
// }
 
 
// mysql_connect("server","login","haslo");
// mysql_select_db("bazadanych");
 
// $tab1 = "tabela1"; // tabela 'tabela1' istnieje w bazie
// $tab2 = "tabela2"; //tabela 'tabela2' nie istnieje w bazie
 
// $r1 = is_table_exist($tab1);
// $r2 = is_table_exist($tab2);
 
// if($r1) 
    // echo "Tabela $tab1 istnieje w bazie";
 
// if($r2)
    // echo "Tabela $tab2 nie istnieje w bazie";
?>
</body>
</html>
<?php
	// public function createTable(){
		// $con=$this->connectDB();
		// //if($con){ echo "połączyłem"; } else { echo "błąd"; }
		// $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);/*do przechwytywania błędów try i catch*/
		// try {
			// $result=$con->exec("CREATE TABLE IF NOT EXISTS `".$this->table."`(`id` INTEGER AUTO_INCREMENT, `now` VARCHAR(200), `what` TEXT, `mod` INTEGER(1), `text` TEXT, PRIMARY KEY(`id`))ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1");
			// echo "<div class=\"center\" >Utworzyłem tabelę: {$this->table}</div>";
		// }
		// catch(PDOException $e){
			// echo "<div class=\"center\" >Tabela istnieje ({})</div>";
			// echo $e->getMessage();
		// }
		// /*zapis do tablei tylko raz*/
		// $q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		// $count = $q -> fetch();/*konwertor na tablice*/
		// if(!$count){
			// $con->exec("INSERT INTO `".$this->table."`(`now`, `what`, `mod`, `text`) VALUES ('rec', 'rec', '0', 'rec')");/*co zrobic zeby raz ?*/
			// echo "<div class=\"center\" >zapis udany</div>";
		// }
		// else{
			// echo "<div class=\"center\" >zapis juz istnieje</div>";
		// }		
		// unset ($con);	
	// }
?>