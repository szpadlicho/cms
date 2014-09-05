<?php
class UpLoadFiles
{
	/*funkcja do sprawdzania i uploadowania plików*/
	public function checkFile($x,$i,$des)
    {
		$allowed = array (/*pliki które są nie do przyjęcia*/);
		if (! in_array($x, $allowed)) {		
			echo '<span class="catch_span">plik zaladowany: '.$_FILES['files']['name'][$i].'</span>';
			move_uploaded_file($_FILES['files']['tmp_name'][$i], $des.'/'.$_FILES['files']['name'][$i]);
		} else {
			echo '<span class="catch_span">Nie dozwolony format pliku: '.$_FILES['files']['name'][$i].'</span>';
		}
	}
	public function upLoad($des)
    {
		$fileCount = count(@$_FILES['files']['tmp_name']);
		for ($i=0; $i<$fileCount; $i++) {
			$this->checkFile(@$_FILES['files']['type'][$i],$i,$des);
		}
	}
}
$upload_and_check_file=new UpLoadFiles();
?>