<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
class Connect_Shipping
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
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
    public function __getAllTablesName()
    {
        $con = $this->connectDB();
        $res = $con->query('SHOW TABLES');
        while ($lol2 = $res->fetch(PDO::FETCH_ASSOC)) {
            var_dump($lol2);
        }
    }
    public function createSupplierTableName()
    {
        $con = $this->connectDB();
        $res = $con->query("CREATE TABLE IF NOT EXISTS `".$this->table."`(
                            `id` INTEGER AUTO_INCREMENT,            
                            `supplier_name` VARCHAR(20) UNIQUE,
                            `mod` INTEGER(10),
                            PRIMARY KEY(`id`)
                            )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1"
                            );
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public function createSupplier($supplier_name)
    {
        $con = $this->connectDB();
        $res = $con->query("CREATE TABLE IF NOT EXISTS `".$supplier_name."`(
                            `id` INTEGER AUTO_INCREMENT,            
                            `name` VARCHAR(20),
                            `configuration_mod` VARCHAR(20),
                            `weight_of` VARCHAR(20),
                            `weight_to` VARCHAR(20),
                            `price_of` VARCHAR(20),
                            `price_to` VARCHAR(20),
                            `package_share` VARCHAR(20),
                            `max_item_in_package` VARCHAR(20),
                            `allow_prepayment` VARCHAR(20),
                            `price_prepayment` VARCHAR(20),
                            `allow_ondelivery` VARCHAR(20),
                            `price_ondelivery` VARCHAR(20),
                            `free_of` VARCHAR(20),
                            `mod` INTEGER(10),
                            PRIMARY KEY(`id`)
                            )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1"
                            );
        if ($res) {
            $res2 = $con->query("INSERT INTO `".$this->table."`(
                            `supplier_name`
                            ) VALUES (
                            '".$supplier_name."'
                            )");
            if ($res2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        unset($con);
    }
    public function __getAllSupplierName()
    {
        $con = $this->connectDB();
        $res = $con->query("SELECT * FROM `".$this->table."`");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    public function addToSupplier()
    {
        isset($_SESSION['this_supplier']) ? $this_supplier = $_SESSION['this_supplier'] : $this_supplier = null;
        isset($_POST['shipping_configuration_mode']) ? $shipping_configuration_mode = $_POST['shipping_configuration_mode'] : $shipping_configuration_mode = null;
        isset($_POST['shipping_weight_of']) ? $shipping_weight_of = $_POST['shipping_weight_of'] : $shipping_weight_of = null;
        isset($_POST['shipping_weight_to']) ? $shipping_weight_to = $_POST['shipping_weight_to'] : $shipping_weight_to = null;
        isset($_POST['shipping_price_of']) ? $shipping_price_of = $_POST['shipping_price_of'] : $shipping_price_of = null;
        isset($_POST['shipping_price_to']) ? $shipping_price_to = $_POST['shipping_price_to'] : $shipping_price_to = null;
        isset($_POST['shipping_package_share']) ? $shipping_package_share = $_POST['shipping_package_share'] : $shipping_package_share = null;
        isset($_POST['shipping_max_item_in_package']) ? $shipping_max_item_in_package = $_POST['shipping_max_item_in_package'] : $shipping_max_item_in_package = null;
        isset($_POST['shipping_allow_prepayment']) ? $shipping_allow_prepayment = $_POST['shipping_allow_prepayment'] : $shipping_allow_prepayment = null;
        isset($_POST['shipping_price_prepayment']) ? $shipping_price_prepayment = $_POST['shipping_price_prepayment'] : $shipping_price_prepayment = null;
        isset($_POST['shipping_allow_ondelivery']) ? $shipping_allow_ondelivery = $_POST['shipping_allow_ondelivery'] : $shipping_allow_ondelivery = null;
        isset($_POST['shipping_price_ondelivery']) ? $shipping_price_ondelivery = $_POST['shipping_price_ondelivery'] : $shipping_price_ondelivery = null;
        isset($_POST['shipping_free_of']) ? $shipping_free_of = $_POST['shipping_free_of'] : $shipping_free_of = null;
        
        $con = $this->connectDB();
        $res = $con->query("INSERT INTO `".$_SESSION['this_supplier']."`(
                                `name`,
                                `configuration_mod`,
                                `weight_of`,
                                `weight_to`,
                                `price_of`,
                                `price_to`,
                                `package_share`,
                                `max_item_in_package`,
                                `allow_prepayment`,
                                `price_prepayment`,
                                `allow_ondelivery`,
                                `price_ondelivery`,
                                `free_of`,
                                `mod`
                                ) VALUES (
                                '".$this_supplier."',
                                '".$shipping_configuration_mode."',
                                '".$shipping_weight_of."',
                                '".$shipping_weight_to."',
                                '".$shipping_price_of."',
                                '".$shipping_price_to."',
                                '".$shipping_package_share."',
                                '".$shipping_max_item_in_package."',
                                '".$shipping_allow_prepayment."',
                                '".$shipping_price_prepayment."',
                                '".$shipping_allow_ondelivery."',
                                '".$shipping_price_ondelivery."',
                                '".$shipping_free_of."',
                                '0'
                                )");
        if ($res) {
                return true;
            } else {
                return false;
            }
        unset($con);
    }
    public function showSupplierConfig()
    {
        $con = $this->connectDB();
        $res = $con->query("SELECT * FROM `".$_SESSION['this_supplier']."`");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
}
$obj_shipping = new Connect_Shipping();
//next
if (isset($_POST['add']) && ! empty($_POST['supplier_name']) && $_POST['supplier_name'] != ' ') {
    $obj_shipping->__setTable('supplier');
    $success = $obj_shipping->createSupplierTableName();// to bedzie w install na bank (moze byc na sztywno)
    $success = $obj_shipping->createSupplier($_POST['supplier_name']);
}
$obj_shipping->__setTable('supplier');
$names = $obj_shipping->__getAllSupplierName();
//var_dump($names);
if (isset($_POST['set_this'])) {
    $_SESSION['this_supplier'] = $_POST['set_this'];
}
if (isset($_POST['unset_this'])) {
    unset($_SESSION['this_supplier']);
}
if (isset($_POST['add_new'])) {
    $success = $obj_shipping->addToSupplier();
}
if (isset($_SESSION['this_supplier'])) {
    $show = $obj_shipping->showSupplierConfig();
}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Koszty dostaw</title>
	<?php include ("meta5.html"); ?>
    <link href="../upload/uploadfile.css" rel="stylesheet">    
    <script src="../upload/jquery.uploadfile.js"></script>
</head>
<body>
	<section id="place-holder">				
		<?php include ('backroom-top-menu.php'); ?>
		<div class="back-all shipping placeholder">
            <form method="POST" >
                <table class="back-all shipping table">
                    <tr>
                        <th>Nazwa:</th>
                        <td colspan="2"><input id="" class="back-all shipping text" type="text" name="supplier_name" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input id="" class="back-all shipping submit" type="submit" name="add" value="Dodaj" /></td>
                        <td><input id="" class="back-all shipping submit" type="submit" name="cancel" value="Anuluj" /></td>
                    </tr>
                </table>
            </form>
            <form method="POST" >
            <?php
            if ($names) {
                // foreach ($names as $name) {
                    // echo $name;
                    // //var_dump($name);
                // }
                while ( $name = $names->fetch(PDO::FETCH_ASSOC)) {
                    //var_dump($name);
                    //echo $name['supplier_name'].'<br />';
                    ?>
                    <input id="" class="" type="submit" name="set_this" value="<?php echo $name['supplier_name']; ?>" />
                    <?php
                }
                ?>
                <input id="" class="" type="submit" name="unset_this" value="Zamknij" />
                <?php
            }
            ?>
            </form>
            <?php if (isset($_SESSION['this_supplier'])) { ?>
            <form method="POST" >
                <table class="back-all shipping table">
                    <tr>
                        <th>tryb konfiguracji</th>
                        <script type="text/javascript">
                            $(function(){
                                $( '.weight_mode, .price_mode' ).hide();
                                $(document).on('change', '#shipping_configuration_mode', function () {
                                    //console.log($( this ).val());
                                    if ($( this ).val() == 'weight') {
                                        $( '.weight_mode' ).show();
                                        $( '.price_mode' ).hide();
                                    } else if ($( this ).val() == 'price') {
                                        $( '.price_mode' ).show();
                                        $( '.weight_mode' ).hide();
                                    } else if ($( this ).val() == 'simple') {
                                        $( '.weight_mode, .price_mode' ).hide();
                                    }
                                });
                            });
                        </script>
                        <!-- Configuration mode -->
                        <th class="weight_mode">waga od</th>
                        <th class="weight_mode">waga do</th>
                        <th class="price_mode">cena od</th>
                        <th class="price_mode">cena do</th>
                        <!-- Configuration mode -->
                        <script type="text/javascript">
                            $(function(){
                                $( '.shipping_max_item_in_package' ).hide();
                                $(document).on('change', '#shipping_package_share', function () {
                                    console.log($( this ).val());
                                    if ($( this ).val() == 'yes') {
                                        $( '.shipping_max_item_in_package' ).hide();
                                    } else if ($( this ).val() == 'no') {
                                        $( '.shipping_max_item_in_package' ).show();
                                    }
                                });
                            });
                        </script>
                        <th>dziel na paczki</th>
                        <!-- package share -->
                        <th class="shipping_max_item_in_package">maksymalnie w paczce</th>
                        <!-- package share -->
                        <th>cena z przedpłata</th>
                        <th>dopuszczać za pobraniem</th>
                        <script type="text/javascript">
                            $(function(){
                                $( '.shipping_price_ondelivery' ).show();
                                $(document).on('change', '#shipping_allow_ondelivery', function () {
                                    console.log($( this ).val());
                                    if ($( this ).val() == 'yes') {
                                        $( '.shipping_price_ondelivery' ).show();
                                    } else if ($( this ).val() == 'no') {
                                        $( '.shipping_price_ondelivery' ).hide();
                                    }
                                });
                            });
                        </script>
                        <th class="shipping_price_ondelivery">cena za pobraniem</th>
                        <th>darmowa od</th>
                        <th>
                            <label><input id="" class="back-all shipping radio seo-radio" type="radio" name="shipping" checked="checked" value="title_false" /></label>
                            <label><input id="" class="back-all shipping radio seo-radio" type="radio" name="shipping" value="title_true" /></label>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <select id="shipping_configuration_mode" class="back-all shipping select" name="shipping_configuration_mode">
                                <option value="simple">Prosty</option>
                                <option value="weight">Przedziały wagowe</option>
                                <option value="price">Przedziały kwotowe</option>
                            </select>
                        </td>
                        <!-- Configuration mode -->
                        <td class="weight_mode"><input id="" class="back-all shipping text" type="text" name="shipping_weight_of" /></td>
                        <td class="weight_mode"><input id="" class="back-all shipping text" type="text" name="shipping_weight_to" /></td>
                        <td class="price_mode"><input id="" class="back-all shipping text" type="text" name="shipping_price_of" /></td>
                        <td class="price_mode"><input id="" class="back-all shipping text" type="text" name="shipping_price_to" /></td>
                        <!-- Configuration mode -->
                        <td>
                            <select id="shipping_package_share" class="back-all shipping select" name="shipping_package_share">
                                <option value="yes">Tak</option>
                                <option value="no">Nie</option>
                            </select>
                        </td>
                        <!-- package share -->
                        <td class="shipping_max_item_in_package"><input class="back-all shipping text" type="text" name="shipping_max_item_in_package" /></td>
                        <!-- package share -->
                        <td><input id="" class="back-all shipping text" type="text" name="shipping_price_prepayment" /></td>
                        <td>
                            <select id="shipping_allow_ondelivery" class="back-all shipping select" name="shipping_allow_ondelivery">
                                <option value="yes">Tak</option>
                                <option value="no">Nie</option>
                            </select>
                        </td>
                        <td class="shipping_price_ondelivery"><input id="" class="back-all shipping text" type="text" name="shipping_price_ondelivery" /></td>
                        <td><input id="" class="back-all shipping text" type="text" name="shipping_free_of" /></td>
                        <td><input id="" class="back-all shipping text" type="text" name="" /></td>
                    </tr>
                    <tr>
                        <td colspan="5"><input id="" class="back-all shipping submit" type="submit" name="add_new" value="Dodaj" /></td>
                        <td colspan="5"><input id="" class="back-all shipping submit" type="submit" name="cancel" value="Anuluj" /></td>
                    </tr>
                </table>
            </form>
            <?php } ?>
            <?php if (isset($show)) { ?>
                <?php
                while ( $shows = $show->fetch(PDO::FETCH_ASSOC)) {
                    var_dump($shows);
                }
                ?>
            <?php } ?>
		</div>
	</section>
	<footer></footer>
    <div class="catch">
        <?php
            if (isset($success)) {
                //echo 'isset';
                if ($success == true) {
                    echo 'Zapis udany';
                } else {
                    echo 'Błąd';
                }
            }
        ?>
    </div>
	<div id="debugger">
		<?php
		echo "post";
		var_dump (@$_POST);
		echo "session";
		var_dump ($_SESSION);
		// echo "files";
		// var_dump (@$_FILES);
		// echo "var2";
		 // var_dump ($var2);	
		//echo "cookies";
		//var_dump ($_COOKIE);
		?>
	</div>
</body>
</html>
