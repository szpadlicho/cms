<?php
/*
//for deleting files folder with all files inside
*/
class Delete
{
	public function delete_file($dir_array)
    {
	// do kasowania jeden plik dla tablic
		foreach ($dir_array as $dir) {
			unlink($dir);
		}
	}
	public function delete_folder($dir_array) 
    {
	// do kasowania folderów plików i pod folderów dla tablic
		foreach ($dir_array as $dir) {
			if (is_dir($dir)) {
				$files = scandir($dir);
				foreach ($files as $file) {
					if ($file != "." && $file != "..") {
						if (filetype($dir."/".$file) == "dir") {
							$folders[]=$dir."/".$file;//zmieniam w tablice bi inaczej funkcja nie zadziała
							$this->delete_folder($folders);
						} else {
							unlink($dir."/".$file);
						}
					}
				}
				reset($files);
				rmdir($dir);
			}
		}
	}
	public function rrmdir($dir) 
    {
	// do kasowania folderów plików i pod folderów
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}
}
$del=new Delete();
?>