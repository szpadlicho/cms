<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
echo '<div class="catch">';
include_once 'setting_category_class.php';
/**/
$produkt = new CategorySetCls();
if (isset($_POST['save_main'])) {
	$produkt->__setTable('product_category_main');
	$produkt->createREC($_POST['product_add_category_main'],'file_name_category_main');
    $produkt->createFile($_POST['product_add_category_main']);//tu
}
if (isset($_POST['delete_rec_main'])) {
	$produkt->__setTable('product_category_main');
	$produkt->deleteREC($_POST['hidden_old_rec_main']);
    $produkt->deleteFile($_POST['hidden_old_rec_main']);
}
if (isset($_POST['ok_main'])) {    
	$produkt->__setTable('product_category_main');
    $produkt->deleteFile($_POST['hidden_old_rec_main']);
	$produkt->updateREC($_POST['update_txt'],$_POST['hidden_old_rec_main'],'file_name_category_main');
    $produkt->createFile($_POST['update_txt']);//tu
    //set change on product tab
    $produkt->__setTable('product_tab');
    $produkt->updateAllRecProductTab($_POST['update_txt'],$_POST['hidden_old_rec_main'],'product_category_main');
}
echo '</div>';
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
		<div>
            <form enctype="multipart/form-data" action="" method="POST" >
                <!--MAIN-->
                <table class="table-bck table-category">
                    <tr>
                        <th>Nazwa Kategorii w górnym Menu</th>
                        <th>Zapis</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls" type="text" name="product_add_category_main" />
                        </td>
                        <td>
                            <input id="" class="submit-cls" type="submit" name="save_main" value="Dodaj" />
                        </td>
                    </tr>
                    <tr>
                        <th>Ustawienia dla SEO</th>
                        <td>
                            <input id="" class="seo-radio" type="radio" name="seo_setting" checked="checked" value="title-n_false" />Użyj globalnych ustawień.<br />
                            <input id="" class="seo-radio" type="radio" name="seo_setting" value="title-n_true" />Użyj własnych ustawień (zalecane).
                        </td>
                    </tr>
                </table>
                <table id="seo-table-new" class="table-bck table-category">                              
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
                            <input id="" class="text-cls seo-n-text" type="text" name="title" />
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <th>Max. około 200 znaków</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input id="" class="text-cls seo-n-text" type="text" name="description" />
                        </td>
                    </tr>
                    <tr>
                        <th>Keywords</th>
                        <th>Max. około 200 znaków</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input id="" class="text-cls seo-n-text" type="text" name="keywords" />
                        </td>
                    </tr>
                </table>
            </form>
		</div>
        <!--EDIT-->
        <!--MAIN-->  
		<div>
		<?php
		$produkt->__setTable('product_category_main');//tabelke juz bedzie mial trzeba ustalic z gory w install jak bedzie sie nazywala tabelka z produktami
		if ($produkt->showCategory()) { ?>   
            <?php foreach ($produkt->showCategory() as $cat) { ?>
                <form enctype="multipart/form-data" action="" method="POST" >
                    <table class="table-bck table-category">                    
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('.ok').css({'display':'none'});                                    
                                $('input.up-sub-main<?php echo $cat['id']; ?>').click(function() {
                                    $('input#main<?php echo $cat['id']; ?>').removeAttr('disabled');
                                    $('#ok-main<?php echo $cat['id']; ?>').css({'display':'inline'});
                                    $('#anuluj-main<?php echo $cat['id']; ?>').css({'display':'inline'});
                                    $('#seo-table-edit-<?php echo $cat['id']; ?>').css({'display':'table'});
                                    //change
                                    $('input.up-sub-main<?php echo $cat['id']; ?>').css({'display':'none'});
                                    $('input.delete-main<?php echo $cat['id']; ?>').css({'display':'none'});
                                    
                                });
                            });
                        </script>
                        <tr>
                            <td>
                                <?php echo $cat['id']; ?>
                            </td>
                            <td>
                                <input id="main<?php echo $cat['id']; ?>" class="text-cls" type="text" name="update_txt" value="<?php echo $cat['product_category_main']; ?>" disabled="disabled" />
                                                            
                            </td>
                            <td>
                                <input id="" class="up-sub-main<?php echo $cat['id']; ?>" type="button" name="update_rec_main" value="Edytuj" />
                                <input id="" class="delete-main<?php echo $cat['id']; ?>" type="submit" name="delete_rec_main" value="Usuń" />
                                <!--change-->
                                <input id="ok-main<?php echo $cat['id']; ?>" class="ok" type="submit" name="ok_main" value="OK"/>
                                <input id="anuluj-main<?php echo $cat['id']; ?>" class="ok" type="submit" name="anuluj" value="Anuluj"/>
                                <!--old-->
                                <input id="" class="" type="hidden" name="hidden_old_rec_main" value="<?php echo $cat['product_category_main']; ?>" />
                            </td>
                        </tr>
                    </table>       
                    <table id="seo-table-edit-<?php echo $cat['id']; ?>" class="table-bck table-category seo-table-edit">
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('.seo-table-edit').css({'display':'none'});
                                $('input[type="radio"]').each(function() { 
                                    $(this).change(function(){
                                        if( $('input[value="title_true-<?php echo $cat['id']; ?>"]').is(":checked") ) {
                                            $('input.seo-e-text-<?php echo $cat['id']; ?>').removeAttr("disabled");
                                            //alert('im here1');
                                        } else {
                                            $('input.seo-e-text-<?php echo $cat['id']; ?>').attr("disabled", "disabled");
                                            //alert('im here2');
                                        }
                                    });
                                });
                            });
                            $(window).load(function() {
                                $('input[type="radio"]').each(function() { 
                                    if( $('input[value="title_true-<?php echo $cat['id']; ?>"]').is(":checked") ) {
                                        $('input.seo-e-text-<?php echo $cat['id']; ?>').removeAttr("disabled");
                                        //alert('im here3');
                                    } else {
                                        $('input.seo-e-text-<?php echo $cat['id']; ?>').attr("disabled", "disabled");
                                        //alert('im here4');
                                    }
                                }); 
                            });
                        </script>
                        <tr>
                            <th>Ustawienia dla SEO</th>
                            <td>
                                <input id="" class="seo-radio" type="radio" name="seo_setting" <?php echo $cat['mod']==0 ? 'checked="checked"' : '' ; ?> value="title_false" />Użyj globalnych ustawień.<br />
                                <input id="" class="seo-radio" type="radio" name="seo_setting" <?php echo $cat['mod']==1 ? 'checked="checked"' : '' ; ?> value="title_true-<?php echo $cat['id']; ?>" />Użyj własnych ustawień (zalecane).
                            </td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <th>Max. około 70 znaków</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="" class="text-cls seo-e-text-<?php echo $cat['id']; ?>" type="text" name="title" value="<?php echo $cat['title']!=null ? $cat['title'] : 'brak' ; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <th>Max. około 200 znaków</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="" class="text-cls seo-e-text-<?php echo $cat['id']; ?>" type="text" name="description" value="<?php echo $cat['description']!=null ? $cat['description'] : 'brak' ; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th>Keywords</th>
                            <th>Max. około 200 znaków</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="" class="text-cls seo-e-text-<?php echo $cat['id']; ?>" type="text" name="keywords" value="<?php echo $cat['keywords']!=null ? $cat['keywords'] : 'brak' ; ?>" />
                            </td>
                        </tr>
                    </table>
                </form>
			<?php } ?>
		<?php } ?>
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
