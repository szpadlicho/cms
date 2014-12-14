<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
class Connect_Search
{
    private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;
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
    public function __getProdyctName($string)
    {
        $con = $this->connectDB();
        $res = $con->query("SELECT * FROM `".$this->table."` WHERE `product_name` LIKE '%".$string."%'");
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
}
$obj_search = new Connect_Search();
$obj_search->__setTable('product_tab');
$success = $obj_search->__getProdyctName($_POST['string']);
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
    <?php while ($cat = $success->fetch(PDO::FETCH_ASSOC)) { ?>
        <a class="square-link" href="../product/<?php echo $cat['file_name'].'.php'; ?>">
            <div class="product-square">
                <div class="pr-sq img">
                   <img class="mini-image-pr-list" src="<?php echo $obj_search->showMiniImg($cat['id']); ?>" alt="mini image" />
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
                <form method="POST">
                    <input class="basket-field text" type="text" name="amount" value="1" />
                    <input class="basket-field text" type="hidden" name="pr_id" value="<?php echo $cat['id']; ?>" />
                    <input class="basket-field button" type="submit" name="add_to_basket" value="Dodaj" />
                </form>
                <?php } ?>
            </div>
        </a>
    <?php } ?>
</table>
<?php
// foreach ($success as $row) {
    // echo $row['product_name'].'<br />';
    // var_dump($row);
// }
?>