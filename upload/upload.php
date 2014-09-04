<?php
include_once('../classes/img/set/size.php');
$cls_img = new Img_Set_Size();
$cls_img->__setTable('setting_img');
$get = $cls_img->__getRow(1);
?>
<?php
//mini image
if(isset($_FILES["product_foto_mini"]))
{
    //$folder = "uploads/1/";
    $folder = $_POST['folder'];//dodalem
    //tworze foldery jeśli nie istnieją
    
    if (!file_exists($folder)) {
        $cr = mkdir($folder, 0777, true);
    }
	$ret = array();

	$error =$_FILES["product_foto_mini"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["product_foto_mini"]["name"])) //single file
	{
 	 	$fileName = $_FILES["product_foto_mini"]["name"];
        //--kasuje zawartość co by zawsze był tylko jeden
        $dir = opendir($folder);//do kasacji zawartości folderu mini
        while( $path = readdir($dir)){
            if( $path!='.' && $path!='..'){
               //echo $folder.'/'.$path;
               unlink($folder.'/'.$path);
            }
        }
        //--
        include_once('resize.php');
        $cls_resize = new ImageResize();
        $cls_resize->resizeImage($_FILES["product_foto_mini"]["tmp_name"],$get['small_width'],$get['small_height'],$folder.$fileName);
        //--
 		//move_uploaded_file($_FILES["product_foto_mini"]["tmp_name"],$folder.$fileName);
    	$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["product_foto_mini"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["product_foto_mini"]["name"][$i];
        include_once('resize.php');
        $cls_resize = new ImageResize();
        $cls_resize->resizeImage($_FILES["product_foto_mini"]["tmp_name"],$get['small_width'],$get['small_height'],$folder.$fileName);
        //--
		//move_uploaded_file($_FILES["product_foto_mini"]["tmp_name"][$i],$folder.$fileName);
	  	$ret[] = $fileName;
	  }
	
	}
    echo json_encode($ret);
}
//large files
if(isset($_FILES["product_foto_large"]))
{
    //$folder = "uploads/2/";
    $folder = $_POST['folder'];//dodalem
    //tworze foldery jeśli nie istnieją
    if (!file_exists($folder)) {
        $cr = mkdir($folder, 0777, true);
    }
    
	$ret = array();

	$error =$_FILES["product_foto_large"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["product_foto_large"]["name"])) //single file
	{
 	 	$fileName = $_FILES["product_foto_large"]["name"];
        include_once('resize.php');
        $cls_resize = new ImageResize();
        $cls_resize->resizeImage($_FILES["product_foto_large"]["tmp_name"],$get['large_width'],$get['large_height'],$folder.$fileName);
 		//move_uploaded_file($_FILES["product_foto_large"]["tmp_name"],$folder.$fileName);
    	$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["product_foto_large"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["product_foto_large"]["name"][$i];
        include_once('resize.php');
        $cls_resize = new ImageResize();
        $cls_resize->resizeImage($_FILES["product_foto_large"]["tmp_name"],$get['large_width'],$get['large_height'],$folder.$fileName);
		//move_uploaded_file($_FILES["product_foto_large"]["tmp_name"][$i],$folder.$fileName);
	  	$ret[]= $fileName;
	  }
	
	}
    echo json_encode($ret);
 }
 ?>