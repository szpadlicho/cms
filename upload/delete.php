<?php
if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
{
    $output_dir = $_POST['folder'];
	$fileName =$_POST['name'];
	$filePath = $output_dir. $fileName;
	if (file_exists($filePath)) 
	{
        unlink($filePath);
    }
	echo "Deleted File ".$fileName."<br>";
}
?>