-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 14 Gru 2014, 23:19
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `szpadlic_cms`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `1`
--

CREATE TABLE IF NOT EXISTS `1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_id` int(10) unsigned DEFAULT NULL,
  `amount` int(10) unsigned DEFAULT NULL,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `1`
--

INSERT INTO `1` (`id`, `pr_id`, `amount`, `mod`) VALUES
(4, 6, 1, NULL),
(5, 10, 5, NULL),
(6, 13, 3, NULL),
(7, 16, 6, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `2`
--

CREATE TABLE IF NOT EXISTS `2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_id` int(10) DEFAULT NULL,
  `amount` int(10) unsigned DEFAULT NULL,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `2`
--

INSERT INTO `2` (`id`, `pr_id`, `amount`, `mod`) VALUES
(1, 7, 2, NULL),
(2, 11, 2, NULL),
(3, 12, 1, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bookmarks`
--

CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Índice de la tabla',
  `url` varchar(555) DEFAULT NULL COMMENT 'Contiene la dirección URL del bookmark',
  `fecha` datetime DEFAULT NULL COMMENT 'Fecha en que se guardo el bookmark',
  `orden` int(4) DEFAULT NULL COMMENT 'Orden en que se va a mostrar el registro',
  `estado` varchar(1) DEFAULT NULL COMMENT '1: Activo 0: Inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `index_pieces`
--

CREATE TABLE IF NOT EXISTS `index_pieces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empty` text,
  `php_beafor_html` text,
  `html_p1` text,
  `head_title` text,
  `head_description` text,
  `head_keywords` text,
  `head_include` text,
  `head_p1` text,
  `html_p2` text,
  `html_p3` text,
  `html_p4` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `index_pieces`
--

INSERT INTO `index_pieces` (`id`, `empty`, `php_beafor_html`, `html_p1`, `head_title`, `head_description`, `head_keywords`, `head_include`, `head_p1`, `html_p2`, `html_p3`, `html_p4`) VALUES
(1, 'for initiate id', '<?php //php_beafor_html ?>\r\n<?php\r\nheader(''Content-Type: text/html; charset=utf-8'');\r\nsession_start();\r\ninclude_once ''../classes/connect.php'';\r\ninclude_once ''../classes/connect/load.php'';\r\nclass ProductDisplay\r\n{\r\n	private $host=''sql.bdl.pl'';\r\n	private $port='''';\r\n	private $dbname=''szpadlic_cms'';\r\n	private $charset=''utf8'';\r\n	private $user=''szpadlic_baza'';\r\n	private $pass=''haslo'';\r\n	private $table;\r\n	public function __setTable($tab_name)\r\n    {\r\n		$this->table=$tab_name;\r\n	}\r\n	public function connectDB()\r\n    {\r\n		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);\r\n		return $con;\r\n		unset ($con);\r\n	}\r\n	public function showCategoryMain()\r\n    {\r\n		$con = $this->connectDB();\r\n		$q = $con->query("SELECT `product_category_main` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/\r\n		unset ($con);\r\n		return $q;\r\n	}\r\n	public function showCategorySub($sub)\r\n    {\r\n		$con = $this->connectDB();\r\n		$q = $con->query("SELECT DISTINCT `product_category_sub` FROM `".$this->table."` WHERE `product_category_main` = ''".$sub."''");/*zwraca false jesli tablica nie istnieje*/\r\n		unset ($con);\r\n		return $q;\r\n	}\r\n    public function showSubAll()\r\n    {\r\n		$con = $this->connectDB();\r\n		$q = $con->query("SELECT DISTINCT `product_category_sub` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/\r\n		unset ($con);\r\n		return $q;\r\n	}\r\n	public function showAll()\r\n    {\r\n		$con = $this->connectDB();\r\n		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/\r\n		unset ($con);\r\n		return $q;\r\n	}\r\n	public function showAllCategory($main)\r\n    {\r\n		$con = $this->connectDB();\r\n		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = ''".$main."''");/*zwraca false jesli tablica nie istnieje*/\r\n		unset ($con);\r\n		return $q;\r\n	}\r\n    public function showAllSub($sub)\r\n    {\r\n		$con = $this->connectDB();\r\n		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_sub` = ''".$sub."''");/*zwraca false jesli tablica nie istnieje*/\r\n		unset ($con);\r\n		return $q;\r\n	}\r\n	public function showAllCategorySub($main, $sub)\r\n    {\r\n		$con = $this->connectDB();\r\n		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `product_category_main` = ''".$main."'' AND `product_category_sub` = ''".$sub."''");/*zwraca false jesli tablica nie istnieje*/\r\n		unset ($con);\r\n		return $q;\r\n	}\r\n    public function showProduct($id)\r\n    {\r\n		$con = $this->connectDB();\r\n		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `id` = ''".$id."''");/*zwraca false jesli tablica nie istnieje*/\r\n		unset ($con);\r\n		return $q;\r\n	}\r\n    public function __getCatMain($id)\r\n    {\r\n		$con = $this->connectDB();\r\n		$q = $con->query("SELECT `product_category_main` FROM `".$this->table."` WHERE `id` = ''".$id."''");/*zwraca false jesli tablica nie istnieje*/\r\n        $q = $q->fetch(PDO::FETCH_ASSOC);\r\n		unset ($con);\r\n		return $q;\r\n	}\r\n    public function __getCatMainFileName($id)\r\n    {\r\n        $this->__setTable(''product_tab'');\r\n        $cat = $this->__getCatMain($id);\r\n		$cat = $cat[''product_category_main''];\r\n        //return $cat;\r\n        $con=$this->connectDB();\r\n		$q = $con->query("SELECT `file_name_category_main` FROM `product_category_main` WHERE `product_category_main` = ''".$cat."''");/*zwraca false jesli tablica nie istnieje*/\r\n        $q = $q->fetch(PDO::FETCH_ASSOC);\r\n		unset ($con);\r\n		return $q[''file_name_category_main''];\r\n	}\r\n    public function showMiniImg($id)\r\n    {\r\n        //losowy obrazek z katalogu                                           \r\n        $dir_mini = ''../data/''.$id.''/mini/'';                                        \r\n        if (@opendir($dir_mini)) {//sprawdzam czy sciezka istnieje\r\n            $q = (count(glob($dir_mini."/*")) === 0) ? ''Empty'' : ''Not empty'';\r\n            if ($q=="Empty") {\r\n                echo "Brak"; // mozna by tu dodac fotke ze braz fotki\r\n            } else {\r\n                $folder = opendir($dir_mini);\r\n                $i = 0;\r\n                while (false !=($plik = readdir($folder))) {\r\n                    if ($plik != "." && $plik != "..") {\r\n                        $obrazki[$i]= $plik;//tablica z obrazkami\r\n                        $i++;\r\n                    }\r\n                }\r\n                closedir($folder);\r\n                $losowy=rand(0,count(@$obrazki)-1);//losuje obrazek\r\n                return $dir_mini.@$obrazki[$losowy];//link do obrazka ''src''\r\n                unset($obrazki);\r\n            }                                               \r\n        } else {\r\n            echo ''Brak'';//mozna by tu dodac fotke ze braz fotki\r\n        }\r\n    }\r\n    public function showAllImg($id)\r\n    {\r\n        //wszystkie orazki z katalogu                                         \r\n        $dir_all = ''../data/''.$id.''/'';                                        \r\n        if (@opendir($dir_all)) {//sprawdzam czy sciezka istnieje\r\n            $q = (count(glob($dir_all."/*")) === 1) ? ''Empty'' : ''Not empty'';\r\n            if ($q=="Empty") {\r\n                //echo "Chwilowo Brak";\r\n                return false;\r\n            } else {\r\n                $folder = opendir($dir_all);\r\n                $i = 0;\r\n                while (false !=($plik = readdir($folder))) {\r\n                    if ($plik != "." && $plik != ".." && $plik != "mini") {\r\n                        $obrazki[$i]= $dir_all.$plik;//tablica z obrazkami\r\n                        $i++;\r\n                    }\r\n                }\r\n                closedir($folder);\r\n                //$losowy=rand(0,count(@$obrazki)-1);//losuje obrazek\r\n                return $obrazki;//link do obrazka ''src''\r\n                unset($obrazki);\r\n            }                                               \r\n        } else {\r\n            //echo ''Brak'';\r\n            return false;\r\n        }\r\n    }\r\n    public function showSquare($cat)\r\n    {\r\n        ?>\r\n        <a class="square-link" href="../product/<?php echo $cat[''file_name''].''.php''; ?>">\r\n            <div class="product-square">\r\n                <div class="pr-sq img">\r\n                   <img class="mini-image-pr-list" src="<?php echo $this->showMiniImg($cat[''id'']); ?>" alt="mini image" />\r\n                </div>\r\n                <div class="pr-sq price">\r\n                    Cena: <?php echo $cat[''product_price'']; ?> PLN\r\n                </div>\r\n                <div class="pr-sq cat-main">\r\n                    <?php echo $cat[''product_category_main'']; ?>\r\n                </div>\r\n                <div class="pr-sq cat-sub">\r\n                    <?php echo $cat[''product_category_sub'']; ?>\r\n                </div>\r\n                <div class="pr-sq name">\r\n                    <?php echo $cat[''product_name'']; ?>\r\n                </div>\r\n                <?php if (isset($_SESSION[''user_id''])) { ?>\r\n                <div class="pr-sq add">\r\n                    <form method="POST">\r\n                        <input class="basket-field text" type="text" name="amount" value="1" />\r\n                        <input class="basket-field text" type="hidden" name="pr_id" value="<?php echo $cat[''id'']; ?>" />\r\n                        <input class="basket-field button" type="submit" name="add_to_basket" value="Dodaj" />\r\n                    </form>\r\n                </div>\r\n                <?php } ?>\r\n                <div class="pr-sq shipping">\r\n                    <?php echo $this->showShippingPrice($cat[''id'']); ?>\r\n                </div>\r\n            </div>\r\n        </a>\r\n        <?php\r\n    }\r\n    public function showFullSquare($cat)\r\n    {\r\n        ?>\r\n        <div class="product-full-square">\r\n            <div class="full-up-place-holder">\r\n                <div class="full-mini-img">\r\n                    <img class="mini-image-pr-list" src="<?php echo $this->showMiniImg($cat[''id'']); ?>" alt="mini image" />\r\n                </div>\r\n                <div class="full-name"><?php echo $cat[''product_name'']; ?></div>\r\n                <div class="full shipping">\r\n                    <?php echo $this->showShippingPrice($cat[''id'']); ?>\r\n                </div>\r\n                <?php if (isset($_SESSION[''user_id''])) { ?>\r\n                <div class="full add">\r\n                    <form method="POST">\r\n                        <input class="basket-field text" type="text" name="amount" value="1" />\r\n                        <input class="basket-field text" type="hidden" name="pr_id" value="<?php echo $cat[''id'']; ?>" />\r\n                        <input class="basket-field button" type="submit" name="add_to_basket" value="Dodaj" />\r\n                    </form>\r\n                </div>\r\n                <?php } ?>\r\n            </div>          \r\n            <div class="full-down-place-holder">\r\n                <div class="full-description-button color full-click active">Opis</div>\r\n                <div class="full-description-container color"><?php echo $cat[''product_description_large'']; ?></div>\r\n                <div class="full-gallery-button color full-click">Galeria</div>\r\n                <div class="full-gallery-container color">\r\n                    <?php\r\n                    $img_tab = $this->showAllImg($cat[''id'']);\r\n                    if ($img_tab) {\r\n                        foreach ($img_tab as $img) {\r\n                            ?>\r\n                            <div class="full-img-gallery">\r\n                                <img class="mini-image-pr-list" src="<?php echo $img; ?>" alt="<?php echo $cat[''product_name'']; ?>" />\r\n                            </div>\r\n                            <?php\r\n                        }\r\n                    }\r\n                    ?>\r\n                </div>\r\n                <div class="full-other-button color full-click">Inne</div>\r\n                <div class="full-other-container color"><?php echo $cat[''product_description_small'']; ?></div>\r\n            </div>\r\n        </div>        \r\n        <?php\r\n    }\r\n    public function showShippingPrice($id)\r\n    {\r\n        $con = $this->connectDB();\r\n		$q = $con->query("SELECT * FROM `".$this->table."` WHERE `id` = ''".$id."''");/*zwraca false jesli tablica nie istnieje*/\r\n        $q = $q->fetch(PDO::FETCH_ASSOC);\r\n		unset ($con);\r\n		$mod = $q[''shipping_mod''];\r\n        if ($mod == 0) {\r\n            $con = $this->connectDB();\r\n            $k = $con->query("SELECT * FROM `".$q[''predefined'']."` WHERE `weight_of` <= ".$q[''weight'']." AND `weight_to` >= ".$q[''weight'']."");\r\n            $k = $k->fetch(PDO::FETCH_ASSOC);\r\n            unset ($con);\r\n            echo ''Przesyłka od:'';\r\n            echo ''<br />'';\r\n            if ($k) {\r\n                echo $k[''price_prepayment''];\r\n            } else {\r\n                $con = $this->connectDB();\r\n                $d = $con->query("SELECT * FROM `".$q[''predefined'']."` WHERE `price_of` <= ".$q[''product_price'']." AND `price_to` >= ".$q[''product_price'']."");\r\n                $d = $d->fetch(PDO::FETCH_ASSOC);\r\n                unset ($con);\r\n                if ($d) {\r\n                    echo $d[''price_prepayment''];\r\n                } else {\r\n                    $con = $this->connectDB();\r\n                    $f = $con->query("SELECT * FROM `".$q[''predefined'']."` WHERE `configuration_mod` = ''simple''");\r\n                    $f = $f->fetch(PDO::FETCH_ASSOC);\r\n                    //var_dump($f);\r\n                    unset ($con);\r\n                    if ($f) {\r\n                        echo $f[''price_prepayment''];\r\n                    } else {\r\n                        echo (''niezdefi-<br />niowane'');\r\n                    }\r\n                }\r\n            }\r\n        } elseif ($mod == 1) {\r\n            echo ''Przesyłka od:'';\r\n            echo ''<br />'';\r\n            if ($q[''allow_prepaid''] == 1 && !empty($q[''price_prepaid''])) {\r\n                echo $q[''price_prepaid''];\r\n            } elseif ($q[''allow_ondelivery''] == 1 && !empty($q[''price_ondelivery''])) {\r\n                echo $q[''price_ondelivery''];\r\n            } else {\r\n                echo (''niezdefi-<br />niowane'');\r\n            }\r\n            \r\n        }\r\n    }\r\n}\r\nif (isset($_POST[''topmenu''])) {\r\n	$_SESSION[''category''] = $_POST[''topmenu''];\r\n	unset($_SESSION[''sub'']);\r\n}\r\nif (isset($_POST[''leftmenu''])) {\r\n	$_SESSION[''sub''] = $_POST[''leftmenu''];\r\n}\r\nif (@$_POST[''leftmenu'']==''Wszystkie'') {\r\n    unset($_SESSION[''sub'']);\r\n}\r\nif (@$_POST[''topmenu'']==''Home'') {\r\n    //niema posta juz!!!!\r\n	//unset($_SESSION[''sub'']);\r\n	//unset($_SESSION[''category'']);\r\n	//unset($_SESSION[''session_menu_id'']);\r\n	//session_unset();\r\n}\r\n//(@$_POST[''topmenu'']==''Sprzęt'') ? header("location: zap/index.php") : ''błąd'' ;//tymczasowo na zaplecze\r\n$objload = new Connect_Load();\r\n$objload->__setTable(''setting_seo'');\r\n$global = $objload->globalMetaData();\r\nclass Connect_Form extends Connect\r\n{\r\n    static function registerForm()\r\n    {\r\n    ?>\r\n        <form method="POST">\r\n            <div class="full-square">\r\n                <p>Account</p>\r\n                <div class="line"></div>\r\n                <div class="inline" ><span class="">Login:</span><input id="" class="register-field text" type="text" name="login" value="user" /></div>\r\n                <div class="inline" ><span class="">Adres email:</span><input id="" class="register-field text" type="text" name="email" value="user@gmail.com" /></div>\r\n                <div class="inline" ><span class="">Powtórz adres email:</span><input id="" class="register-field text" type="text" name="email_confirm" value="user@gmail.com" /></div>\r\n                <div class="inline" ><span class="">Hasło:</span><input id="" class="register-field text" type="text" name="password" value="user" /></div>\r\n                <div class="inline" ><span class="">Powtórz hasło:</span><input id="" class="register-field text" type="text" name="password_confirm" value="user" /></div>\r\n                <p>Personal info</p>\r\n                <div class="line"></div>\r\n                <div class="inline" ><span class="">Imię:</span><input id="" class="register-field text" type="text" name="first_name" value="Piotr" /></div>\r\n                <div class="inline" ><span class="">Nazwisko:</span><input id="" class="register-field text" type="text" name="last_name" value="Szpanelewski" /></div>\r\n                <div class="inline" ><span class="">Telefon:</span><input id="" class="register-field text" type="text" name="phone" value="888958277" /></div>\r\n                <div class="inline" ><span class="">Miasto:</span><input id="" class="register-field text" type="text" name="town" value="Częstochowa" /></div>\r\n                <div class="inline" ><span class="">Kod pocztowy:</span><input id="" class="register-field text" type="text" name="post_code" value="42-200" /></div>\r\n                <div class="inline" ><span class="">Ulica i nr domu:</span><input id="" class="register-field text" type="text" name="street" value="Garibaldiego 16 m. 23" /></div>\r\n                <p>Confirm</p>\r\n                <div class="line"></div>\r\n                <div class="inline" ><span class=""></span><input id="" class="register-field button" type="submit" name="addUser" value="Zapisz" /></div>\r\n            </div>\r\n        </form>\r\n    <?php\r\n    }\r\n    public function editForm($id)\r\n    {\r\n        $con = $this->connectDB();\r\n		$q = $con->query("SELECT * FROM `users` WHERE `id` = ''".$id."''");\r\n        $q = $q->fetch(PDO::FETCH_ASSOC);\r\n		unset ($con);\r\n    ?>\r\n        <form method="POST">\r\n            <div class="full-square">\r\n                <p>Account</p>\r\n                <div class="line"></div>\r\n                <div class="inline" ><span class="">Login:</span><input id="" class="register-field text" type="text" name="login" value="<?php echo $q[''login'']; ?>" /></div>\r\n                <div class="inline" ><span class="">Adres email:</span><input id="" class="register-field text" type="text" name="email" value="<?php echo $q[''email'']; ?>" /></div>\r\n                <div class="inline" ><span class="">Hasło:</span><input id="" class="register-field text" type="text" name="password" value="<?php echo $q[''password'']; ?>" /></div>\r\n                <div class="inline" ><span class="">Powtórz hasło:</span><input id="" class="register-field text" type="text" name="password_confirm" value="<?php echo $q[''password'']; ?>" /></div>\r\n                <p>Personal info</p>\r\n                <div class="line"></div>\r\n                <div class="inline" ><span class="">Imię:</span><input id="" class="register-field text" type="text" name="first_name" value="<?php echo $q[''first_name'']; ?>" /></div>\r\n                <div class="inline" ><span class="">Nazwisko:</span><input id="" class="register-field text" type="text" name="last_name" value="<?php echo $q[''last_name'']; ?>" /></div>\r\n                <div class="inline" ><span class="">Telefon:</span><input id="" class="register-field text" type="text" name="phone" value="<?php echo $q[''phone'']; ?>" /></div>\r\n                <div class="inline" ><span class="">Miasto:</span><input id="" class="register-field text" type="text" name="town" value="<?php echo $q[''town'']; ?>" /></div>\r\n                <div class="inline" ><span class="">Kod pocztowy:</span><input id="" class="register-field text" type="text" name="post_code" value="<?php echo $q[''post_code'']; ?>" /></div>\r\n                <div class="inline" ><span class="">Ulica i nr domu:</span><input id="" class="register-field text" type="text" name="street" value="<?php echo $q[''street'']; ?>" /></div>\r\n                <p>Confirm</p>\r\n                <div class="line"></div>\r\n                <div class="inline" ><span class=""></span><input id="" class="register-field button" type="submit" name="updateUser" value="Uaktualnij" /></div>\r\n            </div>\r\n        </form>\r\n    <?php \r\n    }\r\n}\r\ninclude_once ''../classes/connect/register.php'';\r\n$obj_users = new Connect_Register;\r\nif (isset($_POST[''addUser''])) {\r\n    $obj_users->__setTable(''users'');\r\n    $arr_val = array(\r\n        ''login''         =>$_POST[''login''], \r\n        ''password''      =>$_POST[''password''], \r\n        ''email''         =>$_POST[''email''],                     \r\n        ''create_data''   => date(''Y-m-d H:i:s''),\r\n        ''update_data''   => date(''Y-m-d H:i:s''),\r\n        ''first_name''    =>$_POST[''first_name''],\r\n        ''last_name''     =>$_POST[''last_name''],\r\n        ''phone''         =>$_POST[''phone''],\r\n        ''country''       =>''Polska'',\r\n        ''town''          =>$_POST[''town''],\r\n        ''post_code''     =>$_POST[''post_code''],\r\n        ''street''        =>$_POST[''street'']\r\n        );\r\n    $return = $obj_users->addUser($arr_val);\r\n    if ($return) {\r\n        $_SESSION[''user_id''] = $return;\r\n        header(''location: ../home/index.php'');\r\n    }\r\n}\r\nif (isset($_POST[''updateUser''])) {\r\n    $obj_users->__setTable(''users'');\r\n    $arr_val = array(\r\n        ''login''         =>$_POST[''login''], \r\n        ''password''      =>$_POST[''password''], \r\n        ''email''         =>$_POST[''email''],\r\n        ''update_data''   => date(''Y-m-d H:i:s''),\r\n        ''first_name''    =>$_POST[''first_name''],\r\n        ''last_name''     =>$_POST[''last_name''],\r\n        ''phone''         =>$_POST[''phone''],\r\n        ''country''       =>''Polska'',\r\n        ''town''          =>$_POST[''town''],\r\n        ''post_code''     =>$_POST[''post_code''],\r\n        ''street''        =>$_POST[''street'']\r\n        );\r\n    $return = $obj_users->updateUser($arr_val, 1);    \r\n}\r\nif (isset($_POST[''user_check''])) {\r\n    include_once ''../users/user_login.php'';\r\n    if (is_int($check)) {\r\n        $_SESSION[''user_id''] = $check;\r\n    }\r\n} elseif (isset($_POST[''user_logout''])) {\r\n        unset($_SESSION[''user_id'']);\r\n        //header tylko dla lokacji edit i basket\r\n        header(''location: ../home/index.php'');\r\n        // $arr_location = array (''user_edit.php'', ''user_basket.php'');\r\n        // if (in_array(basename(__FILE__), $arr_location, true)) {\r\n            // header(''location: ../home/index.php'');\r\n        // }\r\n}\r\nclass Connect_Basket extends Connect\r\n{\r\n    private $sumar=array();\r\n    public function __getSumar(){\r\n        return $this->sumar;\r\n    }\r\n    public function basketAdd($table, $pr_id, $amount)\r\n    {\r\n        /**\r\n        * jesli produkt juz jest w koszyku zwiekszyc tylko ilosc\r\n        **/\r\n        $con = $this->connectDB();\r\n        $res = $con->query("CREATE TABLE IF NOT EXISTS `".$table."`(\r\n                            `id` INTEGER AUTO_INCREMENT,            \r\n                            `pr_id` INTEGER(10) UNSIGNED,\r\n                            `amount` INTEGER(10) UNSIGNED,\r\n                            `mod` INTEGER(10),\r\n                            PRIMARY KEY(`id`)\r\n                            )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1"\r\n                            );\r\n        // tu musze pobrac pole o pr_id jesli jest pobrac i zwiekszyc tylko amount (update)\r\n        // jesli nie to zostawic normalnie !it done\r\n        $check = $con->query("SELECT `amount` FROM `".$table."` WHERE `pr_id` = ''".$pr_id."''");\r\n        $check = $check->fetch(PDO::FETCH_ASSOC);\r\n        //var_dump($check);\r\n        if ($check) {// if exist sum and add only amount\r\n            $value = $check[''amount''] + $amount;\r\n            $res = $con->query("UPDATE `".$table."` \r\n                                SET\r\n                                `amount` = ''".$value."''\r\n                                WHERE\r\n                                `pr_id` = ''".$pr_id."''\r\n                                ");\r\n        } else {// if product not exist in basket yet \r\n            $res = $con->query("INSERT INTO `".$table."`(\r\n                                `pr_id`,\r\n                                `amount`\r\n                                ) VALUES (\r\n                                ''".$pr_id."'',\r\n                                ''".$amount."''\r\n                                )");\r\n        }\r\n        //$q = $con->query("SELECT * FROM `".$table."`");\r\n        //$q = $q->fetch(PDO::FETCH_ASSOC);\r\n		unset ($con);\r\n    }\r\n    public function basketUpdate($table, $id, $amount_new)\r\n    {\r\n        /**\r\n        * regulowanie ilosci produktu w koszyku\r\n        **/\r\n        $con = $this->connectDB();\r\n        $check = $con->query("SELECT `amount` FROM `".$table."` WHERE `id` = ''".$id."''");\r\n        $check = $check->fetch(PDO::FETCH_ASSOC);\r\n        if ($check) {\r\n            $res = $con->query("UPDATE `".$table."` \r\n            SET\r\n			`amount` = ''".$amount_new."''\r\n			WHERE\r\n            `id` = ''".$id."''\r\n            ");\r\n            return true;\r\n        } else {\r\n            return false;\r\n        }\r\n		//unset ($con);\r\n    }\r\n    public function basketDrop($table)\r\n    {\r\n        $con = $this->connectDB();\r\n        $res = $con->query(''DROP TABLE `''.$table.''`'');\r\n        return $res ? true : false;\r\n    }\r\n    public function basketItemDrop($table, $id)\r\n    {\r\n        $con = $this->connectDB();\r\n        $res = $con->query("DELETE FROM `".$table."` WHERE `id` = ''".$id."''");\r\n        return $res ? true : false;\r\n    }\r\n    public function basketGet($table)\r\n    {\r\n        $con = $this->connectDB();\r\n        $q = $con->query("SELECT * FROM `".$table."`");\r\n        //$q = $q->fetch(PDO::FETCH_ASSOC);\r\n        return $q;\r\n		unset ($con);\r\n    }\r\n    public function basketSelect($table, $id)\r\n    {\r\n        $con = $this->connectDB();\r\n        $q = $con->query("SELECT * FROM `".$table."` WHERE `id`=''".$id."''");\r\n        $q = $q->fetch(PDO::FETCH_ASSOC);\r\n        return $q;\r\n		unset ($con);\r\n    }\r\n    public function basketShow($id, $pr_id, $amount)\r\n    {\r\n        $wyn = $this->basketSelect(''product_tab'', $pr_id);\r\n        $min_img = new ProductDisplay;\r\n        //$this->sumar=array();\r\n        ?>       \r\n            <div class="bs-square">\r\n                <div class="bs-sq img">\r\n                    <img class="mini-image-bs-list" src="<?php echo $min_img->showMiniImg($wyn[''id'']); ?>" alt="mini image" />\r\n                </div>\r\n                <div class="bs-sq price">\r\n                    Cena: <?php echo $wyn[''product_price'']; ?>\r\n                </div>\r\n                <!--\r\n                <div class="bs-sq cat-main">\r\n                    <?php echo $wyn[''product_category_main'']; ?>\r\n                </div>\r\n                <div class="bs-sq cat-sub">\r\n                    <?php echo $wyn[''product_category_sub'']; ?>\r\n                </div>\r\n                -->\r\n                <div class="bs-sq name">\r\n                    <a class="bs-square-link" href="../product/<?php echo $wyn[''file_name''].''.php''; ?>">\r\n                        <?php echo $wyn[''product_name'']; ?>\r\n                    </a>\r\n                </div>\r\n                <div class="bs-sq amount">\r\n                    <form method="POST">\r\n                        Ilość: <input class="basket-field text" type="text" name="basket_item_update_text" value="<?php echo $amount; ?>" />\r\n                        <input class="basket-field button" type="submit" name="basket_item_update_amount" value="Aktualizuj" />\r\n                        <input type="hidden" name="basket_item_update_id" value="<?php echo $id; ?>" />\r\n                    </form>\r\n                </div>\r\n                <div class="bs-sq suma">\r\n                    Razem: <?php echo $wyn[''product_price'']*$amount; ?> PLN\r\n                </div>\r\n                <div class="bs-sq del">\r\n                    <form method="POST">\r\n                        <input class="basket-field button" type="submit" name="basket_item_drop" value="Usuń" />\r\n                        <input type="hidden" name="basket_item_drop_id" value="<?php echo $id; ?>" />\r\n                    </form>\r\n                </div>\r\n            </div>\r\n        <?php\r\n        $lol = $wyn[''product_price'']*$amount;\r\n        $this->sumar[] = $lol;\r\n    }\r\n    // public function basketSum()\r\n    // {\r\n        // $con = $this->connectDB();\r\n        // $sumar = $con->query("SELECT sum(numbers) FROM all_nums");\r\n        // $sumar = $sumar->fetch(PDO::FETCH_ASSOC);\r\n        // return $sumar;\r\n    // }\r\n    public function basketSubtraction($table)\r\n    {\r\n        $con = $this->connectDB();\r\n    }\r\n    public function basketAccept($table)\r\n    {\r\n        $con = $this->connectDB();\r\n        $check = $con->query("SELECT * FROM `".$table."`");\r\n        //$check = $check->fetch(PDO::FETCH_ASSOC);\r\n        //var_dump($check);\r\n        if ($check) {\r\n            while ($row = $check->fetch(PDO::FETCH_ASSOC)) {\r\n                //$obj_basket_show->basketShow($row[''id''], $row[''pr_id''], $row[''amount'']);\r\n                //var_dump($row);\r\n                $con = $this->connectDB();\r\n                $old = $con->query("SELECT `amount` FROM `product_tab` WHERE `id` = ''".$row[''pr_id'']."''");\r\n                $old = $old->fetch(PDO::FETCH_ASSOC);\r\n                $value = $old[''amount''] - $row[''amount''];\r\n                //echo $value;\r\n                $res = $con->query("UPDATE `product_tab` \r\n                    SET\r\n                    `amount` = ''".$value."''\r\n                    WHERE\r\n                    `id` = ''".$row[''pr_id'']."''\r\n                    ");\r\n            }\r\n        }\r\n    }\r\n}\r\n\r\nif (isset($_POST[''add_to_basket'']) && isset($_SESSION[''user_id''])) {\r\n    $obj_basket_add = new Connect_Basket;\r\n    $obj_basket_add->basketAdd($_SESSION[''user_id''], $_POST[''pr_id''], $_POST[''amount'']);\r\n}\r\nif (isset($_POST[''basket_item_update_amount'']) && isset($_SESSION[''user_id''])) {\r\n    $obj_basket_add = new Connect_Basket;\r\n    $obj_basket_add->basketUpdate($_SESSION[''user_id''], $_POST[''basket_item_update_id''], $_POST[''basket_item_update_text'']);\r\n}\r\nif (isset($_POST[''basket_drop''])) {\r\n    $obj_basket_add = new Connect_Basket;\r\n    $drop = $obj_basket_add->basketDrop($_SESSION[''user_id'']);\r\n    header(''location: ../home/index.php'');\r\n}\r\nif (isset($_POST[''basket_item_drop''])) {\r\n    $obj_basket_add = new Connect_Basket;\r\n    $drop = $obj_basket_add->basketItemDrop($_SESSION[''user_id''], $_POST[''basket_item_drop_id'']);\r\n}\r\nif (isset($_POST[''basket_accept''])) {\r\n    $obj_basket_add = new Connect_Basket;\r\n    $drop = $obj_basket_add->basketAccept($_SESSION[''user_id'']);\r\n}\r\ninclude_once(''../classes/connect/general.php'');\r\n$obj_gen = new Connect_General;\r\n$obj_gen->__setTable(''setting_gen'');\r\n$get_setting = $obj_gen->__getRow(1);\r\n?>\r\n<?php //php_beafor_html ?>', '<?php //html_p1 ?>\r\n<!DOCTYPE HTML>\r\n<html lang="pl">\r\n<head>\r\n<?php //html_p1 ?>', '<?php //head_title ?>\r\n	<?php echo ''<title>''.$global[''global_title_index''].''</title>''; ?>\r\n<?php //head_title ?>', '<?php //head_description ?>\r\n    <?php echo ''<meta name="description" content="''.$global[''global_description_index''].''" />''; ?>\r\n<?php //head_description ?>', '<?php //head_keywords ?>\r\n    <?php echo ''<meta name="keywords" content="''.$global[''global_keywords_index''].''" />''; ?>\r\n<?php //head_keywords ?>', '<?php //head_include ?>\r\n	<?php include ("../meta5.html"); ?>\r\n<?php //head_include ?>', '<?php //head_p1 ?>\r\n	<script type="text/javascript" src="../js/menu.js"></script>\r\n    <script type="text/javascript">\r\n    $(document).ready(function(){\r\n    });\r\n    </script>\r\n<?php //head_p1 ?>', '<?php //html_p2 ?>\r\n</head>\r\n<?php if ($get_setting[''background_mod'']==''one'') { ?>\r\n<body style="background: #000 url(../images/bg.jpg) center 0px no-repeat; background-attachment:fixed; background-size: cover;">\r\n<?php } else { ?>\r\n<body>\r\n<?php } ?>\r\n<?php //html_p2 ?>', '<?php //html_p3 ?>\r\n<?php if ($get_setting[''background_mod'']==''two'') { ?>\r\n	<!--poczatek-animcja-tła-->\r\n    <!--\r\n	<ul class="cb-slideshow">\r\n		<li><span class="image-bg">Image 01</span><div class="title-bg"><h3>WELCOME</h3></div></li>\r\n		<li><span class="image-bg">Image 02</span><div class="title-bg"><h3>TO MY</h3></div></li>\r\n		<li><span class="image-bg">Image 03</span><div class="title-bg"><h3>GREAT</h3></div></li>\r\n		<li><span class="image-bg">Image 04</span><div class="title-bg"><h3>WORLD</h3></div></li>\r\n		<li><span class="image-bg">Image 05</span><div class="title-bg"><h3>OF</h3></div></li>\r\n		<li><span class="image-bg">Image 06</span><div class="title-bg"><h3>PROGRAMMING</h3></div></li>\r\n	</ul>\r\n    -->\r\n    <div class="bg-slider-overflow">\r\n        <ul class="bg-slider">\r\n            <li><img alt="" title="" src="../images/background/01.jpg" /><div class="title-bg"><h3>WELCOME</h3></div></li>\r\n            <li><img alt="" title="" src="../images/background/02.jpg" /><div class="title-bg"><h3>TO MY</h3></div></li>\r\n            <li><img alt="" title="" src="../images/background/03.jpg" /><div class="title-bg"><h3>GREAT</h3></div></li>\r\n            <li><img alt="" title="" src="../images/background/04.jpg" /><div class="title-bg"><h3>WORLD</h3></div></li>\r\n            <li><img alt="" title="" src="../images/background/05.jpg" /><div class="title-bg"><h3>OF</h3></div></li>\r\n            <li><img alt="" title="" src="../images/background/06.jpg" /><div class="title-bg"><h3>PROGRAMMING</h3></div></li>\r\n        </ul>\r\n    </div>\r\n	<!--koniec-animacja-tła-->\r\n<?php } ?>\r\n	<section id="place-holder">\r\n		<div id="wrapper1">\r\n			<nav id="top-menu-place-holder">\r\n				<div id="top-menu">\r\n					<div id="top-menu-0">\r\n							<a id="top-menu-1" class="top-menu" href="../home/index.php">Home</a>\r\n							<?php\r\n                            //top menu\r\n                            //------------------------------------------------\r\n							$main = new ProductDisplay();\r\n							$main->__setTable(''product_category_main'');//tabelke juz bedzie mial trzeba ustalic z gory w install jak bedzie sie nazywala tabelka z produktami\r\n							if ($main->showCategoryMain()) { \r\n								$i=2;\r\n								foreach ($main->showCategoryMain() as $cat) { ?>\r\n                                    <?php $file_name = str_replace(" ", "-", $cat[''product_category_main'']);//zamieniam spacje ?><!--dodac kolumne nazwa kat do cd-->\r\n									<a id="top-menu-<?php echo $i; ?>" class="top-menu" href="../category/<?php echo $file_name.''.php''; ?>"><?php echo $cat[''product_category_main''] ?></a>\r\n								<?php\r\n								$i++;\r\n								}\r\n							}\r\n							unset($main);\r\n							?>\r\n                            <a id="top-menu-backroom" class="top-menu" href="../backroom/product_list.php">Zaplecze</a>\r\n							<div id="bottom-line"></div>\r\n                            <a href="http://localhost/htdocs/cms/backroom/db_update_index.php">update index</a>\r\n					</div>						\r\n				</div>	\r\n			</nav>	\r\n			<div id="wrapper2">\r\n                    <!-- login edit register basket-->\r\n                    <form method="POST" >\r\n                    <?php if (isset($_SESSION[''user_id'']) && is_int($_SESSION[''user_id''])) { ?>\r\n                        <a class="login-field button" name="user_edit" href="../users/user_edit.php" >Edit</a>\r\n                        <a class="login-field button" name="user_basket" href="../users/user_basket.php" >Basket</a>\r\n                        <input class="login-field button" type="submit" name="user_logout" value="Wyloguj" />\r\n                    <?php } else { ?>\r\n                        <input class="login-field text" type="text" name="user_email" value="user@gmail.com" />\r\n                        <input class="login-field text" type="text" name="user_password" value="user" />\r\n                        <input class="login-field button" type="submit" name="user_check" value="Zaloguj" />\r\n                        <a class="login-field button" name="user_register" href="../users/user_register.php" >Register</a>\r\n                    <?php } ?>\r\n                    </form>\r\n                    <!-- search -->\r\n                    <script type="text/javascript">\r\n                        $(function(){\r\n                            $(document).on(''keyup'', ''#search, #search2'', function() {\r\n                                //console.log( $( this ).val() );\r\n                                var string = $( this ).val();\r\n                                $.ajax({\r\n                                    type: ''POST'',\r\n                                    url: ''../backroom/search_index.php'',\r\n                                    data: {string : string }, \r\n                                    cache: false,\r\n                                    dataType: ''text'',\r\n                                    success: function(data){\r\n                                        //$(''#show'').html(data);\r\n                                        // setTimeout(function(){ \r\n                                            // $(''#show'').html(data); \r\n                                        // }, 500)\r\n                                        $(''#wrapper4'').html(data);\r\n                                    }\r\n                                });\r\n                            });\r\n                        });\r\n                    </script>\r\n                    <input id="search" type="text" placeholder="Szukaj..." />\r\n			</div>\r\n			<div id="wrapper1-1"></div>\r\n		</div>\r\n		<div id="wrapper3">\r\n			<nav id="left-menu-place-holder">\r\n				<div id="left-menu">\r\n					<div id="left-menu-title"><h2><?php echo @$_SESSION[''category'']; ?></h2></div>\r\n					<div id="left-menu-0">\r\n						<form method="POST">                     \r\n							<?php\r\n                            if (! isset($user_register) && ! isset($user_edit) && ! isset($user_basket)) {//co by nic nie wyswietlało kiedy wywołam register user edit albo basket\r\n                                //$category_now_display=''PC'';\r\n                                //$product_now_display=''6'';\r\n                                //left menu\r\n                                //------------------------------------------------\r\n                                $sub = new ProductDisplay();\r\n                                $sub->__setTable(''product_tab'');\r\n                                //-index\r\n                                //------------------------------------------------\r\n                                if (! isset($category_now_display) && ! isset($product_now_display)) {//sub dla home\r\n                                    $is = $sub->showSubAll()->fetch(PDO::FETCH_ASSOC);//sprawdzam czy cos ma sub kategorie jesli tak to pokazuje button wszystkie\r\n                                    $i=1;                                \r\n                                    if ($is) {\r\n                                        ?><input id="left-menu-all" class="left-menu<?php if(!isset($_SESSION[''sub''])){echo '' active'';}?>" type="submit" name="leftmenu" value="Wszystkie" /><?php //dla kategorii\r\n                                    }\r\n                                    foreach ($sub->showSubAll() as $cat) {								\r\n                                        ?><input id="left-menu-<?php echo $i; $i++?>" class="left-menu<?php if(@$cat[''product_category_sub'']==@$_SESSION[''sub'']){echo '' active'';}?>" type="submit" name="leftmenu" value="<?php echo $cat[''product_category_sub'']; ?>" /><?php							\r\n                                    }\r\n                                }\r\n                                //------------------------------------------------\r\n                                //-category\r\n                                //------------------------------------------------\r\n                                elseif (isset($category_now_display)) {\r\n                                    if ($sub->showCategorySub($category_now_display)) {\r\n                                        $is = $sub->showCategorySub($category_now_display)->fetch(PDO::FETCH_ASSOC);//sprawdzam czy cos ma sub kategorie jesli tak to pokazuje button wszystkie\r\n                                        $i=1;                                \r\n                                        if ($is) {\r\n                                            ?><input id="left-menu-all" class="left-menu<?php if(!isset($_SESSION[''sub''])){echo '' active'';}?>" type="submit" name="leftmenu" value="Wszystkie" /><?php //dla home\r\n                                        }\r\n                                        foreach ($sub->showCategorySub($category_now_display) as $cat) {								\r\n                                            ?><input id="left-menu-<?php echo $i; $i++?>" class="left-menu<?php if(@$cat[''product_category_sub'']==@$_SESSION[''sub'']){echo '' active'';}?>" type="submit" name="leftmenu" value="<?php echo $cat[''product_category_sub'']; ?>" /><?php							\r\n                                        }\r\n                                    }\r\n                                    unset($sub);\r\n                                }\r\n                                //------------------------------------------------\r\n                                //-product card\r\n                                //------------------------------------------------\r\n                                elseif (isset($product_now_display) && !isset($_SESSION[''menu_id''])) {//dla karty towaru z home\r\n                                    ?><a class="leftmenu_a_button" href="../home/index.php">Powrót</a><?php \r\n                                } elseif (isset($product_now_display) && isset($_SESSION[''menu_id''])) {// dla karty towaru z kategorii   \r\n                                    ?><a class="leftmenu_a_button" href="../category/<?php echo $sub->__getCatMainFileName($product_now_display); ?>.php">Powrót</a><?php \r\n                                }\r\n                                //------------------------------------------------\r\n                            }\r\n							?>\r\n						</form>\r\n					</div>	\r\n				</div>	\r\n			</nav>\r\n			<div id="wrapper4">    \r\n                <script type="text/javascript">\r\n                    $(function(){\r\n                        /**\r\n                        * behawior when product-square basket-field click in home position\r\n                        **/\r\n                        // $( ''.basket-field'' ).click(function(e){//stop follow link when amount click\r\n                            // $( ''.square-link'' ).click(function(e){\r\n                                // e.preventDefault();\r\n                                // //alert(''sdf'');\r\n                                // //console.log(''a follow blocked'');\r\n                            // });\r\n                        // });\r\n                        $(".square-link").on(''click'', ''.basket-field.text'', function(e) {//stop follow link when amount click\r\n                            e.preventDefault();\r\n                            //console.log(''a follow blocked'');\r\n                        });\r\n                        // $(".square-link").on(''click'', ''.basket-field.button'', function(e) {//stop follow link when add click\r\n                            // e.preventDefault();\r\n                            // //console.log(''a follow blocked'');\r\n                        // });\r\n                        $(".basket-field.text").mousedown(function () { //set cursor on the end text input !important\r\n                            this.setSelectionRange(this.value.length, this.value.length);    \r\n                        });\r\n                    });\r\n                </script>\r\n                <?php\r\n                //echo $_SERVER[''PHP_SELF''];\r\n                //echo basename(__FILE__);\r\n                if (! isset($user_register) && ! isset($user_edit) && ! isset($user_basket)) {//co by nic nie wyswietlało kiedy wywołam register user edit albo basket\r\n                    //------------------------------------------------\r\n                    $show = new ProductDisplay();\r\n                    $show->__setTable(''product_tab'');\r\n                    //-index\r\n                    //------------------------------------------------\r\n                    if (! isset($category_now_display) && ! isset($product_now_display) && ! isset($_SESSION[''sub''])) {//all\r\n                        if ($show->showAll()) {\r\n                            foreach ($show->showAll() as $cat) {\r\n                                echo $show->showSquare($cat);\r\n                            }\r\n                        }\r\n                    } elseif (! isset($category_now_display) && ! isset($product_now_display) && isset($_SESSION[''sub''])) {//sub\r\n                        if ($show->showAllSub($_SESSION[''sub''])) {\r\n                            foreach ($show->showAllSub($_SESSION[''sub'']) as $cat) {\r\n                                echo $show->showSquare($cat);\r\n                            }\r\n                        }\r\n                    }\r\n                    //------------------------------------------------\r\n                    //-category\r\n                    //------------------------------------------------\r\n                    elseif (isset($category_now_display) && !isset($_SESSION[''sub''])) {//all\r\n                        if ($show->showAllCategory($category_now_display)) {\r\n                            foreach ($show->showAllCategory($category_now_display) as $cat) {\r\n                                echo $show->showSquare($cat);\r\n                            }					\r\n                        }\r\n                    } elseif (isset($category_now_display) && isset($_SESSION[''sub''])) {\r\n                        if ($show->showAllCategorySub($category_now_display, $_SESSION[''sub''])) {\r\n                            foreach ($show->showAllCategorySub($category_now_display, $_SESSION[''sub'']) as $cat) {\r\n                                echo $show->showSquare($cat);\r\n                            }					\r\n                        }\r\n                    }\r\n                    //------------------------------------------------\r\n                    //-product card\r\n                    //------------------------------------------------              \r\n                    elseif (isset($product_now_display)) {\r\n                        if ($show->showProduct($product_now_display)) {\r\n                            foreach ($show->showProduct($product_now_display) as $cat) {\r\n                                echo $show->showFullSquare($cat);\r\n                            }\r\n                        }\r\n                    }\r\n                //-user register\r\n                //------------------------------------------------\r\n                } elseif (isset($user_register) && ! isset($user_basket)  && ! isset($user_edit)) {\r\n                    if (isset($return)) {\r\n                        echo $return ? ''dodany'' : ''błąd'';\r\n                    }                    \r\n                    Connect_Form::registerForm();\r\n                //-user edit/update\r\n                //------------------------------------------------\r\n                } elseif (isset($user_edit) && ! isset($user_basket)  && ! isset($user_register)) {\r\n                    if (isset($return)) {\r\n                        echo $return ? ''wyedytowany'' : ''błąd'';\r\n                    }\r\n                    $asd = new Connect_Form;\r\n                    $asd->editForm($_SESSION[''user_id'']);\r\n                //-basket\r\n                //------------------------------------------------\r\n                } elseif (isset($user_basket) && ! isset($user_edit)  && ! isset($user_register)) {\r\n                    $obj_basket_show = new Connect_Basket;\r\n                    $foo = $obj_basket_show->basketGet($_SESSION[''user_id'']);\r\n                    if ($foo) {\r\n                        while ($row = $foo->fetch(PDO::FETCH_ASSOC)) {\r\n                            $obj_basket_show->basketShow($row[''id''], $row[''pr_id''], $row[''amount'']);\r\n                        }\r\n                    }\r\n                    $bar = $obj_basket_show->__getSumar();\r\n                    //var_dump($bar);                    \r\n                    $sumar = array_sum($bar);\r\n                    ?>\r\n                    <div class="bs-sq sumar">Do zapłaty: <?php echo $sumar; ?> PLN</div>\r\n                    <div class="bs-sq send">+ koszty przesyłki: <?php echo $send = 2; ?> PLN</div>\r\n                    <div class="bs-sq all">Razem: <?php echo $sumar+$send; ?> PLN</div>\r\n                    <form method="POST">                        \r\n                        <input class="basket-field button bs-sq drop" type="submit" name="basket_drop" value="Opróżnij koszyk" />\r\n                        <input class="basket-field button bs-sq pay" type="submit" name="basket_accept" value="Zapłać" />\r\n                    </form>\r\n                    <?php                    \r\n                }\r\n				?>\r\n            <!--\r\n			<br />\r\n			<br />\r\n			-->\r\n			</div>				\r\n		</div>		\r\n		<div>\r\n            <script type="text/javascript">\r\n            $(function(){\r\n                console.log($( ''body'' ).css( ''font-size'' ));\r\n            });\r\n            </script>\r\n			<h1 id="titi" >WELCOME TO MY GREAT WORLD OF PROGRAMMING</h1>	\r\n		</div>\r\n	</section>\r\n	<footer>\r\n	<!--<div id="count"></div><div id="count2"></div>-->\r\n	</footer>\r\n	<div id="debugger">\r\n	<?php\r\n	echo "post";\r\n	var_dump (@$_POST);\r\n	//echo "get";\r\n	//var_dump (@$_GET);\r\n	//echo "files";\r\n	//var_dump (@$_FILES);\r\n	echo "session";\r\n	var_dump (@$_SESSION);\r\n	echo "cookie";\r\n	var_dump (@$_COOKIE);\r\n    //unset($_SESSION);\r\n    //unset($_COOKIE);\r\n    //session_destroy();\r\n	?>\r\n	</div>\r\n<?php //html_p3 ?>', '<?php //html_p4 ?>\r\n</body>\r\n</html>\r\n<?php //html_p4 ?>');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `paczka w ruchu`
--

CREATE TABLE IF NOT EXISTS `paczka w ruchu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `configuration_mod` varchar(20) DEFAULT NULL,
  `weight_of` varchar(20) DEFAULT NULL,
  `weight_to` varchar(20) DEFAULT NULL,
  `price_of` varchar(20) DEFAULT NULL,
  `price_to` varchar(20) DEFAULT NULL,
  `package_share` varchar(20) DEFAULT NULL,
  `max_item_in_package` varchar(20) DEFAULT NULL,
  `allow_prepayment` varchar(20) DEFAULT NULL,
  `price_prepayment` varchar(20) DEFAULT NULL,
  `allow_ondelivery` varchar(20) DEFAULT NULL,
  `price_ondelivery` varchar(20) DEFAULT NULL,
  `free_of` varchar(20) DEFAULT NULL,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `paczka w ruchu`
--

INSERT INTO `paczka w ruchu` (`id`, `name`, `configuration_mod`, `weight_of`, `weight_to`, `price_of`, `price_to`, `package_share`, `max_item_in_package`, `allow_prepayment`, `price_prepayment`, `allow_ondelivery`, `price_ondelivery`, `free_of`, `mod`) VALUES
(1, 'Paczka w ruchu', 'price', '', '', '0', '500', 'yes', '', '', '12.99', 'yes', '15.99', '10000', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `poczta s.a`
--

CREATE TABLE IF NOT EXISTS `poczta s.a` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `configuration_mod` varchar(20) DEFAULT NULL,
  `weight_of` varchar(20) DEFAULT NULL,
  `weight_to` varchar(20) DEFAULT NULL,
  `price_of` varchar(20) DEFAULT NULL,
  `price_to` varchar(20) DEFAULT NULL,
  `package_share` varchar(20) DEFAULT NULL,
  `max_item_in_package` varchar(20) DEFAULT NULL,
  `allow_prepayment` varchar(20) DEFAULT NULL,
  `price_prepayment` varchar(20) DEFAULT NULL,
  `allow_ondelivery` varchar(20) DEFAULT NULL,
  `price_ondelivery` varchar(20) DEFAULT NULL,
  `free_of` varchar(20) DEFAULT NULL,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `poczta s.a`
--

INSERT INTO `poczta s.a` (`id`, `name`, `configuration_mod`, `weight_of`, `weight_to`, `price_of`, `price_to`, `package_share`, `max_item_in_package`, `allow_prepayment`, `price_prepayment`, `allow_ondelivery`, `price_ondelivery`, `free_of`, `mod`) VALUES
(1, 'Poczta S.A', 'simple', '', '', '', '', 'yes', '', '', '7,99', 'yes', '8,99', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_category_main`
--

CREATE TABLE IF NOT EXISTS `product_category_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_main` text,
  `file_name_category_main` text,
  `title` text,
  `description` text,
  `keywords` text,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Zrzut danych tabeli `product_category_main`
--

INSERT INTO `product_category_main` (`id`, `product_category_main`, `file_name_category_main`, `title`, `description`, `keywords`, `mod`) VALUES
(1, 'Eboki', 'Eboki', '', '', '', 0),
(2, 'Blu ray', 'Blu-ray', '', '', '', 0),
(3, 'PC', 'PC', 'PC Category Own Title', 'PC Category Own Description', 'PC,Category,Own,Keywords', 1),
(4, 'Digital', 'Digital', NULL, NULL, NULL, 0),
(5, 'PS 3', 'PS-3', NULL, NULL, NULL, 0),
(6, 'WII', 'WII', NULL, NULL, NULL, 0),
(7, 'XBOX', 'XBOX', NULL, NULL, NULL, 0),
(10, 'PSP', 'PSP', NULL, NULL, NULL, 0),
(14, 'Go Sport', 'Go-Sport', '', '', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_category_sub`
--

CREATE TABLE IF NOT EXISTS `product_category_sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_sub` text,
  `file_name_category_sub` text,
  `title` text,
  `description` text,
  `keywords` text,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Zrzut danych tabeli `product_category_sub`
--

INSERT INTO `product_category_sub` (`id`, `product_category_sub`, `file_name_category_sub`, `title`, `description`, `keywords`, `mod`) VALUES
(1, 'Strategiczne', 'Strategiczne', '', '', '', 0),
(2, 'Przygodowe', 'Przygodowe', NULL, NULL, NULL, 0),
(3, 'Akcji', 'Akcji', '', '', '', 0),
(4, 'Horror', 'Horror', NULL, NULL, NULL, 0),
(5, 'Wyścigi', 'Wyścigi', NULL, NULL, NULL, 0),
(6, 'Zręcznościowe', 'Zręcznościowe', NULL, NULL, NULL, 0),
(9, 'MMO', 'MMO', '', '', '', 0),
(10, 'RTS', 'RTS', '', '', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_tab`
--

CREATE TABLE IF NOT EXISTS `product_tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` text,
  `product_price` varchar(10) DEFAULT NULL,
  `amount` int(10) unsigned DEFAULT NULL,
  `product_category_main` text,
  `product_category_sub` text,
  `product_description_small` text,
  `product_description_large` text,
  `product_foto_mini` text,
  `product_foto_large` text,
  `file_name` text,
  `product_title` text,
  `product_description` text,
  `product_keywords` text,
  `mod` int(10) DEFAULT NULL,
  `shipping_mod` int(10) unsigned DEFAULT NULL,
  `predefined` varchar(50) DEFAULT NULL,
  `weight` int(100) unsigned DEFAULT NULL,
  `allow_prepaid` int(10) unsigned DEFAULT NULL,
  `price_prepaid` varchar(50) DEFAULT NULL,
  `allow_ondelivery` int(10) unsigned DEFAULT NULL,
  `price_ondelivery` varchar(50) DEFAULT NULL,
  `package_share` int(10) unsigned DEFAULT NULL,
  `max_item_in_package` int(100) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Zrzut danych tabeli `product_tab`
--

INSERT INTO `product_tab` (`id`, `product_name`, `product_price`, `amount`, `product_category_main`, `product_category_sub`, `product_description_small`, `product_description_large`, `product_foto_mini`, `product_foto_large`, `file_name`, `product_title`, `product_description`, `product_keywords`, `mod`, `shipping_mod`, `predefined`, `weight`, `allow_prepaid`, `price_prepaid`, `allow_ondelivery`, `price_ondelivery`, `package_share`, `max_item_in_package`) VALUES
(6, 'Mini Ninjas', '83.90', 10, 'XBOX', 'Zręcznościowe', 'Zręcznościowa gra walki. Jako młody ninja o imieniu Hiro musimy z pomocą wiernych towarzyszy wyplenić wszelkie zło z wirtualnego świata gry. Do zabawy wprowadzone zostały proste elementy charakterystyczne dla gatunku RPG. W trakcie rozgrywki drużyna głównego bohatera nieustannie podnosi swoje umiejętności.\r\n', 'Zręcznościowa gra walki. Jako młody ninja o imieniu Hiro musimy z pomocą wiernych towarzyszy wyplenić wszelkie zło z wirtualnego świata gry. Do zabawy wprowadzone zostały proste elementy charakterystyczne dla gatunku RPG. W trakcie rozgrywki drużyna głównego bohatera nieustannie podnosi swoje umiejętności.\r\n\r\nMini Ninjas to nowa gry akcji duńskiego studia deweloperskiego Io Interactive (seria Hitman, Kane & Lynch, Freedom Fighters). Wcielamy się w postać Hiro, będącego jednym z najmniejszych bohaterów ninja w historii elektronicznej rozrywki. Wyrusza on w najtrudniejszą misję jaką można sobie wyobrazić. Zadanie polega na przywróceniu pokoju i harmonii w świecie ogarniętym przez ciemne moce i nieustanny chaos. Hiro dokonuje tego wespół z dwoma najbardziej zaufanymi przyjaciółmi.\r\n\r\nPodróż przez starożytne krainy wojowników ninja zakończy ostateczna konfrontacja ze Złym Samurajem, zarządcą potężnej Twierdzy Zagłady. Wyprawa jest ciężka i zróżnicowana, a przy tym przepełniona humorem oraz kreskówkową oprawą graficzną.\r\n\r\nW trakcie rozgrywki drużyna głównego bohatera nieustannie podnosi swoje umiejętności. Do zabawy wprowadzone zostały zatem proste elementy charakterystyczne dla gatunku RPG. Hiro i spółka nie dość, że uzyskują dostęp do nowych ciosów, to jeszcze rozbudowują możliwości magiczne. Czary z katalogu magii Kuji nie jeden raz uratują ich z największych opresji - przydadzą się zarówno w walce ze zwykłymi przeciwnikami, jak i wielkimi bossami strzegącymi kluczowych lokacji.\r\n\r\nRozgrywce towarzyszy ładna i bardzo kolorowa, trójwymiarowa oprawa graficzna. Akcję obserwujemy zza pleców ', '0', '0', '6-Mini-Ninjas', 'Mini Ninjas XBOX - Zręcznościowe', 'Zręcznościowa gra walki. Jako młody ninja o imieniu Hiro musimy z pomocą wiernych towarzyszy wyplenić wszelkie zło z wirtualnego świata.', 'Mini,Ninjas,XBOX,Zręcznościowe', 1, 0, 'Paczka w ruchu', 10, 1, '15.00', 1, '20.00', 1, 10),
(7, 'Grand Theft Auto V', '160.99', 9, 'PC', 'Akcji', 'Opracowany przez twórców serii, studio Rockstar North, Grand Theft Auto V jest największym i najbardziej ambitnym dotychczasowym tytułem serii. ', 'Doceniony przez krytyków i bijący wszelkie rekordy otwarty świat Grand Theft Auto V wkracza na urządzenia nowej generacji.\r\n\r\n \r\n\r\nGrand Theft Auto V w pełni wykorzysta moc drzemiącą w PlayStation®4, Xbox One oraz PC. Ulepszenia są znaczne i dotyczą wyższej rozdzielczości, poziomu detali, natężenia ruchu ulicznego, dłuższego dystansu renderowania obiektów, zmian w sztucznej inteligencji, nowej fauny, wyglądu wody oraz efektów pogodowych i modelu zniszczeń.\r\n\r\n \r\n\r\nLos Santos to skąpana w słońcu i tętniąca życiem metropolia zamieszkana przez przeróżnej maści mentorów, psychoterapeutów, sławy wielkiego ekranu i blednące gwiazdki. Niegdyś to miejsce stanowiło obiekt zazdrości całego Zachodu, teraz z trudem walczy o utrzymanie swojego statusu w czasach gospodarczej niepewności i zalewu telewizyjnej taniochy. W tym tyglu trzech różnych kryminalistów spróbuje postawić wszystko na jedną kartę i wykonać skok, który odmieni ich życie.\r\n\r\n \r\n\r\nNajwiększy i najbardziej dynamiczny otwarty świat, jaki do tej pory stworzono, zostanie jeszcze bardziej dopracowany. Grand Theft Auto V łączy w sobie doskonałą fabułę i trzymającą w napięciu rozgrywkę, a gracze mogą swobodnie wcielać się w trójkę bohaterów i dzięki temu poznawać każdy niuans intrygującej opowieści.\r\n\r\n \r\n\r\nWraz z Grand Theft Auto V na urządzenia nowej generacji zawita także Grand Theft Auto Online, dynamiczny świat Grand Theft Auto pełen wielu możliwości. Zwiedzajcie przepastne tereny gry bądź pnijcie się po szczeblach przestępczej kariery i bierzcie wraz z innymi udział w akcjach, kupujcie posiadłości, pojazdy i ulepszenia postaci. Rywalizować można w tradycyjnych trybach gry oraz stworzonych i udostępnionych przez społeczność Grand Theft Auto akcjach.\r\n\r\n \r\n\r\nW dniu premiery na PlayStation®4, Xbox One oraz PC w Grand Theft Auto Online dostępna będzie cała opublikowana do tej pory zawartość oraz wszystkie możliwości rozgrywki, w tym nowe uzbrojenie, dziesiątki pojazdów, posiadłości i opcje zmiany wyglądu swojej postaci. Dodatkowo gracze będą mogli przenieść swoje obecne postacie z Grand Theft Auto Online na wybraną platformę PlayStation®4, Xbox One lub PC.', '0', '0', '7-Grand-Theft-Auto-V', '', '', '', 0, 0, 'Poczta S.A', 10, 0, '', 0, '', 0, 0),
(8, 'Far Cry 4', '379.90', 12, 'PC', 'Akcji', 'Kolejna część najlepiej ocenianej strzelaniny roku 2012. Far Cry 4 przeniesie nas do fikcyjnego miasteczka Kyrat położonego w Himalajach, rządzonego przez dyktatora o imieniu Pagan Min.', 'Far Cry 4 – EDYCJA KYRAT została stworzona dla wszystkich, którzy chcą jeszcze bardziej zagłębić się w świecie Kyratu. Edycja oferuje specjalne upominki dla kolekcjonerów oraz poszerza doświadczenia gracza za pomocą dodatków cyfrowych.\r\n\r\nZawartość to: 20cm figutka despoty Pagan Mina na tronie. Dziennik podróży, w którym możecie zapisywać własne przyody, Plakat propagandowy oraz mapa świata gry. Ponadto pakiet zawiera Odkupienie Hurka – 3 dodatkowe misje oraz nową broń – działko harpunnicze!', '0', '0', '8-Far-Cry-4', '', '', '', 0, 0, 'siódemka', 15, 1, '', 0, '', 0, 0),
(9, ' Broken Sword 5: Klątwa Węża', '84.99', 10, 'PC', 'Przygodowe', 'Paryż wiosną. W galerii rozlegają się strzały… Kradzież… morderstwo… i początek nowej, niezwykłej przygody Broken Sword.', 'Paryż wiosną. W galerii rozlegają się strzały… Kradzież… morderstwo… i początek nowej, niezwykłej przygody Broken Sword.\r\n\r\n \r\n\r\nStudio Revolution przedstawia najnowszą część klasycznej serii Broken Sword. Wcielając się w role nieustraszonego Amerykanina, George’a Stobbarta, i hardej francuskiej dziennikarki, Nico Collard, trafisz na trop skradzionego malowidła oraz morderczego spisku. Spisku, którego korzenie sięgają tajemnic starszych niż słowo pisane.\r\n\r\n \r\n\r\nCzy uda ci się odkryć tajemnicę Klątwy Węża? George i Nico, uzbrojeni jedynie w logikę, uczciwość oraz specyficzne poczucie humoru, ponownie muszą uchronić świat przed nadciągającą katastrofą.', '0', '0', '9-Broken-Sword-5-Klatwa-Weza', '', '', '', 0, 0, 'siódemka', 10, 0, '', 0, '', 0, 0),
(10, ' Sacred 3 First Edition', '179.99', 2, 'XBOX', 'Przygodowe', 'Droga do chwały wybrukowana jest ogromnymi niebezpieczeństwami. Sacred 3, kolejna część znanej serii, to zręcznościowa gra typu hack‘n’slash przeznaczona do wieloosobowej rozgrywki kooperacyjnej z udziałem do czterech graczy.', 'Premierowe wydanie gry Sacred 3 będzie dostępne w limitowanej, Pierwszej Edycji na wszystkie platformy. Edycja ta będzie zawierać klasę postaci Malakhim oraz fabularny dodatek, pt. „Podziemia”, w którym gracze będą mieli za zadanie przebić się na szczyt tajemniczej wieży, w której zmierzą się z Czarną Serafią, przeciwnikiem znanym z Sacred 2.\r\n\r\n \r\n\r\nDroga do chwały wybrukowana jest ogromnymi niebezpieczeństwami.\r\n\r\nSacred 3, kolejna część znanej serii, to zręcznościowa gra typu hack‘n’slash przeznaczona do wieloosobowej rozgrywki kooperacyjnej z udziałem do czterech graczy. W trakcie wojny o Ankarię wybierzesz tu bohaterów, którzy stoczą walkę z podnoszącym głowę złem.\r\n\r\nZagrasz postaciami takimi jak Safiri, Serafia, Ankaryjka, Khukuri, a także zupełnie nową klasą Malakhów. Stawisz czoła Grimmokom, potężnym bestiom, legionom najemników i nieumarłym magom – nie obejdzie się więc bez ulepszania broni oraz pancerza.\r\n\r\nOtrzymasz możliwość rozwinięcia umiejętności i talentów swojej postaci w wybranym kierunku oraz sprzymierzenia się z innymi graczami, by korzystać z potężnych zdolności oraz taktyk kooperacyjnych. Swobodnie dołączysz do rozgrywek innych graczy i opuścisz je zarówno w trybie offline (2 graczy), jak i online (4 graczy).\r\n\r\n \r\n\r\nZwycięstwo nasze, chwała moja.', '0', '0', '10-Sacred-3-First-Edition', '', '', '', 0, 0, 'siódemka', 10, 0, '', 0, '', 0, 0),
(11, ' Diablo III: Ultimate Evil Edition  PL', '129.90', 10, 'PS 3', 'Przygodowe', 'Ponad 13 milionów graczy stawiło czoła demonicznym hordom w Diablo III. Teraz twoja kolej, by dołączyć do krucjaty i zmierzyć się z wrogami krain śmiertelników. Wydanie Ultimate Evil Edition zawiera pełną wersję gry Diablo III oraz rozszerzenie Reaper of Souls. Szykuj się – nadciąga coś naprawdę straszliwego.', 'STAW CZOŁA ZŁU W OSTATECZNEJ POSTACI\r\n\r\n \r\n\r\nPonad 13 milionów graczy stawiło czoła demonicznym hordom w Diablo III. Teraz twoja kolej, by dołączyć do krucjaty i zmierzyć się z wrogami krain śmiertelników. Wydanie Ultimate Evil Edition zawiera pełną wersję gry Diablo III oraz rozszerzenie Reaper of Souls. Szykuj się – nadciąga coś naprawdę straszliwego.\r\n\r\n \r\n\r\n    Wezwij swoich sojuszników – Graj w pojedynkę lub skrzyknij znajomych i stwórz drużynę złożoną z nawet czterech bohaterów — grających lokalnie na jednym ekranie albo w sieci, za pośrednictwem usługi PlayStation Network lub Xbox Live.\r\n    Zostań legendarnym bohaterem – Wciel się w jednego z ostatnich obrońców ludzkości — krzyżowca, barbarzyńcę, szamana, mnicha, łowczynię demonów lub czarownicę — i rozwijaj swoją postać, zdobywając legendarne skarby oraz opanowując nowe, niszczycielskie moce i zdolności.\r\n    Przerwij demoniczne oblężenie – Siej spustoszenie w szeregach sług zła i poznaj fabułę Diablo III na przestrzeni wszystkich pięciu aktów; przemierzaj otwarty świat w trybie przygodowym lub poluj na pradawne demony i potwory, które czają się w mrocznych ostępach krain śmiertelników.\r\n', '0', '0', '11-Diablo-III-Ultimate-Evil-Edition--PL', '', '', '', 0, 0, 'siódemka', 10, 0, '', 0, '', 0, 0),
(12, ' Tales of Xilia 2 Edycji Kolekcjonerskiej Ludgera Kresnika', '389.99', 10, 'PS 3', 'Przygodowe', 'TALES OF XILLIA 2 przedstawia losy dwóch nowych bohaterów: Ludgera Kresnicka i Elle Marty rok po wydarzeniach z pierwszej części gry. Osią fabuły jest ich przepięknie animowana, pełna przygód i niezwykle dramatycznych wydarzeń epicka wyprawa w poszukiwaniu krainy Caanan. ', 'Edycja Kolekcjonerska Ludgera Kresnika składa się z:\r\n\r\n    Figurki Ludgera Kresnika\r\n    Gry TALES OF XILLIA 2\r\n    Artbooka TALES OF XILLIA 2\r\n    Repliki zegarka kieszonkowego\r\n    Specjalnego opakowania Edycji kolekcjonerskiej\r\n    Utworów muzycznych wybranych przez autorów gry\r\n    Metalowego pudełka z wizerunkiem Rollo\r\n\r\nTALES OF XILLIA 2 przedstawia losy dwóch nowych bohaterów: Ludgera Kresnicka i Elle Marty rok po wydarzeniach z pierwszej części gry. Osią fabuły jest ich przepięknie animowana, pełna  przygód i niezwykle dramatycznych wydarzeń epicka wyprawa w poszukiwaniu krainy Caanan.', '0', '0', '12-Tales-of-Xilia-2-Edycji-Kolekcjonerskiej-Ludgera-Kresnika', '', '', '', 0, 0, 'siódemka', 10, 0, '', 0, '', 0, 0),
(13, ' The Last of Us Remastered (PS4) PL', '199.90', 7, 'PS 3', 'Przygodowe', 'The Last of Us, zdobywca ponad 200 nagród w kategorii Gra Roku, został odświeżony specjalnie dla systemu PlayStation 4. Teraz tytuł w wersji Remastered oferuje wykorzystanie pełnego 1080p, modele postaci w wyższej rozdzielczości, udoskonalone cienie i oświetlenie, oraz szereg innych ulepszeń rozgrywki.', 'he Last of Us, zdobywca ponad 200 nagród w kategorii Gra Roku, został odświeżony specjalnie dla systemu PlayStation 4. Teraz tytuł w wersji Remastered oferuje wykorzystanie pełnego 1080p, modele postaci w wyższej rozdzielczości, udoskonalone cienie i oświetlenie, oraz szereg innych ulepszeń rozgrywki.\r\n\r\n \r\n\r\n20 lat po pandemii, która wyniszczyła znaną cywilizację, zainfekowani ludzie stają się coraz dziksi i bardziej krwiożerczy, zaś ocalałe resztki ludzkości zabijają się nawzajem dla żywności i broni, oraz wszystkiego, co mogą dostać w swoje ręce. Joel, agresywny niedobitek, jest zatrudniony do przeprowadzenia 14-letniej dziewczynki, Ellie, z surowej wojskowej strefy kwarantanny, ale to, co zaczyna się jako proste i krótkie zadanie, szybko przemienia się w wyczerpującą i straszną podróż po terytorium USA.\r\n\r\n \r\n\r\nThe Last of Us Remastered zawiera oprócz oryginalnej gry także dodatkowe mapy w trybie gry wieloosobowej, oraz niezwykle chwalony dodatkowy rozdział kampanii dla jednego gracza, The Last of Us: Left Behind, który łączy motywy przetrwania, lojalności oraz miłości z klimatyczną rozgrywką typu survival-action.\r\n\r\n \r\n\r\nCechy edycji Remastered:\r\n\r\n    Odkrywaj brutalny świat po strasznej pandemii, stworzony z wykorzystaniem pełnej mocy systemu PlayStation 4\r\n    Zawiera dodatkową zawartość:\r\n        Odkryj przeszłość Ellie w Left Behind, dodatkowym rozdziale poprzedzającym kampanię dla jednego gracza\r\n        Osiem nowych map trybu wieloosobowego\r\n    Filmowy komentarz przedstawiający kulisy powstawania tytułu, przygotowany przez twórców i aktorów\r\n', '0', '0', '13-The-Last-of-Us-Remastered-(PS4)-PL', '', '', '', 0, 0, 'siódemka', 10, 0, '', 0, '', 0, 0),
(14, 'Wiedźmin 3: Dziki Gon', '118.90', 10, 'PC', 'Przygodowe', 'Wiedźmin 3: Dziki Gon to trzecia odsłona popularnej serii cRPG opartej na prozie Andrzeja Sapkowskiego. Grę wyprodukowało studio CD Projekt RED, czyli zespół odpowiedzialny również za dwie poprzednie części.', 'Ponownie wcielamy się w znanego z poprzednich odsłon wiedźmina. Główna oś fabularna obraca się wokół kilku oddzielnych wątków. Wśród nich znalazło się poszukiwanie utraconej miłości Geralta oraz inwazja Nilfgaardu na królestwa północy. Spróbujemy też powstrzymać tytułowy Dziki Gon, prześladujący wiedźmina zarówno w powieściach, jak i obecny w pierwszej i w nikłym stopniu w drugiej części serii. Wszystkie te główne zadania oferują filmową jakość opowiadanej historii, z rozgałęzionymi ścieżkami wydarzeń, imponującymi scenkami przerywnikowymi i starannie wyreżyserowanymi sekwencjami. Co ciekawe, możemy porzucić część wątków, trzeba będzie jednak liczyć się z wynikającymi z tego faktu przykrymi konsekwencjami. Poza głównymi opowieściami dostępne jest także zatrzęsienie misji pobocznych, które w sumie starczają na ponad sto godzin zabawy. Autorzy zadbali o dużą różnorodność wyzwań. W trakcie przygód będziemy eksplorowali m.in. jaskinie, prastare ruiny i tętniące życiem wioski. Zapolujemy na potwory dla zysku oraz specjalnych nagród. Pojawią się również zadania oparte na dochodzeniach. Różne rejony świata oferują swoje własne mini gierki (np. zawody w rzucaniu nożami) ze specjalnymi nagrodami, choć jednocześnie ich ukończenie nigdy nie jest wymagane dla dalszego rozwoju fabuły.\r\n\r\nZgodnie z tradycją serii, trzeci Wiedźmin oferuje sporą swobodę odgrywania postaci, a fabuła jest mocno rozgałęziona, tak aby umożliwić graczom dokonywanie różnych wyborów. Jednocześnie wirtualny świat jest w dużym stopniu dynamiczny. Przykładowo, niektóre nasze akcje sprawią, że zagrożona przez ataki bandytów wioska kompletnie się wyludni. Gra posiada świat o otwartej strukturze, który jest czterdziestokrotnie bardziej rozległy niż ten w The Witcher 2: Assassins of Kings. Nowy silnik (REDengine 3) został zaprojektowany tak, aby cały czas ładował dane w tle, co pozwoliło uniknąć ekranów wczytywania. Przemieszczanie się ułatwia opcja jazdy na koniu. Przy dobrym rumaku dotarcie z jednego końca mapy na drugi zajmuje około 30-40 minut. Dostępna jest również opcja natychmiastowej podróży do miejsc wcześniej odwiedzonych.\r\n\r\nSpore zmiany zaszły w systemie walki. Kompletnie przebudowano sztuczną inteligencję przeciwników. Geralt otrzymał 96 animacji wykorzystywanych w starciach, podczas gdy w drugiej części miał ich jedynie 20. Gracze mogą wreszcie przerywać atak w jego trakcie oraz blokować ciosy i wykonywać uniki, nawet gdy zabraknie im kondycji, choć nie są one wtedy tak skuteczne. Zamiast przewrotów bohater wykonuje teraz szybkie piruety, aby zejść z linii ciosu przeciwnika. Nowy system kamery dba o zapewnienie czytelnej perspektywy podczas starć. Nie zabrakło starć z bossami (m.in. z lodowym gigantem), ale nie są one tym razem oskryptowane. Mocno przebudowano również system znaków. Każdy z pięciu ma podstawowy poziom, a wraz z rozwojem Geralta odblokujemy drugi stopień. Przykładowo, ulepszone Igni wywoła eksplozję ognia, która otoczy bohatera. Z kolei drugi poziom Ydren zamiast pułapki na jednego potwora stworzy duże pole, które spowolni wszystkich przebywających w nim nieprzyjaciół.\r\n\r\nPodczas starć wykorzystujemy również w dużym stopniu otoczenie. Np. możemy telekinetycznie uderzyć w ul os, które zaatakują wrogów. Natomiast gdy zwrócą się w naszą stronę spalimy je znakiem Igni. Poszerzanie zasobu wiedzy o przeciwnikach umożliwia poznanie ich słabych punktów. Niektóre pokonane monstra pozostawią po sobie niemożliwe do dostania w inny sposób składniki służące do przepisów alchemicznych i tworzenia nowych przedmiotów. Pozwolą również Geraltowi na rozwijanie własnego drzewka mutacji, zapewniającego dostęp do nowych mocy. Gracze mogą również rozwijać umiejętności szermiercze i alchemii.', '0', '0', '14-Wiedzmin-3-Dziki-Gon', '', '', '', 0, 0, 'siódemka', 10, 0, '', 0, '', 0, 0),
(15, 'Sacrilegium', '139.90', 10, 'PC', 'Przygodowe', 'Sacrilegium to przygodowa gra akcji w klimatach survival horroru, która opowiada o losach pewnej dziewczyny walczącej z potworami. ', 'W Sacrilegium wcielamy się w dwudziestoletnią Alex, mądrą, ładną i przyjazną studentkę z Kalifornii, która przy okazji jest adeptką sztuk walki. Dziewczyna wplątuje się w poważną intrygę związaną z objawieniem się złowrogich istot. To od niej zależą losy przyjaciół, a może i całego świata. Podczas tej przygody Alex musi poświęcić własną moralność i dokonać wielu trudnych wyborów, aby nie dać się pochłonąć ciemności.\r\n\r\nSacrilegium zabiera nas w prawdziwą podróż dokoła świata, bo rozgrywa się zarówno w San Francisco, jak i najodleglejszych zakątkach Europy. Przemierzając kolejne lokacje walczymy z przeciwnikami z piekła rodem – w tym z tajemniczymi istotami Moroi, które przypominają wyjątkowo potężną wersję wampirów. Bohaterka dysponuje szerokim wachlarzem zdolności bojowych, ale sama gra zawiera wiele motywów rodem z rasowych survival horrorów.', '0', '0', '15-Sacrilegium', '', '', '', 0, 0, 'siódemka', 10, 0, '', 0, '', 0, 0),
(16, 'Obcy: Izolacja PL Edycja Ripley + Artbook', '124.99', 4, 'PC', 'Horror', 'Odkryj prawdziwe znaczenie strachu w Alien: Isolation, survival horrorze, którego akcja toczy się w atmosferze ciągłego strachu i śmiertelnego zagrożenia.', 'Jak zamierzasz przetrwać?\r\n\r\n \r\n\r\nOdkryj prawdziwe znaczenie strachu w Obcy: Izolacja, survival horrorze, którego akcja toczy się w atmosferze ciągłego strachu i śmiertelnego zagrożenia. Piętnaście lat po wydarzeniach z Alien, córka Ellen Ripley, Amanda toczy desperacką walkę o przetrwanie, z misją poznania prawdy o zniknięciu matki. \r\n\r\n \r\n\r\nJako Amanda, będziesz poruszać się po coraz bardziej niestabilnym świecie będąc zmuszonym do konfrontacji ze wszystkich stron przez spanikowaną i zdesperowaną populację ludzi oraz nieprzewidywalnych, bezwzględnych Obcych.\r\n\r\n \r\n\r\nSłaby i niegotowy, będziesz zmuszony wyszukiwać zasoby, improwizować rozwiązania i użyć swego sprytu, aby nie tylko odnieść sukces w swojej misji, ale po prostu pozostać przy życiu.\r\n\r\n \r\n\r\nKluczowe cechy:\r\n\r\n    Pokonaj ciągle obecne, śmiertelne zagrożenie – Doświadcz ustawicznego lęku, gdy prawdziwie dynamiczny i reagujący Obcy wykorzystuje swoje zmysły polując na ciebie i reagując na każdy twój ruch.\r\n    Improwizuj, by przetrwać – Włamuj się do systemu, przeszukuj otoczenie w poszukiwaniu kluczowych zasobów i twórz przedmioty pomocne w poradzeniu sobie z każdym problemem. Czy będziesz unikać przeciwników, rozpraszać ich uwagę czy stawisz im czoła w otwartej walce?\r\n    Odkrywaj świat pełen tajemnic i zdrady – Zanurz się w szczegółowej scenerii Sewastopolu, wycofanej z użycia stacji handlowej na obrzeżach kosmosu. Natknij się na niezwykle zróżnicowaną grupę mieszkańców w świecie naznaczonym strachem i nieufnością.\r\n', '0', '0', '16-Obcy-Izolacja-PL-Edycja-Ripley--Artbook', '', '', '', 0, 0, 'siódemka', 10, 0, '', 0, '', 0, 0),
(26, 'magic man', '56.78', 10, 'Eboki', 'MMO', 'sxdsdfsddf', 'sdfsdafsdf', '0', '0', '26-magic-man', 'Mini Ninjas XBOX - Zręcznościowe', 'dfgsdfg', 'Mini,Ninjas,XBOX,Zręcznościowe', 1, 1, 'siódemka', 1, 1, '10', 1, '12', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `setting_gen`
--

CREATE TABLE IF NOT EXISTS `setting_gen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `background_mod` varchar(50) DEFAULT NULL,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `setting_gen`
--

INSERT INTO `setting_gen` (`id`, `background_mod`, `mod`) VALUES
(1, 'one', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `setting_img`
--

CREATE TABLE IF NOT EXISTS `setting_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `small_width` int(4) unsigned DEFAULT NULL,
  `small_height` int(4) unsigned DEFAULT NULL,
  `large_width` int(4) unsigned DEFAULT NULL,
  `large_height` int(4) unsigned DEFAULT NULL,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `setting_img`
--

INSERT INTO `setting_img` (`id`, `small_width`, `small_height`, `large_width`, `large_height`, `mod`) VALUES
(1, 200, 300, 700, 700, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `setting_seo`
--

CREATE TABLE IF NOT EXISTS `setting_seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `global_title_index` text,
  `global_keywords_index` text,
  `global_description_index` text,
  `global_title_category` text,
  `global_keywords_category` text,
  `global_description_category` text,
  `global_title_product` text,
  `global_keywords_product` text,
  `global_description_product` text,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `setting_seo`
--

INSERT INTO `setting_seo` (`id`, `global_title_index`, `global_keywords_index`, `global_description_index`, `global_title_category`, `global_keywords_category`, `global_description_category`, `global_title_product`, `global_keywords_product`, `global_description_product`, `mod`) VALUES
(1, 'Globalny tytuł strony głównej', 'globalne,słowa,keywords,strony,głównej', 'Globalny opis strony głównej dodać max znaków', 'Globalny tytuł strony kategorii', 'globalne,słowa,keywords,strony,kategorii', 'Globalny opis strony kategorii dodać max znaków', 'Globalny tytuł strony towaru', 'globalne,słowa,keywords,strony,towaru', 'Globalny opis strony towaru dodać max znaków', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `siódemka`
--

CREATE TABLE IF NOT EXISTS `siódemka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `configuration_mod` varchar(20) DEFAULT NULL,
  `weight_of` varchar(20) DEFAULT NULL,
  `weight_to` varchar(20) DEFAULT NULL,
  `price_of` varchar(20) DEFAULT NULL,
  `price_to` varchar(20) DEFAULT NULL,
  `package_share` varchar(20) DEFAULT NULL,
  `max_item_in_package` varchar(20) DEFAULT NULL,
  `allow_prepayment` varchar(20) DEFAULT NULL,
  `price_prepayment` varchar(20) DEFAULT NULL,
  `allow_ondelivery` varchar(20) DEFAULT NULL,
  `price_ondelivery` varchar(20) DEFAULT NULL,
  `free_of` varchar(20) DEFAULT NULL,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Zrzut danych tabeli `siódemka`
--

INSERT INTO `siódemka` (`id`, `name`, `configuration_mod`, `weight_of`, `weight_to`, `price_of`, `price_to`, `package_share`, `max_item_in_package`, `allow_prepayment`, `price_prepayment`, `allow_ondelivery`, `price_ondelivery`, `free_of`, `mod`) VALUES
(3, 'siódemka', 'weight', '1', '2', '', '', 'no', '10', '', '15.00', 'yes', '25.00', '300', 0),
(4, 'siódemka', 'weight', '3', '4', '', '', 'no', '20', '', '30', 'yes', '35', '400', 0),
(5, 'siódemka', 'price', '', '', '0', '1000', 'no', '12', '', '12', 'yes', '15', '500', 0),
(6, 'siódemka', 'weight', '5', '10', '', '', 'yes', '', '', '9,99', 'yes', '14,99', '600', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(20) DEFAULT NULL,
  `mod` int(10) DEFAULT NULL,
  `supplier_name_d` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supplier_name` (`supplier_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_name`, `mod`, `supplier_name_d`) VALUES
(1, 'siódemka', NULL, 'siódemka'),
(2, 'paczka w ruchu', NULL, 'Paczka w ruchu'),
(3, 'poczta s.a', NULL, 'Poczta S.A.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `create_data` datetime NOT NULL,
  `update_data` datetime NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `town` varchar(50) NOT NULL,
  `post_code` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `active` varchar(50) NOT NULL,
  `pref` varchar(50) NOT NULL,
  `mod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `create_data`, `update_data`, `first_name`, `last_name`, `phone`, `country`, `town`, `post_code`, `street`, `active`, `pref`, `mod`) VALUES
(1, 'user', 'user', 'user@gmail.com', '2014-12-10 21:23:41', '2014-12-10 21:23:41', 'Piotr', 'Szpanelewski', '888958277', 'Polska', 'Częstochowa', '42-200', 'Garibaldiego 16 m. 23', '', '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
