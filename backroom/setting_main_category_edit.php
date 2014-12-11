<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include_once 'setting_category_class.php';
/**/
$produkt = new CategorySetCls();
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
        <!--EDIT-->
        <!-- MAIN -->  
		<div class="back-all main placeholder">
		<?php
		$produkt->__setTable('product_category_main');//tabelke juz bedzie mial trzeba ustalic z gory w install jak bedzie sie nazywala tabelka z produktami
		if ($produkt->showCategory()) { ?>   
            <?php foreach ($produkt->showCategory() as $cat) { ?>
                <form enctype="multipart/form-data" action="" method="POST" >
                    <table class="back-all main table table-category">                    
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('.ok').css({'display':'none'});                                   
                                $('.cancel').css({'display':'none'});                                   
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
                                <input id="main<?php echo $cat['id']; ?>" class="back-all main text" type="text" name="update_txt" value="<?php echo $cat['product_category_main']; ?>" disabled="disabled" />
                                                            
                            </td>
                            <td>
                                <input class="back-all main submit up-sub-main<?php echo $cat['id']; ?>" type="button" name="update_rec_main" value="Edytuj" />
                                <input class="back-all main submit delete-main<?php echo $cat['id']; ?>" type="submit" name="delete_rec_main" value="Usuń" />
                                <!--change-->
                                <input id="ok-main<?php echo $cat['id']; ?>" class="back-all main submit ok" type="submit" name="ok_main" value="OK"/>
                                <input id="anuluj-main<?php echo $cat['id']; ?>" class="back-all main submit cancel" type="submit" name="anuluj" value="Anuluj"/>
                                <!--old-->
                                <input type="hidden" name="hidden_old_rec_main" value="<?php echo $cat['product_category_main']; ?>" />
                            </td>
                        </tr>
                    </table>       
                    <table id="seo-table-edit-<?php echo $cat['id']; ?>" class="back-all main table table-category seo-table-edit">
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
                                <input class="back-all main radio seo-radio" type="radio" name="seo_setting" <?php echo $cat['mod']==0 ? 'checked="checked"' : '' ; ?> value="title_false" />Użyj globalnych ustawień.<br />
                                <input class="back-all main radio seo-radio" type="radio" name="seo_setting" <?php echo $cat['mod']==1 ? 'checked="checked"' : '' ; ?> value="title_true-<?php echo $cat['id']; ?>" />Użyj własnych ustawień (zalecane).
                            </td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <th>Max. około 70 znaków</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="back-all main text seo-e-text-<?php echo $cat['id']; ?>" type="text" name="title" value="<?php echo $cat['title']!=null ? $cat['title'] : 'brak' ; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <th>Max. około 200 znaków</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="back-all main text seo-e-text-<?php echo $cat['id']; ?>" type="text" name="description" value="<?php echo $cat['description']!=null ? $cat['description'] : 'brak' ; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th>Keywords</th>
                            <th>Max. około 200 znaków</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="back-all main text seo-e-text-<?php echo $cat['id']; ?>" type="text" name="keywords" value="<?php echo $cat['keywords']!=null ? $cat['keywords'] : 'brak' ; ?>" />
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
