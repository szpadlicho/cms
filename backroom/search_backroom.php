<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include_once '../classes/connect.php';
class Connect_Search extends Connect
{
    // private $host='localhost';
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
$obj_search = new Connect_Search();
$obj_search->__setTable('product_tab');
$success = $obj_search->__getProdyctName($_POST['string']);
?>
<script type="text/javascript">
    $( '[name="id_post_bt"]').click(function(){
        //console.log( $( this ).val() );
        var id = $( this ).next().val();//hidden input with id
        console.log( id );
        $.post( 'product_edit.php', { id_post: id}).done(function( data ) {
            window.location = 'product_edit.php';
        });
    });
</script>
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
    while ($wyn = $success->fetch(PDO::FETCH_ASSOC)) { ?>
       <?php
        //var_dump($res);
        //echo $wyn['product_name'].'<br />';
        ?>
        <form enctype="multipart/form-data" action="product_edit.php" method="POST" >
            <tr>
                <td>
                    <?php echo $wyn['id']; ?>
                </td>
                <td>                                          
                    <?php $obj_search->showMiniImg($wyn['id']);?>
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
<?php
// foreach ($success as $row) {
    // echo $row['product_name'].'<br />';
    // var_dump($row);
// }
?>