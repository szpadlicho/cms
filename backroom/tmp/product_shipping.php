<?php
//ini_set('output_buffering', 'Off');//output_buffering = On
header('Content-Type: text/html; charset=utf-8');
session_start();
if (isset($_POST['id_post'])) {
	$_SESSION['id_post']=(int)$_POST['id_post'];
}
include_once '../../classes/connect.php';
class ProduktEditCls extends Connect
{
	// private $host='localhost';
	// private $port='';
	// private $dbname='szpadlic_cms';
	// private $charset='utf8';
	// private $user='user';
	// private $pass='user';
	private $table;// ma miec
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
	}
	// public function connectDB()
    // {
		// $con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		// return $con;
		// unset ($con);
	// }
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
		$con = $this->connectDB();        
			$feedback = $con->query("
                UPDATE 
                `".$this->table."`   
                SET 
                `product_name` = '".$_POST['product_name']."', 
                `product_price` = '".str_replace(",",".",$_POST['product_price'])."', 
                `amount` = '".$_POST['amount']."',
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
                `product_keywords` = '".trim($keywords)."'
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
        $res = $con->query("SELECT * FROM `".$this->table."`");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
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
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Edycja</title>
	<?php include ("meta5.html"); ?>
    <link href="../upload/uploadfile.css" rel="stylesheet">    
    <script src="../upload/jquery.uploadfile.js"></script>
</head>
<body>
	<section id="place-holder">
		<?php include ('backroom-top-menu.php'); ?>
        <div class="back-all edit placeholder">
            <?php foreach ($product->showOne() as $wyn) { ?>
                <form method="POST">
                    <table class="back-all edit table">
                        <tr>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('input[type="radio"]').each(function() { 
                                        $(this).change(function(){
                                            if( $('input[value="suppliers_true"]').is(":checked") ) {
                                                $('.suppliers-tr-two').show();
                                                $('.suppliers-tr-one').hide();
                                            } else {
                                                $('.suppliers-tr-two').hide();
                                                $('.suppliers-tr-one').show();
                                            }
                                        });
                                    });
                                });
                                $(window).load(function() {
                                    $('input[type="radio"]').each(function() { 
                                        if( $('input[value="suppliers_true"]').is(":checked") ) {
                                            $('.suppliers-tr-two').show();
                                            $('.suppliers-tr-one').hide();
                                        } else {
                                            $('.suppliers-tr-two').hide();
                                            $('.suppliers-tr-one').show();
                                        }
                                    }); 
                                });
                            </script>
                            <th>
                                Tryb dostawców
                            </th>
                            <td colspan="3">
                                <label><input id="" class="back-all edit radio suppliers-radio" type="radio" name="suppliers_setting" value="suppliers_false" <?php echo $wyn['mod']==0 ? 'checked="checked"' : '' ; ?> />Użyj zdefiniowanych.</label><br />
                                <label><input id="" class="back-all edit radio suppliers-radio" type="radio" name="suppliers_setting" value="suppliers_true" <?php echo $wyn['mod']==1 ? 'checked="checked"' : '' ; ?> />Skonfiguruj indywidualnie.</label>
                            </td>
						</tr>
						<tr class="suppliers-tr-one">
							<th>Dostawca:</th>
							<td>
								<select class="back-all edit select" name="product_category_main">
									<option></option>
                                    <?php
                                    $shippng_name = new ProduktEditCls();
                                    $shippng_name->__setTable('supplier');
                                    if ($shippng_name->__getAllSupplierName()) {
                                        foreach ($shippng_name->__getAllSupplierName() as $cat) {
                                            echo '<option value="'.$cat['supplier_name'].'"';
                                            // if ($cat['product_category_main'] == $wyn['product_category_main']) {
                                                // echo ' selected ';
                                            // }
                                            echo '">';
                                            echo $cat['supplier_name'];
                                            echo '</option>';
                                        }
                                    }
                                    ?>
								</select>
							</td>
                            <th>Waga</th>
							<td>
                                <input id="product-weight" type="text" name="product_weight" />
							</td>
						</tr>
                        <tr class="suppliers-tr-two">
                            <th>Dopuszczać przedpłatą</th>
                            <script type="text/javascript">
                                $(function(){
                                    //$( '.price_ondelivery' ).show();
                                    $(document).on('change', '#allow_prepaid', function () {
                                        //console.log($( this ).val());
                                        if ($( this ).val() == 'yes') {
                                            $( '#price_prepaid' ).removeAttr("disabled");
                                        } else if ($( this ).val() == 'no') {
                                            $( '#price_prepaid' ).attr("disabled", "disabled");
                                        }
                                    });
                                });
                            </script>
                            <td>
                                <select id="allow_prepaid" class="back-all shipping select" name="allow_ondelivery">
                                    <option value="yes">Tak</option>
                                    <option value="no">Nie</option>
                                </select>
                            </td>
                            <th>Dopuszczać pobranie</th>
                            <script type="text/javascript">
                                $(function(){
                                    //$( '.price_ondelivery' ).show();
                                    $(document).on('change', '#allow_ondelivery', function () {
                                        //console.log($( this ).val());
                                        if ($( this ).val() == 'yes') {
                                            $( '#price_ondelivery' ).removeAttr("disabled");
                                        } else if ($( this ).val() == 'no') {
                                            $( '#price_ondelivery' ).attr("disabled", "disabled");
                                        }
                                    });
                                });
                            </script>
                            <td>
                                <select id="allow_ondelivery" class="back-all shipping select" name="allow_ondelivery">
                                    <option value="yes">Tak</option>
                                    <option value="no">Nie</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="suppliers-tr-two">
                            <th>Cena za przedpłatą</th>
                            <td><input id="price_prepaid" type="text" /></td>
                            <th>Cena za pobraniem</th>
                            <td><input id="price_ondelivery" type="text" /></td>
                        </tr>
                        <tr class="suppliers-tr-two">
                            <script type="text/javascript">
                                $(function(){
                                    $( '#max_item_in_package' ).attr("disabled", "disabled");
                                    $(document).on('change', '#package_share', function () {
                                        //console.log($( this ).val());
                                        if ($( this ).val() == 'no') {
                                            $( '#max_item_in_package' ).removeAttr("disabled");
                                        } else if ($( this ).val() == 'yes') {
                                            $( '#max_item_in_package' ).attr("disabled", "disabled");
                                        }
                                    });
                                });
                            </script>
                            <th>Każdy w osobnej paczce</th>
                            <td>
                                <select id="package_share" class="back-all shipping select" name="package_share">
                                    <option value="yes">Tak</option>
                                    <option value="no">Nie</option>
                                </select>
                            </td>
                            <th>maksymalnie w paczce</th>
                            <td><input  id="max_item_in_package" class="back-all shipping text" type="text" name="max_item_in_package" /></td>
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
