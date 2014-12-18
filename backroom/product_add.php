<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
class ProduktSetCls 
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;// ma miec
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
    public function createFileName($id)
    {
        //$con=$this->connectDB();
        //$res=$con->query("ALTER TABLE `".$this->table."` ADD `file_name` TEXT");//do zakomentowania po update install.php
        $file_name = $_POST['product_name'];
        $file_name = ltrim($file_name);
        $file_name = rtrim($file_name);
        $file_name = str_replace(array('ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'), array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'), $file_name);
        $file_name = str_replace(array('Ą', 'Ć', 'Ę', 'Ł', 'Ń', 'Ó', 'Ś', 'Ź', 'Ż'), array('A', 'C', 'E', 'L', 'N', 'O', 'S', 'Z', 'Z'), $file_name);
        $file_name = str_replace(' ', '-', $file_name);
        //$file_name = preg_replace('/[^0-9a-z\-]+/', '', $file_name);//usun wszystko co jest zabronionym znakiem
        $file_name = preg_replace('/[:\^\*\+]/', '', $file_name);//usun wszystko co jest zabronionym znakiem
        //unset ($con); 
        return $id.'-'.$file_name;
    }
	public function createREC($next_id)
    {
		/*zapis do tablei tylko raz*/
        $_POST['seo_setting']=='title_true' ? $mod=1 : $mod=0 ;
        isset($_POST['title']) ? $title = $_POST['title'] : $title = null ;
        isset($_POST['description']) ? $description = substr($_POST['description'], 0, 200) : $description = null ;
        isset($_POST['keywords']) ? $keywords = $_POST['keywords'] : $keywords = null ;
        /*SHIPPING*/
        if (isset($_POST['shipping_mod'])) {
            if ($_POST['shipping_mod'] == 'suppliers_false') {
                $shipping_mod = 0;
            } elseif ($_POST['shipping_mod'] == 'suppliers_true') {
                $shipping_mod = 1;
            }
        } else {
            $shipping_mod = 0;
        }
        if (isset($_POST['predefined'])) {
            $value = explode('|', $_POST['predefined']);
            isset($value[0]) ? $predefined = $value[0] : $predefined = null ;
            isset($value[1]) ? $predefined_d = $value[1] : $predefined_d = null ;
        }   else {
            $predefined = null;
            $predefined_d = null;
        }
        isset($_POST['weight']) ? $weight = $_POST['weight'] : $weight = null ;
        isset($_POST['allow_prepaid']) ? $allow_prepaid = $_POST['allow_prepaid'] : $allow_prepaid = 1 ;
        isset($_POST['price_prepaid']) ? $price_prepaid = $_POST['price_prepaid'] : $price_prepaid = null ;
        isset($_POST['allow_ondelivery']) ? $allow_ondelivery = $_POST['allow_ondelivery'] : $allow_ondelivery = 1 ;
        isset($_POST['price_ondelivery']) ? $price_ondelivery = $_POST['price_ondelivery'] : $price_ondelivery = null ;
        isset($_POST['package_share']) ? $package_share = $_POST['package_share'] : $package_share = 0 ;
        isset($_POST['max_item_in_package']) ? $max_item_in_package = $_POST['max_item_in_package'] : $max_item_in_package = null ;
        isset($_POST['connect_package']) ? $connect_package = $_POST['connect_package'] : $connect_package = 0;
        isset($_POST['only_if_the_same']) ? $only_if_the_same = $_POST['only_if_the_same'] : $only_if_the_same = 0;
		$con=$this->connectDB();
		//$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		//$count = $q -> fetch();/*konwertor na tablice*/
		//if(!$count){
			$feedback = $con->exec("INSERT INTO `".$this->table."`(
			`product_name`, 
			`product_price`, 
			`amount`,
			`product_category_main`,
			`product_category_sub`,
			`product_description_small`,
			`product_description_large`,
			`product_foto_mini`,
			`product_foto_large`,
			`mod`,
            `file_name`,           
            `product_title`,
            `product_description`,
            `product_keywords`,
            `shipping_mod`,
            `predefined`,
            `predefined_d`,
            `weight`,
            `allow_prepaid`,
            `price_prepaid`,
            `allow_ondelivery`,
            `price_ondelivery`,
            `package_share`,
            `max_item_in_package`,
            `connect_package`,
            `only_if_the_same`
			) VALUES (
			'".$_POST['product_name']."',
			'".str_replace(",",".",$_POST['product_price'])."',
			'".(int)$_POST['amount']."',
			'".$_POST['product_category_main']."',  
			'".$_POST['product_category_sub']."',
			'".$_POST['product_description_small']."',
			'".$_POST['product_description_large']."',
			'0',
			'0',
			'".$mod."',
            '".$this->createFileName($next_id)."',
            '".trim($title)."',
            '".trim($description)."',
            '".trim($keywords)."',
            '".(int)$shipping_mod."',
            '".$predefined."',
            '".$predefined_d."',
            '".str_replace(",",".",$weight)."',
            '".(int)$allow_prepaid."',
            '".str_replace(',', '.',$price_prepaid)."',
            '".(int)$allow_ondelivery."',
            '".str_replace(',', '.',$price_ondelivery)."',
            '".(int)$package_share."',
            '".(int)$max_item_in_package."',
            '".(int)$connect_package."',
            '".(int)$only_if_the_same."'
			)");
		unset ($con);
        //echo "<div class=\"center\" >zapis udany</div>";
        if ($feedback) {
            return true;
        } else {
            return false;
        }
	}
	public function showCategory()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT `".$this->table."` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function _getLastId()
    {
        $con=$this->connectDB();
        $next_id = $con->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'product_tab'");
        $next_id = $next_id->fetch();
        return $next_id;
    }
    public function createFile($rec)// $rec=$next_id_is
    {
        $content='<?php
        include_once \'../classes/connect/load.php\';
        $load = new Connect_Load;
        $load->__setTable(\'index_pieces\');
        $q = $load->loadIndex();
        $product_now_display=\''.$rec.'\';
        ';
        //'. PHP_EOL .' nowa linia
        //title = category + subcategory + product name
        //description
        //keyword
        $content .='
        eval(\'?>\'.$q[\'php_beafor_html\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p1\'].\'<?php \');
        //--
        $load->__setTable(\'product_tab\');
        $meta = $load->metaDataProduct($product_now_display);
        //--
        $load->__setTable(\'setting_seo\');
        $global = $load->globalMetaData();
        //--
        if ($meta[\'product_title\']!=null) {
            echo \'<title>\'.$meta[\'product_title\'].\'</title>\';
        } else {
            echo \'<title>\'.$global[\'global_title_product\'].\'</title>\';
        }
        
        if ($meta[\'product_description\']!=null) {
            echo \'<meta name="description" content="\'.$meta[\'product_description\'].\'" />\';
        } else {
            echo \'<meta name="description" content="\'.$global[\'global_description_product\'].\'" />\';
        }
        
        if ($meta[\'product_keywords\']!=null) {
            echo \'<meta name="keywords" content="\'.$meta[\'product_keywords\'].\'" />\';
        } else {
            echo \'<meta name="keywords" content="\'.$global[\'global_keywords_product\'].\'" />\';
        }
        //---
        eval(\'?>\'.$q[\'head_include\'].\'<?php \');
        eval(\'?>\'.$q[\'head_p1\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p2\'].\'<?php \');
        //here
        eval(\'?>\'.$q[\'html_p3\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p4\'].\'<?php \');
        ?>';
        $path = '../product/'.$this->createFileName($rec).'.php';//gdzie i jak apisac
        $out_file = fopen($path, 'w');
        fwrite($out_file, $content);
        fclose($out_file);
    }
    public function __getAllSupplierName()
    {
        $con = $this->connectDB();
        $res = $con->query("SELECT * FROM `shipping_".$this->table."`");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
}
$next_id_is = new ProduktSetCls();
$next_id_is->__setTable('product_tab');
$next_is = $next_id_is->_getLastId();
$next_id = $next_is['AUTO_INCREMENT'];
$id = $next_id;//for upload system
if (isset($_POST['save'])) {
	$product = new ProduktSetCls();
	$product->__setTable('product_tab');
	$success = $product->createREC($next_id);
	$product->createFile($next_id);
    header('Location: product_list.php');
    //echo("<script>location.href = 'product_list.php';</script>");
}
//echo 'next id is: '.$next_id;
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Nowy</title>
	<?php include ("meta5.html"); ?>
    <link href="../upload/uploadfile.css" rel="stylesheet">    
    <script src="../upload/jquery.uploadfile.js"></script>
</head>
<body>
	<section id="place-holder">				
		<?php include ('backroom-top-menu.php'); ?>
		<div class="back-all add placeholder">
            <form enctype="multipart/form-data" action="" method="POST" >
                <table class="back-all add table">
                    <tr>
                        <th>ID:</th>
                        <th><?php echo $next_id; ?></th>
                        <th>Nazwa:</th>
                        <td>
                            <input id="" class="back-all add text" type="text" name="product_name" />
                        </td>
                    </tr>
                    <tr>
                        <th>Cena:</th>
                        <td>
                            <input id="" class="back-all add text" type="text" name="product_price" />
                        </td>
                        <th>Ilość:</th>
                        <td>
                            <input id="" class="back-all add text" type="text" name="amount" />
                        </td>
                    </tr>
                    <tr>
                        <th>Zapisz:</th>
                        <td colspan="3">
                            <input id="" class="back-all add submit" type="submit" name="save" value="Zapisz" />
                        </td>
                    </tr>
                    <tr>
                        <th>Przypisz do Kategorii<br />Pozycji w górnym Menu:</th>
                        <td>
                            <select class="back-all add select" name="product_category_main">
                                <option></option>
                            <?php
                            $main= new ProduktSetCls();
                            $main->__setTable('product_category_main');
                            if ($main->showCategory()) {
                                foreach ($main->showCategory() as $cat) {
                                    echo '<option value="'.$cat['product_category_main'].'">';
                                    echo $cat['product_category_main'];
                                    echo '</option>';
                                }
                            }
                            ?>
                            </select>
                        </td>
                        <th>Przypisz do Podkategorii<br />Pozycji w lewym Menu:</th>
                        <td>
                            <select class="back-all add select" name="product_category_sub">
                                <option></option>
                            <?php
                            $sub = new ProduktSetCls();
                            $sub->__setTable('product_category_sub');
                            if ($sub->showCategory()) {
                                foreach ($sub->showCategory() as $cat) {
                                    echo '<option value="'.$cat['product_category_sub'].'">';
                                    echo $cat['product_category_sub'];
                                    echo '</option>';
                                }
                            }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td colspan="3">
                            <textarea id="" class="back-all add textarea" name="product_description_small" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Zapisz:</th>
                        <td  colspan="3">
                            <input id="" class="back-all add submit" type="submit" name="update" value="Zapisz" />
                        </td>
                    </tr>
                    <tr>
                        <th>Opis:</th>
                        <td colspan="3">
                            <textarea id="" class="back-all add textarea" name="product_description_large" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4">Miniaturka:</th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="back-all add div"><?php include('../upload/up_small.php'); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4">Zdjęcia:</th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="back-all add div"><?php include('../upload/up_large.php'); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>Zapisz:</th>
                        <td colspan="3">
                            <input id="" class="back-all add submit" type="submit" name="save" value="Zapisz" />
                        </td>
                    </tr>
                    <!-- SHIPPING -->
                        <tr>
                            <script type="text/javascript">
                                var shipping = function(){
                                    if( $('input[value="suppliers_true"]').is(":checked") ) {
                                        $('.suppliers-tr-two').show();
                                        $( '#allow_prepaid, #allow_ondelivery, #price_prepaid, #price_ondelivery, #package_share, #max_item_in_package, #connect_one, #connect_two' ).prop( "disabled", false );
                                        $('.suppliers-tr-one').hide();
                                    } else {
                                        $('.suppliers-tr-two').hide();
                                        $( '#allow_prepaid, #allow_ondelivery, #price_prepaid, #price_ondelivery, #package_share, #max_item_in_package, #connect_one, #connect_two' ).prop( "disabled", true );
                                        $('.suppliers-tr-one').show();
                                    }
                                }
                                $(document).ready(function(){
                                    $('input[type="radio"]').each(function() { 
                                        $( this ).change(function(){
                                            shipping();
                                        });
                                    });
                                });
                                $(window).load(function() {
                                    $('input[type="radio"]').each(function() { 
                                        shipping();
                                    }); 
                                });
                            </script>
                            <th>
                                Tryb dostawców
                            </th>
                            <td colspan="3">
                                <label><input id="" class="back-all edit radio suppliers-radio" type="radio" name="shipping_mod" value="suppliers_false" checked="checked" />Użyj zdefiniowanych.</label><br />
                                <label><input id="" class="back-all edit radio suppliers-radio" type="radio" name="shipping_mod" value="suppliers_true" />Skonfiguruj indywidualnie.</label>
                            </td>
						</tr>
						<tr class="suppliers-tr-one">
							<th>Dostawca:</th>
							<td>
								<select class="back-all edit select" name="predefined">
									<!--<option></option>-->
                                    <?php
                                    $shippng_name = new ProduktSetCls();
                                    $shippng_name->__setTable('supplier');
                                    if ($shippng_name->__getAllSupplierName()) {
                                        foreach ($shippng_name->__getAllSupplierName() as $cat) {
                                            echo '<option value="'.$cat['supplier_name'].'|'.$cat['supplier_name_d'].'"';
                                            // if ($cat['supplier_name'] == $wyn['predefined']) {
                                                // echo ' selected ';
                                            // }
                                            echo '">';
                                            echo $cat['supplier_name_d'];
                                            echo '</option>';
                                        }
                                    }
                                    ?>
								</select>
							</td>
                            <th>Waga</th>
							<td>
                                <input id="product-weight" type="text" name="weight" />
							</td>
						</tr>
                        <tr class="suppliers-tr-two">
                            <th>Dopuszczać przedpłatą</th>
                            <script type="text/javascript">
                                $(function(){
                                    //$( '.price_prepaid' ).show();
                                    var prepaid = function(){
                                        if ($( '#allow_prepaid' ).val() == '1') {
                                            $( '#price_prepaid' ).removeAttr("disabled");
                                        } else if ($( '#allow_prepaid' ).val() == '0') {
                                            $( '#price_prepaid' ).attr("disabled", "disabled");
                                        }
                                        //console.log('prepaid');
                                    }
                                    prepaid();
                                    $(document).on('change', '#allow_prepaid', function () {
                                        //console.log($( this ).val());
                                        prepaid();
                                    });
                                });
                            </script>
                            <td>
                                <select id="allow_prepaid" class="back-all shipping select" name="allow_prepaid">
                                    <option value="1" >Tak</option>
                                    <!--<option value="0" >Nie</option>-->
                                </select>
                            </td>
                            <th>Dopuszczać pobranie</th>
                            <script type="text/javascript">
                                $(function(){
                                    var ondelivery = function(){
                                        if ($( '#allow_ondelivery' ).val() == '1') {
                                            $( '#price_ondelivery' ).removeAttr("disabled");
                                        } else if ($( '#allow_ondelivery' ).val() == '0') {
                                            $( '#price_ondelivery' ).attr("disabled", "disabled");
                                        }
                                    }
                                    ondelivery();
                                    //$( '.price_ondelivery' ).show();
                                    $(document).on('change', '#allow_ondelivery', function () {
                                        //console.log($( this ).val());
                                        ondelivery();
                                    });
                                });
                            </script>
                            <td>
                                <select id="allow_ondelivery" class="back-all shipping select" name="allow_ondelivery">
                                    <option value="1" >Tak</option>
                                    <option value="0" >Nie</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="suppliers-tr-two">
                            <th>Cena za przedpłatą</th>
                            <td><input id="price_prepaid" type="text" name="price_prepaid" /></td>
                            <th>Cena za pobraniem</th>
                            <td><input id="price_ondelivery" type="text" name="price_ondelivery" /></td>
                        </tr>
                        <tr class="suppliers-tr-two">
                            <script type="text/javascript">
                                $(function(){
                                    var share = function() {
                                        if ($( '#package_share' ).val() == '1') {
                                            $( '#max_item_in_package' ).removeAttr("disabled");
                                            $( '.max_item_in_package' ).show();
                                        } else if ($( '#package_share' ).val() == '0') {
                                            $( '#max_item_in_package' ).attr("disabled", "disabled");
                                            $( '.max_item_in_package' ).hide();
                                        }
                                    }
                                    share();
                                    //$( '#max_item_in_package' ).attr("disabled", "disabled");
                                    $(document).on('change', '#package_share', function () {
                                        //console.log($( this ).val());
                                        share();
                                    });
                                });
                            </script>
                            <th>Osobne paczki</th>
                            <td>
                                <select id="package_share" class="back-all shipping select" name="package_share">
                                    <option value="0" >Tak</option>
                                    <option value="1" >Nie</option>
                                </select>
                            </td>
                            <th>maksymalnie w paczce</th>
                            <td><input  id="max_item_in_package" class="back-all shipping text" type="text" name="max_item_in_package" /></td>
                        </tr>
                        <tr class="suppliers-tr-two">
                            <th class="max_item_in_package">Łącz sztuki między paczkami:</th>
                            <td colspan="3" class="max_item_in_package">
                                <select id="connect_one" class="back-all shipping select" name="connect_package">
                                    <option value="1">Tak</option>
                                    <option value="0">Nie</option>
                                </select>
                            </td>
                        </tr>
                        <!-- SHIPPING -->
                    <tr>
                        <th>Ustawienia dla SEO</th>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('input[type="radio"]').each(function() { 
                                    $(this).change(function(){
                                        if( $('input[value="title_true"]').is(":checked") ) {
                                            $('input.seo-text').removeAttr("disabled");
                                        } else {
                                            $('input.seo-text').attr("disabled", "disabled");
                                        }
                                    });
                                });
                            });
                            $(window).load(function() {
                                $('input[type="radio"]').each(function() { 
                                    if( $('input[value="title_true"]').is(":checked") ) {
                                        $('input.seo-text').removeAttr("disabled");
                                    } else {
                                        $('input.seo-text').attr("disabled", "disabled");
                                    }
                                }); 
                            });
                        </script>                            
                        <td colspan="3">
                            <label><input id="" class="back-all add radio seo-radio" type="radio" name="seo_setting" checked="checked" value="title_false" />Użyj globalnych ustawień.</label><br />
                            <label><input id="" class="back-all add radio seo-radio" type="radio" name="seo_setting" value="title_true" />Użyj własnych ustawień (zalecane).</label>
                        </td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td colspan="3">
                            <input id="" class="back-all add text seo-text" type="text" name="title" />
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td colspan="3">
                            <input id="" class="back-all add text seo-text" type="text" name="description" />
                        </td>
                    </tr>
                    <tr>
                        <th>Keywords</th>
                        <td colspan="3">
                            <input id="" class="back-all add text seo-text" type="text" name="keywords" />
                        </td>
                    </tr>                        
                    <tr>
                        <th>Zapisz:</th>
                        <td colspan="3">
                            <input id="" class="back-all add submit" type="submit" name="save" value="Zapisz" />
                        </td>
                    </tr>                        
                    <tr>    
                        <th>Anuluj:</th>
                        <td colspan="3">
                            <input id="" class="back-all add submit" type="submit" name="cancel" value="Anuluj" />
                        </td>
                    </tr>
                </table>
            </form>
		</div>

	</section>
	<footer>
	<!--<div id="count"></div><div id="count2"></div>-->
	</footer>
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
		//echo "session";
		//var_dump ($_SESSION);
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
