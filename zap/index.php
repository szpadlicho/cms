<?php
session_start();
echo '<div class="catch">';
class ProduktSetCls{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;
	private $admin;
	private $autor;
	public function _setTable($tab_name){
		$this->table=$tab_name;
	}
	public function connectDB(){
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
	public function show(){
		/*zapis do tablei tylko raz*/
		$con=$this->connectDB();
	}
}
echo '</div>';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Zaplecze-index</title>
	<?php include ("meta5.html"); ?>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
	<section id="place-holder">
		<?php include ('menu_zap.php'); ?>
	</section>
	<footer>
	<!--<div id="count"></div><div id="count2"></div>-->
	</footer>
	<div id="debugged">
		<?php
		echo "post";
		var_dump (@$_POST);
		//echo "session";
		//var_dump ($_SESSION);
		// echo "files";
		// var_dump (@$_FILES);
		// echo "var2";
		 // var_dump ($var2);	
		//echo "cookies";
		//var_dump ($_COOKIE);
		?>
	</div>
</body>
</html>
