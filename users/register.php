<?php
include_once '../classes/connect/load.php';
$load = new Connect_Load;
$load->__setTable('index_pieces');
$q = $load->loadIndex();
//--
eval('?>'.$q['php_beafor_html'].'<?php ');
unset($_SESSION['menu_id']);
//--PHP
class Register
{
    static function registerForm()
    {
    ?>
        <form method="POST">
            <div class="full-square">
                <p>Account</p>
                <div class="line"></div>
                <div class="inline" ><span class="">Login:</span><input id="" class="register-field text" type="text" name="login" value="user" />*</div>
                <div class="inline" ><span class="">Adres email:</span><input id="" class="register-field text" type="text" name="email" value="user@gmail.com" />*</div>
                <div class="inline" ><span class="">Powtórz adres email:</span><input id="" class="register-field text" type="text" name="email" value="user@gmail.com" />*</div>
                <div class="inline" ><span class="">Hasło:</span><input id="" class="register-field text" type="text" name="user" value="user" />*</div>
                <div class="inline" ><span class="">Powtórz hasło:</span><input id="" class="register-field text" type="text" name="user" value="user" />*</div>
                <p>Personal info</p>
                <div class="line"></div>
                <div class="inline" ><span class="">Imię:</span><input id="" class="register-field text" type="text" name="first_name" value="Piotr" />*</div>
                <div class="inline" ><span class="">Nazwisko:</span><input id="" class="register-field text" type="text" name="last_name" value="Szpanelewski" />*</div>
                <div class="inline" ><span class="">Telefon:</span><input id="" class="register-field text" type="text" name="phone" value="888958277" />*</div>
                <div class="inline" ><span class="">Miasto:</span><input id="" class="register-field text" type="text" name="town" value="Częstochowa" />*</div>
                <div class="inline" ><span class="">Kod pocztowy:</span><input id="" class="register-field text" type="text" name="post_code" value="42-200" />*</div>
                <div class="inline" ><span class="">Ulica i nr domu:</span><input id="" class="register-field text" type="text" name="street" value="Garibaldiego 16 m. 23" />*</div>
                <p>Confirm</p>
                <div class="line"></div>
                <div class="inline" ><span class=""></span><input id="" class="register-field button" type="submit" name="" value="Zapisz" /></div>
            </div>
        </form>
    <?php
    }
}
//--PHP
eval('?>'.$q['html_p1'].'<?php ');
//--
$load->__setTable('setting_seo');
$global = $load->globalMetaData();
//--
echo '<title>'.$global['global_title_category'].'</title>';
echo '<meta name="description" content="'.$global['global_description_category'].'" />';
echo '<meta name="keywords" content="'.$global['global_keywords_category'].'" />';
//---
eval('?>'.$q['head_include'].'<?php ');
eval('?>'.$q['head_p1'].'<?php ');
eval('?>'.$q['html_p2'].'<?php ');
//here
$register = true;//znika cale wyświetlanie z index
eval('?>'.$q['html_p3'].'<?php ');
eval('?>'.$q['html_p4'].'<?php ');
?>