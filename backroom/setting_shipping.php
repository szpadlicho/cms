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
        isset($_POST['configuration_mod']) ? $configuration_mod = $_POST['configuration_mod'] : $configuration_mod = null;
        isset($_POST['weight_of']) ? $weight_of = $_POST['weight_of'] : $weight_of = null;
        isset($_POST['weight_to']) ? $weight_to = $_POST['weight_to'] : $weight_to = null;
        isset($_POST['price_of']) ? $price_of = $_POST['price_of'] : $price_of = null;
        isset($_POST['price_to']) ? $price_to = $_POST['price_to'] : $price_to = null;
        isset($_POST['package_share']) ? $package_share = $_POST['package_share'] : $package_share = null;
        isset($_POST['max_item_in_package']) ? $max_item_in_package = $_POST['max_item_in_package'] : $max_item_in_package = null;
        isset($_POST['allow_prepayment']) ? $allow_prepayment = $_POST['allow_prepayment'] : $allow_prepayment = null;
        isset($_POST['price_prepayment']) ? $price_prepayment = $_POST['price_prepayment'] : $price_prepayment = null;
        isset($_POST['allow_ondelivery']) ? $allow_ondelivery = $_POST['allow_ondelivery'] : $allow_ondelivery = null;
        isset($_POST['price_ondelivery']) ? $price_ondelivery = $_POST['price_ondelivery'] : $price_ondelivery = null;
        isset($_POST['free_of']) ? $free_of = $_POST['free_of'] : $free_of = null;
        
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
                                '".$configuration_mod."',
                                '".$weight_of."',
                                '".$weight_to."',
                                '".$price_of."',
                                '".$price_to."',
                                '".$package_share."',
                                '".$max_item_in_package."',
                                '".$allow_prepayment."',
                                '".$price_prepayment."',
                                '".$allow_ondelivery."',
                                '".$price_ondelivery."',
                                '".$free_of."',
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
        public function updateToSupplier()
    {
        isset($_SESSION['this_supplier']) ? $this_supplier = $_SESSION['this_supplier'] : $this_supplier = null;
        isset($_POST['configuration_mod']) ? $configuration_mod = $_POST['configuration_mod'] : $configuration_mod = null;
        isset($_POST['weight_of']) ? $weight_of = $_POST['weight_of'] : $weight_of = null;
        isset($_POST['weight_to']) ? $weight_to = $_POST['weight_to'] : $weight_to = null;
        isset($_POST['price_of']) ? $price_of = $_POST['price_of'] : $price_of = null;
        isset($_POST['price_to']) ? $price_to = $_POST['price_to'] : $price_to = null;
        isset($_POST['package_share']) ? $package_share = $_POST['package_share'] : $package_share = null;
        isset($_POST['max_item_in_package']) ? $max_item_in_package = $_POST['max_item_in_package'] : $max_item_in_package = null;
        isset($_POST['allow_prepayment']) ? $allow_prepayment = $_POST['allow_prepayment'] : $allow_prepayment = null;
        isset($_POST['price_prepayment']) ? $price_prepayment = $_POST['price_prepayment'] : $price_prepayment = null;
        isset($_POST['allow_ondelivery']) ? $allow_ondelivery = $_POST['allow_ondelivery'] : $allow_ondelivery = null;
        isset($_POST['price_ondelivery']) ? $price_ondelivery = $_POST['price_ondelivery'] : $price_ondelivery = null;
        isset($_POST['free_of']) ? $free_of = $_POST['free_of'] : $free_of = null;
        
        $con = $this->connectDB();
        $res = $con->query("UPDATE `".$_SESSION['this_supplier']."`
                                SET
                                `name` = '".$this_supplier."',
                                `configuration_mod` = '".$configuration_mod."',
                                `weight_of` = '".$weight_of."',
                                `weight_to` = '".$weight_to."',
                                `price_of` = '".$price_of."',
                                `price_to` = '".$price_to."',
                                `package_share` = '".$package_share."',
                                `max_item_in_package` = '".$max_item_in_package."',
                                `allow_prepayment` = '".$allow_prepayment."',
                                `price_prepayment` = '".$price_prepayment."',
                                `allow_ondelivery` = '".$allow_ondelivery."',
                                `price_ondelivery` = '".$price_ondelivery."',
                                `free_of` = '".$free_of."',
                                `mod` = '0'
                                WHERE
                                `id` = '".$_POST['curent_id']."'
                                ");
        if ($res) {
                return true;
            } else {
                return false;
            }
        unset($con);
        $res = $con->query("UPDATE `".$table."` 
                                SET
                                `amount` = '".$value."'
                                WHERE
                                `pr_id` = '".$pr_id."'
                                ");
    }
    public function deleteTable($table)
    {
        $con = $this->connectDB();
        $res = $con->query('DROP TABLE `'.$table.'`');
        return $res ? true : false;
    }
    public function deleteFromSupplier()
    {
		$con=$this->connectDB();
		$con->query("DELETE FROM `".$_SESSION['this_supplier']."` WHERE `id` = '".$_POST['curent_id']."'");	
		unset ($con);
	
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
if (isset($_POST['update'])) {
    $obj_shipping->updateToSupplier();
}
if (isset($_POST['delete'])) {
    $success = $obj_shipping->deleteFromSupplier();
}
if (isset($_SESSION['this_supplier'])) { // must be last !important
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
                                $( '.weight_mod, .price_mod' ).hide();
                                $(document).on('change', '#configuration_mod', function () {
                                    //console.log($( this ).val());
                                    if ($( this ).val() == 'weight') {
                                        $( '.weight_mod' ).show();
                                        $( '.price_mod' ).hide();
                                    } else if ($( this ).val() == 'price') {
                                        $( '.price_mod' ).show();
                                        $( '.weight_mod' ).hide();
                                    } else if ($( this ).val() == 'simple') {
                                        $( '.weight_mod, .price_mod' ).hide();
                                    }
                                });
                            });
                        </script>
                        <!-- Configuration mode -->
                        <th class="weight_mod">waga od</th>
                        <th class="weight_mod">waga do</th>
                        <th class="price_mod">cena od</th>
                        <th class="price_mod">cena do</th>
                        <!-- Configuration mode -->
                        <script type="text/javascript">
                            $(function(){
                                $( '.max_item_in_package' ).hide();
                                $(document).on('change', '#package_share', function () {
                                    //console.log($( this ).val());
                                    if ($( this ).val() == 'yes') {
                                        $( '.max_item_in_package' ).hide();
                                    } else if ($( this ).val() == 'no') {
                                        $( '.max_item_in_package' ).show();
                                    }
                                });
                            });
                        </script>
                        <th>Każdy w osobnej paczce</th>
                        <!-- package share -->
                        <th class="max_item_in_package">maksymalnie w paczce</th>
                        <!-- package share -->
                        <th>cena z przedpłata</th>
                        <th>dopuszczać za pobraniem</th>
                        <script type="text/javascript">
                            $(function(){
                                $( '.price_ondelivery' ).show();
                                $(document).on('change', '#allow_ondelivery', function () {
                                    //console.log($( this ).val());
                                    if ($( this ).val() == 'yes') {
                                        $( '.price_ondelivery' ).show();
                                    } else if ($( this ).val() == 'no') {
                                        $( '.price_ondelivery' ).hide();
                                    }
                                });
                            });
                        </script>
                        <th class="price_ondelivery">cena za pobraniem</th>
                        <th>darmowa od</th>
                        <th>
                            <label><input id="" class="back-all shipping radio seo-radio" type="radio" name="shipping" checked="checked" value="title_false" /></label>
                            <label><input id="" class="back-all shipping radio seo-radio" type="radio" name="shipping" value="title_true" /></label>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <select id="configuration_mod" class="back-all shipping select" name="configuration_mod">
                                <option value="simple">Prosty</option>
                                <option value="weight">Przedziały wagowe</option>
                                <option value="price">Przedziały kwotowe</option>
                            </select>
                        </td>
                        <!-- Configuration mode -->
                        <td class="weight_mod"><input id="" class="back-all shipping text" type="text" name="weight_of" /></td>
                        <td class="weight_mod"><input id="" class="back-all shipping text" type="text" name="weight_to" /></td>
                        <td class="price_mod"><input id="" class="back-all shipping text" type="text" name="price_of" /></td>
                        <td class="price_mod"><input id="" class="back-all shipping text" type="text" name="price_to" /></td>
                        <!-- Configuration mode -->
                        <td>
                            <select id="package_share" class="back-all shipping select" name="package_share">
                                <option value="yes">Tak</option>
                                <option value="no">Nie</option>
                            </select>
                        </td>
                        <!-- package share -->
                        <td class="max_item_in_package"><input class="back-all shipping text" type="text" name="max_item_in_package" /></td>
                        <!-- package share -->
                        <td><input id="" class="back-all shipping text" type="text" name="price_prepayment" /></td>
                        <td>
                            <select id="allow_ondelivery" class="back-all shipping select" name="allow_ondelivery">
                                <option value="yes">Tak</option>
                                <option value="no">Nie</option>
                            </select>
                        </td>
                        <td class="price_ondelivery"><input id="" class="back-all shipping text" type="text" name="price_ondelivery" /></td>
                        <td><input id="" class="back-all shipping text" type="text" name="free_of" /></td>
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
                while ( $row = $show->fetch(PDO::FETCH_ASSOC)) { ?>
                    <form method="POST" >
                        <table class="back-all shipping table">
                            <tr>
                                <th>tryb konfiguracji</th>
                                <script type="text/javascript">
                                    $(function(){
                                        $( '.weight_mod_<?php echo $row['id']; ?>, .price_mod_<?php echo $row['id']; ?>' ).hide();
                                        var confMod = function() {
                                            if ($( '#configuration_mod_<?php echo $row['id']; ?>' ).val() == 'weight') {
                                                $( '.weight_mod_<?php echo $row['id']; ?>' ).show();
                                                $( '.price_mod_<?php echo $row['id']; ?>' ).hide();
                                                $( '.price_mod_<?php echo $row['id']; ?> > input' ).removeAttr('value');//clear unused field
                                            } else if ($( '#configuration_mod_<?php echo $row['id']; ?>' ).val() == 'price') {
                                                $( '.price_mod_<?php echo $row['id']; ?>' ).show();
                                                $( '.weight_mod_<?php echo $row['id']; ?>' ).hide();
                                                $( '.weight_mod_<?php echo $row['id']; ?> > input' ).removeAttr('value');//clear unused field
                                            } else if ($( '#configuration_mod_<?php echo $row['id']; ?>' ).val() == 'simple') {
                                                $( '.weight_mod_<?php echo $row['id']; ?>, .price_mod_<?php echo $row['id']; ?>' ).hide();
                                                $( '.weight_mod_<?php echo $row['id']; ?> > input, .price_mod_<?php echo $row['id']; ?> > input' ).removeAttr('value');//clear unused field
                                            }
                                        }
                                        confMod();
                                        $(document).on('change', '#configuration_mod_<?php echo $row['id']; ?>', function () {
                                            //console.log($( this ).val());
                                            confMod();
                                        });
                                    });
                                </script>
                                <!-- Configuration mode -->
                                <th class="weight_mod_<?php echo $row['id']; ?>">waga od</th>
                                <th class="weight_mod_<?php echo $row['id']; ?>">waga do</th>
                                <th class="price_mod_<?php echo $row['id']; ?>">cena od</th>
                                <th class="price_mod_<?php echo $row['id']; ?>">cena do</th>
                                <!-- Configuration mode -->
                                <script type="text/javascript">
                                    $(function(){
                                        $( '.max_item_in_package_<?php echo $row['id']; ?>' ).hide();
                                        var packShare = function() {
                                            if ($( '#package_share_<?php echo $row['id']; ?>' ).val() == 'yes') {
                                                $( '.max_item_in_package_<?php echo $row['id']; ?>' ).hide();
                                            } else if ($( '#package_share_<?php echo $row['id']; ?>' ).val() == 'no') {
                                                $( '.max_item_in_package_<?php echo $row['id']; ?>' ).show();
                                            }
                                        }
                                        packShare();
                                        $(document).on('change', '#package_share_<?php echo $row['id']; ?>', function () {
                                            //console.log($( this ).val());
                                            packShare();
                                        });
                                    });
                                </script>
                                <th>dziel na paczki</th>
                                <!-- package share -->
                                <th class="max_item_in_package_<?php echo $row['id']; ?>">maksymalnie w paczce</th>
                                <!-- package share -->
                                <th>cena z przedpłata</th>
                                <th>dopuszczać za pobraniem</th>
                                <script type="text/javascript">
                                    $(function(){
                                        $( '.price_ondelivery_<?php echo $row['id']; ?>' ).show();
                                        var allowOndel = function() {
                                            if ($( '#allow_ondelivery_<?php echo $row['id']; ?>' ).val() == 'yes') {
                                                $( '.price_ondelivery_<?php echo $row['id']; ?>' ).show();
                                            } else if ($( '#allow_ondelivery_<?php echo $row['id']; ?>' ).val() == 'no') {
                                                $( '.price_ondelivery_<?php echo $row['id']; ?>' ).hide();
                                            }
                                        }
                                        allowOndel();
                                        $(document).on('change', '#allow_ondelivery_<?php echo $row['id']; ?>', function () {
                                            //console.log($( this ).val());
                                            allowOndel();
                                        });
                                    });
                                </script>
                                <!-- allow ondelivery -->
                                <th class="price_ondelivery_<?php echo $row['id']; ?>">cena za pobraniem</th>
                                <!-- allow ondelivery -->
                                <th>darmowa od</th>
                                <th>
                                    <label><input id="" class="back-all shipping radio seo-radio" type="radio" name="shipping" checked="checked" value="title_false" /></label>
                                    <label><input id="" class="back-all shipping radio seo-radio" type="radio" name="shipping" value="title_true" /></label>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <?php $val1 = $row['configuration_mod'] ;?>
                                    <select id="configuration_mod_<?php echo $row['id']; ?>" class="back-all shipping select" name="configuration_mod">
                                        <option <?php if ($val1 == 'simple') { echo 'selected'; } ?> value="simple">Prosty</option>
                                        <option <?php if ($val1 == 'weight') { echo 'selected'; } ?> value="weight">Przedziały wagowe</option>
                                        <option <?php if ($val1 == 'price') { echo 'selected'; } ?> value="price">Przedziały kwotowe</option>
                                    </select>
                                    
                                </td>
                                <!-- Configuration mode -->
                                <td class="weight_mod_<?php echo $row['id']; ?>"><input id="" class="back-all shipping text" type="text" name="weight_of" value="<?php echo $row['weight_of'] ;?>" /></td>
                                <td class="weight_mod_<?php echo $row['id']; ?>"><input id="" class="back-all shipping text" type="text" name="weight_to" value="<?php echo $row['weight_to'] ;?>" /></td>
                                <td class="price_mod_<?php echo $row['id']; ?>"><input id="" class="back-all shipping text" type="text" name="price_of" value="<?php echo $row['price_of'] ;?>" /></td>
                                <td class="price_mod_<?php echo $row['id']; ?>"><input id="" class="back-all shipping text" type="text" name="price_to" value="<?php echo $row['price_to'] ;?>" /></td>
                                <!-- Configuration mode -->
                                <td>
                                    <?php $val2 = $row['package_share'] ;?>
                                    <select id="package_share_<?php echo $row['id']; ?>" class="back-all shipping select" name="package_share">
                                        <option <?php if ($val2 == 'yes') { echo 'selected'; } ?> value="yes">Tak</option>
                                        <option <?php if ($val2 == 'no') { echo 'selected'; } ?> value="no">Nie</option>
                                    </select>
                                </td>
                                <!-- package share -->
                                <td class="max_item_in_package_<?php echo $row['id']; ?>"><input class="back-all shipping text" type="text" name="max_item_in_package" value="<?php echo $row['max_item_in_package'] ;?>" /></td>
                                <!-- package share -->
                                <td><input id="" class="back-all shipping text" type="text" name="price_prepayment" value="<?php echo $row['price_prepayment'] ;?>" /></td>
                                <td>
                                    <?php $val3 = $row['allow_ondelivery'] ;?>
                                    <select id="allow_ondelivery_<?php echo $row['id']; ?>" class="back-all shipping select" name="allow_ondelivery">
                                        <option <?php if ($val3 == 'yes') { echo 'selected'; } ?> value="yes">Tak</option>
                                        <option <?php if ($val3 == 'no') { echo 'selected'; } ?> value="no">Nie</option>
                                    </select>
                                </td>
                                <!-- allow ondelivery -->
                                <td class="price_ondelivery_<?php echo $row['id']; ?>"><input id="" class="back-all shipping text" type="text" name="price_ondelivery" value="<?php echo $row['price_ondelivery'] ;?>" /></td>
                                <!-- allow ondelivery -->
                                <td><input id="" class="back-all shipping text" type="text" name="free_of" value="<?php echo $row['free_of'] ;?>" /></td>
                                <td><input id="" class="back-all shipping text" type="text" name="" /></td>
                            </tr>
                            <tr>
                                <td colspan="5"><input id="" class="back-all shipping submit" type="submit" name="update" value="Aktualizuj" /></td>
                                <td colspan="5"><input id="" class="back-all shipping submit" type="submit" name="delete" value="Usuń" /></td>
                            </tr>
                        </table>
                        <input type="hidden" name="curent_id" value="<?php echo $row['id']; ?>" />
                    </form>
                    <?php
                    //var_dump($row);
                    ?>
                <?php } ?>
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
