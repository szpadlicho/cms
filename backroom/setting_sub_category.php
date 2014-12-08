<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
echo '<div class="catch">';
include_once 'setting_category_class.php';
/**/
$produkt = new CategorySetCls();
if (isset($_POST['save_sub'])) {
	$produkt->__setTable('product_category_sub');
	$produkt->createREC($_POST['product_add_category_sub'],'file_name_category_sub');
}
if (isset($_POST['delete_rec_sub'])) {
	$produkt->__setTable('product_category_sub');
	$produkt->deleteREC($_POST['hidden_old_rec_sub']);
}
if (isset($_POST['ok_sub'])) {
	$produkt->__setTable('product_category_sub');
	$produkt->updateREC($_POST['update_txt'],$_POST['hidden_old_rec_sub'],'file_name_category_sub');
    //set change on product tab
    $produkt->__setTable('product_tab');
    $produkt->updateAllRecProductTab($_POST['update_txt'],$_POST['hidden_old_rec_sub'],'product_category_sub');  
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
                <!--SUB-->
                <table class="table-bck table-category">	
                    <tr>
                        <th>Nazwa Podkategorii Lewe Menu</th>
                        <th>Zapis</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="text-cls" type="text" name="product_add_category_sub" />
                        </td>
                        <td>
                            <input id="" class="submit-cls" type="submit" name="save_sub" value="Dodaj" />
                        </td>
                    </tr>
                </table>
            </form>
		</div>
        <!--EDIT-->
        <!--SUB-->
		<div>
		<?php
		$produkt->__setTable('product_category_sub');//tabelke juz bedzie mial trzeba ustalic z gory w install jak bedzie sie nazywala tabelka z produktami
		if ($produkt->showCategory()) { ?>
            <table class="table-bck table-category">
            <?php foreach ($produkt->showCategory() as $cat) { ?>			
				<form enctype="multipart/form-data" action="" method="POST" >
                    <tr>
                        <td>
                            <?php echo $cat['id']; ?>
                        </td>
                        <td>
                        	<script type="text/javascript">
                                $(document).ready(function(){
                                    $('.ok').css({'display':'none'});
                                    $('input.up-sub-sub<?php echo $cat['id']; ?>').click(function() {
                                        $('input#sub<?php echo $cat['id']; ?>').removeAttr('disabled');
                                        $('#ok-sub<?php echo $cat['id']; ?>').css({'display':'inline'});
                                        $('#anuluj-sub<?php echo $cat['id']; ?>').css({'display':'inline'});
                                    });
                                });
                            </script>
                            <input id="sub<?php echo $cat['id']; ?>" type="text" name="update_txt" value="<?php echo $cat['product_category_sub']; ?>" disabled="disabled" />                     
                            <input id="ok-sub<?php echo $cat['id']; ?>" class="ok" type="submit" name="ok_sub" value="OK"/>                      
                            <input id="anuluj-sub<?php echo $cat['id']; ?>" class="ok" type="submit" name="anuluj" value="Anuluj"/> 
                        </td>
                        <td>
                            <input id="" class="up-sub-sub<?php echo $cat['id']; ?>" type="button" name="update_rec_sub" value="Edytuj" />
                            <!--<input id="" class="" type="hidden" name="update_hidden_old_rec_sub" value="<?php //echo $cat['product_category_sub']; ?>" />-->
                        </td>
                        <td>
                            <input id="" class="" type="submit" name="delete_rec_sub" value="Usuń" />
                            <input id="" class="" type="hidden" name="hidden_old_rec_sub" value="<?php echo $cat['product_category_sub']; ?>" />
                        </td>
                    </tr>
                </form>
			<?php } ?>
            </table>
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