<?php
session_start();
class Connect_BackroomInf 
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_cms';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;
	private $admin;
	private $autor;
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
	}
	public function connectDB()
    {
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
	public function __getLowAmount2($from, $to)
    {
		/*zapis do tabeli tylko raz*/
		$con=$this->connectDB();
        $res = $con->query("SELECT `id`, `product_name`, `amount` FROM `".$this->table."` WHERE `amount` < 10 ORDER BY `amount` DESC LIMIT ".$from.",".$to." ");
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            var_dump($row);
            
        }
	}
    public function __getLowAmount($from, $to)
    {
		/*zapis do tabeli tylko raz*/
		$con=$this->connectDB();
        $res = $con->query("SELECT `id`, `product_name`, `amount` FROM `".$this->table."` WHERE `amount` < 10 ORDER BY `amount` LIMIT ".$from.",".$to." ");// DESC is opposite
        return $res;
	}
    public function __setAmount($id, $amount)
    {
		/*zapis do tabeli tylko raz*/
		$con=$this->connectDB();
        $res = $con->query("UPDATE `".$this->table."` 
                    SET
                    `amount` = '".$amount."'
                    WHERE
                    `id` = '".$id."'
                    ");
	}
}
$obj_backroom_inf = new Connect_BackroomInf ;
if (isset($_POST['update_amount'])) {
    $obj_backroom_inf->__setTable('product_tab');
    $obj_backroom_inf->__setAmount($_POST['id'], $_POST['amount']);
}

//$obj_backroom_inf->__getLowAmount(0,10);
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
		<?php include ('backroom-top-menu.php'); ?>
        <?php
            // $wyn = $obj_backroom_inf->__getLowAmount2(0,10);
            // //$wyn = $wyn->fetch(PDO::FETCH_ASSOC);
            // foreach ($wyn as $llol) {
                // var_dump($llol);
            // }
        ?>
        <div class="back-all index placeholder">
                <!--<form enctype="multipart/form-data" method="POST">-->
                    <table class="back-all index table">
                        <tr>
							<th colspan="4">Produkty na wyczerpaniu:</th>
						</tr>
                        <tr>
							<th>ID:</th>
                            <th>Nazwa:</th>
                            <th>Dostępna ilość:</th>
                            <th>Zapisz:</th>
						</tr>
                        <script type="text/javascript">
                            $(function(){
                                /**
                                * change color description when amount is low
                                **/
                                // $( '.back-all' ).click(function(){
                                    // alert('asd');
                                // });
                                //console.log('adf');
                                $( '.color' ).each(function(){
                                    var val = $( this ).val();
                                    if (val <= 9 && val >= 8) {
                                        $( this ).css('color','rgb(64,144,28)');
                                        //$(this).closest('#one').children().children('input').css('color','rgb(31,248,28)')
                                        $(this).closest('tr').children('td').css('color','rgb(64,144,28)')
                                    } else if (val <= 7 && val >= 6) {
                                        $( this ).css('color','rgb(249,221,28)');
                                        //$(this).closest('#one').children().children('input').css('color','rgb(249,141,28)')
                                        $(this).closest('tr').children('td').css('color','rgb(249,221,28)')
                                    }else if (val <= 5 && val >= 3) {
                                        $( this ).css('color','rgb(249,141,28)');
                                        //$(this).closest('#one').children().children('input').css('color','rgb(249,141,28)')
                                        $(this).closest('tr').children('td').css('color','rgb(249,141,28)')
                                    } else if (val <= 2 && val >= 0) {
                                        $( this ).css('color','rgb(249,4,28)');
                                        //$(this).closest('#one').children().children('input').css('color','rgb(249,4,28)')
                                        $(this).closest('tr').children('td').css('color','rgb(249,4,28)')
                                    }
                                });
                            });
                        </script>
                        <?php 
                        $obj_backroom_inf->__setTable('product_tab');
                        $wyn = $obj_backroom_inf->__getLowAmount(0,100);
                        foreach ($wyn as $row) { ?>
						<tr>
                            <form enctype="multipart/form-data" method="POST">
                                <td>
                                    <?php echo $row['id']; ?>
                                    <input id="" class="back-all index text" type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                                </td>
                                <td>
                                    <?php echo $row['product_name']; ?>
                                    <input id="" class="back-all index text" type="hidden" name="name" value="<?php echo $row['product_name']; ?>" />
                                </td>
                                <td>
                                    <input id="" class="back-all index text color" type="text" name="amount" value="<?php echo $row['amount']; ?>" />
                                </td>
                                <td>
                                    <input id="" class="back-all index submit" type="submit" name="update_amount" value="Zapisz" />
                                </td>
                            </form>
						</tr>
                        <?php } ?>
                    </table>
                <!--</form>-->
        </div>
	<footer>
	<!--<div id="count"></div><div id="count2"></div>-->
	</footer>
	<div id="debugger">
		<?php
		//echo "post";
		//var_dump (@$_POST);
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
