<?php
    header("Content-type: text/css; charset: UTF-8");
?>
<?php
$files = glob('../fonts/*.*');
//$files = glob('data/*.*');
//$time  = time();
foreach ($files as $file) {
    if (is_file($file)) {
        //echo $file
        //echo basename($file);
        $ext3 = pathinfo($file, PATHINFO_EXTENSION);
        ?>
@font-face {
	font-family: <?php echo basename($file, '.'.$ext3); ?>;
	src: url('<?php echo $file; ?>');
}       
        <?php
    };
};
?>