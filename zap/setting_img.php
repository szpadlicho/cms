<?php
echo '<div class="catch">';
include_once('../classes/img/set/size.php');
$cls_img = new Img_Set_Size();
$cls_img->__setTable('setting_img');
if (isset($_POST['small_save'])) {
    $arr_val= array('small_width'=>$_POST['small_width'],  'small_height'=>$_POST['small_height']);
    $cls_img->__setRow($arr_val, 1);
}
if (isset($_POST['large_save'])) {
    $arr_val= array('large_width'=>$_POST['large_width'],  'large_height'=>$_POST['large_height']);
    $cls_img->__setRow($arr_val, 1);
}
$get = $cls_img->__getRow(1);
echo '</div>';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Edycja</title>
	<?php include ("meta5.html"); ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link href="../upload/uploadfile.css" rel="stylesheet">    
    <script src="../upload/jquery.uploadfile.js"></script>
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
                    <th colspan="2">Mini img:</th>
                </tr>
                <tr>
                    <td>Width: </td>
                    <td><input type="text" name="small_width" value="<?php echo $get['small_width'] ;?>" /></td>
                </tr>
                <tr>
                    <td>Height: </td>
                    <td><input type="text" name="small_height" value="<?php echo $get['small_height'] ;?>" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="small_save" value="Zapisz" /></td>
                </tr>
                <tr>
                    <th colspan="2">Larg img:</th>
                </tr>
                <tr>
                    <td>Width: </td>
                    <td><input type="text" name="large_width" value="<?php echo $get['large_width'] ;?>" /></td>
                </tr>
                <tr>
                    <td>Height: </td>
                    <td><input type="text" name="large_height" value="<?php echo $get['large_height'] ;?>" /></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="large_save" value="Zapisz" /></td>
                </tr>
            </table>
            </form>
        </div>
	</section>
	<footer>
	<!--<div id="count"></div><div id="count2"></div>-->
	</footer>
	<div id="debugged">
		<?php
		//echo "post";
		//var_dump (@$_POST);
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