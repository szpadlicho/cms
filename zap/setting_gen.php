<?php
include_once('../classes/connect/general.php');
$cls_gen = new Connect_General;
$cls_gen->__setTable('setting_gen');
if (isset($_POST['save'])) {
    $arr_val= array('background_mod' => $_POST['radio_bg']);
    $cls_gen->__setRow($arr_val, 1);
    //setcookie("TestCookie", 'asd', time()+3600);    
}
$get = $cls_gen->__getRow(1);
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Edycja</title>
	<?php include ("meta5.html"); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
	<section id="place-holder">
		<?php include ('menu_zap.php'); ?>
        <div>
            <form method="POST">
            <table class="table-bck">
                <tr>
                    <th colspan="2">Background:</th>
                </tr>
                <tr>
                    <td>Static: </td>
                    <td><input type="radio" name="radio_bg" <?php echo $get['background_mod'] == 'one' ? 'checked="checked"' : ''; ?> value="one" /></td>
                </tr>
                <tr>
                    <td>Slide: </td>
                    <td><input type="radio" name="radio_bg" <?php echo $get['background_mod'] == 'two' ? 'checked="checked"' : ''; ?> value="two" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="save" value="Zapisz" /></td>
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
		//echo "post";
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