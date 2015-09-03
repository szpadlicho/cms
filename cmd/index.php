<?php
session_start();

/*curl for fun*/
if(isset($_POST['imie'])) {
	echo 'lol';
}
if(isset($_POST['nazwisko'])) {
	echo 'LOL';
}
/*create storage folder DATA if no exist !important*/
if (! is_dir('data')) {
    mkdir('data');
}
/*download*/
if (isset($_POST['download']) && (! empty($_POST['files']) || ! empty($_POST['folders']))) {
	include_once ('download_files.php');
	include_once ('create_zip.php');
	if (! empty($_POST['files']) && (count($_POST['files'])==1) && empty($_POST['folders'])) {
		$download=new Download($_POST['files'][0]);
		$download->set_header();
		$download->get_file();	
	} elseif (! empty($_POST['files']) && (count($_POST['files'])>1) && empty($_POST['folders'])) {
		@unlink('multi_files.zip');
		foreach ($_POST['files'] as $file) {
			HZip::zipFile($file, 'multi_files.zip'); 
		}			
		$download=new Download('multi_files.zip');
		$download->set_header();
		$download->get_file();
	} elseif (! empty($_POST['folders']) && empty($_POST['files'])) {
		@unlink('multi_files.zip');		
		foreach ($_POST['folders'] as $folder) {
			HZip::zipDir($folder, 'multi_files.zip'); 
		}	
		$download=new Download('multi_files.zip');
		$download->set_header();
		$download->get_file();
	} elseif (! empty($_POST['folders']) && ! empty($_POST['files'])) {
		@unlink('multi_files.zip');	
		$all_files=array_merge($_POST['folders'],$_POST['files']);
		foreach ($all_files as $all_file) {
			if (is_file($all_file)){
				HZip::zipFile($all_file, 'multi_files.zip'); 
			} elseif (is_dir($all_file)) {
				HZip::zipDir($all_file, 'multi_files.zip'); 
			}
		}
		$download=new Download('multi_files.zip');
		$download->set_header();
		$download->get_file();
	} else {
		echo "else";
	}
}
//display
echo '<div class="catch">';
include ('cmdcls.php');//class file
$cmdcls=new CmdCls();
if (isset($_POST['clear']) || ! isset($_SESSION['cmd'])) {
	//$cmdcls->set('../../public_html');//folder startowy// miejsce do ograniczania wychodzenie do góry poza wyznaczony folder 1z2
	$cmdcls->set('data');//folder startowy// miejsce do ograniczania wychodzenie do góry poza wyznaczony folder 1z2
	unset($_POST);
}
if (isset($_POST['catalog'])) {
	$cmdcls->set($cmdcls->get()."/".$_POST['catalog']);
}
if (isset($_POST['back'])) {
	$cmdcls->back();
}
$cmd=$cmdcls->get();
//action
if (isset($_POST['delete']) && ! empty($_POST['folders'])) {
	include_once ('delete.php');/*inlude_one*/
	$del->delete_folder($_POST['folders']);
}
if (isset($_POST['delete']) && ! empty($_POST['files'])) {
	include_once ('delete.php');
	$del->delete_file($_POST['files']);
}
if (isset($_POST['copy']) && ! empty($_POST['files'])) {
	$cmdcls->set_copy_p(0);
}
if (isset($_POST['cut']) && ! empty($_POST['files'])) {
	$cmdcls->set_copy_p(1);
}
if (isset($_POST['copy']) && ! empty($_POST['folders'])) {
	$cmdcls->set_copy_f(2);
}
if (isset($_POST['cut']) && ! empty($_POST['folders'])) {
	$cmdcls->set_copy_f(3);
}
if (isset($_POST['paste']) && (! empty($_SESSION['file']) || ! empty($_SESSION['folder']))) {
	$cmdcls->paste();
}
if (isset($_POST['session_file']) && ! empty($_POST['session_file'])) {
	$_SESSION['file']=$_POST['session_file'];
}
if (isset($_POST['session_folder']) && ! empty($_POST['session_folder'])) {
	$_SESSION['folder']=$_POST['session_folder'];
}
if (isset($_POST['ok_r']) && ! empty($_POST['rename_text']) && isset($_POST['files'][0])) {
	$cmdcls->rename(@$_POST['files'], $_POST['rename_text']);
}
if (isset($_POST['ok_r']) && ! empty($_POST['rename_text']) && isset($_POST['folders'][0])) {
	$cmdcls->rename(@$_POST['folders'], $_POST['rename_text']);
}
if (isset($_POST['ok_n']) && ! empty($_POST['new_text'])) {
	$cmdcls->mk_new($_POST['new_text']);
}
/*upload files*/
if (@$_FILES['files']['error'][0]!=4 && @$_FILES['files']['error'][0]==0) {
	require ('upload_files.php');
	$upload_and_check_file->upLoad($cmd);/*$cmd gdzie ma wkleić*/
}
/**/
echo '</div>';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>CMD</title>
	<?php include ("meta5.html"); ?>
	<style type="text/css"></style>
	<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" ></script>-->
	<script type="text/javascript" src="js/jquery-1.5.2.min.js" ></script>
	<script type="text/javascript" >
