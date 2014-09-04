<?php
//ini_set('xdebug.var_display_max_depth', -1);
//ini_set('xdebug.var_display_max_children', -1);
//ini_set('xdebug.var_display_max_data', -1);
header('Content-Type: text/html; charset=utf-8');
echo '<div class="catch">';
class GlobalSettingCls{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;// ma miec
	private $row;
	private $path;
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
	}
    public function _setRow($row_name)
    {
		$this->row=$row_name;
	}
    // public function _setPath($path)
    // {
		// $this->path=$path;
	// }
	public function connectDB()
    {
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
    public function deleteTB()//usuwam tabele
    {
		$con=$this->connectDB();
        $res = $con->query("SELECT 1 FROM ".$this->table);/*zwraca false jesli tablica nie istnieje*/	        
		if(!$res)
        {
            unset ($con);
            echo "<div class=\"center\" >Tabela nie istnieje więc nie można jej usunąć</div>";
        }
        else
        {
            $result=$con->query("DROP TABLE `".$this->table."`"); //usowanie
            unset ($con);
            if($result)
            {
                echo "<div class=\"center\" >Delete: {$this->table} OK!</div>";
            }
            else
            {
                echo "<div class=\"center\" >Delete: {$this->table} ERROR!</div>";
            }
        }
	}
    public function createTB()//tworze tabele
    {
		$con=$this->connectDB();
		$res = $con->query("SELECT 1 FROM ".$this->table);/*zwraca false jesli tablica nie istnieje*/	
		if(!$res)
        {
			$result=$con->query("CREATE TABLE IF NOT EXISTS `".$this->table."`(
			`id` INTEGER AUTO_INCREMENT,
			PRIMARY KEY(`id`)
			)ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1");
            if($result)
            {
                echo "<div class=\"center\" >Tworzenie tabeli: {$this->table} OK!</div>";
                //inicjacja tabeli
                $res=$con->query("ALTER TABLE `".$this->table."` ADD `mod` INT(11) ");
                $res=$con->query("INSERT INTO `".$this->table."`(
                `mod`
                ) VALUES (
                '0'
                )");               
            }
            else
            {
                echo "<div class=\"center\" >Tworzenie tabeli: {$this->table} ERROR!</div>";
            }
		}
		else
        {
			echo "<div class=\"center\" >Tabela już istnieje !</div>";
		}
	}
    public function addRow($name)
    {
        $this->_setRow($name);
        $con=$this->connectDB();
        $res=$con->query("ALTER TABLE `".$this->table."` ADD `".$this->row."` TEXT ");
        if($res)
        {
            echo "<div class=\"center\" >Dodanie kolumny: {$this->row} OK!</div>";
        }
        else
        {
            echo "<div class=\"center\" >Dodanie kolumny: {$this->row} ERROR!</div>";
        }
    }
    public function recRow($value)
    {
        /*zapis*/
		$con=$this->connectDB();
		$res=$con->exec("UPDATE `".$this->table."` 
            SET
			`".$this->row."` = '".trim($value)."'
			WHERE
            `id` = '1'
            ");
        if($res)
        {
            echo "<div class=\"center\" >Zapis: OK!</div>";
            echo "<div class=\"center\" >Last id: ".$con->lastInsertId()."</div>";
        }
        else
        {
            echo "<div class=\"center\" >Zapis: ERROR!</div>";
        }
    }
    public function __getRow()
    {
        $con=$this->connectDB();
        $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`='1'");
        unset ($con);
        if($q)
        {
            $q = $q->fetch(PDO::FETCH_ASSOC);
            return $q;
        }
        else 
        {
            echo 'nie ustawione';
        }
    }
}
/**/
$setting = new GlobalSettingCls();
if(isset($_POST['save'])){//dodac usuwanie kodu html php itd......
    $setting->__setTable('global_setting');
    $setting->deleteTB();//jak sie bedzie tabela tworzyc z install to się pozmienia system i zostawi tylko update albo insert
    $setting->createTB();
    $setting->addRow('global_title_index');
    $setting->recRow($_POST['global_title_index']);
    $setting->addRow('global_keywords_index');
    $setting->recRow($_POST['global_keywords_index']);
    $setting->addRow('global_description_index');
    $setting->recRow($_POST['global_description_index']);
    $setting->addRow('global_title_category');
    $setting->recRow($_POST['global_title_category']);
    $setting->addRow('global_keywords_category');
    $setting->recRow($_POST['global_keywords_category']);
    $setting->addRow('global_description_category');
    $setting->recRow($_POST['global_description_category']);
    $setting->addRow('global_title_product');
    $setting->recRow($_POST['global_title_product']);
    $setting->addRow('global_keywords_product');
    $setting->recRow($_POST['global_keywords_product']);
    $setting->addRow('global_description_product');
    $setting->recRow($_POST['global_description_product']);
}
echo '</div>';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Zaplecze - Global Setting center</title>
	<?php include ("meta5.html"); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
<section id="place-holder">	
	<?php include ('menu_zap.php'); ?>
    <div>
        <?php 
        $setting->__setTable('global_setting');
        $get = $setting->__getRow();
        ?>
        <form enctype="multipart/form-data" action="" method="POST" >
            <table class="table-bck">
                <tr>
                    <th>SEO Globalne Ustawienia</th>
                </tr>
                <tr>
                    <th>Strona Głowna:</th>
                </tr>
                <tr>
                    <th>Tytuł (Title)</th>
                </tr>
                <tr>
                    <td><input id="" class="text-cls" type="text" name="global_title_index" value="<?php echo $get['global_title_index']; ?>" /></td>
                </tr>
                <tr>
                    <th>Słowa kluczowe (Keywords)</th>
                </tr>
                <tr>
                    <td><input id="" class="text-cls" type="text" name="global_keywords_index" value="<?php echo $get['global_keywords_index']; ?>" /></td>
                </tr>
                <tr>
                    <th>Opis (Description)</th>
                </tr>
                <tr>
                    <td><textarea id="" class="" type="" name="global_description_index" ><?php echo $get['global_description_index']; ?></textarea></td>
                </tr>
                <tr>
                    <th>Zapisz:</th>
                </tr>
                <tr>
                    <td><input id="" class="submit-cls" type="submit" name="save" value="Zapisz" /></td>
                </tr>
                <tr>
                    <th>Strona Kategorii:</th>
                </tr>
                <tr>
                    <th>Tytuł (Title)</th>
                </tr>
                <tr>
                    <td><input id="" class="text-cls" type="text" name="global_title_category" value="<?php echo $get['global_title_category']; ?>" /></td>
                </tr>
                <tr>
                    <th>Słowa kluczowe (Keywords)</th>
                </tr>
                <tr>
                    <td><input id="" class="text-cls" type="text" name="global_keywords_category" value="<?php echo $get['global_keywords_category']; ?>" /></td>
                </tr>
                <tr>
                    <th>Opis (Description)</th>
                </tr>
                <tr>
                    <td><textarea id="" class="" type="" name="global_description_category" ><?php echo $get['global_description_category']; ?></textarea></td>
                </tr>
                <tr>
                    <th>Zapisz:</th>
                </tr>
                <tr>
                    <td><input id="" class="submit-cls" type="submit" name="save" value="Zapisz" /></td>
                </tr>
                <tr>
                    <th>Strona Towaru:</th>
                </tr>
                <tr>
                    <th>Tytuł (Title)</th>
                </tr>
                <tr>
                    <td><input id="" class="text-cls" type="text" name="global_title_product" value="<?php echo $get['global_title_product']; ?>" /></td>
                </tr>
                <tr>
                    <th>Słowa kluczowe (Keywords)</th>
                </tr>
                <tr>
                    <td><input id="" class="text-cls" type="text" name="global_keywords_product" value="<?php echo $get['global_keywords_product']; ?>" /></td>
                </tr>
                <tr>
                    <th>Opis (Description)</th>
                </tr>
                <tr>
                    <td><textarea id="" class="" type="" name="global_description_product" ><?php echo $get['global_description_product']; ?></textarea></td>
                </tr>
                <tr>
                    <th>Zapisz:</th>
                </tr>
                <tr>
                    <td><input id="" class="submit-cls" type="submit" name="save" value="Zapisz" /></td>
                </tr>                
            </table>
        </form>
	</div>
	</section>
	<footer>
	</footer>
	<div id="debugged">
		<?php
		//echo "post";
		//var_dump ($_POST);
		//echo "session";
		//var_dump ($_SESSION);
		//echo "files";
		//var_dump ($_FILES);
		// echo "var2";
		 // var_dump ($var2);	
		//echo "cookies";
		//var_dump ($_COOKIE);
		?>
	</div>
</body>
</html>