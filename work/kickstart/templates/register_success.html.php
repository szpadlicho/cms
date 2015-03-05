<?php include_once 'head.html.php'; ?>

<h1>Success</h1>
<?php if (! isset($data[2]['active'])) { ?>
<h2>Na twój adres email został wysłany link aktywacyjny.</h2>
<?php } else { ?>
<h2>Uzupełnij swoje dane w opcji edycji.</h2>
<?php } ?>
<h3>Twoje dane to:</h3>
<p>Imię: <?php echo isset($data[2]['first_name']) ? $data[2]['first_name'] : null; ?></p>
<p>Nazwisko: <?php echo isset($data[2]['last_name']) ? $data[2]['last_name'] : null; ?></p>
<p>Email: <?php echo isset($data[2]['email']) ? $data[2]['email'] : null; ?></p>
<p>Telefon: <?php echo isset($data[2]['phone']) ? $data[2]['phone'] : null; ?></p>
<p>Kraj: <?php echo isset($data[2]['country']) ? $data[2]['country'] : null; ?></p>
<p>Kod pocztowy: <?php echo isset($data[2]['post_code']) ? $data[2]['post_code'] : null; ?></p>
<p>Miasto: <?php echo isset($data[2]['town']) ? $data[2]['town'] : null; ?></p>
<p>Ulica i numer domu: <?php echo isset($data[2]['street']) ? $data[2]['street'] : null; ?></p>

<?php include_once 'footer.html.php'; ?>