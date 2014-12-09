<?php
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
        if (isset($_POST['seo_setting'])) {
            $_POST['seo_setting']=='title_true' ? $mod=1 : $mod=0 ;
        } else {
            $mod=0;
        }
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
        if (isset($_POST['seo_setting'])) {/**********moze generowac blad************test wyszed dobrze*************/
            $_POST['seo_setting']!='title_false' ? $mod=1 : $mod=0 ;//bo true mam z -id
        } else {
            $mod=0;
        }
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
?>