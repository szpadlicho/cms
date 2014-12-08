<?php
//$dir="uploads/1/mini";
$dir=$_POST['folder'];
$files = scandir($dir);

$ret= array();
foreach ($files as $file) {
    if ($file == "." || $file == ".." || is_dir($dir."/".$file))
        continue;
        $ret[]=$file;
}
echo json_encode($ret);
?>