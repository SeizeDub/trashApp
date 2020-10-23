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
        <?php if (isset($_SESSION['admin'])): ?>
        <nav>
            <a href="admin?disconnect">Deconnexion</a></li>
        </nav>
        <?php endif; ?>
    </header>