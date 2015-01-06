<?php include_once 'head.html.php'; ?>

<h1>Success</h1>
<h2>Na twój adres email został wysłany link aktywacyjny.</h2>
<h3>Twoje dane to:</h3>
<p>Imię: <?php echo $data[2]['first_name']; ?></p>
<p>Nazwisko: <?php echo $data[2]['last_name']; ?></p>
<p>Email: <?php echo $data[2]['email']; ?></p>
<p>Telefon: <?php echo $data[2]['phone']; ?></p>
<p>Kraj: <?php echo $data[2]['country']; ?></p>
<p>Kod pocztowy: <?php echo $data[2]['post_code']; ?></p>
<p>Miasto: <?php echo $data[2]['town']; ?></p>
<p>Ulica i numer domu: <?php echo $data[2]['street']; ?></p>

<?php include_once 'footer.html.php'; ?>