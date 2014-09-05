<?php
class Download
{
	private $file;
	private $file_name;
	private $fh;
	public function __construct($file) 
    {
		$this->file=$file;
		$this->file_name = basename($this->file);
		$this->fh=@fopen($this->file,"rb");
	}
	public function set_header()
    {
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"$this->file_name\"");
		header("Pragma: public");//dla IE6
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//dla IE6

	}
	public function get_file()
    {
		if (file_exists($this->file)) {
			set_time_limit(0);
			while (!feof($this->fh)) {
				print(@fread($this->fh, 1024*8));
				ob_flush();
				flush();
			}
		}
	}
}
?>