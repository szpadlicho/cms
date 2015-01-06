<?php
//header('Content-Type: text/html; charset=utf-8');
//-----------------------------------
// w zmienną $text_body wpisujemy treść maila
$text_body  = '
<html>
<head> 
<title>Aktywacja konta w serwisie www.kickstart.pl</title> 
</head>
<body>
<p>Pomyślnie utworzono nowe konto. Login do konta to '.$destination_address.'  Aby zweryfikować adres e-mail i zakończyć proces rejestracji, wystarczy kliknąć poniższy link:</b></p>';
//--
$text_body .= '<p>';
$text_body .= 'http://www.start.szpadlic.bdl.pl/index.php?con=register&action=activate&token='.$token.PHP_EOL;
$text_body .= '</p>';
//--
$text_body .= '
</body>
</html>';
//----------------------------------
//----------------------------------
//$adresat = 'szpadlicho@gmail.com';
$adresat = $destination_address;
//$adresat = 'marketing@twojewlosy.pl';
//$adresat = 'info@meble24h.com.pl';
$replay = 'szpadlicho@gmail.com';
//----------------------------------
$topic = 'Aktywacja konta w serwisie www.kickstart.pl';
//----------------------------------
$header = 'Reply-to:'.$replay.'<'.$replay.'>'.PHP_EOL;
$header .= 'From: www.kickstart.pl'.PHP_EOL;
$header .= 'MIME-Version: 1.0'.PHP_EOL;
$header .= 'Content-type: text/html; charset=utf-8'.PHP_EOL; 
//----------------------------------		  
if (!mail($destination_address, $topic, $text_body, $header)){
?>
<script type="text/javascript">
    alert ('Coś poszło nie tak!');
</script>
<?php
}
else{
?>
<script type="text/javascript">
    alert ('Wiadomości wysłana !');
</script>
<?php
}
?>