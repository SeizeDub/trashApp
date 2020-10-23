<?php require 'php/includes/admin-header.php';

if (isset($_GET['input-password']) && $_GET['input-password'] === 'admin') {
    $_SESSION['admin'] = true;
} else if (isset($_GET['disconnect'])) {
    session_destroy();
}

?>
 

<main id="admin">

<?php if (isset($_SESSION['admin'])): 
    $encombrants = getEncombrants($db); 
    $depots = getDepots($db);
?>

<div id="task-menu">
        <button class="task-button active" data-task="encombrants">Encombrants</button>
        <button class="task-button" data-task="depots">Dépots sauvages</button>
</div>

<section class="container active">
    <?php foreach($encombrants as $index=>$encombrant):?>
        <article class="encombrant-article <?= $index === 0 ? 'active' : null ?>" data-lat="<?= $encombrant['address_lat'] ?>"  data-lng="<?= $encombrant['address_lng'] ?>">
            <a class="call-button" href="tel:<?= $encombrant['phone'] ?>">Call</a>
            <h3><?= $encombrant['title'] ?></h3>
            <p class="datetime"><?= $encombrant['datetime'] ?></p>
            <div class="article-content">
                <p class="description"><?= $encombrant['description'] ?></p>
                <img src="uploads/<?= $encombrant['image'] ?>" alt="">
                <p class="size"><?= $encombrant['hauteur'].'x'.$encombrant['largeur'].'x'.$encombrant['profondeur'] ?> cm</p>
                <p class="address"><?= trimAddress($encombrant['address']) ?></p>
                <?php if ($index === 0): ?>
                <div id="map"></div>
                <?php endif; ?>
                <button class="main-button" data-task="encombrant" data-id="<?= $encombrant['id'] ?>">Archiver</button>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<section class="container">
<?php foreach($depots as $index=>$depot):?>
        <article class="encombrant-article <?= $index === 0 ? 'active' : null ?>" data-lat="<?= $depot['address_lat'] ?>"  data-lng="<?= $depot['address_lng'] ?>">
            <a class="call-button" href="tel:<?= $depot['phone'] ?>">Call</a>
            <h3><?= $depot['title'] ?></h3>
            <p class="timestamp"><?= $depot['timestamp'] ?></p>
            <div class="article-content">
                <p class="description"><?= $depot['description'] ?></p>
                <img src="uploads/<?= $depot['image'] ?>" alt="">
                <p class="size"<?= $depot['hauteur'].'x'.$depot['largeur'].'x'.$depot['profondeur'] ?> cm</p>
                <p class="address"><?= trimAddress($depot['address']) ?></p>
                <button class="main-button" data-task="depot" data-id="<?= $depot['id'] ?>" >Archiver</button>
            </div>
            
        </article>
    <?php endforeach; ?>
</section>

<?php else: ?>

<form action="admin" id="admin-login">
    <fieldset>
        <label for="input-password">Mot de passe</label>
        <input type="password" name="input-password" id="input-password" required>
    </fieldset>
    <fieldset>
        <input class="main-button" type="submit" value="Connexion">
    </fieldset>
</form>

<?php endif; ?>

</main>

<?php if (isset($_SESSION['admin'])): ?>
<script src="assets/js/src/admin.js"></script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAW9v4ik-x3ylxJM91bCgWBLCcc4MG6uV8&libraries=places&callback=initGoogleMaps"></script>
<?php endif;
require 'php/includes/footer.php';

function getEncombrants($db) {
    $sql = $db->query("SELECT encombrant.*, user.phone, user.address, user.address_lat, user.address_lng FROM encombrant INNER JOIN user WHERE encombrant.user_id = user.id AND archived IS FALSE ORDER BY encombrant.datetime");
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

function getDepots($db) {
    $sql = $db->query("SELECT depot.*, user.phone FROM depot INNER JOIN user WHERE depot.user_id = user.id AND archived IS FALSE ORDER BY timestamp");
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

function trimAddress($address) {
    $address = trim($address);
    $address = preg_replace('/, France$/', '', $address);
    return $address;
}
?>