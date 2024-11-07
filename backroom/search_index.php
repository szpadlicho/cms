<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include_once '../classes/connect.php';
class Connect_Search extends Connect
{
    private $host='localhost';
	// private $port='';
	// private $dbname='szpadlic_cms';
	// private $charset='utf8';
	// private $user='user';
	// private $pass='user';
	private $table;
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
    public function __getProdyctName($string)
    {
        $con = $this->connectDB();
        $res = $con->query("SELECT * FROM `".$this->table."` WHERE `product_name` LIKE '%".$string."%' AND `visibility` = '1'");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    public function __getProdyctNameMain($string, $main)
    {
        $con = $this->connectDB();
        $res = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = '".$main."' AND `product_name` LIKE '%".$string."%' AND `visibility` = '1'");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
        //$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = '".$main."' AND `product_category_sub` = '".$sub."'")
    }
    public function __getProdyctNameSub($string, $sub)
    {
        $con = $this->connectDB();
        $res = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_sub` = '".$sub."' AND `product_name` LIKE '%".$string."%' AND `visibility` = '1'");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    public function __getProdyctNameMainSub($string, $main, $sub)
    {
        $con = $this->connectDB();
        $res = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = '".$main."' AND `product_category_sub` = '".$sub."' AND `product_name` LIKE '%".$string."%' AND `visibility` = '1'");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    public function showMiniImg($id)
    {
        //losowy obrazek z katalogu                                           
        $dir_mini = '../data/'.$id.'/mini/';                                        
        if (@opendir($dir_mini)) {//sprawdzam czy sciezka istnieje
            $q = (count(glob($dir_mini."/*")) === 0) ? 'Empty' : 'Not empty';
            if ($q=="Empty") {
                echo "Brak"; // mozna by tu dodac fotke ze braz fotki
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
                return $dir_mini.@$obrazki[$losowy];//link do obrazka 'src'
                unset($obrazki);
            }                                               
        } else {
            echo 'Brak';//mozna by tu dodac fotke ze braz fotki
        }
    }
    public function showSquare($cat)
    {
        ?>
        <a class="square-link" href="../product/<?php echo $cat['file_name'].'.php'; ?>">
            <div class="product-square">
                <div class="pr-sq img">
                   <img class="mini-image-pr-list" src="<?php echo $this->showMiniImg($cat['id']); ?>" alt="mini image" />
                </div>
                <div class="pr-sq price">
                    Cena: <?php echo $cat['product_price']; ?> PLN
                </div>
                <div class="pr-sq cat-main">
                    <?php echo $cat['product_category_main']; ?>
                </div>
                <div class="pr-sq cat-sub">
                    <?php echo $cat['product_category_sub']; ?>
                </div>
                <div class="pr-sq name">
                    <?php echo $cat['product_name']; ?>
                </div>
                <?php if (isset($_SESSION['user_id'])) { ?>
                <div class="pr-sq add">
                    <form method="POST">
                        <input class="basket-field text" type="text" name="amount" value="1" />
                        <input class="basket-field text" type="hidden" name="pr_id" value="<?php echo $cat['id']; ?>" />
                        <input class="basket-field button" type="submit" name="add_to_basket" value="Dodaj" />
                    </form>
                </div>
                <?php } ?>
                <div class="pr-sq shipping">
                    <?php echo $this->showShippingPrice($cat['id']); ?>
                </div>
            </div>
        </a>
        <?php
    }
    public function showShippingPrice($id)
    {
        $con = $this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `id` = '".$id."'");/*zwraca false jesli tablica nie istnieje*/
        $q = $q->fetch(PDO::FETCH_ASSOC);
		unset ($con);
		$mod = $q['shipping_mod'];
        if ($mod == 0) {
            $con = $this->connectDB();
            $k = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `weight_of` <= ".$q['weight']." AND `weight_to` >= ".$q['weight']."");
            $k = $k->fetch(PDO::FETCH_ASSOC);
            unset ($con);
            echo 'Przesyłka od:';
            echo '<br />';
            if ($k) {
                echo $k['price_prepaid'];
            } else {
                $con = $this->connectDB();
                $d = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `price_of` <= ".$q['product_price']." AND `price_to` >= ".$q['product_price']."");
                $d = $d->fetch(PDO::FETCH_ASSOC);
                unset ($con);
                if ($d) {
                    echo $d['price_prepaid'];
                } else {
                    $con = $this->connectDB();
                    $f = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `configuration_mod` = 'simple'");
                    $f = $f->fetch(PDO::FETCH_ASSOC);
                    //var_dump($f);
                    unset ($con);
                    if ($f) {
                        echo $f['price_prepaid'];
                    } else {
                        echo ('niezdefi-<br />niowane');
                    }
                }
            }
        } elseif ($mod == 1) {
            echo 'Przesyłka od:';
            echo '<br />';
            if ($q['allow_prepaid'] == 1 && !empty($q['price_prepaid'])) {
                echo $q['price_prepaid'];
            } elseif ($q['allow_ondelivery'] == 1 && !empty($q['price_ondelivery'])) {
                echo $q['price_ondelivery'];
            } else {
                echo ('niezdefi-<br />niowane');
            }
            
        }
    }
}
$obj_search = new Connect_Search();
$obj_search->__setTable('product_tab');
if (isset($_SESSION['main']) && isset($_SESSION['sub'])) {
    $success = $obj_search->__getProdyctNameMainSub($_POST['string'], $_SESSION['main'], $_SESSION['sub']);
} elseif (isset($_SESSION['main']) && !isset($_SESSION['sub'])) {
    $success = $obj_search->__getProdyctNameMain($_POST['string'], $_SESSION['main']);
} elseif (! isset($_SESSION['main']) && isset($_SESSION['sub'])) {
    $success = $obj_search->__getProdyctNameSub($_POST['string'], $_SESSION['sub']);
} else {
    $success = $obj_search->__getProdyctName($_POST['string']);
}
?>
<script type="text/javascript">
    // $( '[name="id_post_bt"]').click(function(){
        // //console.log( $( this ).val() );
        // var id = $( this ).next().val();//hidden input with id
        // console.log( id );
        // $.post( 'product_edit.php', { id_post: id}).done(function( data ) {
            // window.location = 'product_edit.php';
        // });
    // });
</script>
<table id="table-list" class="back-all list table">
    <?php while ($cat = $success->fetch(PDO::FETCH_ASSOC)) { 
        $obj_search->showSquare($cat);
    } ?>
</table>
<?php
// foreach ($success as $row) {
    // echo $row['product_name'].'<br />';
    // var_dump($row);
// }
?>