<?php
require '../includes/connect.php';

if (!isset($_SESSION['id'])) exit;
$user_id = htmlspecialchars($_SESSION['id']);
$task = $_GET['task'];

$input_title = htmlspecialchars($_POST['input-title']);
$input_description = htmlspecialchars($_POST['input-description']);
$input_size_h = htmlspecialchars($_POST['input-hauteur']);
$input_size_l = htmlspecialchars($_POST['input-largeur']);
$input_size_p = htmlspecialchars($_POST['input-profondeur']);

if ($task === 'encombrant') {
    $sql = $db->query("SELECT address, address_lat, address_lng FROM user WHERE id = $user_id");
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    $input_address = $data['address'];
    $input_address_lat = $data['address_lat'];
    $input_address_lng = $data['address_lng'];
    $input_date = htmlspecialchars($_POST['input-date']);
    $input_time = htmlspecialchars($_POST['input-time']);
} else if ($task === 'depot') {
    $input_address = htmlspecialchars($_POST['input-address']);
    $input_address_lat = htmlspecialchars($_POST['input-lat']);
    $input_address_lng = htmlspecialchars($_POST['input-lng']);
    $input_danger = htmlspecialchars($_POST['input-danger']) === 'on' ? true : false;
}

$image = $_FILES['input_image'];
if (!empty($image)) {
    $image_name = uniqid().'_'.$image['name'];
    $upload_dir = "./uploads/";
    $upload_name = $upload_dir . $image_name;
    $move_result = move_uploaded_file($image['tmp_name'], $upload_name);
}

$sth = $db->prepare("INSERT INTO report(user_id, title, description, danger, size_h, size_l, size_p, image_url, date, time, address, address_plus, address_lat, address_lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$sth->execute([$input_name, $input_phone, $input_email, $input_password, $input_address, $input_addressPlus, $input_lat, $input_lng])) {
        return array("error" => "Une erreur s'est produite.");
    }

// input-image

// sql stuff



