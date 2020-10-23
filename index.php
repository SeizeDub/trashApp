<?php require 'php/includes/header.php';

if (isset($_GET['disconnect'])) {
    session_destroy();
    header('Refresh:0;url=index.php');
    exit;
}
?>

<main id="hero">

<?php if (isset($_GET['success'])): ?>
    <div class="success">Votre requête a bien été prise en compte.</div>
<?php endif; ?>

<h2>Votre nouveau service pour des rues plus propres !</h2>
<p>Demander l'enlèvement d'un encombrant ou signaler un dépôt sauvage n'a jamais été aussi simple.</p>
<?php if(!isset($_SESSION['id'])): ?>
<p class="infos">Connectez-vous pour commencer à utiliser ce service.</p>
<a class="main-button" href="login">Connexion</a>
<p class="infos">Vous n'avez pas encore de compte ?</p>
<a class="main-button" href="register">Créer un compte</a>
<?php else: ?>
<a class="main-button" href="encombrant">Demander l'enlèvement d'un encombrant<br>à votre domicile</a>
<a class="main-button" href="depot">Signaler un dépôt sauvage<br>génant ou dangereux</a>
<?php endif; ?>

</main>
<?php require 'php/includes/footer.php' ?>