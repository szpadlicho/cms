<?php//php_beafor_html?>
<?php
session_start();
echo '<div class="catch">';
class ShowProductCls{
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
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT `product_category_main` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showCategorySub($sub)
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT DISTINCT `product_category_sub` FROM `".$this->table."` WHERE `product_category_main` = '".$sub."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showSubAll()
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT DISTINCT `product_category_sub` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showAll()
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showAllCategory($main)
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = '".$main."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showAllSub($sub)
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_sub` = '".$sub."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showAllCategorySub($main, $sub)
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = '".$main."' AND `product_category_sub` = '".$sub."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showProduct($id)
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `id` = '".$id."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function _getCatMain($id)
    {
		/**/
		$con=$this->connectDB();
		$q = $con->query("SELECT `product_category_main` FROM `".$this->table."` WHERE `id` = '".$id."'");/*zwraca false jesli tablica nie istnieje*/
        $q = $q->fetch(PDO::FETCH_ASSOC);
		unset ($con);
		return $q;
	}
    // public function showSome()
    // {
		// /**/
		// $con=$this->connectDB();
		// $q = $con->query("SELECT * FROM `product_tab`, `product_category_main` WHERE `product_tab`.`product_category_main` = `product_category_main`.`id`;");/**/
        // //$q = $q->fetch(PDO::FETCH_ASSOC);
		// unset ($con);
		// return $q;
        
	// }
    public function showMiniImg($id)
    {
        //losowy obrazek z katalogu                                           
        $dir_mini = '../data/'.$id.'/mini/';                                        
        if(@opendir($dir_mini))//sprawdzam czy sciezka istnieje
        {
            $q = (count(glob($dir_mini."/*")) === 0) ? 'Empty' : 'Not empty';
            if ($q=="Empty")
            {
                echo "Brak"; 
            }
            else
            {
                $folder = opendir($dir_mini);
                $i = 0;
                while(false !=($plik = readdir($folder))){
                    if($plik != "." && $plik != ".."){
                        $obrazki[$i]= $plik;//tablica z obrazkami
                        $i++;
                    }
                }
                closedir($folder);
                $losowy=rand(0,count(@$obrazki)-1);//losuje obrazek
                return $dir_mini.@$obrazki[$losowy];//link do obrazka 'src'
                unset($obrazki);
            }                                               
        }
        else
        {
            echo 'Brak';
        }
    }
    public function showSquare($cat)
    {
        echo '<a class="square-link" href="../product/'.$cat['file_name'].'.php">';
            echo '<div class="product-square">';
                echo '<div class="pr-sq img">';
                   echo '<img class="mini-image-pr-list" src="'.$this->showMiniImg($cat['id']).'" alt="mini image" />';
                echo '</div>';
                echo '<div class="pr-sq price">';
                    echo 'Cena: '.$cat['product_price'];
                echo '</div>';
                echo '<div class="pr-sq cat-main">';
                    echo $cat['product_category_main'];
                echo '</div>';
                echo '<div class="pr-sq cat-sub">';
                    echo $cat['product_category_sub'];
                echo '</div>';
                echo '<div class="pr-sq name">';
                    echo $cat['product_name'];
                echo '</div>';
            echo '</div>';
        echo '</a>';
    }
    public function showFullSquare($cat)
    {
        ?>
        <div class="product-full-square">
            <div class="full-mini-img">
                <img class="mini-image-pr-list" src="<?php echo $this->showMiniImg($cat['id']); ?>" alt="mini image" />
            </div>
            <div class="full-name"><?php echo $cat['product_name']; ?></div>
            <div class="full-description-button book">Opis</div>
            <div class="full-gallery-button book">Galeria</div>
            <div class="full-other-button book">Inne</div>
            <div class="ful-description-container book"><?php echo $cat['product_description_large']; ?></div>
            <div class="full-gallery-container book"><?php echo $cat['product_name']; ?></div>
            <div class="full-other-container book"><?php echo $cat['product_name']; ?></div>
        </div>        
        <?php
    }
}
if(isset($_POST['topmenu']))
{
	$_SESSION['category'] = $_POST['topmenu'];
	unset($_SESSION['sub']);
}
if(isset($_POST['leftmenu']))
{
	$_SESSION['sub'] = $_POST['leftmenu'];
}
if(@$_POST['topmenu']=='Home')
{
    //niema posta juz!!!!
	//unset($_SESSION['sub']);
	//unset($_SESSION['category']);
	//unset($_SESSION['session_menu_id']);
	//session_unset();
}
//(@$_POST['topmenu']=='Sprzęt') ? header("location: zap/index.php") : 'błąd' ;//tymczasowo na zaplecze

if(@$_POST['leftmenu']=='Wszystkie')
{
    unset($_SESSION['sub']);
}
if(@$_POST['leftmenu']=='Powrót')
{
    unset($_SESSION['sub']);
}
//ustawic jak sie kliknie back (back na poscie) to wtedy pojawia sie zmienna kategory i wraca dop categori jaka miał produkt !! :)
echo '</div>';
?>
<?php//php_beafor_html?>
<?php//html_p1?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
<?php//html_p1?>
<!--spot one begin section head-->
<?php//head_title?>
	<title>Index</title>
<?php//head_title?>
<?php//head_description?>
<?php//head_description?>
<?php//head_keywords?>
<?php//head_keywords?>
<?php//head_include?>
	<?php include ("../meta5.html"); ?>
<?php//head_include?>
<?php//head_p1?>
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
        //set session
		$(document).ready(function(){
			// $('a.top-menu').click(function() {
				// $('a.top-menu').removeClass('active');
				// $(this).addClass('active');
                // var valu = $(this).attr('id');
                // $.post('../set_session.php', { 'value' : valu});                
                // $.ajax({
                    // type: 'POST',
                    // url: '../set_session.php',
                    // data: {value : valu}                  
                // });
			// });
		});
	</script>
    <script type="text/javascript">
        //set session
		$(document).ready(function(){
            //left menu
			$('input.left-menu').click(function() {
				$('input.left-menu').removeClass('active');
				$(this).addClass('active');
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
        // $("a.pagination").click(function() {
            // // Grab the link's href
            // var href = this.href;

            // // Slide up the content you want to slide up
            // $("some_selector_here").slideUp(function() {
                // // Slide is finished, navigate
                // location.href = href;


            // // Prevent the default action of the link
            // return false;
        // });
        function submitOnClick(formName){//do klikania diva i odpalania formy
            //echo '<div class="product-square" onclick="submitOnClick(\'#productForm'.$cat['id'].'\')">';
            $(formName).submit();
        }
    </script>
<?php//head_p1?>
<!--spot two end section head-->
<?php//html_p2?>
</head>
<body>
<?php//html_p2?>
<!--spot three begin section body-->
<?php//html_p3?>
<?php if(0==1){ ?>
	<!--poczatek-animcja-tła-->
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
							$main = new ShowProductCls();
							$main->_setTable('product_category_main');//tabelke juz bedzie mial trzeba ustalic z gory w install jak bedzie sie nazywala tabelka z produktami
							if($main->showCategoryMain())
                            { 
								$i=2;
								foreach($main->showCategoryMain() as $cat){ ?>
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
                            //$product_now_display='7';
                            //------------------------------------------------
                            if((isset($_POST['leftmenu']) || isset($_POST['leftmenu_up'])) && isset($product_now_display) && !isset($_SESSION['menu_id']))//pozwala wracac do home z karty towaru
                            {
                                unset($product_now_display);
                            }
                            else if((isset($_POST['leftmenu']) || isset($_POST['leftmenu_up'])) && isset($product_now_display) && isset($_SESSION['menu_id']))//pozwala wracac do categori z karty towaru
                            {                           
                                $getcat = new ShowProductCls();
                                $getcat->_setTable('product_tab');
                                $category_pruduct_card=$getcat->showProduct($product_now_display);
                                $category_pruduct_card = $category_pruduct_card->fetch(PDO::FETCH_ASSOC);
                                $category_now_display=$category_pruduct_card['product_category_main'];
                            }
                            //------------------------------------------------
							$sub = new ShowProductCls();
							$sub->_setTable('product_tab');
                            if(isset($category_now_display))//sub dla kategori głównej
                            {
                                if($sub->showCategorySub($category_now_display))
                                {
                                    $is = $sub->showCategorySub($category_now_display)->fetch(PDO::FETCH_ASSOC);//sprawdzam czy cos ma sub kategorie jesli tak to pokazuje button wszystkie
                                    $i=1;                                
                                    if($is)
                                    {
                                        ?><input id="left-menu-all" class="left-menu" type="submit" name="leftmenu" value="Wszystkie" /><?php //dla home
                                    }
                                    foreach($sub->showCategorySub($category_now_display) as $cat){								
                                        ?><input id="left-menu-<?php echo $i; $i++?>" class="left-menu" type="submit" name="leftmenu" value="<?php echo $cat['product_category_sub']; ?>" /><?php							
                                    }
                                }
                                unset($sub);
                            }                            
                            else if(!isset($category_now_display) && !isset($product_now_display))//sub dla home
                            {
                                $is = $sub->showSubAll()->fetch(PDO::FETCH_ASSOC);//sprawdzam czy cos ma sub kategorie jesli tak to pokazuje button wszystkie
                                    $i=1;                                
                                    if($is)
                                    {
                                        ?><input id="left-menu-all" class="left-menu" type="submit" name="leftmenu" value="Wszystkie" /><?php //dla kategorii
                                    }
                                    foreach($sub->showSubAll() as $cat){								
                                        ?><input id="left-menu-<?php echo $i; $i++?>" class="left-menu" type="submit" name="leftmenu" value="<?php echo $cat['product_category_sub']; ?>" /><?php							
                                    }
                            }
                            else if(isset($product_now_display) && !isset($_SESSION['sub']))//sub dla karty towaru z home
                            {
                                ?><input id="left-menu-back" class="left-menu" type="submit" name="leftmenu" value="Powrót" /><?php // dla karty towaru z home
                            }
                            else if(isset($product_now_display) && isset($_SESSION['sub']))//sub dla karty towaru z kategori
                            {
                                ?><input id="left-menu-back" class="left-menu" type="submit" name="leftmenu_up" value="Powrót2" /><?php // dla karty towaru z home
                            }
							?>
						</form>
					</div>	
				</div>	
			</nav>
			<div id="wrapper4">               
                <?php
                $show = new ShowProductCls();
				$show->_setTable('product_tab');			
				if(!isset($category_now_display) && !isset($product_now_display) && !isset($_SESSION['sub']))
                {
					if($show->showAll())
                    {
						foreach($show->showAll() as $cat){
                            echo $show->showSquare($cat);
						}
					}
				}               
				else if(isset($category_now_display) && !isset($_SESSION['sub']))
                {
					if($show->showAllCategory($category_now_display))
                    {
						foreach($show->showAllCategory($category_now_display) as $cat){
                            echo $show->showSquare($cat);
						}					
					}
				}
                else if(!isset($category_now_display) && !isset($product_now_display) && isset($_SESSION['sub']))
                {
                    if($show->showAllSub($_SESSION['sub']))
                    {
						foreach($show->showAllSub($_SESSION['sub']) as $cat){
                            echo $show->showSquare($cat);
						}
					}
                }
				else if(isset($category_now_display) && !isset($product_now_display) && isset($_SESSION['sub']))
                {
					if($show->showAllCategorySub($category_now_display, $_SESSION['sub']))
                    {
						foreach($show->showAllCategorySub($category_now_display, $_SESSION['sub']) as $cat){
                            echo $show->showSquare($cat);
						}					
					}
				}
                else if(!isset($category_now_display) && isset($product_now_display) && isset($_SESSION['sub']))
                {
                    if($show->showProduct($product_now_display))
                    {
                        foreach($show->showProduct($product_now_display) as $cat){
                            echo $show->showFullSquare($cat);
                        }
                    }
                }
                else if(isset($category_now_display) && isset($product_now_display) && isset($_SESSION['sub']))
                {
                    if($show->showAllCategorySub($category_now_display, $_SESSION['sub']))
                    {
						foreach($show->showAllCategorySub($category_now_display, $_SESSION['sub']) as $cat){
                            echo $show->showSquare($cat);
						}					
					}
                }
                else if(isset($product_now_display))
                {
                    if($show->showProduct($product_now_display))
                    {
                        foreach($show->showProduct($product_now_display) as $cat){
                            echo $show->showFullSquare($cat);
                        }
                    }
                }
                //$sub = new ShowProductCls();
                //$sub->_setTable('product_tab');
                //$is = $sub->showCategorySub(@$_SESSION['category'])->fetch(PDO::FETCH_ASSOC);
                //$id = $id->fetch(PDO::FETCH_ASSOC);
                //var_dump($id);
                echo @$category_now_display;
                echo @$product_now_display;
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
                type: 'POST',
                url: '../set_session.php',
                data: {value : valu}                  
            });
        });
        $('a.top-menu').click( function () {
            var del = 'sub';
            $.ajax({ 
              //async: false,
              type: 'POST', 
              url: '../unset_session.php',
              data: {value : del}
            });
            //alert('asdasd');
        });
        $('a#top-menu-1').click( function () {
            var del = 'all';
            $.ajax({ 
              //async: false,
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
<?php//html_p3?>
<!--spot four end section body-->
<?php//html_p4?>
</body>
</html>
<?php//html_p4?>