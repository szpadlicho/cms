<?php
    header("Content-type: text/css; charset: UTF-8");
        
    $brandColor = "#990000";
    $bgColor = "grey";
    $textColor = "white";
    $dir = "http://jaksstrona.np";
?>
body{
    background-color: <?php echo $bgColor; ?>;
    color: <?php echo $textColor; ?>;
}
a{
    color: <?php echo $linkColor; ?>;
}

div{
    background: url("<?php echo $dir; ?>/images/header-bg.png") no-repeat;
}