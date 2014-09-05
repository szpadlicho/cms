<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
echo '<div class="catch">';
class ProduktSetCls 
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;// ma miec
	public function _setTable($tab_name)
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
		$con=$this->connectDB();
		//$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		//$count = $q -> fetch();/*konwertor na tablice*/
		//if(!$count){
			$con->exec("INSERT INTO `".$this->table."`(
			`product_name`, 
			`product_price`, 
			`product_number`,
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
            `product_keywords`
			) VALUES (
			'".$_POST['product_name']."',
			'".$_POST['product_price']."',
			'".$_POST['product_number']."',
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
            '".trim($keywords)."'          
			)");
			echo "<div class=\"center\" >zapis udany</div>";
		//}
		//else{
			//echo "<div class=\"center\" >zapis już istnieje</div>";
		//}		
		unset ($con);	
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
        class ConnectCls 
        {
            private $host=\'sql.bdl.pl\';
            private $port=\'\';
            private $dbname=\'szpadlic_cms\';
            private $charset=\'utf8\';
            private $user=\'szpadlic_baza\';
            private $pass=\'haslo\';
            private $table;// ma miec
            private $row;
            private $path;
            public function _setTable($tab_name)
            {
                $this->table=$tab_name;
            }
            public function connectDB()
            {
                $con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
                return $con;
                unset ($con);
            }
            public function loadIndex()
            {
                $con=$this->connectDB();
                $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`=\'1\'");/*zwraca false jesli tablica nie istnieje*/
                unset ($con);
                $q = $q->fetch(PDO::FETCH_ASSOC);
                return $q;
            }
            public function metaData($id)
            {
                $con=$this->connectDB();
                $q = $con->query("SELECT `product_title`,`product_description`,`product_keywords` FROM `".$this->table."` WHERE `id`=\'".$id."\'");/*zwraca false jesli tablica nie istnieje*/
                unset ($con);
                $q = $q->fetch(PDO::FETCH_ASSOC);
                return $q;
            }
            public function globalMetaData()
            {
                $con=$this->connectDB();
                $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`=\'1\'");/*zwraca false jesli tablica nie istnieje*/
                unset ($con);
                $q = $q->fetch(PDO::FETCH_ASSOC);
                return $q;
            }
        }
        $load = new ConnectCls();
        $load->_setTable(\'index_pieces\');
        $q = $load->loadIndex();
        ';
        //'. PHP_EOL .' nowa linia
        //title = category + subcategory + product name
        //description
        //keyword
        $content .='
        eval(\'?>\'.$q[\'php_beafor_html\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p1\'].\'<?php \');
        //--
        $product_now_display=\''.$rec.'\';
        //--
        $load->_setTable(\'product_tab\');
        $meta = $load->metaData($product_now_display);
        //--
        $load->_setTable(\'setting_seo\');
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
        $product_now_display=\''.$rec.'\';
        eval(\'?>\'.$q[\'html_p3\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p4\'].\'<?php \');
        ?>';
        $path = '../product/'.$this->createFileName($rec).'.php';//gdzie i jak apisac
        $out_file = fopen($path, 'w');
        fwrite($out_file, $content);
        fclose($out_file);
    }
}
$next_id_is = new ProduktSetCls();
$next_id_is->_setTable('product_tab');
$next_is = $next_id_is->_getLastId();
$next_id = $next_is['AUTO_INCREMENT'];
$id = $next_id;//for upload system
if (isset($_POST['save'])) {
	$product = new ProduktSetCls();
	$product->_setTable('product_tab');
	$product->createREC($next_id);
	$product->createFile($next_id);
    //ob_start();
    //header('Location: product_list.php');
    //ob_end_flush();
    echo("<script>location.href = 'product_list.php';</script>");
}
//echo 'next id is: '.$next_id;
echo '</div>';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Nowy</title>
	<?php include ("meta5.html"); ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link href="../upload/uploadfile.css" rel="stylesheet">    
    <script src="../upload/jquery.uploadfile.js"></script>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
	<section id="place-holder">				
		<?php include ('menu_zap.php'); ?>
		<div>
            <form enctype="multipart/form-data" action="" method="POST" >
                <table class="table-bck">
                    <tr>
                        <th>ID: <?php echo $next_id; ?></th>
                    </tr>
                    <tr>
                        <th>Nazwa:</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls" type="text" name="product_name" />
                        </td>
                    </tr>
                    <tr>
                        <th>Cena:</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls" type="text" name="product_price" />
                        </td>
                    </tr>
                    <tr>
                        <th>Ilość:</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls" type="text" name="product_number" />
                        </td>
                    </tr>
                    <tr>
                        <th>Zapisz:</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="submit-cls" type="submit" name="save" value="Zapisz" />
                        </td>
                    </tr>
                    <tr>
                        <th>Przypisz do Kategorii / Pozycji w górnym Menu:</th>
                    </tr>
                    <tr>
                        <td>
                            <select class="option-cls" name="product_category_main">
                                <option></option>
                            <?php
                            $main= new ProduktSetCls();
                            $main->_setTable('product_category_main');
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
                    </tr>
                    <tr>
                        <th>Przypisz do Podkategorii / Pozycji w lewym Menu:</th>
                    </tr>
                    <tr>
                        <td>
                            <select class="option-cls" name="product_category_sub">
                                <option></option>
                            <?php
                            $sub = new ProduktSetCls();
                            $sub->_setTable('product_category_sub');
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
                    </tr>
                    <tr>
                        <td>
                            <textarea id="" class="" type="" name="product_description_small" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Zapisz:</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="submit-cls" type="submit" name="update" value="Zapisz" />
                        </td>
                    </tr>
                    <tr>
                        <th>Opis:</th>
                    </tr>
                    <tr>
                        <td>
                            <textarea id="" class="" type="" name="product_description_large" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Miniaturka:</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="upload_td_div"><?php include('../upload/up_small.php'); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>Zdjęcia:</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="upload_td_div"><?php include('../upload/up_large.php'); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>Zapisz:</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="submit-cls" type="submit" name="save" value="Zapisz" />
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
                    </tr>  
                    <tr>
                        <td class="seo-td">
                            <input id="" class="seo-radio" type="radio" name="seo_setting" checked="checked" value="title_false" />Użyj globalnych ustawień.<br />
                            <input id="" class="seo-radio" type="radio" name="seo_setting" value="title_true" />Użyj własnych ustawień (zalecane).
                        </td>
                    </tr>
                    <tr>
                        <th>Title</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls seo-text" type="text" name="title" />
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls seo-text" type="text" name="description" />
                        </td>
                    </tr>
                    <tr>
                        <th>Keywords</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls seo-text" type="text" name="keywords" />
                        </td>
                    </tr>                        
                    <tr>
                        <th>Zapisz:</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="submit-cls" type="submit" name="save" value="Zapisz" />
                        </td>
                    </tr>
                </table>
            </form>
		</div>

	</section>
	<footer>
	<!--<div id="count"></div><div id="count2"></div>-->
	</footer>
	<div id="debugged">
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
