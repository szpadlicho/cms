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
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
	}
    public function __setRow($row_name)
    {
		$this->row = $row_name;
	}
	public function connectDB()
    {
		$con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
    public function addRow($name)
    {
        $this->__setRow($name);
        $con = $this->connectDB();
        $res = $con->query("ALTER TABLE `".$this->table."` ADD `".$this->row."` TEXT ");
        if ($res) {
            echo "<div class=\"center\" >Dodanie kolumny: {$this->row} OK!</div>";
        } else {
            echo "<div class=\"center\" >Dodanie kolumny: {$this->row} ERROR!</div>";
        }
    }
    public function recRow($value)//wgranie zawartości wywołane wewnątrz funkcji _getString
    {
        //zapis
		$con = $this->connectDB();
		$res = $con->query("UPDATE `".$this->table."` 
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
		$con = $this->connectDB();
		$res = $con->query("UPDATE `".$this->table."` 
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
    public function addRowDynamic($arr_row)
    {
        $con = $this->connectDB();
        $content = '';
        foreach ($arr_row as $name => $value) {
            $content .= 'ADD COLUMN `'.$name.'` '.$value.',';
        }       
        $res = $con->query("ALTER TABLE `".$this->table."` ".$content." ADD COLUMN `mod2` TEXT");
        if ($res) {
            echo "<div class=\"center\" >Dodanie kolumny: add OK!</div>";
        } else {
            echo "<div class=\"center\" >Dodanie kolumny: add ERROR!</div>";
        }
    }
    public function addRowDynamic2($arr_row)
    {
        $con = $this->connectDB();
        foreach ($arr_row as $name => $value) {
            $res = $con->query("ALTER TABLE `".$this->table."` ADD COLUMN `".$name."` ".$value."");
            if ($res) {
                echo "<div class=\"center\" >Dodanie kolumny: add ".$name."=>".$value." OK!</div>";
            } else {
                echo "<div class=\"center\" >Dodanie kolumny: add ".$name."=>".$value." ERROR!</div>";
            }
        }
    }
    public function addRowDynamic3($arr_row)
    {
        $con = $this->connectDB();
        foreach ($arr_row as $name => $value) {
            $res = $con->query("ALTER TABLE `".$this->table."` ADD COLUMN `".$name."` ".$value." AFTER predefined");
            if ($res) {
                echo "<div class=\"center\" >Dodanie kolumny: add ".$name."=>".$value." OK!</div>";
            } else {
                echo "<div class=\"center\" >Dodanie kolumny: add ".$name."=>".$value." ERROR!</div>";
            }
        }
    }
    public function renameColumn($old_name, $new_name)
    {
        $con = $this->connectDB();
        // foreach ($arr_row as $name => $value) {
            // $res = $con->query("ALTER TABLE `".$this->table."` ADD COLUMN `".$name."` ".$value."");
            // if ($res) {
                // echo "<div class=\"center\" >Dodanie kolumny: add ".$name."=>".$value." OK!</div>";
            // } else {
                // echo "<div class=\"center\" >Dodanie kolumny: add ".$name."=>".$value." ERROR!</div>";
            // }
        // }
        $res = $con->query("ALTER TABLE `".$this->table."` CHANGE ".$old_name." ".$new_name." INTEGER(10) UNSIGNED");
        if ($res) {
            echo "<div class=\"center\" >Zmiana nazwy z ".$old_name." na ".$new_name." OK!</div>";
        } else {
            echo "<div class=\"center\" >Zmiana nazwy z ".$old_name." na ".$new_name." ERROR!</div>";
        }
    }
}
//
$upgrade = new UpgradeCls();
/*
if (isset($_POST['add1'])) {//dodane na kompie
    $upgrade->__setTable('product_tab'); 
    $upgrade->addRow('product_title');
    $upgrade->addRow('product_description');
    $upgrade->addRow('product_keywords');
}
if (isset($_POST['add2'])) {//dodane na kompie
    $upgrade->__setTable('product_category_main'); 
    $upgrade->addRow('mod');
    $upgrade->__setRow('mod');
    $upgrade->recRowAll('0');
    $upgrade->addRow('title');
    $upgrade->addRow('description');
    $upgrade->addRow('keywords');
    $upgrade->__setTable('product_category_sub'); 
    $upgrade->addRow('mod');
    $upgrade->__setRow('mod');
    $upgrade->recRowAll('0');
    $upgrade->addRow('title');
    $upgrade->addRow('description');
    $upgrade->addRow('keywords');
}
*/
if (isset($_POST['add3'])) {//dodane na kompie
    $upgrade->__setTable('product_tab');
    $upgrade->renameColumn('product_number', 'amount');
}
if (isset($_POST['add4'])) {//dodane na kompie
    $upgrade->__setTable('product_tab');
    //$upgrade->renameColumn('product_number', 'amount');
    $arr_row = array(
        'shipping_mod'              =>'INTEGER(10) UNSIGNED', 
        'predefined'                =>'VARCHAR(50)', 
        'weight'                    =>'INTEGER(100) UNSIGNED', 
        'allow_prepaid'             =>'INTEGER(10) UNSIGNED',
        'price_prepaid'             =>'VARCHAR(50)',
        'allow_ondelivery'          =>'INTEGER(10) UNSIGNED',
        'price_ondelivery'          =>'VARCHAR(50)',
        'package_share'             =>'INTEGER(10) UNSIGNED',
        'max_item_in_package'       =>'INTEGER(100) UNSIGNED'
        );
    $upgrade->addRowDynamic2($arr_row);
}
if (isset($_POST['add5'])) {//dodane na kompie
    $upgrade->__setTable('supplier');
    //$upgrade->renameColumn('product_number', 'amount');
    $arr_row = array(
        'supplier_name_d'              =>'VARCHAR(30)'
        );
    $upgrade->addRowDynamic2($arr_row);
}
if (isset($_POST['add6'])) {//dodane na kompie
    $upgrade->__setTable('product_tab');
    $arr_row = array(
        'predefined_d'              =>'VARCHAR(30)'
        );
    $upgrade->addRowDynamic3($arr_row);
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
        <?php include ('backroom-top-menu.php'); ?>
        <div class="center">
            <form method="POST">
                <!--
                <input type="submit" name="add1" value="product_meta_data" />
                <input type="submit" name="add2" value="category_meta_data" />
                -->
                <input type="submit" name="add3" value="product number to amount" />
                
                <input type="submit" name="add4" value="shipping add to product tab" />
                <input type="submit" name="add5" value="supplier_name_d" />
                <input type="submit" name="add6" value="predefined_d" />
            </form>
        </div>
    </section>

</body>
</html>