<?php

require '../includes/connect.php';

function handleRequest() {
    global $db;
    if (!$db) {
        return "error";
    }
    
    $data = $_POST;

    foreach($data as $key => $value) {
        if (empty($value) && $key !== 'input-address-plus') {
            return "missing";
        }
    }
    
    $input_name = htmlspecialchars($data['input-name']);
    $input_phone = htmlspecialchars($data['input-phone']);
    $input_email = htmlspecialchars($data['input-email']);
    $input_password = htmlspecialchars($data['input-password']);
    $input_address = htmlspecialchars($data['input-address']);
    $input_addressPlus = htmlspecialchars($data['input-address-plus']);
    $input_lat = htmlspecialchars($data['input-lat']);
    $input_lng = htmlspecialchars($data['input-lng']);

    if (!$sql = $db->query("SELECT * FROM user WHERE email = '$input_email'")) {
        return "error";
    }
    if ($sql->rowCount() !== 0) {
        return "email";
    }

    $input_password = password_hash($input_password, PASSWORD_DEFAULT);

    $sth = $db->prepare("INSERT INTO user(name, phone, email, password, address, address_plus, address_lat, address_lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$sth->execute([$input_name, $input_phone, $input_email, $input_password, $input_address, $input_addressPlus, $input_lat, $input_lng])) {
        return "error";
    }

    $_SESSION['id'] = $db->lastInsertId();
    return "success";
}

echo handleRequest();



