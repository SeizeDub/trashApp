<?php require 'php/includes/header.php' ?>
<main>

<h2>Créer un compte</h2>
<form id="register-form">
    <p class="infos">Votre adresse e-mail sera utilisée uniquement comme identifiant.</p>
    <fieldset>
        <label for="input-email">Adresse e-mail</label>
        <input type="email" name="input-email" id="input-email" required>
    </fieldset>
    <fieldset>
        <label for="input-password">Mot de passe</label>
        <input type="password" name="input-password" id="input-password" required>
    </fieldset>
    <hr>
    <p class="infos">Ces informations serviront à vous contacter si necessaire.</p>
    <fieldset>
        <label for="input-name">Nom complet</label>
        <input type="text" name="input-name" id="input-name" required>
    </fieldset>
    <fieldset>
        <label for="input-phone">N° téléphone</label>
        <input type="tel" name="input-phone" id="input-phone" required>
    </fieldset>
    <hr>
    <fieldset>
        <label for="input-address">Adresse</label>
        <input type="text" name="input-address" id="input-address" required placeholder="exemple : 58 rue de Marseille, Bordeaux">
        <p class="input-infos">Veuillez choisir une adresse de domicile valide parmis les options proposées dans la liste déroulante.</p>
    </fieldset>
    <fieldset>
        <label for="input-address-plus">Complément d'adresse <span class="optional-tag">(facultatif)</span></label>
        <input type="text" name="input-address-plus" id="input-address-plus">
    </fieldset>
    <fieldset>
        <input id="register-submit" class="main-button" type="submit" value="Créer le compte">
    </fieldset>
</form>

</main>
<script src="assets/js/src/formValidation.js"></script>
<script src="assets/js/src/register.js"></script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAW9v4ik-x3ylxJM91bCgWBLCcc4MG6uV8&libraries=places&callback=initAutocomplete"></script>
<?php require 'php/includes/footer.php' ?>