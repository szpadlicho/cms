<?php
include_once '../classes/connect.php';
class asd extends Connect
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
    public function showAllImg($id)
    {
        //wszystkie orazki z katalogu                                         
        $dir_all = '../data/'.$id.'/';                                        
        if (@opendir($dir_all)) {//sprawdzam czy sciezka istnieje
            $q = (count(glob($dir_all."/*")) === 1) ? 'Empty' : 'Not empty';
            if ($q=="Empty") {
                //echo "Chwilowo Brak";
                return false;
            } else {
                $folder = opendir($dir_all);
                $i = 0;
                while (false !=($plik = readdir($folder))) {
                    if ($plik != "." && $plik != ".." && $plik != "mini") {
                        $obrazki[$i]= $dir_all.$plik;//tablica z obrazkami
                        $i++;
                    }
                }
                closedir($folder);
                //$losowy=rand(0,count(@$obrazki)-1);//losuje obrazek
                return $obrazki;//link do obrazka 'src'
                unset($obrazki);
            }                                               
        } else {
            //echo 'Brak';
            return false;
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
    public function showFullSquare($cat)
    {
        ?>
        <div class="product-full-square">
            <div class="full-up-place-holder">
                <div class="full-mini-img">
                    <img class="mini-image-pr-list" src="<?php echo $this->showMiniImg($cat['id']); ?>" alt="mini image" />
                </div>
                <div class="full-name"><?php echo $cat['product_name']; ?></div>
                <div class="full shipping">
                    <?php echo $this->showShippingPrice($cat['id']); ?>
                </div>
                <?php if (isset($_SESSION['user_id'])) { ?>
                <div class="full add">
                    <form method="POST">
                        <input class="basket-field text" type="text" name="amount" value="1" />
                        <input class="basket-field text" type="hidden" name="pr_id" value="<?php echo $cat['id']; ?>" />
                        <input class="basket-field button" type="submit" name="add_to_basket" value="Dodaj" />
                    </form>
                </div>
                <?php } ?>
            </div>          
            <div class="full-down-place-holder">
                <div class="full-description-button color full-click active">Opis</div>
                <div class="full-description-container color"><?php echo $cat['product_description_large']; ?></div>
                <div class="full-gallery-button color full-click">Galeria</div>
                <div class="full-gallery-container color">
                    <?php
                    $img_tab = $this->showAllImg($cat['id']);
                    if ($img_tab) {
                        foreach ($img_tab as $img) {
                            ?>
                            <div class="full-img-gallery">
                                <img class="mini-image-pr-list" src="<?php echo $img; ?>" alt="<?php echo $cat['product_name']; ?>" />
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="full-other-button color full-click">Inne</div>
                <div class="full-other-container color"><?php echo $cat['product_description_small']; ?></div>
            </div>
        </div>        
        <?php
    }
}
$work = new asd();
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php include ("../meta5.html"); ?>
	<script type="text/javascript" src="../js/menu.js"></script>
    <style>
        .lightbox{
            position: absolute;
            top: 0em;
            left: 0em;
            display: none;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.2);         
        }
        .lightbox-in{
            display:table;
            vertical-align: middle;
            text-align: center;
            width: 100%;
            height: 100%;
        }
        .lightbox-in-in{
            display:table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .lightbox-button{
            position:relative;
            display: inline-block;
        }
        .now-displayed-image{
            max-width: 50em;
            margin: 0 auto;
        }
        .close{
            position:absolute;

            cursor: default;
            cursor: pointer;
            z-index: 100;
            
            top: -25px;
            right: -25px;
            float: right;
            display: block;
            height: 50px;
            width: 50px;
            background: url("../images/close.png") no-repeat scroll 0% 0% transparent;

        }
        .next{
            position:absolute;
            top:50%;
            right:-0.5em;
            font-size: 3em;
            cursor: default;
            cursor: pointer;
            z-index: 100;
            color:pink;
            float: right;
            display: block;
            height: 50px;
            width: 50px;
            background: url("../images/next.png") no-repeat scroll 0% 0% transparent;
            background-size: 50px 50px;
        }
        .prev{
            position:absolute;
            top:50%;
            left:-0.5em;
            font-size: 3em;
            cursor: default;
            cursor: pointer;
            z-index: 100;
            color:pink;
            float: right;
            display: block;
            height: 50px;
            width: 50px;
            background: url("../images/prev.png") no-repeat scroll 0% 0% transparent;
            background-size: 50px 50px;
        }
        .mini-image-pr-list{
            max-width:10em;
            max-height:10em;
            display:inline-block;
            border: 1px solid black;
            padding: 0.5em;
        }
        /*
        .current{
            position:absolute;
            top: 50%;
            left: 50%;
            max-width:20em;
            max-height:20em;
        }
        */
        /*
        .next-img{
            border: 1px solid blue;
        }
        .prev-img{
            border: 1px solid green;
        }
        */
    </style>
    <script type="text/javascript">
    $(function(){

        var con = '<div class="lightbox-button" ><img class="now-displayed-image" src="';
        var tent = '" /><div class="prev"></div><div class="close"></div><div class="next"></div></div>';
        $( '.mini-image-pr-list' ).click(function(){
            var src = $( this ).attr('src');// zwraca sciezke wzglwdna
            //var src = $( this ).prop('src');// zwraca sciezke bezwzgledna
            //console.log(src);
            $( '.lightbox' ).show();
            $( '.lightbox-in-in' ).html( con+src+tent );
            $( '.mini-image-pr-list' ).removeClass('current').removeClass('next-img').removeClass('prev-img');
            $( this ).addClass('current');
            $( this ).next('img.mini-image-pr-list').addClass('next-img');
            $( this ).prev('img.mini-image-pr-list').addClass('prev-img');
        });
        $( document ).on('click', '.next', function(event){
            $( '.current' ).removeClass('current');
            $( '.next-img' ).addClass('current').removeClass('next-img');
            if ( $( '.current' ).length == 0 ) {
                $( 'img.mini-image-pr-list' ).first().addClass('current');
            }
            $( '.prev-img').removeClass('prev-img');
            $( '.current' ).next('img.mini-image-pr-list').addClass('next-img');
            $( '.current' ).prev('img.mini-image-pr-list').addClass('prev-img');
            //var lkl = $( '.current' ).length;
            //console.log(lkl);
            var src = $( '.current' ).attr('src');
            $( '.lightbox-in-in' ).html( con+src+tent );
            
        });
        $( document ).on('click', '.prev', function(event){
            $( '.current' ).removeClass('current');
            $( '.prev-img' ).addClass('current').removeClass('prev-img');
            if ( $( '.current' ).length == 0 ) {
                $( 'img.mini-image-pr-list' ).last().addClass('current');
            }
                $( '.next-img').removeClass('next-img');
                $( '.current' ).prev('img.mini-image-pr-list').addClass('prev-img');
                $( '.current' ).next('img.mini-image-pr-list').addClass('next-img');
                var src = $( '.current' ).attr('src');
                $( '.lightbox-in-in' ).html( con+src+tent );
        });
        $( document ).on('click', '.close', function(){
            $( '.lightbox' ).hide();
        });
        // $( document ).on('click', '.lightbox', function(){
            // $( '.lightbox' ).hide();
        // });
        // $( document ).on('click', '.now-displayed-image', function(event){
            // //event.preventDefault();
            // event.isDefaultPrevented();
            // return false;
        // });
    });
    </script>
</head>
<body style="color:black;">
    <div class="full-gallery-containerr color">
        <?php
        $img_tab = $work->showAllImg(6);
        //var_dump($img_tab);
        if ($img_tab) {
            foreach ($img_tab as $img) {
                ?>
                <!--<div class="full-img-gallery">-->
                    <img class="mini-image-pr-list" src="<?php echo $img; ?>" alt="" />
                <!--</div>-->
                <?php
            }
        }
        ?>
        <div class="lightbox"><div class="lightbox-in"><div class="lightbox-in-in"></div></div></div>
    </div>
</body>
</html>




