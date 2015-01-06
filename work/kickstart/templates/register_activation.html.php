<?php include_once 'head.html.php'; ?>

<h1>Success</h1>

<?php if ($data == true) { ?>
    <h2>Aktywacja pomyślna</h2>
<?php } else { ?>
    <h2>Błąd ! skontaktuj się z administratorem serwisu</h2>
<?php } ?>

<?php include_once 'footer.html.php'; ?>