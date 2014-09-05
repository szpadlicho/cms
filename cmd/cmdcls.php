<?php
class CmdCls
{
/**
class for show folders and files 
**/
	public function set($set)//ustaw gdzie aktualnie jestem
    {
		//session_destroy();
		session_unset();
		//session_start();
		$_SESSION['cmd']=$set;
	}
	public function get()//pobierz aktualna ścieżkę
    {
		$cmd=$_SESSION['cmd'];
		return $cmd;
	}	
	public function back()//ścieżka do góry
    {
		$exp=explode("/",$this->get());
		$fileCount = count($exp) - 1;
		unset($exp[$fileCount]);
		$exp = array_values($exp);
		$back=implode("/",$exp);
		$this->set($back);
	}
	public function set_copy_p($mod)//zapamiętuje co kopiować dla plików
    {
		$what=@$_POST['files'];
		$what=@implode("*|*", $what);
		$what=$what."*|+|*".$mod;
		$_SESSION['file']=$what;
		$_POST['session_file']=$what;
		if (!isset($_POST['folders']) && empty($_POST['folders'])) {
			unset($_SESSION['folder']);
			unset($_POST['session_folder']);
		}
	}
	public function set_copy_f($mod)//zapamiętuje co kopiować dla katalogów
    {
		$what=@$_POST['folders'];
		$what=@implode("*|*", $what);
		$what=$what."*|+|*".$mod;
		$_SESSION['folder']=$what;
		$_POST['session_folder']=$what;
		if (! isset($_POST['files']) && empty($_POST['files'])) {
			unset($_SESSION['file']);
			unset($_POST['session_file']);
		}
	}
	public function copy_folder($src, $dst)//kopiowanie folderów
    {
		if (is_dir($src)) {//jeśli katalog
			@mkdir($dst);
			$files = scandir($src);
			foreach ($files as $file) {//dla podfolderów 
				if ($file != "." && $file != "..") {
					$this->copy_folder($src."/".$file, $dst."/".$file);
				}
			}
		} elseif (file_exists($src)) {//kopiowanie plików zawartych w folderach
			copy($src, $dst);
		}
	}
	public function cut_folder($src, $dst)//przenoszenie folderów
    {
		if (is_dir($src)) {//jeśli katalog
			@mkdir($dst);
			$files = scandir($src);
			foreach ($files as $file) {//dla podfolderów 
				if ($file != "." && $file != "..") {		
					$this->cut_folder($src."/".$file, $dst."/".$file);				
				}
			}
			if (count(scandir($src)) < 3) {//usuwam  pusty katalog jeśli wszystkie plik w nim już są przeniesione sprawdzam to za pomocą . i .. = 2 czyli < 3
				rmdir($src);
			}
		} elseif (file_exists($src)) {//przenoszenie plików zawartych w folderach
			rename($src, $dst);
		}	
	}
	public function paste()
    {
		$mod_p = explode("*|+|*",@$_SESSION['file']);//wyciągam numer mod $mod_p[1] dla plików
		$mod_f = explode("*|+|*",@$_SESSION['folder']);//wyciągam numer mod $mod_p[1] dla katalogów
		$tab_p = explode("*|*",$mod_p[0]);//wyciągam ścieżki co ma być kopiowane dla plików
		$tab_f = explode("*|*",$mod_f[0]);//wyciągam ścieżki co ma być kopiowane dla katalogów
		foreach ($tab_p as $src) {//dla plików
			$exp=explode("/",$src);//wyciągam nazwę pliku
			$exp=array_reverse($exp);//zmieniam klucz nazwy pliku z ostatniej na pierwsza pozycje
			if (is_file($src)) {//sprawdzam czy na pewno plik i wykluczam błąd przy kopiowaniu folderów
				if (@$mod_p[1]==0) {					
						copy($src , $this->get()."/".$exp[0]);
						//unset($_SESSION['file']);
						//unset($_POST['session_file']);
						//unset($_POST['file']);				
				} elseif(@$mod_p[1]==1) {
					rename($src , $this->get()."/".$exp[0]);
					unset($_SESSION['file']);
					unset($_POST['session_file']);
					//unset($_POST['file']);
				} else {
					echo '<span class="catch_span">Błąd MOD przy kopiowaniu plików</span>';
				}
			}
		}
		foreach ($tab_f as $src) {//dla folderów
			$exp=explode("/",$src);//wyciągam nazwę pliku
			$exp=array_reverse($exp);//zmieniam klucz nazwy pliku z ostatniej na pierwsza pozycje
			if (is_dir($src)) {//sprawdzam czy na pewno folder i wykluczam błąd przy kopiowaniu plików
				if(@$mod_f[1]==2) {
					$this->copy_folder($src, $this->get()."/".$exp[0]);
					//unset($_SESSION['folder']);
					//unset($_POST['session_folder']);
					//unset($_POST['folder']);
				} elseif (@$mod_f[1]==3) {
					$this->cut_folder($src, $this->get()."/".$exp[0]);
					unset($_SESSION['folder']);
					unset($_POST['session_folder']);
					//unset($_POST['folder']);
				} else {
					echo '<span class="catch_span">Błąd MOD przy kopiowaniu folderów</span>';
				}
			}
		}
	}
	public function mk_new($new_text)
    {
		@mkdir ($this->get()."/".$new_text);
	}	
	public function rename($old,$new)
    {
		$ile=count($old);//zliczam ile plikow jest w tablicy czy jeden czy multi
		//echo $ile;
		if ($ile==1) {//zmiana nazwy dla pojedynczego pliku z przenoszeniem rozszerzenia
			foreach ($old as $old_one) {//zmiana nazwy dla wielu plików z przenoszeniem rozszerzenia
				if (is_file($old_one)) {//jesli plik to:
					$exp=explode("/", $old_one);//rozbijam ścieżkę
					$exp=array_reverse($exp);//obracam tablice zęby nazwa pliku była pierwsza [0]
					$roz=explode(".", $exp[0]);// pod zmienna $roz[1] ląduje rozszerzenie
					$new=$new.".".@$roz[1];//dokładam do nowej nazwy stare rozszerzenie
					rename($old_one, $this->get()."/".$new);
				} elseif (is_dir($old_one)) {//jesli katalog to:
					rename($old_one, $this->get()."/".$new);
				} else {
					echo '<span class="catch_span">Plik lub katalog nie istnieje</span>';
				}
			}
		} else {
			$i=0;
			foreach ($old as $old_one) {//zmiana nazwy dla wielu plików z przenoszeniem rozszerzenia i dodaniem liczby kolejnosci
				$i++;//numer dla nazwy	
				if (is_file($old_one)) {//jeśli plik to:
					$exp=explode("/", $old_one);//rozbijam ścieżkę
					$exp=array_reverse($exp);//obracam tablice żeby nazwa pliku była pierwsza [0]
					$roz=explode(".", $exp[0]);// pod zmienna $roz[1] ląduje rozszerzenie
					$new2=$new."(".$i.").".@$roz[1];//dokładam do nowej nazwy stare rozszerzenie i numer za nazwą
					rename($old_one, $this->get()."/".$new2);
				} elseif(is_dir($old_one)) {//jeśli katalog to:
					$new2=$new."(".$i.")";//dokładam do nowej nazwy numer
					rename($old_one, $this->get()."/".$new2);
				} else {
					echo '<span class="catch_span">Plik lub katalog nie istnieje</span>';
				}
				
			}
		}
	}
}
?>