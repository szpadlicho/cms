<?php //php_beafor_html ?>
<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include_once '../classes/connect.php';
include_once '../classes/connect/load.php';
class ProductDisplay
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
	public function showCategoryMain()
    {
		$con = $this->connectDB();
		$q = $con->query("SELECT `product_category_main` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showCategorySub($sub)
    {
		$con = $this->connectDB();
		$q = $con->query("SELECT DISTINCT `product_category_sub` FROM `".$this->table."` WHERE `product_category_main` = '".$sub."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showSubAll()
    {
		$con = $this->connectDB();
		$q = $con->query("SELECT DISTINCT `product_category_sub` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showAll()
    {
		$con = $this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showAllCategory($main)
    {
		$con = $this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = '".$main."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showAllSub($sub)
    {
		$con = $this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_sub` = '".$sub."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
	public function showAllCategorySub($main, $sub)
    {
		$con = $this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = '".$main."' AND `product_category_sub` = '".$sub."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showProduct($id)
    {
		$con = $this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `id` = '".$id."'");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function __getCatMain($id)
    {
		$con = $this->connectDB();
		$q = $con->query("SELECT `product_category_main` FROM `".$this->table."` WHERE `id` = '".$id."'");/*zwraca false jesli tablica nie istnieje*/
        $q = $q->fetch(PDO::FETCH_ASSOC);
		unset ($con);
		return $q;
	}
    public function __getCatMainFileName($id)
    {
        $this->__setTable('product_tab');
        $cat = $this->__getCatMain($id);
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
$objload = new Connect_Load();
$objload->__setTable('setting_seo');
$global = $objload->globalMetaData();
class Connect_Form extends Connect
{
    static function registerForm()
    {
    ?>
        <form method="POST">
            <div class="full-square">
                <p>Account</p>
                <div class="line"></div>
                <div class="inline" ><span class="">Login:</span><input id="" class="register-field text" type="text" name="login" value="user" /></div>
                <div class="inline" ><span class="">Adres email:</span><input id="" class="register-field text" type="text" name="email" value="user@gmail.com" /></div>
                <div class="inline" ><span class="">Powtórz adres email:</span><input id="" class="register-field text" type="text" name="email_confirm" value="user@gmail.com" /></div>
                <div class="inline" ><span class="">Hasło:</span><input id="" class="register-field text" type="text" name="password" value="user" /></div>
                <div class="inline" ><span class="">Powtórz hasło:</span><input id="" class="register-field text" type="text" name="password_confirm" value="user" /></div>
                <p>Personal info</p>
                <div class="line"></div>
                <div class="inline" ><span class="">Imię:</span><input id="" class="register-field text" type="text" name="first_name" value="Piotr" /></div>
                <div class="inline" ><span class="">Nazwisko:</span><input id="" class="register-field text" type="text" name="last_name" value="Szpanelewski" /></div>
                <div class="inline" ><span class="">Telefon:</span><input id="" class="register-field text" type="text" name="phone" value="888958277" /></div>
                <div class="inline" ><span class="">Miasto:</span><input id="" class="register-field text" type="text" name="town" value="Częstochowa" /></div>
                <div class="inline" ><span class="">Kod pocztowy:</span><input id="" class="register-field text" type="text" name="post_code" value="42-200" /></div>
                <div class="inline" ><span class="">Ulica i nr domu:</span><input id="" class="register-field text" type="text" name="street" value="Garibaldiego 16 m. 23" /></div>
                <p>Confirm</p>
                <div class="line"></div>
                <div class="inline" ><span class=""></span><input id="" class="register-field button" type="submit" name="addUser" value="Zapisz" /></div>
            </div>
        </form>
    <?php
    }
    public function editForm($id)
    {
        $con = $this->connectDB();
		$q = $con->query("SELECT * FROM `users` WHERE `id` = '".$id."'");
        $q = $q->fetch(PDO::FETCH_ASSOC);
		unset ($con);
    ?>
        <form method="POST">
            <div class="full-square">
                <p>Account</p>
                <div class="line"></div>
                <div class="inline" ><span class="">Login:</span><input id="" class="register-field text" type="text" name="login" value="<?php echo $q['login']; ?>" /></div>
                <div class="inline" ><span class="">Adres email:</span><input id="" class="register-field text" type="text" name="email" value="<?php echo $q['email']; ?>" /></div>
                <div class="inline" ><span class="">Hasło:</span><input id="" class="register-field text" type="text" name="password" value="<?php echo $q['password']; ?>" /></div>
                <div class="inline" ><span class="">Powtórz hasło:</span><input id="" class="register-field text" type="text" name="password_confirm" value="<?php echo $q['password']; ?>" /></div>
                <p>Personal info</p>
                <div class="line"></div>
                <div class="inline" ><span class="">Imię:</span><input id="" class="register-field text" type="text" name="first_name" value="<?php echo $q['first_name']; ?>" /></div>
                <div class="inline" ><span class="">Nazwisko:</span><input id="" class="register-field text" type="text" name="last_name" value="<?php echo $q['last_name']; ?>" /></div>
                <div class="inline" ><span class="">Telefon:</span><input id="" class="register-field text" type="text" name="phone" value="<?php echo $q['phone']; ?>" /></div>
                <div class="inline" ><span class="">Miasto:</span><input id="" class="register-field text" type="text" name="town" value="<?php echo $q['town']; ?>" /></div>
                <div class="inline" ><span class="">Kod pocztowy:</span><input id="" class="register-field text" type="text" name="post_code" value="<?php echo $q['post_code']; ?>" /></div>
                <div class="inline" ><span class="">Ulica i nr domu:</span><input id="" class="register-field text" type="text" name="street" value="<?php echo $q['street']; ?>" /></div>
                <p>Confirm</p>
                <div class="line"></div>
                <div class="inline" ><span class=""></span><input id="" class="register-field button" type="submit" name="updateUser" value="Uaktualnij" /></div>
            </div>
        </form>
    <?php 
    }
}
include_once '../classes/connect/register.php';
$obj_users = new Connect_Register;
if (isset($_POST['addUser'])) {
    $obj_users->__setTable('users');
    $arr_val = array(
        'login'         =>$_POST['login'], 
        'password'      =>$_POST['password'], 
        'email'         =>$_POST['email'],                     
        'create_data'   => date('Y-m-d H:i:s'),
        'update_data'   => date('Y-m-d H:i:s'),
        'first_name'    =>$_POST['first_name'],
        'last_name'     =>$_POST['last_name'],
        'phone'         =>$_POST['phone'],
        'country'       =>'Polska',
        'town'          =>$_POST['town'],
        'post_code'     =>$_POST['post_code'],
        'street'        =>$_POST['street']
        );
    $return = $obj_users->addUser($arr_val);
    if ($return) {
        $_SESSION['user_id'] = $return;
        header('location: ../home/index.php');
    }
}
if (isset($_POST['updateUser'])) {
    $obj_users->__setTable('users');
    $arr_val = array(
        'login'         =>$_POST['login'], 
        'password'      =>$_POST['password'], 
        'email'         =>$_POST['email'],
        'update_data'   => date('Y-m-d H:i:s'),
        'first_name'    =>$_POST['first_name'],
        'last_name'     =>$_POST['last_name'],
        'phone'         =>$_POST['phone'],
        'country'       =>'Polska',
        'town'          =>$_POST['town'],
        'post_code'     =>$_POST['post_code'],
        'street'        =>$_POST['street']
        );
    $return = $obj_users->updateUser($arr_val, 1);    
}
if (isset($_POST['user_check'])) {
    include_once '../users/user_login.php';
    if (is_int($check)) {
        $_SESSION['user_id'] = $check;
    }
} elseif (isset($_POST['user_logout'])) {
        unset($_SESSION['user_id']);
        //header tylko dla lokacji edit i basket
        header('location: ../home/index.php');
        // $arr_location = array ('user_edit.php', 'user_basket.php');
        // if (in_array(basename(__FILE__), $arr_location, true)) {
            // header('location: ../home/index.php');
        // }
}
class Connect_Basket extends Connect
{
    private $sumar = array();
    private $sum_shipping = array();
    //private $arrPrePr = array();
    //private $arrOnPr = array();
    //private $arrPreSu = array();
    //private $arrOnSu = array();
    //**//
    private $noPre = array(); //1
    private $noOn = array(); //2
    private $shPre = array(); //3
    private $shOn = array(); //4
    private $shConPre = array(); //5
    private $shConOn = array(); //6
    private $conFixPre = array();
    private $conFixOn = array();
    public function __getSumar(){
        return $this->sumar;
    }
    public function __setSumShipping($value){
        $this->sum_shipping = $value;
    }
    public function __getSumShipping(){
        return $this->sum_shipping;
    }
    public function __getNoPre(){
        return $this->noPre; //1
    }
    public function __getNoOn(){
        return $this->noOn; //2
    }
    public function __getShPre(){
        return $this->shPre; //3
    }
    public function __getShOn(){
        return $this->shOn; //4
    }
    public function __getShConPre(){
        return $this->shConPre; //5
    }
    public function __getShConOn(){
        return $this->shConOn; //6
    }
    public function __getConFixPre(){
        return $this->conFixPre; //7
    }
    public function __getConFixOn(){
        return $this->conFixOn; //8
    }
    public function basketAdd($table, $pr_id, $amount)
    {
        /**
        * jesli produkt juz jest w koszyku zwiekszyc tylko ilosc
        **/
        $con = $this->connectDB();
        $res = $con->query("CREATE TABLE IF NOT EXISTS `basket_".$table."`(
                            `id` INTEGER AUTO_INCREMENT,            
                            `pr_id` INTEGER(10) UNSIGNED,
                            `amount` INTEGER(10) UNSIGNED,
                            `mod` INTEGER(10),
                            PRIMARY KEY(`id`)
                            )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1"
                            );
        // tu musze pobrac pole o pr_id jesli jest pobrac i zwiekszyc tylko amount (update)
        // jesli nie to zostawic normalnie !it done
        $check = $con->query("SELECT `amount` FROM `basket_".$table."` WHERE `pr_id` = '".$pr_id."'");
        $check = $check->fetch(PDO::FETCH_ASSOC);
        //var_dump($check);
        if ($check) {// if exist sum and add only amount
            $value = $check['amount'] + $amount;
            $res = $con->query("UPDATE `basket_".$table."` 
                                SET
                                `amount` = '".(int)$value."'
                                WHERE
                                `pr_id` = '".$pr_id."'
                                ");
        } else {// if product not exist in basket yet 
            $res = $con->query("INSERT INTO `basket_".$table."`(
                                `pr_id`,
                                `amount`
                                ) VALUES (
                                '".$pr_id."',
                                '".(int)$amount."'
                                )");
        }
        //$q = $con->query("SELECT * FROM `".$table."`");
        //$q = $q->fetch(PDO::FETCH_ASSOC);
		unset ($con);
    }
    public function basketUpdate($table, $id, $amount_new)
    {
        /**
        * regulowanie ilosci produktu w koszyku
        **/
        $con = $this->connectDB();
        $check = $con->query("SELECT `amount` FROM `basket_".$table."` WHERE `id` = '".$id."'");
        $check = $check->fetch(PDO::FETCH_ASSOC);
        if ($check) {
            $res = $con->query("UPDATE `basket_".$table."` 
            SET
			`amount` = '".(int)$amount_new."'
			WHERE
            `id` = '".$id."'
            ");
            return true;
        } else {
            return false;
        }
		//unset ($con);
    }
    public function basketDrop($table)
    {
        $con = $this->connectDB();
        $res = $con->query('DROP TABLE `basket_'.$table.'`');
        return $res ? true : false;
    }
    public function basketItemDrop($table, $id)
    {
        $con = $this->connectDB();
        $res = $con->query("DELETE FROM `basket_".$table."` WHERE `id` = '".$id."'");
        return $res ? true : false;
    }
    public function basketGet($table)
    {
        $con = $this->connectDB();
        $q = $con->query("SELECT * FROM `basket_".$table."`");
        //$q = $q->fetch(PDO::FETCH_ASSOC);
        return $q;
		unset ($con);
    }
    public function basketSelect($table, $id)
    {
        $con = $this->connectDB();
        $q = $con->query("SELECT * FROM `".$table."` WHERE `id`='".$id."'");
        $q = $q->fetch(PDO::FETCH_ASSOC);
        return $q;
		unset ($con);
    }
    public function basketShow($id, $pr_id, $amount)
    {
        $wyn = $this->basketSelect('product_tab', $pr_id);
        $min_img = new ProductDisplay;
        //$this->sumar=array();
        ?>       
            <div class="bs-square">
                <div class="bs-sq img">
                    <img class="mini-image-bs-list" src="<?php echo $min_img->showMiniImg($wyn['id']); ?>" alt="mini image" />
                </div>
                <!--
                <div class="bs-sq cat-main">
                    <?php //echo $wyn['product_category_main']; ?>
                </div>
                <div class="bs-sq cat-sub">
                    <?php //echo $wyn['product_category_sub']; ?>
                </div>
                -->
                <div class="bs-sq name">
                    <a class="bs-square-link" href="../product/<?php echo $wyn['file_name'].'.php'; ?>">
                        <?php echo $wyn['product_name']; ?>
                    </a>
                </div>
                <div class="bs-sq price">
                    Cena: <?php echo $wyn['product_price']; ?>
                </div>
                <div class="bs-sq amount">
                    <form method="POST">
                        Ilość: <input class="basket-field text" type="text" name="basket_item_update_text" value="<?php echo $amount; ?>" />
                        <input class="basket-field button" type="submit" name="basket_item_update_amount" value="Aktualizuj" />
                        <input type="hidden" name="basket_item_update_id" value="<?php echo $id; ?>" />
                    </form>
                </div>
                <div class="bs-sq amount2">
                    Ilość: <?php echo $amount; ?>
                </div>
                <div class="bs-sq cost">
                    Koszt: <?php echo $sum = $wyn['product_price']*$amount; ?> PLN
                </div>
                <div class="bs-sq shipping">
                    Przesyłka: <?php echo $shipping = $this->basketShipping($id, $pr_id, $amount); ?> PLN
                </div>
                <div class="bs-sq line"></div>
                <div class="bs-sq sum">
                    Razem: <?php echo $sum + $shipping; ?> PLN
                </div>
                <div class="bs-sq del">
                    <form method="POST">
                        <input class="basket-field button" type="submit" name="basket_item_drop" value="Usuń" />
                        <input type="hidden" name="basket_item_drop_id" value="<?php echo $id; ?>" />
                    </form>
                </div>
            </div>
        <?php
        $lol = $wyn['product_price']*$amount;
        $this->sumar[] = $lol;
    }
    // public function basketSum()
    // {
        // $con = $this->connectDB();
        // $sumar = $con->query("SELECT sum(numbers) FROM all_nums");
        // $sumar = $sumar->fetch(PDO::FETCH_ASSOC);
        // return $sumar;
    // }
    public function basketAccept($table)
    {
        $con = $this->connectDB();
        $check = $con->query("SELECT * FROM `basket_".$table."`");
        //$check = $check->fetch(PDO::FETCH_ASSOC);
        //var_dump($check);
        if ($check) {
            while ($row = $check->fetch(PDO::FETCH_ASSOC)) {
                //$obj_basket_show->basketShow($row['id'], $row['pr_id'], $row['amount']);
                //var_dump($row);
                $con = $this->connectDB();
                $old = $con->query("SELECT `amount` FROM `product_tab` WHERE `id` = '".$row['pr_id']."'");
                $old = $old->fetch(PDO::FETCH_ASSOC);
                $value = $old['amount'] - $row['amount'];
                //echo $value;
                $res = $con->query("UPDATE `product_tab` 
                    SET
                    `amount` = '".(int)$value."'
                    WHERE
                    `id` = '".$row['pr_id']."'
                    ");
            }
        }
    }
    public function basketShipping($id, $pr_id, $amount) //id numer w koszyku pr_id id zakupionego przedmiotu amoun ilosc
    {
        $product_tab = 'product_tab';
        if (isset($_SESSION['paid_mod'])) { // pre or on
            $_SESSION['paid_mod'] == 1 ? $paid_mod = 1 : $paid_mod = 0;
        } else {
            $paid_mod = 0; // domyslne pre
        }
        $amount2 = $amount;
        $con = $this->connectDB();
        $q = $con->query("SELECT * FROM `".$product_tab."` WHERE `id` = '".$pr_id."'");/*zwraca false jeśli tablica nie istnieje*/
        $q = $q->fetch(PDO::FETCH_ASSOC);
        unset ($con);
        $mod = $q['shipping_mod']; // Pr or Su
        
        if ($mod == 0) { // supplier setup
            $con = $this->connectDB();
            $k = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `weight_of` <= ".$q['weight']." AND `weight_to` >= ".$q['weight']."");
            $k = $k->fetch(PDO::FETCH_ASSOC);
            unset ($con);
            if ($k) { // if weight
                if ($k['package_share'] == 0) {
                    $this->noPre[] = (float)$k['price_prepaid'] * $amount;//cena w sumie no share
                    $this->noOn[] = (float)$k['price_ondelivery'] * $amount;//cena w sumie no share
                }
                if ($k['package_share'] == 1) {
                    if ($k['connect_package'] == 0) {
                        $max = (int)$k['max_item_in_package'];
                        $a = 0;
                        while( $amount > 0) {
                            $amount = $amount - $max;
                            $a++;
                        }
                        (int)$am = $a;
                        $this->shPre[] = (float)$k['price_prepaid'] * $am;//cena w sumie with share
                        $this->shOn[] = (float)$k['price_ondelivery'] * $am;//cena w sumie with share
                    }
                    if ($k['connect_package'] == 1) {
                        if (! array_key_exists($k['price_prepaid'], $this->shConPre)) {
                            $this->shConPre[$k['price_prepaid']] = (int)$amount; // cena => ilosc
                        } else {
                            $this->shConPre[$k['price_prepaid']] += (int)$amount; // cena => ilosc
                        }
                        
                        if (! array_key_exists($k['price_ondelivery'], $this->shConOn)) {
                            $this->shConOn[$k['price_ondelivery']] = (int)$amount; // cena => ilosc
                        } else {
                            $this->shConOn[$k['price_ondelivery']] += (int)$amount; // cena => ilosc
                        }
                    }
                }
            } else {
                $con = $this->connectDB();
                $d = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `price_of` <= ".$q['product_price']." AND `price_to` >= ".$q['product_price']."");
                $d = $d->fetch(PDO::FETCH_ASSOC);
                unset ($con);
                if ($d) {
                    if ($k['package_share'] == 0) {
                        $this->noPre[] = (float)$d['price_prepaid'] * $amount;//cena w sumie no share
                        $this->noOn[] = (float)$d['price_ondelivery'] * $amount;//cena w sumie no share
                    }
                    if ($d['package_share'] == 1) {
                        if ($k['connect_package'] == 0) {
                            $max = (int)$d['max_item_in_package'];
                            $a = 0;
                            while( $amount > 0) {
                                $amount = $amount - $max;
                                $a++;
                            }
                            (int)$am = $a;
                            $this->shPre[] = (float)$d['price_prepaid'] * $am;//cena w sumie with share
                            $this->shOn[] = (float)$d['price_ondelivery'] * $am;//cena w sumie with share
                        }
                        if ($d['connect_package'] == 1) {
                            if (! array_key_exists($d['price_prepaid'], $this->shConPre)) {
                                $this->shConPre[$d['price_prepaid']] = (int)$amount; // cena => ilosc
                            } else {
                                $this->shConPre[$d['price_prepaid']] += (int)$amount; // cena => ilosc
                            }
                            
                            if (! array_key_exists($d['price_ondelivery'], $this->shConOn)) {
                                $this->shConOn[$d['price_ondelivery']] = (int)$amount; // cena => ilosc
                            } else {
                                $this->shConOn[$d['price_ondelivery']] += (int)$amount; // cena => ilosc
                            }
                        }
                    }
                } else {
                    $con = $this->connectDB();
                    $f = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `configuration_mod` = 'simple'");
                    $f = $f->fetch(PDO::FETCH_ASSOC);
                    //var_dump($f);
                    unset ($con);
                    if ($f) {
                        if ($k['package_share'] == 0) {
                            $this->noPre[] = (float)$f['price_prepaid'] * $amount;//cena w sumie no share
                            $this->noOn[] = (float)$f['price_ondelivery'] * $amount;//cena w sumie no share
                        }
                        if ($f['package_share'] == 1) {
                            if ($k['connect_package'] == 0) {
                                $max = (int)$f['max_item_in_package'];
                                $a = 0;
                                while( $amount > 0) {
                                    $amount = $amount - $max;
                                    $a++;
                                }
                                (int)$am = $a;
                                $this->shPre[] = (float)$f['price_prepaid'] * $am;//cena w sumie with share
                                $this->shOn[] = (float)$f['price_ondelivery'] * $am;//cena w sumie with share
                            }
                            if ($f['connect_package'] == 1) {
                                if (! array_key_exists($f['price_prepaid'], $this->shConPre)) {
                                    $this->shConPre[$f['price_prepaid']] = (int)$amount; // cena => ilosc
                                } else {
                                    $this->shConPre[$f['price_prepaid']] += (int)$amount; // cena => ilosc
                                }
                                
                                if (! array_key_exists($f['price_ondelivery'], $this->shConOn)) {
                                    $this->shConOn[$f['price_ondelivery']] = (int)$amount; // cena => ilosc
                                } else {
                                    $this->shConOn[$f['price_ondelivery']] += (int)$amount; // cena => ilosc
                                }
                            }
                        }
                    } else {
                        // ???
                    }
                }
            }
        } elseif ($mod == 1) { // own setup
            if ($q['package_share'] == 0) {
                // prepaid
                if ($q['allow_prepaid'] == 1) {
                    $this->noPre[] = (float)$q['price_prepaid'] * $amount;//cena w sumie no share;
                }
                // on delivery
                if ($q['allow_ondelivery'] == 1) {
                    $this->noOn[] = (float)$q['price_ondelivery'] * $amount;//cena w sumie no share;
                }
            }
            // calculate amount for package share
            if ($q['package_share'] == 1) {
                if ($q['connect_package'] == 0) {
                    $max = (int)$q['max_item_in_package'];
                    $a = 0;
                    while( $amount > 0) {
                        $amount = $amount - $max;
                        $a++;
                    }
                    (int)$am = $a;
                    $this->shPre[] = (float)$q['price_prepaid'] * $am;//cena w sumie with share
                    $this->shOn[] = (float)$q['price_ondelivery'] * $am;//cena w sumie with share
                }
                // calculate amount for connect package
                if ($q['connect_package'] == 1) {
                    if (! array_key_exists($q['price_prepaid'], $this->shConPre)) {
                        $this->shConPre[$q['price_prepaid']] = (int)$amount2; // cena => ilosc
                    } else {
                        $this->shConPre[$q['price_prepaid']] += (int)$amount2; // cena => ilosc
                    }
                    
                    if (! array_key_exists($q['price_ondelivery'], $this->shConOn)) {
                        $this->shConOn[$q['price_ondelivery']] = (int)$amount2; // cena => ilosc
                    } else {
                        $this->shConOn[$q['price_ondelivery']] += (int)$amount2; // cena => ilosc
                    }
                }
            }
        }
        /*amount*/
        // if (! $q['connect_package'] == 1) {
            // if ($paid_mod == 0) { // prepaid
                // $add = $pre*$amount;
                // $this->sum_shipping[] = $add;
                // return $add;
            // } elseif ($paid_mod == 1) { // on delivery
                // $add = $on*$amount;
                // $this->sum_shipping[] = $add;
                // return $add;
            // }
        // } else {
            // // co ?
        // }
    }
    public function shConFixPre($arr, $max)
    {
        foreach ($arr as $price => $amount) {
            //$max = (int)$q['max_item_in_package'];
            $a = 0;
            while( $amount > 0) {
                $amount = $amount - $max;
                $a++;
            }
            (int)$am = $a;
            $this->conFixPre[] = (float)$price * $am;//cena w sumie with share
        }
    }
    public function shConFixOn($arr, $max)
    {
        foreach ($arr as $price => $amount) {
            //$max = (int)$q['max_item_in_package'];
            $a = 0;
            while( $amount > 0) {
                $amount = $amount - $max;
                $a++;
            }
            (int)$am = $a;
            $this->conFixOn[] = (float)$price * $am;//cena w sumie with share
        }
    }
    
    // public function basketShipping22($id, $pr_id, $amount) //id numer w koszyku pr_id id zakupionego przedmiotu amoun ilosc
    // {
        // //$user = $_SESSION['user_id'];// użytkownik jednocześnie nazwa tabeli
        // //$user_basket = 'basket_'.$_SESSION['user_id']; // koszyk (nazwa w bazie)
        // $product_tab = 'product_tab';
        // if (isset($_SESSION['paid_mod'])) {
            // $_SESSION['paid_mod'] == 1 ? $paid_mod = 1 : $paid_mod = 0;
        // } else {
            // $paid_mod = 0; // domyslne
        // }
        // $con = $this->connectDB();
		// $q = $con->query("SELECT * FROM `".$product_tab."` WHERE `id` = '".$pr_id."'");/*zwraca false jeśli tablica nie istnieje*/
        // $q = $q->fetch(PDO::FETCH_ASSOC);
		// unset ($con);
		// $mod = $q['shipping_mod'];
        // if ($mod == 0) { // supplier setup
            // $con = $this->connectDB();
            // $k = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `weight_of` <= ".$q['weight']." AND `weight_to` >= ".$q['weight']."");
            // $k = $k->fetch(PDO::FETCH_ASSOC);
            // unset ($con);
            // if ($k) {
                // $pre = (float)$k['price_prepaid'];
                // $on = (float)$k['price_ondelivery'];
                // if ($k['package_share'] == 1) {
                    // $max = (int)$k['max_item_in_package'];
                    // $a = 0;
                    // while( $amount > 0) {
                        // $amount = $amount - $max;
                        // $a++;
                    // }
                    // (int)$amount = $a;
                    // if ($k['connect_package'] == 1) {
                        // //$this->arrPreSu[$k['price_prepaid']][$pr_id] = $a;
                        // //$this->arrOnSu[$k['price_ondelivery']][$pr_id] = $a;
                        // if (! array_key_exists($k['price_prepaid'], $this->arrPreSu)) {
                            // $this->arrPreSu[$k['price_prepaid']] = (int)$amount;
                        // } else {
                            // $this->arrPreSu[$k['price_prepaid']] += (int)$amount;
                        // }
                        
                        // if (! array_key_exists($k['price_ondelivery'], $this->arrOnSu)) {
                            // $this->arrOnSu[$k['price_ondelivery']] = (int)$amount;
                        // } else {
                            // $this->arrOnSu[$k['price_ondelivery']] += (int)$amount;
                        // }
                    // }
                // }
            // } else {
                // $con = $this->connectDB();
                // $d = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `price_of` <= ".$q['product_price']." AND `price_to` >= ".$q['product_price']."");
                // $d = $d->fetch(PDO::FETCH_ASSOC);
                // unset ($con);
                // if ($d) {
                    // $pre = (float)$d['price_prepaid'];
                    // $on = (float)$d['price_ondelivery'];
                    // if ($d['package_share'] == 1) {
                        // $max = (int)$d['max_item_in_package'];
                        // $a = 0;
                        // while( $amount > 0) {
                            // $amount = $amount - $max;
                            // $a++;
                        // }
                        // (int)$amount = $a;
                        // if ($d['connect_package'] == 1) {
                            // //$this->arrPreSu[$d['price_prepaid']][$pr_id] = $a;
                            // //$this->arrOnSu[$d['price_ondelivery']][$pr_id] = $a;
                            // if (! array_key_exists($d['price_prepaid'], $this->arrPreSu)) {
                                // $this->arrPreSu[$d['price_prepaid']] = (int)$amount;
                            // } else {
                                // $this->arrPreSu[$d['price_prepaid']] += (int)$amount;
                            // }
                            
                            // if (! array_key_exists($d['price_ondelivery'], $this->arrOnSu)) {
                                // $this->arrOnSu[$d['price_ondelivery']] = (int)$amount;
                            // } else {
                                // $this->arrOnSu[$d['price_ondelivery']] += (int)$amount;
                            // }
                        // }
                    // }
                // } else {
                    // $con = $this->connectDB();
                    // $f = $con->query("SELECT * FROM `shipping_".$q['predefined']."` WHERE `configuration_mod` = 'simple'");
                    // $f = $f->fetch(PDO::FETCH_ASSOC);
                    // //var_dump($f);
                    // unset ($con);
                    // if ($f) {
                        // $pre = (float)$f['price_prepaid'];
                        // $on = (float)$f['price_ondelivery'];
                        // if ($f['package_share'] == 1) {
                            // $max = (int)$f['max_item_in_package'];
                            // $a = 0;
                            // while( $amount > 0) {
                                // $amount = $amount - $max;
                                // $a++;
                            // }
                            // (int)$amount = $a;
                            // if ($f['connect_package'] == 1) {
                                // //$this->arrPreSu[$f['price_prepaid']][$pr_id] = $a;
                                // //$this->arrOnSu[$f['price_ondelivery']][$pr_id] = $a;
                                // if (! array_key_exists($f['price_prepaid'], $this->arrPreSu)) {
                                    // $this->arrPreSu[$f['price_prepaid']] = (int)$amount;
                                // } else {
                                    // $this->arrPreSu[$f['price_prepaid']] += (int)$amount;
                                // }
                                
                                // if (! array_key_exists($f['price_ondelivery'], $this->arrOnSu)) {
                                    // $this->arrOnSu[$f['price_ondelivery']] = (int)$amount;
                                // } else {
                                    // $this->arrOnSu[$f['price_ondelivery']] += (int)$amount;
                                // }
                            // }
                        // }
                    // } else {
                        // $pre = 0;
                        // $on = 0;
                    // }
                // }
            // }
        // } elseif ($mod == 1) { // own setup
            // // prepaid
            // if ($q['allow_prepaid'] == 1 && !empty($q['price_prepaid'])) {
                // $pre = (float)$q['price_prepaid'];
            // } else {
                // $pre = 0;
            // }
            // // on delivery
            // if ($q['allow_ondelivery'] == 1 && !empty($q['price_ondelivery'])) {
                // $on = (float)$q['price_ondelivery'];
            // } else {
                // $on = 0;
            // }
            // // calculate amount for package share
            // // if ($q['package_share'] == 1) {
                // // $max = (int)$q['max_item_in_package'];
                // // $a = 0;
                // // while( $amount > 0) {
                    // // $amount = $amount - $max;
                    // // $a++;
                // // }
                // // (int)$amount = $a;
                // // // calculate amount for connect package
                // // //$arr = array();
                // // if ($q['connect_package'] == 1) {
                    // // if (! array_key_exists($q['price_prepaid'], $this->arrPrePr)) {
                        // // $this->arrPrePr[$q['price_prepaid']] = $a;
                    // // } else {
                        // // $this->arrPrePr[$q['price_prepaid']] += $a;
                    // // }
                    
                    // // if (! array_key_exists($q['price_ondelivery'], $this->arrOnPr)) {
                        // // $this->arrOnPr[$q['price_ondelivery']] = $a;
                    // // } else {
                        // // $this->arrOnPr[$q['price_ondelivery']] += $a;
                    // // }
                    // // /*tu cos powinno byc - to z elsifa matki $pre i $on powinny wynosic co inneg albo 0*/
                    // // /*jesli to sie wykonyje to rodzic elseif nie powinien sie dodac*/
                // // }
            // // }
            // if ($q['package_share'] == 1) {
                // if ($q['connect_package'] == 1) {
                    // if (! array_key_exists($q['price_prepaid'], $this->arrPrePr)) {
                        // $this->arrPrePr[$q['price_prepaid']] = (int)$amount;
                    // } else {
                        // $this->arrPrePr[$q['price_prepaid']] += (int)$amount;
                    // }
                    // if (! array_key_exists($q['price_ondelivery'], $this->arrOnPr)) {
                        // $this->arrOnPr[$q['price_ondelivery']] = (int)$amount;
                    // } else {
                        // $this->arrOnPr[$q['price_ondelivery']] += (int)$amount;
                    // }
                    // /**/
                // } else {
                    // $max = (int)$q['max_item_in_package'];
                    // $a = 0;
                    // while( $amount > 0) {
                        // $amount = $amount - $max;
                        // $a++;
                    // }
                    // (int)$amount = $a;
                // }
            // }
        // }
        // /*amount*/
        // if (! $q['connect_package'] == 1) {
            // if ($paid_mod == 0) { // prepaid
                // $add = $pre*$amount;
                // $this->sum_shipping[] = $add;
                // return $add;
            // } elseif ($paid_mod == 1) { // on delivery
                // $add = $on*$amount;
                // $this->sum_shipping[] = $add;
                // return $add;
            // }
        // } else {
            // // co ?
        // }
    // }
}

if (isset($_POST['add_to_basket']) && isset($_SESSION['user_id'])) {
    $obj_basket_add = new Connect_Basket;
    $obj_basket_add->basketAdd($_SESSION['user_id'], $_POST['pr_id'], $_POST['amount']);
}
if (isset($_POST['basket_item_update_amount']) && isset($_SESSION['user_id'])) {
    $obj_basket_add = new Connect_Basket;
    $obj_basket_add->basketUpdate($_SESSION['user_id'], $_POST['basket_item_update_id'], $_POST['basket_item_update_text']);
}
if (isset($_POST['basket_drop'])) {
    $obj_basket_add = new Connect_Basket;
    $drop = $obj_basket_add->basketDrop($_SESSION['user_id']);
    header('location: ../home/index.php');
}
if (isset($_POST['basket_item_drop'])) {
    $obj_basket_add = new Connect_Basket;
    $drop = $obj_basket_add->basketItemDrop($_SESSION['user_id'], $_POST['basket_item_drop_id']);
}
if (isset($_POST['basket_accept'])) {
    $obj_basket_add = new Connect_Basket;
    $drop = $obj_basket_add->basketAccept($_SESSION['user_id']);
}
isset($_POST['set_prepaid']) ? $_SESSION['paid_mod'] = 0 : '' ;
isset($_POST['set_ondelivery']) ? $_SESSION['paid_mod'] = 1 : '' ;
include_once('../classes/connect/general.php');
$obj_gen = new Connect_General;
$obj_gen->__setTable('setting_gen');
$get_setting = $obj_gen->__getRow(1);
?>
<?php //php_beafor_html ?>
<?php //html_p1 ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
<?php //html_p1 ?>
<![CDATA[spot one begin section head]]>
<?php //head_title ?>
	<?php echo '<title>'.$global['global_title_index'].'</title>'; ?>
<?php //head_title ?>
<?php //head_description ?>
    <?php echo '<meta name="description" content="'.$global['global_description_index'].'" />'; ?>
<?php //head_description ?>
<?php //head_keywords ?>
    <?php echo '<meta name="keywords" content="'.$global['global_keywords_index'].'" />'; ?>
<?php //head_keywords ?>
<?php //head_include ?>
	<?php include ("../meta5.html"); ?>
<?php //head_include ?>
<?php //head_p1 ?>
	<script type="text/javascript" src="../js/menu.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
    });
    </script>
<?php //head_p1 ?>
<![CDATA[spot two end section head]]>
<?php //html_p2 ?>
</head>
<?php if ($get_setting['background_mod']=='one') { ?>
<body style="background: #000 url(../images/bg.jpg) center 0px no-repeat; background-attachment:fixed; background-size: cover;">
<?php } else { ?>
<body>
<?php } ?>
<?php //html_p2 ?>
<![CDATA[spot three begin section body]]>
<?php //html_p3 ?>
<?php if ($get_setting['background_mod']=='two') { ?>
	<!--poczatek-animcja-tła-->
    <!--
	<ul class="cb-slideshow">
		<li><span class="image-bg">Image 01</span><div class="title-bg"><h3>WELCOME</h3></div></li>
		<li><span class="image-bg">Image 02</span><div class="title-bg"><h3>TO MY</h3></div></li>
		<li><span class="image-bg">Image 03</span><div class="title-bg"><h3>GREAT</h3></div></li>
		<li><span class="image-bg">Image 04</span><div class="title-bg"><h3>WORLD</h3></div></li>
		<li><span class="image-bg">Image 05</span><div class="title-bg"><h3>OF</h3></div></li>
		<li><span class="image-bg">Image 06</span><div class="title-bg"><h3>PROGRAMMING</h3></div></li>
	</ul>
    -->
    <div class="bg-slider-overflow">
        <ul class="bg-slider">
            <li><img alt="" title="" src="../images/background/01.jpg" /><div class="title-bg"><h3>WELCOME</h3></div></li>
            <li><img alt="" title="" src="../images/background/02.jpg" /><div class="title-bg"><h3>TO MY</h3></div></li>
            <li><img alt="" title="" src="../images/background/03.jpg" /><div class="title-bg"><h3>GREAT</h3></div></li>
            <li><img alt="" title="" src="../images/background/04.jpg" /><div class="title-bg"><h3>WORLD</h3></div></li>
            <li><img alt="" title="" src="../images/background/05.jpg" /><div class="title-bg"><h3>OF</h3></div></li>
            <li><img alt="" title="" src="../images/background/06.jpg" /><div class="title-bg"><h3>PROGRAMMING</h3></div></li>
        </ul>
    </div>
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
							$main = new ProductDisplay();
							$main->__setTable('product_category_main');//tabelke juz bedzie mial trzeba ustalic z gory w install jak bedzie sie nazywala tabelka z produktami
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
                            <a id="top-menu-backroom" class="top-menu" href="../backroom/product_list.php">Zaplecze</a>
							<div id="bottom-line"></div>
                            <a href="http://localhost/htdocs/cms/backroom/db_update_index.php">update index</a>
					</div>						
				</div>	
			</nav>	
			<div id="wrapper2">
                    <!-- login edit register basket-->
                    <form method="POST" >
                    <?php if (isset($_SESSION['user_id']) && is_int($_SESSION['user_id'])) { ?>
                        <a class="login-field button" name="user_edit" href="../users/user_edit.php" >Edit</a>
                        <a class="login-field button" name="user_basket" href="../users/user_basket.php" >Basket</a>
                        <input class="login-field button" type="submit" name="user_logout" value="Wyloguj" />
                    <?php } else { ?>
                        <input class="login-field text" type="text" name="user_email" value="user@gmail.com" />
                        <input class="login-field text" type="text" name="user_password" value="user" />
                        <input class="login-field button" type="submit" name="user_check" value="Zaloguj" />
                        <a class="login-field button" name="user_register" href="../users/user_register.php" >Register</a>
                    <?php } ?>
                    </form>
                    <!-- search -->
                    <script type="text/javascript">
                        $(function(){
                            $(document).on('keyup', '#search, #search2', function() {
                                //console.log( $( this ).val() );
                                var string = $( this ).val();
                                $.ajax({
                                    type: 'POST',
                                    url: '../backroom/search_index.php',
                                    data: {string : string }, 
                                    cache: false,
                                    dataType: 'text',
                                    success: function(data){
                                        //$('#show').html(data);
                                        // setTimeout(function(){ 
                                            // $('#show').html(data); 
                                        // }, 500)
                                        $('#wrapper4').html(data);
                                    }
                                });
                            });
                        });
                    </script>
                    <input id="search" type="text" placeholder="Szukaj..." />
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
                            if (! isset($user_register) && ! isset($user_edit) && ! isset($user_basket)) {//co by nic nie wyswietlało kiedy wywołam register user edit albo basket
                                //$category_now_display='PC';
                                //$product_now_display='6';
                                //left menu
                                //------------------------------------------------
                                $sub = new ProductDisplay();
                                $sub->__setTable('product_tab');
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
                                    ?><a class="leftmenu_a_button" href="../category/<?php echo $sub->__getCatMainFileName($product_now_display); ?>.php">Powrót</a><?php 
                                }
                                //------------------------------------------------
                            }
							?>
						</form>
					</div>	
				</div>	
			</nav>
			<div id="wrapper4">    
                <script type="text/javascript">
                    $(function(){
                        /**
                        * behawior when product-square basket-field click in home position
                        **/
                        // $( '.basket-field' ).click(function(e){//stop follow link when amount click
                            // $( '.square-link' ).click(function(e){
                                // e.preventDefault();
                                // //alert('sdf');
                                // //console.log('a follow blocked');
                            // });
                        // });
                        $(".square-link").on('click', '.basket-field.text', function(e) {//stop follow link when amount click
                            e.preventDefault();
                            //console.log('a follow blocked');
                        });
                        // $(".square-link").on('click', '.basket-field.button', function(e) {//stop follow link when add click
                            // e.preventDefault();
                            // //console.log('a follow blocked');
                        // });
                        $(".basket-field.text").mousedown(function () { //set cursor on the end text input !important
                            this.setSelectionRange(this.value.length, this.value.length);    
                        });
                    });
                </script>
                <?php
                //echo $_SERVER['PHP_SELF'];
                //echo basename(__FILE__);
                if (! isset($user_register) && ! isset($user_edit) && ! isset($user_basket)) {//co by nic nie wyswietlało kiedy wywołam register user edit albo basket
                    //------------------------------------------------
                    $show = new ProductDisplay();
                    $show->__setTable('product_tab');
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
                //-user register
                //------------------------------------------------
                } elseif (isset($user_register) && ! isset($user_basket)  && ! isset($user_edit)) {
                    if (isset($return)) {
                        echo $return ? 'dodany' : 'błąd';
                    }                    
                    Connect_Form::registerForm();
                //-user edit/update
                //------------------------------------------------
                } elseif (isset($user_edit) && ! isset($user_basket)  && ! isset($user_register)) {
                    if (isset($return)) {
                        echo $return ? 'wyedytowany' : 'błąd';
                    }
                    $asd = new Connect_Form;
                    $asd->editForm($_SESSION['user_id']);
                //-basket
                //------------------------------------------------
                } elseif (isset($user_basket) && ! isset($user_edit)  && ! isset($user_register)) {
                    $obj_basket_show = new Connect_Basket;
                    $obj_shipping_get = new Connect_Basket;// tworze nowe bo raz wyswietliłem na poszczegolnych polach w koszyku i to sie by dodało jescze raz
                    $foo = $obj_basket_show->basketGet($_SESSION['user_id']);
                    if ($foo) {
                        while ($row = $foo->fetch(PDO::FETCH_ASSOC)) {
                            $obj_basket_show->basketShow($row['id'], $row['pr_id'], $row['amount']);
                            $obj_shipping_get->basketShipping($row['id'], $row['pr_id'], $row['amount']);
                        }
                    }
                    $bar = $obj_basket_show->__getSumar();
                    //$obj_basket_show->__setSumShipping(0); 
                    $foo = $obj_shipping_get->__getSumShipping();
                    //var_dump($bar);                    
                    $sumar = array_sum($bar);
                    $send = array_sum($foo);
                    ?>
                    <div class="bs-sq cost-all">Koszt: <?php echo $sumar; ?> PLN</div>
                    <div class="bs-sq shipping-all">Przesyłka: <?php echo $send; ?> PLN</div>
                    <div class="bs-sq line-all"></div>
                    <div class="bs-sq sum-all">Do zapłaty: <?php echo $sumar+$send; ?> PLN</div>
                    <form method="POST">                        
                        <input class="basket-field button bs-sq drop" type="submit" name="basket_drop" value="Opróżnij koszyk" />
                        <input class="basket-field button bs-sq pay" type="submit" name="basket_accept" value="Zapłać" />
                    </form>
                    <form method="POST">                        
                        <input class="basket-field button bs-sq pre" type="submit" name="set_prepaid" value="Płace przelewem" />
                        <input class="basket-field button bs-sq on" type="submit" name="set_ondelivery" value="Płacę przy odbiorze" />
                    </form>
                    <?php
                    $arrNoPre = $obj_shipping_get->__getNoPre();
                    $arrNoOn = $obj_shipping_get->__getNoOn();
                    $arrShPre = $obj_shipping_get->__getShPre();
                    $arrShOn = $obj_shipping_get->__getShOn();
                    $arrShConPre = $obj_shipping_get->__getShConPre();
                    $arrShConOn = $obj_shipping_get->__getShConOn();
                    var_dump($arrNoPre);
                    var_dump($arrNoOn);
                    var_dump($arrShPre);
                    var_dump($arrShOn);
                    var_dump($arrShConPre);
                    var_dump($arrShConOn);
                    echo '----------------------';
                    $obj_shipping_get->shConFixPre($arrShConPre, 5);
                    $obj_shipping_get->shConFixOn($arrShConOn, 5);
                    
                    $fixPre = $obj_shipping_get->__getConFixPre();
                    $fixOn = $obj_shipping_get->__getConFixOn();
                    var_dump($fixPre);
                    var_dump($fixOn);
                    echo $fixPre = array_sum($fixPre);
                    echo $fixOn = array_sum($fixOn);
                    // echo ' ustawione z karty produktu pre';
                    // var_dump($arrPrePr);
                    // if (! empty($arrPrePr)) {
                        // foreach ($arrPrePr as $key => $value) {
                            // $wynPrePr[] = $key * $value;
                        // }
                        // $wynPrePr = array_sum($wynPrePr);
                        // echo $wynPrePr;
                    // }
                    // echo ' ustawione z karty produktu on';
                    // var_dump($arrOnPr);
                    // if (! empty($arrOnPr)) {
                        // foreach ($arrOnPr as $key => $value) {
                            // $wynOnPr[] = $key * $value;
                        // }
                        // $wynOnPr = array_sum($wynOnPr);
                        // echo $wynOnPr;
                    // }
                    // echo ' ustawione z supplier produktu pre';
                    // var_dump($arrPreSu);
                    // if (! empty($arrPreSu)) {
                        // foreach ($arrPreSu as $key => $value) {
                            // $wynPreSu[] = $key * $value;
                        // }
                        // $wynPreSu = array_sum($wynPreSu);
                        // echo $wynPreSu;
                    // }
                    // echo ' ustawione z supplier produktu on';
                    // var_dump($arrOnSu);
                    // if (! empty($arrOnSu)) {
                        // foreach ($arrOnSu as $key => $value) {
                            // $wynOnSu[] = $key * $value;
                        // }
                        // $wynOnSu = array_sum($wynOnSu);
                        // echo $wynOnSu;
                    // }
                    echo '----------------------';
                    ?>
                <?php } ?>
			</div>				
		</div>		
		<div>
            <script type="text/javascript">
            $(function(){
                console.log($( 'body' ).css( 'font-size' ));
            });
            </script>
			<h1 id="titi" >WELCOME TO MY GREAT WORLD OF PROGRAMMING</h1>	
		</div>
	</section>
	<footer>
	<!--<div id="count"></div><div id="count2"></div>-->
	</footer>
	<div id="debugger">
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
    //unset($_SESSION);
    //unset($_COOKIE);
    //session_destroy();
	?>
	</div>
<?php //html_p3 ?>
<![CDATA[spot four end section body]]>
<?php //html_p4 ?>
</body>
</html>
<?php //html_p4 ?>