<?php
require '../includes/connect.php';

if (!isset($_SESSION['id'])) exit;

function handleRequest($db) {

    if (!$db) return "error";

    $data = $_POST;

    foreach($data as $key => $value) {
        if (empty($value) && $key !== 'input-image') {
            return "missing";
        }
    }

    $user_id = htmlspecialchars($_SESSION['id']);
    $title = htmlspecialchars($_POST['input-title']);
    $description = htmlspecialchars($_POST['input-description']);
    $hauteur = htmlspecialchars($_POST['input-hauteur']);
    $largeur = htmlspecialchars($_POST['input-largeur']);
    $profondeur = htmlspecialchars($_POST['input-profondeur']);
    $datetime = htmlspecialchars($_POST['input-datetime']);

    $image = $_FILES['input-image'];
    $image_name = null;
    if ($image['error'] !== 4) {
        if ($image['error'] !== 0) {
            return "file";
        }
        $image_name = uniqid().'_'.$image['name'];
        $destination = "../../uploads";
        if (!move_uploaded_file($image['tmp_name'], "$destination/$image_name")) {
            return "file";
        }
    }

    $sth = $db->prepare("INSERT INTO encombrant
    (user_id, title, description, hauteur, largeur, profondeur, image, datetime) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$sth) return "error";

    $exc = $sth->execute([$user_id, $title, $description, $hauteur, $largeur, $profondeur, $image_name, $datetime]);
    if (!$exc) return "error";
    
    return "success";
}

echo handleRequest($db);