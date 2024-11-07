<?php
session_start();
// if(isset($_POST['id_post'])){
	// $_SESSION['id_post']=$_POST['id_post'];
// }
include_once '../classes/connect.php';
class ProduktGetCls extends Connect
{
	// private $host='localhost';
	// private $port='';
	// private $dbname='szpadlic_cms';
	// private $charset='utf8';
	// private $user='user';
	// private $pass='user';
	private $table;
	private $admin;
	private $autor;
	public function _setTable($tab_name)
    {
		$this->table=$tab_name;
	}
	// public function connectDB()
    // {
		// $con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		// return $con;
		// unset ($con);
	// }
	public function showAll()
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showMiniImg($id)
    {
        //losowy obrazek z katalogu                                           
        $dir_mini = '../data/'.$id.'/mini/';                                        
        if (@opendir($dir_mini)) {//sprawdzam czy sciezka istnieje
            $q = (count(glob($dir_mini."/*")) === 0) ? 'Empty' : 'Not empty';
            if ($q=="Empty") {
                echo "Brak"; 
            } else {
                $folder = opendir($dir_mini);
                $i = 0;
                while (false !=($plik = readdir($folder))) {
                    if ($plik != "." && $plik != "..") {
                        $obrazki[$i]= $plik;//tablica z obrazkami
                        $i++;
                    }
                }
                closedir($folder);
                $losowy=rand(0,count(@$obrazki)-1);//losuje obrazek
                echo '<img class="back-all list mini-image" src="'.$dir_mini.@$obrazki[$losowy].'" alt="mini image" /><br />';
                unset($obrazki);
            }                                               
        } else {
            echo 'Brak';
        }
    }
}
$produkt = new ProduktGetCls();
$produkt->_setTable('product_tab');
//$produkt->showAll();
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Lista</title>
	<?php include ("meta5.html"); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
	<section id="place-holder">		
		<?php include ('backroom-top-menu.php'); ?>
		<div class="back-all list placeholder">
					<?php
					if ($produkt->showAll()) { ?>
						<table id="table-list" class="back-all list table">
							<tr>
								<th>
									ID
								</th>
                                <th>
									Mini
								</th>
								<th>
									Nazwa
								</th>
								<th>
									Pozycja w menu/kategoria
								</th>
								<th>
									Podkategoria
								</th>
								<th>
									Cena
								</th>
								<th>
									Dostępność
								</th>
								<th>
									Edycja
								</th>
							</tr>
							<?php
                            
							foreach ($produkt->showAll() as $wyn) { ?>
								<form enctype="multipart/form-data" action="product_edit.php" method="POST" >
									<tr>
										<td>
											<?php echo $wyn['id']; ?>
										</td>
                                        <td>                                          
                                            <?php $produkt->showMiniImg($wyn['id']);?>
										</td>
										<td>
											<?php echo $wyn['product_name']; ?>
										</td>
										<td>
											<?php echo $wyn['product_category_main']; ?>
										</td>
										<td>
											<?php echo $wyn['product_category_sub']; ?>
										</td>
										<td>
											<?php echo $wyn['product_price']; ?>
										</td>
										<td>
											<?php echo $wyn['amount']; ?>
										</td>
										<td>
											<input class="back-all list submit edit" type="submit" name="id_post_bt" value="Edytuj" />
											<input type="hidden" name="id_post" value="<?php echo$wyn['id']; ?>" />
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
