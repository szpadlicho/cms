<?php
//ini_set('output_buffering', 'Off');//output_buffering = On
header('Content-Type: text/html; charset=utf-8');
session_start();
if (isset($_POST['id_post'])) {
	$_SESSION['id_post']=(int)$_POST['id_post'];
}
class ProduktEditCls 
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
	public function showOne()
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`='".$_SESSION['id_post']."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function deleteOldFile()
    {
        $con=$this->connectDB();
        $q = $con->query("SELECT `file_name` FROM `".$this->table."` WHERE `id`='".$_SESSION['id_post']."'");/*zwraca false jesli tablica nie istnieje*/
        $q = $q->fetch(PDO::FETCH_ASSOC);
		@unlink('../product/'.$q['file_name'].'.php');
        return $q['file_name'];
        unset ($con);
	}
    public function deleteREC()
    {
		$con=$this->connectDB();
		$con->query("DELETE FROM `".$this->table."` WHERE `id` = '".$_SESSION['id_post']."'");	
		unset ($con);
	
	}
    public function createFileName($id)
    {
        //$con=$this->connectDB();
        //$res=$con->query("ALTER TABLE `".$this->table."` ADD `file_name` TEXT");//do zakomentowania po update install.php
        $file_name = $_POST['product_name'];
        $file_name = ltrim($file_name);
        $file_name = rtrim($file_name);
        //$file_name = str_replace(':', '', $file_name);
        //$charset = "UTF-8";    
        //$file_name = iconv($charset, "ASCII//TRANSLIT//IGNORE", $file_name);
        $file_name = str_replace(array('ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'), array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'), $file_name);
        $file_name = str_replace(array('Ą', 'Ć', 'Ę', 'Ł', 'Ń', 'Ó', 'Ś', 'Ź', 'Ż'), array('A', 'C', 'E', 'L', 'N', 'O', 'S', 'Z', 'Z'), $file_name);
        $file_name = str_replace(' ', '-', $file_name);
        //$file_name = preg_replace('/[^0-9a-z\-]+/', '', $file_name);//usun wszystko co jest zabronionym znakiem
        $file_name = preg_replace('/[:\^\*\+]/', '', $file_name);//usun wszystko co jest zabronionym znakiem
        //$res=$con->exec("UPDATE `".$this->table."` SET `file_name` = '".$file_name."' WHERE `id`='".$what."'");
        //unset ($con); 
        return $id.'-'.$file_name;
    }
	public function updateREC($what)
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
        isset($_POST['visibility']) ? $visibility = $_POST['visibility'] : $visibility = 1;
		$con = $this->connectDB();        
			$feedback = $con->query("
                UPDATE 
                `".$this->table."`   
                SET 
                `product_name` = '".$_POST['product_name']."', 
                `product_price` = '".str_replace(",",".",$_POST['product_price'])."', 
                `amount` = '".(int)$_POST['amount']."',
                `product_category_main` = '".$_POST['product_category_main']."',
                `product_category_sub` = '".$_POST['product_category_sub']."',
                `product_description_small` = '".$_POST['product_description_small']."',
                `product_description_large` = '".$_POST['product_description_large']."',
                `product_foto_mini` = '0',
                `product_foto_large` = '0',
                `mod` = '".$mod."',
                `file_name` = '".$this->createFileName($what)."',
                `product_title` = '".trim($title)."',
                `product_description` = '".trim($description)."',
                `product_keywords` = '".trim($keywords)."',
                `shipping_mod` = '".(int)$shipping_mod."',
                `predefined` = '".$predefined."',
                `predefined_d` = '".$predefined_d."',
                `weight` = '".str_replace(",",".",$weight)."',
                `allow_prepaid` = '".(int)$allow_prepaid."',
                `price_prepaid` = '".str_replace(',', '.',$price_prepaid)."',
                `allow_ondelivery` = '".(int)$allow_ondelivery."',
                `price_ondelivery` = '".str_replace(',', '.',$price_ondelivery)."',
                `package_share` = '".(int)$package_share."',
                `max_item_in_package` = '".(int)$max_item_in_package."' ,
                `connect_package` = '".(int)$connect_package."',
                `only_if_the_same` = '".(int)$only_if_the_same."',
                `visibility` = '".(int)$visibility."'
                WHERE 
                `id`='".$what."'");	
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
		$q = $con->query("SELECT `".$this->table."` FROM `".$this->table."`");// return false if table not exist
		unset ($con);
		return $q;
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
        //title -> category + subcategory + product name
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
    public function showAll()
    {
		//$con=$this->connectDB();
		//$q = $con->query("SELECT * FROM `".$this->table."` WHERE `id` = '1'");/*zwraca false jesli tablica nie istnieje*/
        //$q = $q->fetch(PDO::FETCH_ASSOC);
		//unset ($con);
		//return $q;
	}
    public function __getAllSupplierName()
    {
        $con = $this->connectDB();
        $res = $con->query("SELECT * FROM `shipping_".$this->table."`");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    public function __getFirstLastId()
    {
        $con = $this->connectDB();
        $aid = $con->query('SELECT MIN(id),MAX(id) FROM `product_tab`');
        $aid = $aid->fetch(PDO::FETCH_ASSOC);
        return $aid;
    }
    public function __getAllId()
    {
        $con = $this->connectDB();
        $aid = $con->query('SELECT `id` FROM `product_tab`');
        //$aid = $aid->fetch(PDO::FETCH_ASSOC);
        return $aid;
    }
    public function nextId()
    {
        $allId = $this->__getAllId();
        $arrId = array();
        while ( $id = $allId->fetch(PDO::FETCH_ASSOC) ) {
            $arrId[] = $id['id'];
        }
        $curentKey = array_search($_SESSION['id_post'], $arrId);
        $keys = array_keys($arrId);
        $flId = $this->__getFirstLastId();
        if(@$arrId[$keys[array_search($curentKey, $keys)+1]]){
            return $next = $arrId[$keys[array_search($curentKey, $keys)+1]];
        } else {
            return $flId['MIN(id)'];
        }
    }
    public function prevId()
    {
        $allId = $this->__getAllId();
        $arrId = array();
        while ( $id = $allId->fetch(PDO::FETCH_ASSOC) ) {
            $arrId[] = $id['id'];
        }
        $curentKey = array_search($_SESSION['id_post'], $arrId);
        $keys = array_keys($arrId);
        $flId = $this->__getFirstLastId();
        if(@$arrId[$keys[array_search($curentKey, $keys)-1]]){
            return $next = $arrId[$keys[array_search($curentKey, $keys)-1]];
        } else {
            return $flId['MAX(id)'];
        }
    }
}
$product = new ProduktEditCls();
$product->__setTable('product_tab');
if (isset($_POST['update'])) {
    $product->deleteOldFile();
	$success = $product->updateREC($_SESSION['id_post']);
    $product->createFile($_SESSION['id_post']);
    //echo $success;
    //output_buffering = On
    //header('Location: product_list.php');
}
if (isset($_POST['delete'])) {
    $product->deleteOldFile();
    $product->deleteREC();        
    //dodac usuwanie galeri
    include_once('product_delete.php');
    $del->rrmdir('../data/'.$_SESSION['id_post']);
    unset($_SESSION['id_post']);
    header('Location: product_list.php');
    //echo("<script>location.href = 'product_list.php';</script>");
}
isset($_POST['prev']) ? $_SESSION['id_post'] = $product->prevId() : '' ;
isset($_POST['next']) ? $_SESSION['id_post'] = $product->nextId() : '' ;
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Edycja</title>
	<?php include ("meta5.html"); ?>
    <link  rel="stylesheet" href="../upload/uploadfile.css" />    
    <script type="text/javascript" src="../upload/jquery.uploadfile.js"></script>
</head>
<body>
	<section id="place-holder">
		<?php include ('backroom-top-menu.php'); ?>
        <div class="back-all edit placeholder">
            <?php foreach ($product->showOne() as $wyn) { ?>
                <form enctype="multipart/form-data" method="POST">
                    <div class="back-all edit div nav">
                        <input class="back-all edit submit nav" type="submit" name="prev" value="prev"/>
                        <input class="back-all edit submit nav"type="submit" name="next" value="next"/>
                    </div>
                    <table class="back-all edit table">
                        <tr>
							<th>ID:</th>
                            <td>
                                <?php echo $wyn['id'] ?>
                            </td>
                            <th>Nazwa:</th>
							<td>
                                <input id="" class="back-all edit text" type="text" name="product_name" value="<?php echo $wyn['product_name'] ?>" />
                            </td>
						</tr>
						<tr>
							<th>Cena:</th>
							<td>
                                <input id="" class="back-all edit text" type="text" name="product_price" value="<?php echo $wyn['product_price'] ?>" />
                            </td>
                            <th>Ilość:</th>
							<td>
                                <input id="" class="back-all edit text" type="text" name="amount" value="<?php echo $wyn['amount'] ?>" />
                            </td>
						</tr>
						<tr>
							<th>Zapisz:</th>
							<td colspan="3">
                                <input id="" class="back-all edit submit save" type="submit" name="update" value="Zapisz" />
                            </td>
                        </tr>                        
                        <tr>    
                            <th>Usuń Produkt:</th>
							<td colspan="3">
                                <input id="" class="back-all edit submit delete" type="submit" name="delete" value="delete" />
                            </td>
						</tr>
						<tr>
							<th>Przypisz do Kategorii<br />Pozycji w górnym Menu:</th>
							<td>
								<select class="back-all edit select" name="product_category_main">
									<!--<option></option>-->
                                    <?php
                                    $main= new ProduktEditCls();
                                    $main->__setTable('product_category_main');
                                    if ($main->showCategory()) {
                                        foreach ($main->showCategory() as $cat) {
                                            echo '<option value="'.$cat['product_category_main'].'"';
                                            if ($cat['product_category_main']==$wyn['product_category_main']) {
                                                echo ' selected ';
                                            }
                                            echo '">';
                                            echo $cat['product_category_main'];
                                            echo '</option>';
                                        }
                                    }
                                    ?>
								</select>
							</td>
                            <th>Przypisz do Podkategorii<br />Pozycji w lewym Menu:</th>
							<td>
								<select class="back-all edit select" name="product_category_sub">
									<!--<option></option>-->
                                    <?php
                                    $sub = new ProduktEditCls();
                                    $sub->__setTable('product_category_sub');
                                    if ($sub->showCategory()) {
                                        foreach ($sub->showCategory() as $cat) {
                                            echo '<option value="'.$cat['product_category_sub'].'"'; 
                                            if ($cat['product_category_sub']==$wyn['product_category_sub']) {
                                                echo ' selected ';
                                            }									
                                            echo '>';
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
                                <textarea id="" class="back-all edit textarea" name="product_description_small" ><?php echo $wyn['product_description_small'] ?></textarea>
                            </td>
						</tr>
                        <tr>
							<th>Zapisz:</th>
							<td colspan="3">
                                <input id="" class="back-all edit submit save" type="submit" name="update" value="Zapisz" />
                            </td>
						</tr>
						<tr>
							<th>Opis:</th>
							<td  colspan="3">
                                <textarea id="" class="back-all edit textarea" name="product_description_large" ><?php echo $wyn['product_description_large'] ?></textarea>
                            </td>
						</tr>
						<tr>
							<th colspan="4">Miniaturka:</th>
						</tr>
						<tr>
							<td colspan="4">
                                <?php $id = $_SESSION['id_post']; ?>
                                <!--<div class="upload_td_div"></div>-->
                                <div class="back-all edit div upload_td_div"><?php include('../upload/up_small.php'); ?></div>
                            </td>
						</tr>
						<tr>
							<th colspan="4">Zdjęcia:</th>
						</tr>
						<tr>
							<td colspan="4">
                                <?php $id = $_SESSION['id_post']; ?>
                                <!--<div class="upload_td_div"></div>-->
                                <div class="back-all edit div upload_td_div"><?php include('../upload/up_large.php'); ?></div>
                            </td>
						</tr>
						<tr>
							<th>Zapisz:</th>
							<td colspan="3">
                                <input id="" class="back-all edit submit save" type="submit" name="update" value="Zapisz" />
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
                                Widzialność
                            </th>
                            <td>
                                <select id="visibility" class="back-all shipping select visibility" name="visibility">
                                    <option <?php echo $wyn['visibility'] == 1 ? 'selected' : '' ; ?> value="1" >Tak</option>
                                    <option <?php echo $wyn['visibility'] == 0 ? 'selected' : '' ; ?> value="0" >Nie</option>
                                </select>
                            </td>
                            <th>
                                Tryb dostawców
                            </th>
                            <td>
                                <label><input id="" class="back-all edit radio suppliers-radio" type="radio" name="shipping_mod" value="suppliers_false" <?php echo $wyn['shipping_mod']==0 ? 'checked="checked"' : '' ; ?> />Użyj zdefiniowanych.</label><br />
                                <label><input id="" class="back-all edit radio suppliers-radio" type="radio" name="shipping_mod" value="suppliers_true" <?php echo $wyn['shipping_mod']==1 ? 'checked="checked"' : '' ; ?> />Skonfiguruj indywidualnie.</label>
                            </td>
						</tr>
						<tr class="suppliers-tr-one">
							<th>Dostawca:</th>
							<td>
								<select class="back-all edit select" name="predefined">
									<!--<option></option>-->
                                    <?php
                                    $shippng_name = new ProduktEditCls();
                                    $shippng_name->__setTable('supplier');
                                    if ($shippng_name->__getAllSupplierName()) {
                                        foreach ($shippng_name->__getAllSupplierName() as $cat) {
                                            echo '<option value="'.$cat['supplier_name'].'|'.$cat['supplier_name_d'].'"';
                                            if ($cat['supplier_name'] == $wyn['predefined']) {
                                                echo ' selected ';
                                            }
                                            echo '">';
                                            echo $cat['supplier_name_d'];
                                            echo '</option>';
                                        }
                                    }
                                    ?>
								</select>
                                <!--<input type="hidden" name="predefined_d" value="<?php //echo $cat['supplier_name_d']; ?> " />-->
							</td>
                            <th>Waga</th>
							<td>
                                <input id="product-weight" type="text" name="weight" value="<?php echo $wyn['weight']; ?>"/>
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
                                    <option value="1" <?php echo $wyn['allow_prepaid'] == 1 ? 'selected' : '' ; ?> >Tak</option>
                                    <!--<option value="0" <?php //echo $wyn['allow_prepaid'] == 0 ? 'selected' : '' ; ?> >Nie</option>-->
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
                                    <option value="1" <?php echo $wyn['allow_ondelivery'] == 1 ? 'selected' : '' ; ?> >Tak</option>
                                    <option value="0" <?php echo $wyn['allow_ondelivery'] == 0 ? 'selected' : '' ; ?>>Nie</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="suppliers-tr-two">
                            <th>Cena za przedpłatą</th>
                            <td><input id="price_prepaid" type="text" name="price_prepaid" value="<?php echo $wyn['price_prepaid']; ?>" /></td>
                            <th>Cena za pobraniem</th>
                            <td><input id="price_ondelivery" type="text" name="price_ondelivery" value="<?php echo $wyn['price_ondelivery']; ?>" /></td>
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
                                    <option value="0" <?php echo $wyn['package_share'] == 0 ? 'selected' : '' ; ?> >Tak</option>
                                    <option value="1" <?php echo $wyn['package_share'] == 1 ? 'selected' : '' ; ?> >Nie</option>
                                </select>
                            </td>
                            <th>maksymalnie w paczce</th>
                            <td><input  id="max_item_in_package" class="back-all shipping text" type="text" name="max_item_in_package" value="<?php echo $wyn['max_item_in_package']; ?>" /></td>
                        </tr>
                        <tr class="suppliers-tr-two">
                            <th class="max_item_in_package">Łącz sztuki między paczkami:</th>
                            <td colspan="3" class="max_item_in_package">
                                <?php $con = $wyn['connect_package'] ;?>
                                <select id="connect_one_<?php echo $wyn['id']; ?>" class="back-all shipping select" name="connect_package">
                                    <option <?php if ($con == '1') { echo 'selected'; } ?> value="1">Tak</option>
                                    <option <?php if ($con == '0') { echo 'selected'; } ?> value="0">Nie</option>
                                </select>
                            </td>
                        </tr>
                        <!-- SHIPPING -->
                        <tr>
							<th>Zapisz:</th>
							<td colspan="3">
                                <input id="" class="back-all edit submit save" type="submit" name="update" value="Zapisz" />
                            </td>
						</tr>                        
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
                                <label><input id="" class="back-all edit radio seo-radio" type="radio" name="seo_setting" value="title_false" <?php echo $wyn['mod']==0 ? 'checked="checked"' : '' ; ?> />Użyj globalnych ustawień.</label><br />
                                <label><input id="" class="back-all edit radio seo-radio" type="radio" name="seo_setting" value="title_true" <?php echo $wyn['mod']==1 ? 'checked="checked"' : '' ; ?> />Użyj własnych ustawień (zalecane).</label>
                            </td>
						</tr>
						<tr>
							<th>Title</th>
                            <td colspan="3">
                                <input id="" class="back-all edit text seo-text" type="text" name="title" value="<?php echo $wyn['product_title']!=null ? $wyn['product_title'] : 'brak' ; ?>" />
                            </td>
						</tr>
						<tr>
							<th>Description</th>
                            <td colspan="3">
                                <input id="" class="back-all edit text seo-text" type="text" name="description" value="<?php echo $wyn['product_description']!=null ? $wyn['product_description'] : 'brak' ; ?>" />
                            </td>
						</tr>
                        <tr>
							<th>Keywords</th>
                            <td colspan="3">
                                <input id="" class="back-all edit text seo-text" type="text" name="keywords" value="<?php echo $wyn['product_keywords']!=null ? $wyn['product_keywords'] : 'brak' ; ?>" />
                            </td>
						</tr>                        
                        <tr>
							<th>Zapisz:</th>
							<td colspan="3">
                                <input id="" class="back-all edit submit save" type="submit" name="update" value="Zapisz" />
                            </td>
                        </tr>                        
                        <tr>    
                            <th>Usuń Produkt:</th>
							<td colspan="3">
                                <input id="" class="back-all edit submit delete" type="submit" name="delete" value="delete" />
                            </td>
						</tr>
					</table>
                    <input type="hidden" name="id_product_edit" value="<?php echo $wyn['id'] ?>" />
				</form>
            <?php } ?>
		</div>
	</section>
	<footer>
	<!--<div id="count"></tr><div id="count2"></tr>-->
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
		//echo "files";
		//var_dump (@$_FILES);
		// echo "var2";
		 // var_dump ($var2);	
		//echo "cookies";
		//var_dump ($_COOKIE);
		?>
	</div>
</body>
</html>
