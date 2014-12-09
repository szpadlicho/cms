<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include_once 'setting_category_class.php';
/**/
$produkt = new CategorySetCls();
if (isset($_POST['save_main'])) {
	$produkt->__setTable('product_category_main');
	$produkt->createREC($_POST['product_add_category_main'],'file_name_category_main');
    $produkt->createFile($_POST['product_add_category_main']);//tu
}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Kategoria</title>
	<?php include ('meta5.html'); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
	<section id="place-holder">
		<nav>		
			<?php include ('backroom-top-menu.php'); ?>
		</nav>
        <!--NEW-->
		<div class="back-main-placeholder">
            <form enctype="multipart/form-data" action="" method="POST" >
                <!--MAIN-->
                <table class="back-main-table table-category">
                    <tr>
                        <th>Nazwa Kategorii w górnym Menu</th>
                        <td>
                            <input id="" class="back-main-text" type="text" name="product_add_category_main" />
                        </td>
                    </tr>
                    <tr>
                        <th>Zapis</th>
                        <td>
                            <input id="" class="back-main-submit" type="submit" name="save_main" value="Dodaj" />
                        </td>
                    </tr>
                    <tr>
                        <th>Ustawienia dla SEO</th>
                        <td>
                            <input id="" class="back-main-radio seo-radio" type="radio" name="seo_setting" checked="checked" value="title-n_false" />Użyj globalnych ustawień.<br />
                            <input id="" class="back-main-radio seo-radio" type="radio" name="seo_setting" value="title-n_true" />Użyj własnych ustawień (zalecane).
                        </td>
                    </tr>
                </table>
                <table id="seo-table-new" class="back-main-table table-category">                              
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('input[type="radio"]').each(function() { 
                                $(this).change(function(){
                                    if( $('input[value="title-n_true"]').is(":checked") ) {
                                        $('#seo-table-new').css({'display':'table'});
                                        $('input.seo-n-text').removeAttr("disabled");
                                    } else {
                                        $('input.seo-n-text').attr("disabled", "disabled");
                                        $('#seo-table-new').css({'display':'none'});
                                    }
                                });
                            });
                        });
                        $(window).load(function() {
                            $('input[type="radio"]').each(function() { 
                                if( $('input[value="title-n_true"]').is(":checked") ) {
                                    $('#seo-table-new').css({'display':'table'});
                                    $('input.seo-n-text').removeAttr("disabled");
                                } else {
                                    $('input.seo-n-text').attr("disabled", "disabled");
                                    $('#seo-table-new').css({'display':'none'});
                                }
                            }); 
                        });
                    </script>  
                    <tr>
                        <th>Title</th>
                        <th>Max. około 70 znaków</th>
                    </tr>  
                    <tr>
                        <td colspan="2">
                            <input id="" class="back-main-text seo-n-text" type="text" name="title" />
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <th>Max. około 200 znaków</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input id="" class="back-main-text seo-n-text" type="text" name="description" />
                        </td>
                    </tr>
                    <tr>
                        <th>Keywords</th>
                        <th>Max. około 200 znaków</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input id="" class="back-main-text seo-n-text" type="text" name="keywords" />
                        </td>
                    </tr>
                </table>
            </form>
		</div>
	</section>
	<footer>
	<!--<div id="count"></div><div id="count2"></div>-->
	</footer>
	<div id="debugger">
		<?php
		echo "post";
		var_dump (@$_POST);
		//echo "session";
		//var_dump ($_SESSION);
		// echo "files";
		// var_dump (@$_FILES);
		// echo "var2";
		//var_dump ($produkt->showCategory());	
		//echo "cookies";
		//var_dump ($_COOKIE);
		?>
	</div>
</body>
</html>
