<?php require 'connect.php' ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($encombrant)) {
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">';
    }?>
    <link rel="stylesheet" href="assets/css/dist/main.min.css">
    <title>Document</title>
</head>
<body>
    <header>
        <a href="index"><h1>
            <span>Bordeaux</span>
            <span><span>trash</span>App</span>
        </h1>
        </a>
        <nav>
        <button id="hamburger">Menu</button>
            <ul id="header-menu">
                <li><a href="index">Accueil</a></li>
            <?php if (isset($_SESSION['id'])): ?>
                <li><a href="account">Mon compte</a></li>
                <li><a href="index?disconnect">Deconnexion</a></li>
            <?php else: ?>
                <li><a href="login">Connexion</a></li>
                <li><a href="register">Inscription</a></li>
            <?php endif; ?>
            </ul>
            
        </nav>
        <script>
            document.getElementById('hamburger').onclick = () => {
                let menu = document.getElementById('header-menu');
                if (menu.classList.contains('active')) {
                    menu.classList.remove('active');
                } else {
                    menu.classList.add('active');
                }
            }
        </script>
    </header>