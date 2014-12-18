<?php
//ini_set('xdebug.var_display_max_depth', -1);
//ini_set('xdebug.var_display_max_children', -1);
//ini_set('xdebug.var_display_max_data', -1);
header('Content-Type: text/html; charset=utf-8');
class GlobalSettingCls
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;// ma miec
	private $row;
	private $path;
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
    public function __setRow($arr_val, $id)
    {
        $value ='';
        foreach ($arr_val as $name => $val) {
            $value .= "`".$name."` = '".trim($val)."',";
        }
        /*zapis*/
		$con=$this->connectDB();
		$res=$con->exec("UPDATE `".$this->table."` 
            SET
			".$value."
            `mod` = '0'
			WHERE
            `id` = '".$id."'
            ");
        if ($res) {
            echo "<div class=\"center\" >Zapis: OK!</div>";
        } else {
            echo "<div class=\"center\" >Zapis: ERROR!</div>";
        }
    }
    public function __getRow($id)
    {
        $con=$this->connectDB();
        $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`='".$id."'");
        unset ($con);
        if ($q) {
            $q = $q->fetch(PDO::FETCH_ASSOC);
            return $q;
        } else {
            echo 'nie ustawione';
        }
    }
}
/**/
$setting_seo = new GlobalSettingCls();
$setting_seo->__setTable('setting_seo');
if (isset($_POST['save'])) {//dodac usuwanie kodu html php itd......    
    $arr_val = array('global_title_index'=>$_POST['global_title_index'],
                    'global_keywords_index'=>$_POST['global_keywords_index'],
                    'global_description_index'=>$_POST['global_description_index'],
                    'global_title_category'=>$_POST['global_title_category'],
                    'global_keywords_category'=>$_POST['global_keywords_category'],
                    'global_description_category'=>$_POST['global_description_category'],
                    'global_title_product'=>$_POST['global_title_product'],
                    'global_keywords_product'=>$_POST['global_keywords_product'],
                    'global_description_product'=>$_POST['global_description_product']
                    );
    $setting_seo->__setRow($arr_val,1);
}
$get = $setting_seo->__getRow(1);
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Zaplecze - Global Setting center</title>
	<?php include ("meta5.html"); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
<section id="place-holder">	
	<?php include ('backroom-top-menu.php'); ?>
    <div class="back-all seo placeholder">
        <form enctype="multipart/form-data" action="" method="POST" >
            <table class="back-all seo table">
                <tr>
                    <th colspan="2">SEO Globalne Ustawienia</th>
                </tr>
                <tr>
                    <th colspan="2">Strona Głowna:</th>
                </tr>
                <tr>
                    <th>Tytuł (Title)</th>
                    <td><input id="" class="back-all seo text" type="text" name="global_title_index" value="<?php echo $get['global_title_index']; ?>" /></td>
                </tr>
                <tr>
                    <th>Słowa kluczowe (Keywords)</th>
                    <td><input id="" class="back-all seo text" type="text" name="global_keywords_index" value="<?php echo $get['global_keywords_index']; ?>" /></td>
                </tr>
                <tr>
                    <th>Opis (Description)</th>
                    <td><textarea id="" class="back-all seo textarea" name="global_description_index" ><?php echo $get['global_description_index']; ?></textarea></td>
                </tr>
                <tr>
                    <th>Zapisz:</th>
                    <td><input id="" class="back-all seo submit save" type="submit" name="save" value="Zapisz" /></td>
                </tr>
                <tr>
                    <th colspan="2">Strona Kategorii:</th>
                </tr>
                <tr>
                    <th>Tytuł (Title)</th>
                    <td><input id="" class="back-all seo text" type="text" name="global_title_category" value="<?php echo $get['global_title_category']; ?>" /></td>
                </tr>
                <tr>
                    <th>Słowa kluczowe (Keywords)</th>
                    <td><input id="" class="back-all seo text" type="text" name="global_keywords_category" value="<?php echo $get['global_keywords_category']; ?>" /></td>
                </tr>
                <tr>
                    <th>Opis (Description)</th>
                    <td><textarea id="" class="back-all seo textarea" name="global_description_category" ><?php echo $get['global_description_category']; ?></textarea></td>
                </tr>
                <tr>
                    <th>Zapisz:</th>
                    <td><input id="" class="back-all seo submit save" type="submit" name="save" value="Zapisz" /></td>
                </tr>
                <tr>
                    <th colspan="2">Strona Towaru:</th>
                </tr>
                <tr>
                    <th>Tytuł (Title)</th>
                    <td><input id="" class="back-all seo text" type="text" name="global_title_product" value="<?php echo $get['global_title_product']; ?>" /></td>
                </tr>
                <tr>
                    <th>Słowa kluczowe (Keywords)</th>
                    <td><input id="" class="back-all seo text" type="text" name="global_keywords_product" value="<?php echo $get['global_keywords_product']; ?>" /></td>
                </tr>
                <tr>
                    <th>Opis (Description)</th>
                    <td><textarea id="" class="back-all seo textarea" name="global_description_product" ><?php echo $get['global_description_product']; ?></textarea></td>
                </tr>
                <tr>
                    <th>Zapisz:</th>
                    <td><input id="" class="back-all seo submit save" type="submit" name="save" value="Zapisz" /></td>
                </tr>                
            </table>
        </form>
	</div>
	</section>
	<footer>
	</footer>
	<div id="debugger">
		<?php
		//echo "post";
		//var_dump ($_POST);
		//echo "session";
		//var_dump ($_SESSION);
		//echo "files";
		//var_dump ($_FILES);
		// echo "var2";
		 // var_dump ($var2);	
		//echo "cookies";
		//var_dump ($_COOKIE);
		?>
	</div>
</body>
</html>