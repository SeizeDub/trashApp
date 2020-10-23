<?php 
$encombrant = true;
require 'php/includes/header.php';

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

?>
<main>

<h2>Demander l'enlèvement d'un encombrant à votre domicile</h2>
<button id="return-button" class="main-button" style="display : none">Etape précédente</button>
<form class="first-step">
    <fieldset>
        <label for="input-title">Intitulé</label>
        <input type="text" id="input-title" name="input-title" required>
        <span class="input-infos">Entrez un nom concis et approprié pour l’encombrant.</span>
    </fieldset>
    <fieldset>
        <label for="input-description">Description</label>
        <textarea name="input-description" id="input-description" rows="4" required></textarea>
        <span class="input-infos">Décrivez la nature de l’encombrant, les problèmes et dangers éventuels.</span>
    </fieldset>
    <div class="input-size">
        <fieldset>
            <label for="input-hauteur">Hauteur</label>
            <input type="number" name="input-hauteur" id="input-hauteur" min="0" required>
        </fieldset>
        <fieldset>
            <label for="input-largeur">Largeur</label>
            <input type="number" name="input-largeur" id="input-largeur" min="0" required>
        </fieldset>
        <fieldset>
            <label for="input-profondeur">Profondeur</label>
            <input type="number" name="input-profondeur" id="input-profondeur" min="0" required>
        </fieldset>
        <span class="input-infos">Renseignez les dimensions de l’encombrant en centimètres.</span>
    </div>
    <fieldset>
        <label class="label-button" for="input-image">Joindre une photo <span class="optional-tag">(facultatif)</span></label>
        <input type="file" name="input-image" id="input-image" accept="image/*">
    </fieldset>
    <fieldset>
        <input class="main-button" type="submit" value="Etape suivante">
    </fieldset>
</form>
<form class="second-step" action="" style="display : none">
    <p class="infos">Indiquez une date où vous serez présent à votre domicile et disponible pour procéder à l’enlèvement de l’encombrant.</p>
    <p class="infos">Les enlèvements sont réalisés de 8h à 18h, du Lundi au Vendredi.</p>
    <p class="infos">Prévoyez d’être disponible pour une plage horaire de 2 heures à partir de l'heure renseignée.</p>
    <fieldset>
        <label for="input-datetime">Date et heure</label>
        <input type="datetime" name="input-datetime" id="input-datetime" required>
    </fieldset>
    <fieldset>
        <input id="encombrant-submit" class="main-button" type="submit" value="Envoyer">
    </fieldset>
</form>

</main>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
<script src="assets/js/src/formValidation.js"></script>
<script src="assets/js/src/encombrant.js"></script>

<?php require 'php/includes/footer.php' ?>