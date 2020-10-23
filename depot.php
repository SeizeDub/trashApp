<?php require 'php/includes/header.php';

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

?>
<main>

<h2>Signaler un dépôt sauvage encombrant ou dangereux</h2>
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
    <p class="infos">Entrez l'adresse de l'encombrant puis indiquez précisement sa position en déplacant le pointeur sur la carte.</p>
    <fieldset>
        <label for="input-address">Adresse</label>
        <input type="text" name="input-address" id="input-address" required placeholder="exemple : 58 rue de Marseille, Bordeaux">
        <div id="map"></div>
    </fieldset>
    <fieldset>
        <input id="depot-submit" class="main-button" type="submit" value="Envoyer">
    </fieldset>
</form>

</main>
<script src="assets/js/src/formValidation.js"></script>
<script src="assets/js/src/depot.js"></script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAW9v4ik-x3ylxJM91bCgWBLCcc4MG6uV8&libraries=places&callback=initGoogleMaps"></script>

<?php require 'php/includes/footer.php' ?>