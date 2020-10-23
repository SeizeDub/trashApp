<?php require 'php/includes/header.php';

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['id'];
$user = getUser($user_id, $db);

function getUser($user_id, $db) {
    $sql = $db->query("SELECT * FROM user WHERE id = $user_id");
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    return $data;
}

?>

<main>

<h2>Mon compte</h2>

<form>
<fieldset>
        <label for="input-email">Adresse e-mail</label>
        <input type="email" name="input-email" id="input-email" required value="<?= $user['email'] ?>">
    </fieldset>
    <p class="infos">Entrez votre mot de passe pour modifier vos informations personnelles.</p>
    <fieldset>
        <label for="input-password">Mot de passe</label>
        <input type="password" name="input-password" id="input-password" required>
    </fieldset>
    <fieldset>
        <label for="input-new-password">Nouveau mot de passe</label>
        <input type="password" name="input-new-password" id="input-new-password" required>
    </fieldset>
    <hr>
    <fieldset>
        <label for="input-name">Nom complet</label>
        <input type="text" name="input-name" id="input-name" required value="<?= $user['name'] ?>">
    </fieldset>
    <fieldset>
        <label for="input-phone">N° téléphone</label>
        <input type="tel" name="input-phone" id="input-phone" required value="<?= $user['phone'] ?>">
    </fieldset>
    <hr>
    <fieldset>
        <label for="input-address">Adresse</label>
        <input type="text" name="input-address" id="input-address" required placeholder="exemple : 58 rue de Marseille, Bordeaux" value="<?= $user['address'] ?>">
        <p class="input-infos">Veuillez choisir une adresse de domicile valide parmis les options proposées dans la liste déroulante.</p>
    </fieldset>
    <fieldset>
        <label for="input-address-plus">Complément d'adresse <span class="optional-tag">(facultatif)</span></label>
        <input type="text" name="input-address-plus" id="input-address-plus" value="<?= $user['address_plus'] ?>">
    </fieldset>
    <fieldset>
        <input class="main-button" type="submit" value="Modifier">
    </fieldset>
</form>

</main>
<script src="assets/js/src/formValidation.js"></script>
<?php require 'php/includes/footer.php' ?>