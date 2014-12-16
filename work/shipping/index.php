<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
class ShippingSetCls
{

}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Koszty dostaw</title>
	<?php include ("../backroom/meta5.html"); ?>
    <link href="../upload/uploadfile.css" rel="stylesheet">    
    <script src="../upload/jquery.uploadfile.js"></script>
</head>
<body>
	<section id="place-holder">				
		<?php include ('../backroom/backroom-top-menu.php'); ?>
		<div class="back-shipping-placeholder">
            <form enctype="multipart/form-data" action="" method="POST" >
                <table class="back-shipping-table">
                    <tr>
                        <th>nazwa</th>
                        <th>cena</th>
                        <th>waga od</th>
                        <th>waga do</th>
                        <th>dziel na paczki</th>
                        <th>tryb konfiguracji</th>
                        <th>dopuszczac za pobraniem</th>
                        <th>doplata do pobrania</th>
                        <th>darmowa od</th>
                        <th>
                            <label><input id="" class="back-shipping-radio seo-radio" type="radio" name="shipping" checked="checked" value="title_false" /></label>
                            <label><input id="" class="back-shipping-radio seo-radio" type="radio" name="shipping" value="title_true" /></label>
                        </th>
                    </tr>
                    <tr>
                        <td><input id="" class="back-shipping-text" type="text" name="shipping" /></td>
                        <td><input id="" class="back-shipping-text" type="text" name="shipping" /></td>
                        <td><input id="" class="back-shipping-text" type="text" name="shipping" /></td>
                        <td><input id="" class="back-shipping-text" type="text" name="shipping" /></td>
                        <td>
                            <select class="back-shipping-select" name="shipping">
                                <option>Tak</option>
                                <option>Nie</option>
                            </select>
                        </td>
                        <td>
                            <select class="back-shipping-select" name="shipping">
                                <option>Prosty</option>
                                <option>Przedzialy wagowe</option>
                                <option>Przedzialy kwotowe</option>
                            </select>
                        </td>
                        <td>
                            <select class="back-shipping-select" name="shipping">
                                <option>Tak</option>
                                <option>Nie</option>
                            </select>
                        </td>
                        <td><input id="" class="back-shipping-text" type="text" name="shipping" /></td>
                        <td><input id="" class="back-shipping-text" type="text" name="shipping" /></td>
                        <td><input id="" class="back-shipping-text" type="text" name="shipping" /></td>
                    </tr>
                    <tr>
                        <td colspan="5"><input id="" class="back-shipping-submit" type="submit" name="save" value="Zapisz" /></td>
                        <td colspan="5"><input id="" class="back-shipping-submit" type="submit" name="cancel" value="Anuluj" /></td>
                    </tr>
                </table>
            </form>
		</div>
	</section>
	<footer></footer>
    <div class="catch">
        <?php
            if (isset($success)) {
                //echo 'isset';
                if ($success == true) {
                    echo 'Zapis udany';
                } else {
                    echo 'Błąd';
                }
            }
        ?>
    </div>
	<div id="debugger">
		<?php
		echo "post";
		var_dump (@$_POST);
		//echo "session";
		//var_dump ($_SESSION);
		// echo "files";
		// var_dump (@$_FILES);
		// echo "var2";
		 // var_dump ($var2);	
		//echo "cookies";
		//var_dump ($_COOKIE);
		?>
	</div>
</body>
</html>
