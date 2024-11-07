<?php
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
header('Content-Type: text/html; charset=utf-8');
echo '<div class="catch">';
include_once '../classes/connect.php';
class UpdateIndexCls extends Connect
{
	// private $host='localhost';
	// private $port='';
	// private $dbname='szpadlic_cms';
	// private $charset='utf8';
	// private $user='user';
	// private $pass='user';
	private $table;
	private $row;
	private $path;
	public function _setTable($tab_name)
    {
		$this->table=$tab_name;
	}
    public function _setRow($row_name)
    {
		$this->row=$row_name;
	}
    public function _setPath($path)
    {
		$this->path=$path;
	}
	// public function connectDB()
    // {
		// $con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		// return $con;
		// unset ($con);
	// }
    public function deleteTB()//usuwam tabele
    {
		$con=$this->connectDB();
        $res = $con->query("SELECT 1 FROM ".$this->table);//zwraca false jesli tablica nie istnieje	        
		if (!$res) {
            unset ($con);
            echo "<div class=\"center\" >Tabela nie istnieje więc nie można jej usunąć</div>";
        } else {
            $result=$con->query("DROP TABLE `".$this->table."`"); //usowanie
            unset ($con);
            if ($result) {
                echo "<div class=\"center\" >Delete: {$this->table} OK!</div>";
            } else {
                echo "<div class=\"center\" >Delete: {$this->table} ERROR!</div>";
            }
        }
	}
    public function createTB()//tworze tabele
    {
		$con=$this->connectDB();
		$res = $con->query("SELECT 1 FROM ".$this->table);//zwraca false jesli tablica nie istnieje	
		if (!$res) {
			$result=$con->query("CREATE TABLE IF NOT EXISTS `".$this->table."`(
			`id` INTEGER AUTO_INCREMENT,
			PRIMARY KEY(`id`)
			)ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1");
            if ($result) {
                echo "<div class=\"center\" >Tworzenie tabeli: {$this->table} OK!</div>";
                //inicjacja tabeli
                $res=$con->query("ALTER TABLE `".$this->table."` ADD `empty` TEXT ");
                $res=$con->query("INSERT INTO `".$this->table."`(
                `empty`
                ) VALUES (
                'for initiate id'
                )");               
            } else {
                echo "<div class=\"center\" >Tworzenie tabeli: {$this->table} ERROR!</div>";
            }
		} else {
			echo "<div class=\"center\" >Tabela już istnieje !</div>";
		}
	}
    public function addRow($name)
    {
        $this->_setRow($name);
        $con=$this->connectDB();
        $res=$con->query("ALTER TABLE `".$this->table."` ADD `".$this->row."` TEXT ");
        if($res) {
            echo "<div class=\"center\" >Dodanie kolumny: {$this->row} OK!</div>";
        } else {
            echo "<div class=\"center\" >Dodanie kolumny: {$this->row} ERROR!</div>";
        }
    }
    public function recRow($value)//wgranie zawartości wywołane wewnątrz funkcji _getString
    {
        //zapis
		$con=$this->connectDB();
		$res=$con->query("UPDATE `".$this->table."` 
            SET
			`".$this->row."` = '".$value."'
			WHERE
            `id` = '1'
            ");
        if($res) {
            echo "<div class=\"center\" >Zapis: OK!</div>";
            echo "<div class=\"center\" >Last id: ".$con->lastInsertId()."</div>";
        } else {
            echo "<div class=\"center\" >Zapis: ERROR!</div>";
        }
        unset($con);
    }
    public function _getString($trigger)
    {
        $path = $this->path;
        $hd = fopen ($path, 'r');
        $content = fread($hd, filesize($path));//cala strona
        fclose($hd);
        $pieces=explode($trigger,$content);
        return $this->recRow(addslashes($trigger.$pieces[1].$trigger));
    }
    /*public function createFile($rec)//calośc do zakomentowania zrobiona do testów
    {
        $con=$this->connectDB();
        $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`='1'");//zwraca false jesli tablica nie istnieje
        unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        //return $q;
        $content='<?php
        class ConnectCls{
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
                $q = $con->query("SELECT * FROM `".$this->table."` WHERE `id`=\'1\'");//zwraca false jesli tablica nie istnieje
                unset ($con);
                $q = $q->fetch(PDO::FETCH_ASSOC);
                return $q;
            }
        }
        $load = new ConnectCls();
        $load->_setTable(\'index_pieces\');
        $q = $load->loadIndex();
        ';
        $content .='
        eval(\'?>\'.$q[\'php_beafor_html\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p1\'].\'<?php \');
        eval(\'?>\'.$q[\'head_title\'].\'<?php \');
        eval(\'?>\'.$q[\'head_description\'].\'<?php \');
        eval(\'?>\'.$q[\'head_keywords\'].\'<?php \');
        eval(\'?>\'.$q[\'head_include\'].\'<?php \');
        eval(\'?>\'.$q[\'head_p1\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p2\'].\'<?php \');
        //here
        $category_now_display=\''.$rec.'\';
        eval(\'?>\'.$q[\'html_p3\'].\'<?php \');
        eval(\'?>\'.$q[\'html_p4\'].\'<?php \');
        ?>';
        // $path = '../test.php';//gdzie i jak apisac
        // $out_file = fopen($path, 'w');
        // fwrite($out_file, $content);
        // fclose($out_file);
    }*/
}
//
$update = new UpdateIndexCls();
$update->_setTable('index_pieces');
$update->deleteTB();
$update->createTB();
$update->_setPath('../home/index.php');
//początek wgrywania
$update->addRow('php_beafor_html');
$update->_getString('<?php //php_beafor_html ?>');

$update->addRow('html_p1');
$update->_getString('<?php //html_p1 ?>');

//spot one begin section head
$update->addRow('head_title');
$update->_getString('<?php //head_title ?>');

$update->addRow('head_description');
$update->_getString('<?php //head_description ?>');

$update->addRow('head_keywords');
$update->_getString('<?php //head_keywords ?>');

$update->addRow('head_include');
$update->_getString('<?php //head_include ?>');

$update->addRow('head_p1');
$update->_getString('<?php //head_p1 ?>');
//spot two end section head
$update->addRow('html_p2');
$update->_getString('<?php //html_p2 ?>');
//spot three begin section body
$update->addRow('html_p3');
$update->_getString('<?php //html_p3 ?>');
//spot four end section body
$update->addRow('html_p4');
$update->_getString('<?php //html_p4 ?>');
//koniec wgrywania
echo '</div>';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Zaplecze - Update index in base</title>
	<?php include ("meta5.html"); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
    <section id="place-holder">	
        <?php include ('backroom-top-menu.php'); ?>
    </section>
<?php
//$update->createFile('PC');
//var_dump($update->createFile());
/*
$add_jquery='jquery add';
$add_pdo='pdo add';
$rec='wynik';

    $dir = '../index.php';
    $hd = fopen ($dir, 'r');
    $tresc = fread($hd, filesize($dir));//cala strona
    fclose($hd);
    $trigger='<?php //<!--php_beafor_html-->?>';
    $pieces=explode($trigger,$tresc);
    //var_dump($pieces);//1
    $trigger='<?php //<!--html_p1-->?>';
    $pieces=explode($trigger,$tresc);
    var_dump($pieces);//1
*/
?>
</body>
</html>