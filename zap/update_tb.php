<?php
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
header('Content-Type: text/html; charset=utf-8');
echo '<div class="catch">';
class UpgradeCls
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;
	private $row;
	private $path;
	public function _setTable($tab_name)
    {
		$this->table=$tab_name;
	}
    public function _setRow($row_name)
    {
		$this->row=$row_name;
	}
	public function connectDB()
    {
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
    public function addRow($name)
    {
        $this->_setRow($name);
        $con=$this->connectDB();
        $res=$con->query("ALTER TABLE `".$this->table."` ADD `".$this->row."` TEXT ");
        if ($res) {
            echo "<div class=\"center\" >Dodanie kolumny: {$this->row} OK!</div>";
        } else {
            echo "<div class=\"center\" >Dodanie kolumny: {$this->row} ERROR!</div>";
        }
    }
    public function recRow($value)//wgranie zawartości wywołane wewnątrz funkcji _getString
    {
        //zapis
		$con=$this->connectDB();
		$res=$con->query("UPDATE `".$this->table."` 
            SET
			`".$this->row."` = '".$value."'
			WHERE
            `id` = '1'
            ");
        if ($res) {
            echo "<div class=\"center\" >Zapis: OK!</div>";
            echo "<div class=\"center\" >Last id: ".$con->lastInsertId()."</div>";
        } else {
            echo "<div class=\"center\" >Zapis: ERROR!</div>";
        }
        unset($con);
    }
    public function recRowAll($value)//wgranie zawartości wywołane wewnątrz funkcji _getString
    {
        //zapis
		$con=$this->connectDB();
		$res=$con->query("UPDATE `".$this->table."` 
            SET
			`".$this->row."` = '".$value."'
            ");
        if ($res) {
            echo "<div class=\"center\" >Zapis: OK!</div>";
            echo "<div class=\"center\" >Last id: ".$con->lastInsertId()."</div>";
        } else {
            echo "<div class=\"center\" >Zapis: ERROR!</div>";
        }
        unset($con);
    }
}
//
$upgrade = new UpgradeCls();
if (isset($_POST['add1'])) {//dodane na kompie
    $upgrade->_setTable('product_tab'); 
    $upgrade->addRow('product_title');
    $upgrade->addRow('product_description');
    $upgrade->addRow('product_keywords');
}
if (isset($_POST['add2'])) {//dodane na kompie
    $upgrade->_setTable('product_category_main'); 
    $upgrade->addRow('mod');
    $upgrade->_setRow('mod');
    $upgrade->recRowAll('0');
    $upgrade->addRow('title');
    $upgrade->addRow('description');
    $upgrade->addRow('keywords');
    $upgrade->_setTable('product_category_sub'); 
    $upgrade->addRow('mod');
    $upgrade->_setRow('mod');
    $upgrade->recRowAll('0');
    $upgrade->addRow('title');
    $upgrade->addRow('description');
    $upgrade->addRow('keywords');
}
echo '</div>';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Zaplecze - Update index in base</title>
	<?php include ("meta5.html"); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
    <section id="place-holder">	
        <?php include ('menu_zap.php'); ?>
        <div class="center">
            <form method="POST">
                <input type="submit" name="add1" value="product_meta_data" />
                <input type="submit" name="add2" value="category_meta_data" />
            </form>
        </div>
    </section>

</body>
</html>