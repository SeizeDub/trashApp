<?php
require '../includes/connect.php';

if (!isset($_SESSION['id'])) exit;

function handleRequest($db) {

    if (!$db) return "error";

    $data = $_POST;

    foreach($data as $key => $value) {
        if (empty($value)) {
            return "missing";
        }
    }

    $user_id = htmlspecialchars($_SESSION['id']);
    $title = htmlspecialchars($_POST['input-title']);
    $description = htmlspecialchars($_POST['input-description']);
    $hauteur = htmlspecialchars($_POST['input-hauteur']);
    $largeur = htmlspecialchars($_POST['input-largeur']);
    $profondeur = htmlspecialchars($_POST['input-profondeur']);
    $address = htmlspecialchars($_POST['input-address']);
    $address_lat = htmlspecialchars($_POST['input-lat']);
    $address_lng = htmlspecialchars($_POST['input-lng']);

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

    $sth = $db->prepare("INSERT INTO depot
    (user_id, title, description, hauteur, largeur, profondeur, image, address, address_lat, address_lng) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$sth) return "error";

    $exc = $sth->execute([$user_id, $title, $description, $hauteur, $largeur, $profondeur, $image_name, $address, $address_lat, $address_lng]);
    if (!$exc) return "error";
    
    return "success";
}

echo handleRequest($db);