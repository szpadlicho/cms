<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
include_once 'setting_category_class.php';
/**/
$produkt = new CategorySetCls();
if (isset($_POST['save_sub'])) {
	$produkt->__setTable('product_category_sub');
	$produkt->createREC($_POST['product_add_category_sub'],'file_name_category_sub');
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
		<div class="back-sub-placeholder">
            <form enctype="multipart/form-data" action="" method="POST" >
                <!--SUB-->
                <table class="back-sub-table table-category">	
                    <tr>
                        <th>Nazwa Podkategorii Lewe Menu</th>
                        <th>Zapis</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="" class="back-sub-text" type="text" name="product_add_category_sub" />
                        </td>
                        <td>
                            <input id="" class="back-sub-submit" type="submit" name="save_sub" value="Dodaj" />
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