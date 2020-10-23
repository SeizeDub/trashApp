<?php require 'php/includes/header.php' ?>
<main>

<h2>Connexion</h2>
<form id="login-form">
    <fieldset>
        <label for="input-email">Adresse email</label>
        <input type="email" name="input-email" id="input-email" required>
    </fieldset>
    <fieldset>
        <label for="input-password">Mot de passe</label>
        <input type="password" name="input-password" id="input-password" required>
    </fieldset>
    <fieldset>
        <input class="main-button" type="submit" value="Connexion">
    </fieldset>
</form>

</main>
<script src="assets/js/src/formValidation.js"></script>
<script src="assets/js/src/login.js"></script>
<?php require 'php/includes/footer.php' ?>