//$("#ciekawe2").after({'content':'','background-image':'url("images/128/edit_cut.png")'});
	</script>
</head>
<body>
	<section id="place-holder">
		<nav>
		</nav>
		<form enctype="multipart/form-data" action="" method="POST">
			<div class="upload-place-holder">
				<div class="upload-form">
					<input id="przegladaj" class="cmd_input_sub" type="file" multiple name="files[]" />
					<input type="hidden" name="MAX_FILE_SIZE" value="104857600" /><!--1GB-->
					<label><label id="ok_label3" class="cmd_label_sub" ><input class="cmd_input_sub" type="submit" name="add" value="Dodaj" /></label></label>
					<label><label id="no_label3" class="cmd_label_sub" ><input class="cmd_input_sub anuluj" type="button" name="anuluj_u" value="Anuluj" /></label></label>
				</div>
			</div>
		</form>
		<form id="form" enctype="multipart/form-data" action="" method="POST">
			<div id="files-place-holder">
				<div id="files-big">
					<div id="files">
						<input id="cmd_check_back" class="cmd_check" type="checkbox" /><img id="cmd_ico_back" class="cmd_ico" src="images/32/back.png" /><input id="cmd_button_back" class="cmd_button" type="submit" name="back" value="..." <?php if($cmdcls->get()=='data') echo 'disabled="disabled"'; // miejsce do ograniczania wychodzenie do góry poza wyznaczony folder 2z2?> /><br />
						<?php
						$var1=glob($cmd."/*", GLOB_ONLYDIR);
						$f=0;
						function foldersize($path) //rozmiar foldera
                        {
							$total_size = 0;
							$files = scandir($path);
							$cleanPath = rtrim($path, '/'). '/';

							foreach ($files as $t) {
								if ($t<>"." && $t<>"..") {
									$currentFile = $cleanPath . $t;
									if (is_dir($currentFile)) {
										$size = foldersize($currentFile);
										$total_size += $size;
									} else {
										$size = filesize($currentFile);
										$total_size += $size;
									}
								}   
							}
							return $total_size;
						}
						function filesize_formatted2($size)/*wielkos pliku plus jednostka*/
                        {
							//$size = filesize($path);
							$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
							$power = $size > 0 ? floor(log($size, 1024)) : 0;
							return '<span class="left">'.number_format($size / pow(1024, $power), 2, '.', ',') . '</span><span class="right">' . $units[$power]."</span>";
						}
						foreach ($var1 as $cat) {
                            $f++;
							$foo=explode("/",$cat);
							$foo=array_reverse($foo);
							if ($cat != '.' && $cat != '..') {
								?>
								<script type="text/javascript" >
                                    $(document).ready(function(){//po kliknieciu
                                        $('#fc<?php echo $f; ?>').click(function(){
                                            if($(this).attr('checked') == true){
                                                 $('#fs<?php echo $f; ?>').attr("disabled","disabled");   
                                            } else {
                                                $('#fs<?php echo $f; ?>').removeAttr('disabled');
                                            }
                                        });
                                    });
                                    $(document).ready(function(){//po kliknieciu w zaznacz wszystko
                                        $('#cmd_check_back').click(function(){
                                            if($(this).attr('checked') == true){
                                                 $('#fs<?php echo $f; ?>').attr("disabled","disabled");   
                                            } else {
                                                $('#fs<?php echo $f; ?>').removeAttr('disabled');
                                            }
                                        });
                                    });
                                    $(document).ready(function(){//po przeladowaniu
                                        if($('#fc<?php echo $f; ?>').attr('checked') == true){
                                             $('#fs<?php echo $f; ?>').attr("disabled","disabled");   
                                        } else {
                                            $('#fs<?php echo $f; ?>').removeAttr('disabled');
                                        }
                                    });
								</script>
                                <script type="text/javascript">
                                    // display old name in rename text for folder
                                    $(document).ready(function($) {
                                        $( '.cmd_check' ).click(function(){
                                            $( '.cmd_check' ).change(function() {
                                                var file_name = $(this).attr('title');
                                                if ($(this).is(':checked')) {
                                                    //alert('Checked');
                                                    $( '#rename_text' ).attr('value', file_name);
                                                } else {
                                                    //alert('Unchecked');
                                                    $( '#rename_text' ).attr('value','');
                                                }
                                            });
                                        });
                                    });
                                </script>
								<label class="label_all"><input id="fc<?php echo $f; ?>" class="cmd_check" type="checkbox" multiple name="folders[]" value="<?php echo $cat; ?>" title="<?php echo $foo['0']; ?>" <?php if (@in_array($cat, @$_POST['folders']) && (isset($_POST['copy']) || isset($_POST['cut']))) { echo "checked='checked'"; } ?> /><img class="cmd_ico" src="images/32/fod.png" />
								<input id="fs<?php echo $f; ?>" class="cmd_button" type="submit" name="catalog" value="<?php echo $foo['0']; ?>" />
								<span class="size_span"><?php echo filesize_formatted2(foldersize($cat)); ?></span>
								<span class="create_time_span">
										<span class="left"><?php echo date ("Y m d", filectime($cat)); ?></span>
										<span class="right"><?php echo date ("H:i:s", filectime($cat)); ?></span>
								</span>
								<span class="modified_time_span">
										<span class="left"><?php echo date ("Y m d", filemtime($cat)); ?></span>
										<span class="right"><?php echo date ("H:i:s", filemtime($cat)); ?></span>
								</span> 
								</label>
								<br />
								<?php
							}
						}
						$var2=glob($cmd."/*.*",GLOB_BRACE);
						
						//$file_info = new finfo(FILEINFO_MIME);//klasa wbudowana
						//$arr_empty = array ('inode/x-empty');
						$arr_txt = array ('text/plain','txt');
						$arr_rtf = array ('rtf');
						$arr_doc = array ('dock','doc');
						$arr_php = array ('text/x-php','php');
						$arr_html = array ('text/html','html','htm','htl');
						$arr_css = array ('css');
						$arr_js = array ('js');					
						$arr_jpg = array ('jpg','jpeg','jpe');
						$arr_bmp = array ('bmp');
						$arr_gif = array ('gif');
						$arr_png = array ('png');
						$arr_psd = array ('psd');
						$arr_tiff = array ('tiff','tif');
						$arr_rar = array ('rar');
						$arr_zip = array ('zip');
						$arr_pdf = array ('pdf');
						$arr_exe = array ('exe');
						$arr_avi = array ('avi');
						$arr_mpg = array ('mpg');
						$arr_mp3 = array ('mp3');
						$arr_mp4 = array ('mp4');
						$arr_sql = array ('sql','sql');
						$arr_tga = array ('tga');
						$arr_tgz = array ('tgz');
						$arr_wav = array ('wav');
						$arr_xml = array ('xml');
						$arr_ico = array ('ico');
						function filesize_formatted($path) /*wielkos pliku plus jednostka*/
                        {
							$size = filesize($path);
							$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
							$power = $size > 0 ? floor(log($size, 1024)) : 0;
							return '<span class="left">'.number_format($size / pow(1024, $power), 2, '.', ',') . '</span><span class="right">' . $units[$power]."</span>";
						}
						foreach ($var2 as $fil) {
							if ($fil!="FILES") {
								//echo $type_info=$file_info->file($fil, FILEINFO_MIME_TYPE);
								$foo=explode("/",$fil);
								$foo=array_reverse($foo);
								$type=explode(".",$foo[0]);//wyciągam rozszerzenie z nazwy pliku pod index [1]
								$type=array_reverse($type);//odwracam tablice żeby mieć rozszerzenie pod index [0]
								//echo $type[0];
								?>
                                <script type="text/javascript">
                                    // display old name in rename text for file
                                    $(document).ready(function($) {
                                        $( '.cmd_check' ).click(function(){
                                            $( '.cmd_check' ).change(function() {
                                                var file_name = $(this).attr('title');
                                                if ($(this).is(':checked')) {
                                                    //alert('Checked');
                                                    $( '#rename_text' ).attr('value', file_name);
                                                } else {
                                                    //alert('Unchecked');
                                                    $( '#rename_text' ).attr('value','');
                                                }
                                            });
                                        });
                                    });
                                </script>
								<label class="label_all"><input class="cmd_check" type="checkbox" multiple name="files[]" value="<?php echo $fil; ?>" title="<?php echo $type[1]; ?>" <?php if (@in_array($fil, @$_POST['files']) && (isset($_POST['copy']) || isset($_POST['cut']))) { echo "checked='checked'"; } ?> /><img class="cmd_ico" title="ico" alt="ico"
								<?php
									if (in_array($type[0], $arr_txt)) {
										echo 'src="images/32/txt.png"';
									} elseif (in_array($type[0], $arr_rtf)) {
										echo 'src="images/32/rtf.png"';
									} elseif (in_array($type[0], $arr_doc)) {
										echo 'src="images/32/dok.png"';
									} elseif (in_array($type[0], $arr_php)) {
										echo 'src="images/32/php.png"';
									} elseif (in_array($type[0], $arr_html)) {
										echo 'src="images/32/html.png"';
									} elseif (in_array($type[0], $arr_css)) {
										echo 'src="images/32/css.png"';
									} elseif (in_array($type[0], $arr_js)) {
										echo 'src="images/32/js.png"';
									} elseif (in_array($type[0], $arr_jpg)) {
										echo 'src="images/32/jpg.png"';
									} elseif (in_array($type[0], $arr_bmp)) {
										echo 'src="images/32/bmp.png"';
									} elseif (in_array($type[0], $arr_gif)) {
										echo 'src="images/32/gif.png"';
									} elseif (in_array($type[0], $arr_png)) {
										echo 'src="images/32/png.png"';
									} elseif (in_array($type[0], $arr_psd)) {
										echo 'src="images/32/psd.png"';
									} elseif (in_array($type[0], $arr_tiff)) {
										echo 'src="images/32/tiff.png"';
									} elseif (in_array($type[0], $arr_rar)) {
										echo 'src="images/32/rar.png"';
									} elseif (in_array($type[0], $arr_zip)) {
										echo 'src="images/32/zip.png"';
									} elseif (in_array($type[0], $arr_pdf)) {
										echo 'src="images/32/pdf.png"';
									} elseif (in_array($type[0], $arr_exe)) {
										echo 'src="images/32/exe.png"';
									} elseif (in_array($type[0], $arr_avi)) {
										echo 'src="images/32/avi.png"';
									} elseif (in_array($type[0], $arr_mpg)) {
										echo 'src="images/32/mpg.png"';
									} elseif (in_array($type[0], $arr_mp3)) {
										echo 'src="images/32/mp3.png"';
									} elseif (in_array($type[0], $arr_mp4)) {
										echo 'src="images/32/mp4.png"';
									} elseif (in_array($type[0], $arr_sql)) {
										echo 'src="images/32/sql.png"';
									} elseif (in_array($type[0], $arr_tga)) {
										echo 'src="images/32/tga.png"';
									} elseif (in_array($type[0], $arr_tgz)) {
										echo 'src="images/32/tgz.png"';
									} elseif (in_array($type[0], $arr_wav)) {
										echo 'src="images/32/wav.png"';
									} elseif (in_array($type[0], $arr_xml)) {
										echo 'src="images/32/xml.png"';
									} elseif (in_array($type[0], $arr_ico)) {
										echo 'src="images/32/ico.png"';
									} else {
										echo 'src="images/32/blank.png"';
									}
								?>
								/>
								<div class="cmd_span"><?php echo $foo['0']; ?></div>
                                <?php if (in_array($type[0], array('jpg','jpeg','gif','bmp','txt','html','htm','xls','ico','png','pdf'))) { //pozwolenie na pokazanie podglądu?>
                                    <span class="preview_span"><a href="<?php echo $_SESSION['cmd'].'/'.$foo['0'];?>" target="_blank" >podgląd</a></span>
                                <?php } ?>
								<span class="size_span"><?php echo filesize_formatted($fil); ?></span>
								<span class="create_time_span">
									<span class="left"><?php echo date ("Y m d", filectime($fil)); ?></span>
									<span class="right"><?php echo date ("H:i:s", filectime($fil)); ?></span>
								</span>
								<span class="modified_time_span">
									<span class="left"><?php echo date ("Y m d", filemtime($fil)); ?></span>
									<span class="right"><?php echo date ("H:i:s", filemtime($fil)); ?></span>
								</span>
								</label>
								<br />
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
			<div id="buttons-place-holder">
				<div id="buttons">
			
					<label><label id="cut_label" class="cmd_label_sub" ><input class="cmd_input_sub" type="submit" name="cut" value="Wytnij" /></label></label>
					<label><label id="copy_label" class="cmd_label_sub" ><input class="cmd_input_sub" type="submit" name="copy" value="Kopiuj" /></label></label>
					<label><label id="paste_label" class="cmd_label_sub" ><input class="cmd_input_sub" type="submit" name="paste" value="Wklej" /></label></label>
					
					<label><label id="delete_label" class="cmd_label_sub" ><input class="cmd_input_sub" type="submit" name="delete" value="Usuń" /></label></label>
					<label><label id="new_label" class="cmd_label_sub" ><input id="form_b_new" class="cmd_input_sub" type="button" name="create" value="Nowy" /></label></label>
					<label><label id="rename_label" class="cmd_label_sub" ><input id="form_b_rename" class="cmd_input_sub" type="button" name="rename" value="Zmień nazwę" /></label></label>					
					<label><label id="upload_label" class="cmd_label_sub" ><input id="form_b_up" class="cmd_input_sub" type="button" name="senform_b_up" value="Dodaj pliki" /></label></label>
					
					<input type="hidden" name="session_file" value="<?php echo @$_SESSION['file']; ?>" />
					<input type="hidden" name="session_folder" value="<?php echo @$_SESSION['folder']; ?>" />
					
					<label><label id="download_label" class="cmd_label_sub" ><input class="cmd_input_sub" type="submit" name="download" value="Pobierz" /></label></label>
					<label><label id="clear_label" class="cmd_label_sub" ><input class="cmd_input_sub" type="submit" name="clear" value="Clear" /></label></label>
				</div>
			</div>
			<!--<div class="line one"></div>-->
			<!--<div class="line two"></div>-->
			<!--<div id="" class="lline three"></div>-->
			<div class="new-place-holder">
				<div class="new-form">
					<input class="cmd_input_sub text_input" type="text" name="new_text" />
					<label><label id="ok_label" class="cmd_label_sub" ><input class="cmd_input_sub" type="submit" name="ok_n" value="OK" /></label></label>
					<label><label id="no_label" class="cmd_label_sub" ><input class="cmd_input_sub anuluj" type="button" name="anuluj_n" value="Anuluj" /></label></label>
				</div>
			</div>
			<div class="rename-place-holder">
				<div class="rename-form">
					<input id="rename_text" class="cmd_input_sub text_input" type="text" name="rename_text" />
					<label><label id="ok_label2" class="cmd_label_sub" ><input class="cmd_input_sub" type="submit" name="ok_r" value="OK" /></label></label>
					<label><label id="no_label2" class="cmd_label_sub" ><input class="cmd_input_sub anuluj" type="button" name="anuluj_r" value="Anuluj" /></label></label>
				</div>
			</div>
		</form>
		<div id="debugged">
		<?php
		//echo "post";
		var_dump (@$_POST);
		//echo "session";
		var_dump ($_SESSION);
		// echo "files";
		var_dump (@$_FILES);
		// echo "var2";
		 // var_dump ($var2);	
		//echo "cookies";
		var_dump ($_COOKIE);
		?>
		</div>
	</section>
	<footer>
	<!--
		<div id="count"></div>
		<div id="count2"></div>
	-->
	</footer>
</body>
</html>
<?php
// $host='sql.bdl.pl';
// $port='';
// $dbname='szpadlic_cms';
// $charset='utf8';
// $user='szpadlic_baza';
// $pass='haslo';
// class spr{
	// private $host='sql.bdl.pl';
	// private $port='';
	// private $dbname='szpadlic_cms';
	// private $charset='utf8';
	// private $user='szpadlic_baza';
	// private $pass='haslo';
	// private $table;
	// private $admin;
	// private $autor;
	// public function setTable($tab_name){
		// $this->table=$tab_name;
		// //echo $this->table."<br />";
	// }
	// public function conDB(){
		// $con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset, $this->user, $this->pass);
		// return $con;
	// }
		
// }
// $spr = new spr();
// $con = $spr->conDB();

// ///$con=new PDO("mysql:host=".$host."; port=".$port."; dbname=".$dbname."; charset=".$charset."", $user, $pass);
// $sth = $con->prepare("SELECT `what` FROM `files`");
// $sth->execute();

// /* Exercise PDOStatement::fetch styles */
// //print("PDO::FETCH_ASSOC: ");
// //print("Return next row as an array indexed by column name\n");
// $result = $sth->fetch(PDO::FETCH_ASSOC);
// var_dump($result);
// print("\n");

// //print("PDO::FETCH_BOTH: ");
// //print("Return next row as an array indexed by both column name and number\n");
// $result = $sth->fetch(PDO::FETCH_BOTH);
// print_r($result);
// print("\n");

// //print("PDO::FETCH_LAZY: ");
// //print("Return next row as an anonymous object with column names as properties\n");
// $result = $sth->fetch(PDO::FETCH_LAZY);
// print_r($result);
// print("\n");

// //print("PDO::FETCH_OBJ: ");
// //print("Return next row as an anonymous object with column names as properties\n");
// $result = $sth->fetch(PDO::FETCH_OBJ);
// print $result->WHAT;
// print("\n");
?>
<?php
//rename($src , $this->get()."/".$exp[0]) or die("Błąd przy przenoszeniu pliku");
?>