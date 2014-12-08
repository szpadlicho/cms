<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
echo '<div class="catch">';
class CategorySetCls
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
    public function createFileName($rec)
    {
        $file_name = $rec;
        $file_name = ltrim($file_name);
        $file_name = rtrim($file_name);
        $file_name = str_replace(array('ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'), array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'), $file_name);
        $file_name = str_replace(array('Ą', 'Ć', 'Ę', 'Ł', 'Ń', 'Ó', 'Ś', 'Ź', 'Ż'), array('A', 'C', 'E', 'L', 'N', 'O', 'S', 'Z', 'Z'), $file_name);
        $file_name = str_replace(' ', '-', $file_name);
        //$file_name = preg_replace('/[^0-9a-z\-]+/', '', $file_name);//usun wszystko co jest zabronionym znakiem
        $file_name = preg_replace('/[:\^\*\+]/', '', $file_name);//usun wszystko co jest zabronionym znakiem
        return $file_name;
    }
	public function createREC($rec,$row_name)
    {
		/*zapis*/
        $_POST['seo_setting']=='title_true' ? $mod=1 : $mod=0 ;
        isset($_POST['title']) ? $title = $_POST['title'] : $title = null ;
        isset($_POST['description']) ? $description = substr($_POST['description'], 0, 200) : $description = null ;
        isset($_POST['keywords']) ? $keywords = $_POST['keywords'] : $keywords = null ;
		$con=$this->connectDB();
			$con->exec("INSERT INTO `".$this->table."`(
			`".$this->table."`,
            `".$row_name."`,
            `mod`,
            `title`,
            `description`,
            `keywords`
			) VALUES (
			'".$rec."',
            '".$this->createFileName($rec)."',
            '".$mod."',
            '".$title."',
            '".$description."',
            '".$keywords."'
			)");
			echo "<div class=\"center\" >zapis udany</div>";	
		unset ($con);	
	}
    public function updateREC($rec,$what,$row_name)
    {
		/*zapis*/
        $_POST['seo_setting']!='title_false' ? $mod=1 : $mod=0 ;//bo true mam z -id
        isset($_POST['title']) ? $title = $_POST['title'] : $title = null ;
        isset($_POST['description']) ? $description = substr($_POST['description'], 0, 200) : $description = null ;
        isset($_POST['keywords']) ? $keywords = $_POST['keywords'] : $keywords = null ;
		$con=$this->connectDB();
			$con->exec("UPDATE `".$this->table."` 
            SET
			`".$this->table."` = '".$rec."',
            `".$row_name."` = '".$this->createFileName($rec)."',
            `mod` = '".$mod."',
            `title` = '".$title."',
            `description` = '".$description."',
            `keywords` = '".$keywords."'
			WHERE
            `".$this->table."` = '".$what."'
            ");        
		echo "<div class=\"center\" >zapis udany</div>";       
		unset ($con);	
	}
    public function createFile($rec)
    {
        $content='<?php
        include_once \'../classes/connect/load.php\';
        $load = new Connect_Load;
        $load->__setTable(\'index_pieces\');
        $q = $load->loadIndex();
        $category_now_display=\''.$rec.'\';
        ';// title = category
        //description
        //keyword
        $content .='
        eval(\'?>\'.$q[\'php_beafor_html\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p1\'].\'<?php \');
        //--
        $load->__setTable(\'product_category_main\');
        $meta = $load->metaDataCategory($category_now_display);
        //--
        $load->__setTable(\'setting_seo\');
        $global = $load->globalMetaData();
        //--
        if ($meta[\'title\']!=null) {
            echo \'<title>\'.$meta[\'title\'].\'</title>\';
        } else {
            echo \'<title>\'.$global[\'global_title_category\'].\'</title>\';
        }
        
        if ($meta[\'description\']!=null) {
            echo \'<meta name="description" content="\'.$meta[\'description\'].\'" />\';
        } else {
            echo \'<meta name="description" content="\'.$global[\'global_description_category\'].\'" />\';
        }
        
        if ($meta[\'keywords\']!=null) {
            echo \'<meta name="keywords" content="\'.$meta[\'keywords\'].\'" />\';
        } else {
            echo \'<meta name="keywords" content="\'.$global[\'global_keywords_category\'].\'" />\';
        }
        //---
        eval(\'?>\'.$q[\'head_include\'].\'<?php \');
        eval(\'?>\'.$q[\'head_p1\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p2\'].\'<?php \');
        //here
        eval(\'?>\'.$q[\'html_p3\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p4\'].\'<?php \');
        ?>';
        $path = '../category/'.$this->createFileName($rec).'.php';//gdzie i jak apisac
        $out_file = fopen($path, 'w');
        fwrite($out_file, $content);
        fclose($out_file);
    }
    public function updateAllRecProductTab($rec_new,$rec_old,$row)
    {//tu
		/*zapis*/
		$con=$this->connectDB();
			$con->query("UPDATE `".$this->table."` 
            SET
			`".$row."` = '".$rec_new."'
			WHERE
            `".$row."` = '".$rec_old."'
            ");
			echo "<div class=\"center\" >zapis udany</div>";	
		unset ($con);	
	}
	public function deleteREC($rec)
    {
		$con=$this->connectDB();
		$con->query("DELETE FROM `".$this->table."` WHERE `".$this->table."` = '".$rec."'");	
		unset ($con);
	
	}
    public function deleteFile($rec)
    {
		unlink('../category/'.$this->createFileName($rec).'.php');
	
	}
	public function showCategory()
    {
		/*pokaz*/
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
}
/**/
$produkt = new CategorySetCls();
if (isset($_POST['save_main'])) {
	$produkt->__setTable('product_category_main');
	$produkt->createREC($_POST['product_add_category_main'],'file_name_category_main');
    $produkt->createFile($_POST['product_add_category_main']);//tu
}
if (isset($_POST['save_sub'])) {
	$produkt->__setTable('product_category_sub');
	$produkt->createREC($_POST['product_add_category_sub'],'file_name_category_sub');
}
if (isset($_POST['delete_rec_main'])) {
	$produkt->__setTable('product_category_main');
	$produkt->deleteREC($_POST['hidden_old_rec_main']);
    $produkt->deleteFile($_POST['hidden_old_rec_main']);
}
if (isset($_POST['delete_rec_sub'])) {
	$produkt->__setTable('product_category_sub');
	$produkt->deleteREC($_POST['hidden_old_rec_sub']);
}
if (isset($_POST['ok_main'])) {    
	$produkt->__setTable('product_category_main');
    $produkt->deleteFile($_POST['hidden_old_rec_main']);
	$produkt->updateREC($_POST['update_txt'],$_POST['hidden_old_rec_main'],'file_name_category_main');
    $produkt->createFile($_POST['update_txt']);//tu
    //set change on product tab
    $produkt->__setTable('product_tab');
    $produkt->updateAllRecProductTab($_POST['update_txt'],$_POST['hidden_old_rec_main'],'product_category_main');
}
if (isset($_POST['ok_sub'])) {
	$produkt->__setTable('product_category_sub');
	$produkt->updateREC($_POST['update_txt'],$_POST['hidden_old_rec_sub'],'file_name_category_sub');
    //set change on product tab
    $produkt->__setTable('product_tab');
    $produkt->updateAllRecProductTab($_POST['update_txt'],$_POST['hidden_old_rec_sub'],'product_category_sub');  
}
echo '</div>';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Kategoria</title>
	<?php include ('meta5.html'); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
	<section id="place-holder">
		<nav>		
			<?php include ('menu_zap.php'); ?>
		</nav>
        <!--NEW-->
		<div>
            <form enctype="multipart/form-data" action="" method="POST" >
                <!--MAIN-->
                <table class="table-bck table-category">
                    <tr>
                        <th>Nazwa Kategorii w górnym Menu</th>
                        <th>Zapis</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls" type="text" name="product_add_category_main" />
                        </td>
                        <td>
                            <input id="" class="submit-cls" type="submit" name="save_main" value="Dodaj" />
                        </td>
                    </tr>
                    <tr>
                        <th>Ustawienia dla SEO</th>
                        <td>
                            <input id="" class="seo-radio" type="radio" name="seo_setting" checked="checked" value="title-n_false" />Użyj globalnych ustawień.<br />
                            <input id="" class="seo-radio" type="radio" name="seo_setting" value="title-n_true" />Użyj własnych ustawień (zalecane).
                        </td>
                    </tr>
                </table>
                <table id="seo-table-new" class="table-bck table-category">                              
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('input[type="radio"]').each(function() { 
                                $(this).change(function(){
                                    if( $('input[value="title-n_true"]').is(":checked") ) {
                                        $('#seo-table-new').css({'display':'table'});
                                        $('input.seo-n-text').removeAttr("disabled");
                                    } else {
                                        $('input.seo-n-text').attr("disabled", "disabled");
                                        $('#seo-table-new').css({'display':'none'});
                                    }
                                });
                            });
                        });
                        $(window).load(function() {
                            $('input[type="radio"]').each(function() { 
                                if( $('input[value="title-n_true"]').is(":checked") ) {
                                    $('#seo-table-new').css({'display':'table'});
                                    $('input.seo-n-text').removeAttr("disabled");
                                } else {
                                    $('input.seo-n-text').attr("disabled", "disabled");
                                    $('#seo-table-new').css({'display':'none'});
                                }
                            }); 
                        });
                    </script>  
                    <tr>
                        <th>Title</th>
                        <th>Max. około 70 znaków</th>
                    </tr>  
                    <tr>
                        <td colspan="2">
                            <input id="" class="text-cls seo-n-text" type="text" name="title" />
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <th>Max. około 200 znaków</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input id="" class="text-cls seo-n-text" type="text" name="description" />
                        </td>
                    </tr>
                    <tr>
                        <th>Keywords</th>
                        <th>Max. około 200 znaków</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input id="" class="text-cls seo-n-text" type="text" name="keywords" />
                        </td>
                    </tr>
                </table>
                <!--SUB-->
                <br />
                <------------------------------------------------------------------------------->
                <br />
                <table class="table-bck table-category">	
                    <tr>
                        <th>Nazwa Podkategorii Lewe Menu</th>
                        <th>Zapis</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls" type="text" name="product_add_category_sub" />
                        </td>
                        <td>
                            <input id="" class="submit-cls" type="submit" name="save_sub" value="Dodaj" />
                        </td>
                    </tr>
                </table>
            </form>
		</div>
        <!--EDIT-->
        <br />
        <------------------------------------------------------------------------------->
        <br />
		<div>
		<?php
		$produkt->__setTable('product_category_main');//tabelke juz bedzie mial trzeba ustalic z gory w install jak bedzie sie nazywala tabelka z produktami
		if ($produkt->showCategory()) { ?>
            <!--MAIN-->            
            <?php foreach ($produkt->showCategory() as $cat) { ?>
                <form enctype="multipart/form-data" action="" method="POST" >
                    <table class="table-bck table-category">                    
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('.ok').css({'display':'none'});                                    
                                $('input.up-sub-main<?php echo $cat['id']; ?>').click(function() {
                                    $('input#main<?php echo $cat['id']; ?>').removeAttr('disabled');
                                    $('#ok-main<?php echo $cat['id']; ?>').css({'display':'inline'});
                                    $('#anuluj-main<?php echo $cat['id']; ?>').css({'display':'inline'});
                                    $('#seo-table-edit-<?php echo $cat['id']; ?>').css({'display':'table'});
                                    //change
                                    $('input.up-sub-main<?php echo $cat['id']; ?>').css({'display':'none'});
                                    $('input.delete-main<?php echo $cat['id']; ?>').css({'display':'none'});
                                    
                                });
                            });
                        </script>
                        <tr>
                            <td>
                                <?php echo $cat['id']; ?>
                            </td>
                            <td>
                                <input id="main<?php echo $cat['id']; ?>" class="text-cls" type="text" name="update_txt" value="<?php echo $cat['product_category_main']; ?>" disabled="disabled" />
                                                            
                            </td>
                            <td>
                                <input id="" class="up-sub-main<?php echo $cat['id']; ?>" type="button" name="update_rec_main" value="Edytuj" />
                                <input id="" class="delete-main<?php echo $cat['id']; ?>" type="submit" name="delete_rec_main" value="Usuń" />
                                <!--change-->
                                <input id="ok-main<?php echo $cat['id']; ?>" class="ok" type="submit" name="ok_main" value="OK"/>
                                <input id="anuluj-main<?php echo $cat['id']; ?>" class="ok" type="submit" name="anuluj" value="Anuluj"/>
                                <!--old-->
                                <input id="" class="" type="hidden" name="hidden_old_rec_main" value="<?php echo $cat['product_category_main']; ?>" />
                            </td>
                        </tr>
                    </table>       
                    <table id="seo-table-edit-<?php echo $cat['id']; ?>" class="table-bck table-category seo-table-edit">
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('.seo-table-edit').css({'display':'none'});
                                $('input[type="radio"]').each(function() { 
                                    $(this).change(function(){
                                        if( $('input[value="title_true-<?php echo $cat['id']; ?>"]').is(":checked") ) {
                                            $('input.seo-e-text-<?php echo $cat['id']; ?>').removeAttr("disabled");
                                            //alert('im here1');
                                        } else {
                                            $('input.seo-e-text-<?php echo $cat['id']; ?>').attr("disabled", "disabled");
                                            //alert('im here2');
                                        }
                                    });
                                });
                            });
                            $(window).load(function() {
                                $('input[type="radio"]').each(function() { 
                                    if( $('input[value="title_true-<?php echo $cat['id']; ?>"]').is(":checked") ) {
                                        $('input.seo-e-text-<?php echo $cat['id']; ?>').removeAttr("disabled");
                                        //alert('im here3');
                                    } else {
                                        $('input.seo-e-text-<?php echo $cat['id']; ?>').attr("disabled", "disabled");
                                        //alert('im here4');
                                    }
                                }); 
                            });
                        </script>
                        <tr>
                            <th>Ustawienia dla SEO</th>
                            <td>
                                <input id="" class="seo-radio" type="radio" name="seo_setting" <?php echo $cat['mod']==0 ? 'checked="checked"' : '' ; ?> value="title_false" />Użyj globalnych ustawień.<br />
                                <input id="" class="seo-radio" type="radio" name="seo_setting" <?php echo $cat['mod']==1 ? 'checked="checked"' : '' ; ?> value="title_true-<?php echo $cat['id']; ?>" />Użyj własnych ustawień (zalecane).
                            </td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <th>Max. około 70 znaków</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="" class="text-cls seo-e-text-<?php echo $cat['id']; ?>" type="text" name="title" value="<?php echo $cat['title']!=null ? $cat['title'] : 'brak' ; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <th>Max. około 200 znaków</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="" class="text-cls seo-e-text-<?php echo $cat['id']; ?>" type="text" name="description" value="<?php echo $cat['description']!=null ? $cat['description'] : 'brak' ; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th>Keywords</th>
                            <th>Max. około 200 znaków</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="" class="text-cls seo-e-text-<?php echo $cat['id']; ?>" type="text" name="keywords" value="<?php echo $cat['keywords']!=null ? $cat['keywords'] : 'brak' ; ?>" />
                            </td>
                        </tr>
                    </table>
                </form>
			<?php } ?>
		<?php } ?>
		</div>
        <br />
        <------------------------------------------------------------------------------>
        <br />
        <!--SUB-->
		<div>
		<?php
		$produkt->__setTable('product_category_sub');//tabelke juz bedzie mial trzeba ustalic z gory w install jak bedzie sie nazywala tabelka z produktami
		if ($produkt->showCategory()) { ?>
            <table class="table-bck table-category">
            <?php foreach ($produkt->showCategory() as $cat) { ?>			
				<form enctype="multipart/form-data" action="" method="POST" >
                    <tr>
                        <td>
                            <?php echo $cat['id']; ?>
                        </td>
                        <td>
                        	<script type="text/javascript">
                                $(document).ready(function(){
                                    $('.ok').css({'display':'none'});
                                    $('input.up-sub-sub<?php echo $cat['id']; ?>').click(function() {
                                        $('input#sub<?php echo $cat['id']; ?>').removeAttr('disabled');
                                        $('#ok-sub<?php echo $cat['id']; ?>').css({'display':'inline'});
                                        $('#anuluj-sub<?php echo $cat['id']; ?>').css({'display':'inline'});
                                    });
                                });
                            </script>
                            <input id="sub<?php echo $cat['id']; ?>" type="text" name="update_txt" value="<?php echo $cat['product_category_sub']; ?>" disabled="disabled" />                     
                            <input id="ok-sub<?php echo $cat['id']; ?>" class="ok" type="submit" name="ok_sub" value="OK"/>                      
                            <input id="anuluj-sub<?php echo $cat['id']; ?>" class="ok" type="submit" name="anuluj" value="Anuluj"/> 
                        </td>
                        <td>
                            <input id="" class="up-sub-sub<?php echo $cat['id']; ?>" type="button" name="update_rec_sub" value="Edytuj" />
                            <!--<input id="" class="" type="hidden" name="update_hidden_old_rec_sub" value="<?php //echo $cat['product_category_sub']; ?>" />-->
                        </td>
                        <td>
                            <input id="" class="" type="submit" name="delete_rec_sub" value="Usuń" />
                            <input id="" class="" type="hidden" name="hidden_old_rec_sub" value="<?php echo $cat['product_category_sub']; ?>" />
                        </td>
                    </tr>
                </form>
			<?php } ?>
            </table>
		<?php } ?>
		</div>
	</section>
	<footer>
	<!--<div id="count"></div><div id="count2"></div>-->
	</footer>
	<div id="debugger">
		<?php
		echo "post";
		var_dump (@$_POST);
		//echo "session";
		//var_dump ($_SESSION);
		// echo "files";
		// var_dump (@$_FILES);
		// echo "var2";
		//var_dump ($produkt->showCategory());	
		//echo "cookies";
		//var_dump ($_COOKIE);
		?>
	</div>
</body>
</html>
