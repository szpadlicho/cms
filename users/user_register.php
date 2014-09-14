<?php
include_once '../classes/connect/load.php';
$load = new Connect_Load;
$load->__setTable('index_pieces');
$q = $load->loadIndex();
//--
eval('?>'.$q['php_beafor_html'].'<?php ');
//--PHP
unset($_SESSION['menu_id']);
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
$user_register = true;//znika cale wyświetlanie z index
eval('?>'.$q['html_p3'].'<?php ');
eval('?>'.$q['html_p4'].'<?php ');
?>