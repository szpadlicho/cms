<?php include_once 'head.html.php'; ?>

<h1>Popraw swoje dane</h1>

<form method="POST">
    <input class="inputs" type="text" name="first_name" placeholder="Imię" value="<?php echo isset($data[3]['first_name']) ? $data[3]['first_name'] : null; ?>"/>
    <input class="inputs" type="text" name="last_name" placeholder="Imię" value="<?php echo isset($data[3]['last_name']) ? $data[3]['last_name'] : null; ?>"/>
    <input class="inputs" type="text" name="email" placeholder="email" value="<?php echo isset($data[3]['email']) ? $data[3]['email'] : null; ?>"/>
    <input class="inputs" type="text" name="confirm_email" placeholder="Powtórz email" value=""/>
    <input class="inputs" type="password" name="password" placeholder="Hasło" value=""/>
    <input class="inputs" type="password" name="confirm_password" placeholder="Powtórz hasło" value=""/>
    <input class="inputs" type="text" name="phone" placeholder="Telefon" value="<?php echo isset($data[3]['phone']) ? $data[3]['phone'] : null; ?>"/>
    <input class="inputs" type="text" name="country" placeholder="Kraj" value="<?php echo isset($data[3]['country']) ? $data[3]['country'] : null; ?>"/>
    <input class="inputs" type="text" name="post_code" placeholder="Kod pocztowy" value="<?php echo isset($data[3]['post_code']) ? $data[3]['post_code'] : null; ?>"/>
    <input class="inputs" type="text" name="town" placeholder="Miasto" value="<?php echo isset($data[3]['town']) ? $data[3]['town'] : null; ?>"/>
    <input class="inputs" type="text" name="street" placeholder="Ulica i numer domu" value="<?php echo isset($data[3]['street']) ? $data[3]['street'] : null; ?>"/>
    <!--
    <input class="inputs" type="text" name="" placeholder="" value=""/>
    -->
    <input class="inputs" type="submit" name="register" value="Zarejestruj"/>
    <input class="inputs" type="submit" name="cancel" value="Anuluj"/>
</form>

<?php include_once 'footer.html.php'; ?>