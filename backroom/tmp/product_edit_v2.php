<?php
//ini_set('output_buffering', 'Off');//output_buffering = On
header('Content-Type: text/html; charset=utf-8');
session_start();
//echo '<div class="catch">';
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
		$con=$this->connectDB();        
			$con->query("
			UPDATE 
			`".$this->table."`   
			SET 
			`product_name` = '".$_POST['product_name']."', 
			`product_price` = '".str_replace(",",".",$_POST['product_price'])."', 
			`product_number` = '".$_POST['product_number']."',
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
        return true;
	}
	public function showCategory()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT `".$this->table."` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
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
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `id` = '1'");/*zwraca false jesli tablica nie istnieje*/
        $q = $q->fetch(PDO::FETCH_ASSOC);
		unset ($con);
		return $q;
	}
}
$product = new ProduktEditCls();
$product->__setTable('product_tab');
if (isset($_POST['update'])) {
    $product->deleteOldFile();
	$product->updateREC($_SESSION['id_post']);
    $product->createFile($_SESSION['id_post']);
    //echo 'fsdfsdfs';
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
//echo '</div>';
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
        <div class="back-edit-placeholder">
            <?php foreach ($product->showOne() as $wyn) { ?>
                <form enctype="multipart/form-data" method="POST">
                    <table class="back-edit-table">
                        <tr>
							<th>ID:</th>
                            <td>
                                <?php echo $wyn['id'] ?>
                            </td>
                            <th>Nazwa:</th>
							<td>
                                <input id="" class="back-edit-text" type="text" name="product_name" value="<?php echo $wyn['product_name'] ?>" />
                            </td>
						</tr>
						<tr>
							<th>Cena:</th>
							<td>
                                <input id="" class="back-edit-text" type="text" name="product_price" value="<?php echo $wyn['product_price'] ?>" />
                            </td>
                            <th>Ilość:</th>
							<td>
                                <input id="" class="back-edit-text" type="text" name="product_number" value="<?php echo $wyn['product_number'] ?>" />
                            </td>
						</tr>
						<tr>
							<th>Zapisz:</th>
							<td>
                            <input id="" class="back-edit-submit" type="submit" name="update" value="Zapisz" />
                            </td>
                            <th>Usuń Produkt:</th>
							<td>
                                <input id="" class="back-edit-submit" type="submit" name="delete" value="delete" />
                            </td>
						</tr>
						<tr>
							<th>Przypisz do Kategorii<br />Pozycji w górnym Menu:</th>
							<td>
								<select class="back-edit-select" name="product_category_main">
									<option></option>
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
								<select class="back-edit-select" name="product_category_sub">
									<option></option>
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
                                <textarea id="" class="back-edit-textarea" name="product_description_small" ><?php echo $wyn['product_description_small'] ?></textarea>
                            </td>
						</tr>
                        <tr>
							<th>Zapisz:</th>
							<td colspan="3">
                                <input id="" class="back-edit-submit" type="submit" name="update" value="Zapisz" />
                            </td>
						</tr>
						<tr>
							<th>Opis:</th>
							<td  colspan="3">
                                <textarea id="" class="back-edit-textarea" name="product_description_large" ><?php echo $wyn['product_description_large'] ?></textarea>
                            </td>
						</tr>
						<tr>
							<th colspan="4">Miniaturka:</th>
						</tr>
						<tr>
							<td colspan="4">
                                <?php $id = $_SESSION['id_post']; ?>
                                <!--<div class="upload_td_div"></div>-->
                                <div class="back-edit-div upload_td_div"><?php include('../upload/up_small.php'); ?></div>
                            </td>
						</tr>
						<tr>
							<th colspan="4">Zdjęcia:</th>
						</tr>
						<tr>
							<td colspan="4">
                                <?php $id = $_SESSION['id_post']; ?>
                                <!--<div class="upload_td_div"></div>-->
                                <div class="back-edit-div upload_td_div"><?php include('../upload/up_large.php'); ?></div>
                            </td>
						</tr>
						<tr>
							<th>Zapisz:</th>
							<td colspan="3">
                                <input id="" class="back-edit-submit" type="submit" name="update" value="Zapisz" />
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
                                <label><input id="" class="back-edit-radio seo-radio" type="radio" name="seo_setting" value="title_false" <?php echo $wyn['mod']==0 ? 'checked="checked"' : '' ; ?> />Użyj globalnych ustawień.</label>
                                <label><input id="" class="back-edit-radio seo-radio" type="radio" name="seo_setting" value="title_true" <?php echo $wyn['mod']==1 ? 'checked="checked"' : '' ; ?> />Użyj własnych ustawień (zalecane).</label>
                            </td>
						</tr>
						<tr>
							<th>Title</th>
                            <td colspan="3">
                                <input id="" class="back-edit-text seo-text" type="text" name="title" value="<?php echo $wyn['product_title']!=null ? $wyn['product_title'] : 'brak' ; ?>" />
                            </td>
						</tr>
						<tr>
							<th>Description</th>
                            <td colspan="3">
                                <input id="" class="back-edit-text seo-text" type="text" name="description" value="<?php echo $wyn['product_description']!=null ? $wyn['product_description'] : 'brak' ; ?>" />
                            </td>
						</tr>
                        <tr>
							<th>Keywords</th>
                            <td colspan="3">
                                <input id="" class="back-edit-text seo-text" type="text" name="keywords" value="<?php echo $wyn['product_keywords']!=null ? $wyn['product_keywords'] : 'brak' ; ?>" />
                            </td>
						</tr>                        
                        <tr>
							<th>Zapisz:</th>
							<td>
                                <input id="" class="back-edit-submit" type="submit" name="update" value="Zapisz" />
                            </td>
                            <th>Usuń Produkt:</th>
							<td>
                                <input id="" class="back-edit-submit" type="submit" name="delete" value="delete" />
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
