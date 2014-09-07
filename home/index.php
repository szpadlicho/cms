<?php //php_beafor_html ?>
<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
echo '<div class="catch">';
class ShowProductCls
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;// ma miec
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
	public function showCategoryMain()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT `product_category_main` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showCategorySub($sub)
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT DISTINCT `product_category_sub` FROM `".$this->table."` WHERE `product_category_main` = '".$sub."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showSubAll()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT DISTINCT `product_category_sub` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showAll()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showAllCategory($main)
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = '".$main."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showAllSub($sub)
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_sub` = '".$sub."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showAllCategorySub($main, $sub)
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = '".$main."' AND `product_category_sub` = '".$sub."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showProduct($id)
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `id` = '".$id."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function _getCatMain($id)
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT `product_category_main` FROM `".$this->table."` WHERE `id` = '".$id."'");/*zwraca false jesli tablica nie istnieje*/
        $q = $q->fetch(PDO::FETCH_ASSOC);
		unset ($con);
		return $q;
	}
    public function _getCatMainFileName($id)
    {
        $this->_setTable('product_tab');
        $cat = $this->_getCatMain($id);
		$cat = $cat['product_category_main'];
        //return $cat;
        $con=$this->connectDB();
		$q = $con->query("SELECT `file_name_category_main` FROM `product_category_main` WHERE `product_category_main` = '".$cat."'");/*zwraca false jesli tablica nie istnieje*/
        $q = $q->fetch(PDO::FETCH_ASSOC);
		unset ($con);
		return $q['file_name_category_main'];
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
                    Cena: <?php echo $cat['product_price']; ?>
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
if (isset($_POST['topmenu'])) {
	$_SESSION['category'] = $_POST['topmenu'];
	unset($_SESSION['sub']);
}
if (isset($_POST['leftmenu'])) {
	$_SESSION['sub'] = $_POST['leftmenu'];
}
if (@$_POST['leftmenu']=='Wszystkie') {
    unset($_SESSION['sub']);
}
if (@$_POST['topmenu']=='Home') {
    //niema posta juz!!!!
	//unset($_SESSION['sub']);
	//unset($_SESSION['category']);
	//unset($_SESSION['session_menu_id']);
	//session_unset();
}
//(@$_POST['topmenu']=='Sprzęt') ? header("location: zap/index.php") : 'błąd' ;//tymczasowo na zaplecze
echo '</div>';
?>
<?php //php_beafor_html ?>
<?php //html_p1 ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
<?php //html_p1 ?>
<![CDATA[spot one begin section head]]>
<?php //head_title ?>
	<title>Index</title>
<?php //head_title ?>
<?php //head_description ?>
<?php //head_description ?>
<?php //head_keywords ?>
<?php //head_keywords ?>
<?php //head_include ?>
	<?php include ("../meta5.html"); ?>
<?php //head_include ?>
<?php //head_p1 ?>
	<style type="text/css"></style>
	<script type="text/javascript">
        //ruch tła
		$(window).scroll(function() {
			var pos=150+($(this).scrollTop()*0.6);
			if( pos <= 288 ){
				$('#titi').css({'top': pos + 'px','position':'absolute'});
			}
		});
		$(window).scroll(function() {
			var pos1=($(this).scrollTop()/3);
			$('body').css('background-position', 'center -'+pos1+'px');
			//var pos2=($(this).scrollTop()/3);
			$('.image-bg').css('background-position', 'center -'+pos1+'px');
			var pos3=190-($(this).scrollTop());
			$('.title-bg').css('top', pos3+'px');
		});
    </script>
    <script type="text/javascript">
        //full square active
		$(document).ready(function(){
            $('.full-click').click(function() {
				$('.full-click').removeClass('active');
				$(this).addClass('active');
			});
		});
	</script>
    <script type="text/javascript">
		$(document).ready(function(){
            //left menu active
			$('input.left-menu').click(function() {
				$('input.left-menu').removeClass('active');
				$(this).addClass('active');
                //alert('im here');
			});
		});
	</script>
	<script type="text/javascript">
		<?php if(isset($_SESSION['menu_id'])){ ?>
			var ids = '<?php echo $_SESSION['menu_id']; ?>';
		<?php } ?>
	</script>
	<script type="text/javascript" src="../js/menu.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
    });
    </script>
    <script type="text/javascript">
        function submitOnClick(formName){//do klikania diva i odpalania formy
            //echo '<div class="product-square" onclick="submitOnClick(\'#productForm'.$cat['id'].'\')">';
            $(formName).submit();
        }
    </script>
<?php //head_p1 ?>
<![CDATA[spot two end section head]]>
<?php //html_p2 ?>
</head>
<body>
<?php //html_p2 ?>
<![CDATA[spot three begin section body]]>
<?php //html_p3 ?>
<?php if (0==1) { ?>
	<!--poczatek-animcja-tła
	<ul class="cb-slideshow">
		<li><span class="image-bg">Image 01</span><div class="title-bg"><h3>1</h3></div></li>
		<li><span class="image-bg">Image 02</span><div class="title-bg"><h3>2</h3></div></li>
		<li><span class="image-bg">Image 03</span><div class="title-bg"><h3>3</h3></div></li>
		<li><span class="image-bg">Image 04</span><div class="title-bg"><h3>4</h3></div></li>
		<li><span class="image-bg">Image 05</span><div class="title-bg"><h3>5</h3></div></li>
		<li><span class="image-bg">Image 06</span><div class="title-bg"><h3>6</h3></div></li>
	</ul>
	<!--koniec-animacja-tła-->
<?php } ?>
	<section id="place-holder">
		<div id="wrapper1">
			<nav id="top-menu-place-holder">
				<div id="top-menu">
					<div id="top-menu-0">
							<a id="top-menu-1" class="top-menu" href="../home/index.php">Home</a>
							<?php
                            //top menu
                            //------------------------------------------------
							$main = new ShowProductCls();
							$main->_setTable('product_category_main');//tabelke juz bedzie mial trzeba ustalic z gory w install jak bedzie sie nazywala tabelka z produktami
							if ($main->showCategoryMain()) { 
								$i=2;
								foreach ($main->showCategoryMain() as $cat) { ?>
                                    <?php $file_name = str_replace(" ", "-", $cat['product_category_main']);//zamieniam spacje ?><!--dodac kolumne nazwa kat do cd-->
									<a id="top-menu-<?php echo $i; ?>" class="top-menu" href="../category/<?php echo $file_name.'.php'; ?>"><?php echo $cat['product_category_main'] ?></a>
								<?php
								$i++;
								}
							}
							unset($main);
							?>
                            <a id="top-menu-11" class="top-menu" href="../zap/index.php">Zaplecze</a>
							<div id="bottom-line"></div>
					</div>						
				</div>	
			</nav>	
			<div id="wrapper2">
			</div>
			<div id="wrapper1-1"></div>
		</div>
		<div id="wrapper3">
			<nav id="left-menu-place-holder">
				<div id="left-menu">
					<div id="left-menu-title"><h2><?php echo @$_SESSION['category']; ?></h2></div>
					<div id="left-menu-0">
						<form method="POST">                     
							<?php
                            //$category_now_display='PC';
                            //$product_now_display='6';
                            //left menu
                            //------------------------------------------------
							$sub = new ShowProductCls();
							$sub->_setTable('product_tab');
                            //-index
                            //------------------------------------------------
                            if (! isset($category_now_display) && ! isset($product_now_display)) {//sub dla home
                                $is = $sub->showSubAll()->fetch(PDO::FETCH_ASSOC);//sprawdzam czy cos ma sub kategorie jesli tak to pokazuje button wszystkie
                                $i=1;                                
                                if ($is) {
                                    ?><input id="left-menu-all" class="left-menu<?php if(!isset($_SESSION['sub'])){echo ' active';}?>" type="submit" name="leftmenu" value="Wszystkie" /><?php //dla kategorii
                                }
                                foreach ($sub->showSubAll() as $cat) {								
                                    ?><input id="left-menu-<?php echo $i; $i++?>" class="left-menu<?php if(@$cat['product_category_sub']==@$_SESSION['sub']){echo ' active';}?>" type="submit" name="leftmenu" value="<?php echo $cat['product_category_sub']; ?>" /><?php							
                                }
                            }
                            //------------------------------------------------
                            //-category
                            //------------------------------------------------
                            elseif (isset($category_now_display)) {
                                if ($sub->showCategorySub($category_now_display)) {
                                    $is = $sub->showCategorySub($category_now_display)->fetch(PDO::FETCH_ASSOC);//sprawdzam czy cos ma sub kategorie jesli tak to pokazuje button wszystkie
                                    $i=1;                                
                                    if ($is) {
                                        ?><input id="left-menu-all" class="left-menu<?php if(!isset($_SESSION['sub'])){echo ' active';}?>" type="submit" name="leftmenu" value="Wszystkie" /><?php //dla home
                                    }
                                    foreach ($sub->showCategorySub($category_now_display) as $cat) {								
                                        ?><input id="left-menu-<?php echo $i; $i++?>" class="left-menu<?php if(@$cat['product_category_sub']==@$_SESSION['sub']){echo ' active';}?>" type="submit" name="leftmenu" value="<?php echo $cat['product_category_sub']; ?>" /><?php							
                                    }
                                }
                                unset($sub);
                            }
                            //------------------------------------------------
                            //-product card
                            //------------------------------------------------
                            elseif (isset($product_now_display) && !isset($_SESSION['menu_id'])) {//dla karty towaru z home
                                ?><a class="leftmenu_a_button" href="../home/index.php">Powrót</a><?php 
                            } elseif (isset($product_now_display) && isset($_SESSION['menu_id'])) {// dla karty towaru z kategorii   
                                ?><a class="leftmenu_a_button" href="../category/<?php echo $sub->_getCatMainFileName($product_now_display); ?>.php">Powrót</a><?php 
                            }
                            //------------------------------------------------
							?>
						</form>
					</div>	
				</div>	
			</nav>
			<div id="wrapper4">               
                <?php               
                $show = new ShowProductCls();
				$show->_setTable('product_tab');
                //-index
                //------------------------------------------------
				if (! isset($category_now_display) && ! isset($product_now_display) && ! isset($_SESSION['sub'])) {//all
					if ($show->showAll()) {
						foreach ($show->showAll() as $cat) {
                            echo $show->showSquare($cat);
						}
					}
				} elseif (! isset($category_now_display) && ! isset($product_now_display) && isset($_SESSION['sub'])) {//sub
                    if ($show->showAllSub($_SESSION['sub'])) {
						foreach ($show->showAllSub($_SESSION['sub']) as $cat) {
                            echo $show->showSquare($cat);
						}
					}
                }
                //------------------------------------------------
                //-category
                //------------------------------------------------
				elseif (isset($category_now_display) && !isset($_SESSION['sub'])) {//all
					if ($show->showAllCategory($category_now_display)) {
						foreach ($show->showAllCategory($category_now_display) as $cat) {
                            echo $show->showSquare($cat);
						}					
					}
				} elseif (isset($category_now_display) && isset($_SESSION['sub'])) {
                    if ($show->showAllCategorySub($category_now_display, $_SESSION['sub'])) {
						foreach ($show->showAllCategorySub($category_now_display, $_SESSION['sub']) as $cat) {
                            echo $show->showSquare($cat);
						}					
					}
                }
                //------------------------------------------------
                //-product card
                //------------------------------------------------              
                elseif (isset($product_now_display)) {
                    if ($show->showProduct($product_now_display)) {
                        foreach ($show->showProduct($product_now_display) as $cat) {
                            echo $show->showFullSquare($cat);
                        }
                    }
                }
                //------------------------------------------------
                //$sub = new ShowProductCls();
                //$sub->_setTable('product_tab');
                //$is = $sub->showCategorySub(@$_SESSION['category'])->fetch(PDO::FETCH_ASSOC);
                //$id = $id->fetch(PDO::FETCH_ASSOC);
                //var_dump($id);
                //echo @$category_now_display;
                //echo @$product_now_display;
				?>
            <!--
			<br />
			<br />
			-->
			</div>				
		</div>		
		<div>
			<h1 id="titi" >WELCOME TO MY GREAT WORLD OF PROGRAMMING</h1>	
		</div>
    <script type="text/javascript">
        //set session
        $('a.top-menu').click(function() {
            $('a.top-menu').removeClass('active');
            $(this).addClass('active');
            var valu = $(this).attr('id');
            //$.post('../set_session.php', { 'value' : valu});                
            $.ajax({
                async: false,
                type: 'POST',
                url: '../set_session.php',
                data: {value : valu}                  
            });
        });
        $('a.top-menu').click( function () {
            var del = 'sub';
            $.ajax({ 
              async: false,
              type: 'POST', 
              url: '../unset_session.php',
              data: {value : del}
            });
            //alert('asdasd');
        });
        $('a#top-menu-1').click( function () {
            var del = 'all';
            $.ajax({ 
              async: false,
              type: 'POST', 
              url: '../unset_session.php',
              data: {value : del}
            });
            //alert('asdasd');
        });        
	</script>
	</section>
	<footer>
	<!--<div id="count"></div><div id="count2"></div>-->
	</footer>
	<div id="debugged">
	<?php
	echo "post";
	var_dump (@$_POST);
	//echo "get";
	//var_dump (@$_GET);
	//echo "files";
	//var_dump (@$_FILES);
	echo "session";
	var_dump (@$_SESSION);
	echo "cookie";
	var_dump (@$_COOKIE);
	?>
	</div>
<?php //html_p3 ?>
<![CDATA[spot four end section body]]>
<?php //html_p4 ?>
</body>
</html>
<?php //html_p4 ?>