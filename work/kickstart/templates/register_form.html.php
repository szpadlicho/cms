<?php include_once 'head.html.php'; ?>

<h1>Wprowadź swoje dane</h1>

<form method="POST">
    <input class="inputs" type="text" name="first_name" placeholder="Imię" value="Piotr"/>
    <input class="inputs" type="text" name="last_name" placeholder="Imię" value="Nazwisko"/>
    <input class="inputs" type="text" name="email" placeholder="email" value="szpadlicho@gmail.com"/>
    <input class="inputs" type="text" name="confirm_email" placeholder="Powtórz email" value="szpadlicho@gmail.com"/>
    <input class="inputs" type="password" name="password" placeholder="Hasło" value="haslo"/>
    <input class="inputs" type="password" name="confirm_password" placeholder="Powtórz hasło" value="haslo"/>
    <input class="inputs" type="text" name="phone" placeholder="Telefon" value="888958277"/>
    <input class="inputs" type="text" name="country" placeholder="Kraj" value="Polska"/>
    <input class="inputs" type="text" name="post_code" placeholder="Kod pocztowy" value="42-200"/>
    <input class="inputs" type="text" name="town" placeholder="Miasto" value="Częstochowa"/>
    <input class="inputs" type="text" name="street" placeholder="Ulica i numer domu" value="Garibaldiego 16 m. 23"/>
    <!--
    <input class="inputs" type="text" name="" placeholder="" value=""/>
    -->
    <input class="inputs" type="submit" name="register" value="Zarejestruj"/>
    <input class="inputs" type="submit" name="cancel" value="Anuluj"/>
</form>

<?php include_once 'footer.html.php'; ?>