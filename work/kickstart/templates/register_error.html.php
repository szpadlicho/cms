<?php include_once 'head.html.php'; ?>

<h1>Error</h1>

<?php 
switch ($data[1]) {
    case 0: ?>
        <h2>Błędna forma adresu email.</h2>
        <?php
        break;
    case 1: ?>
        <h2>Adresy email muszą być identyczne.</h2>	
        <?php
        break;
    case 2: ?>
        <h2>Hasła muszą być identyczne.</h2>
        <?php
        break;
    case 3: ?>
        <h2>Podane dane nie mogą być puste lub krótsze niż 3 znaki.</h2>
        <?php
        break;
    case 4: ?>
        <h2>Email jest zajęty.</h2>
        <?php
        break;
    case 5: ?>
        <h2>Błąd zapisu do bazy.</h2>
        <?php
        break;
    default: ?>
        <h2>Nieznany błąd.</h2>
<?php } ?>

<?php include 'register_form_correct.html.php'; ?>

<?php var_dump($data); ?>

<?php include_once 'footer.html.php'; ?>