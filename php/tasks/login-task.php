<?php

require '../includes/connect.php';

function loginRequestHandler() {

    global $db;
    if (!$db) {
        return "error";
    }
    
    $data = $_POST;

    foreach($data as $key => $value) {
        if (empty($value)) {
            return "missing";
        }
    }

    $input_email = htmlspecialchars($data['input-email']);
    $input_password = htmlspecialchars($data['input-password']);

    if (!$sql = $db->query("SELECT * FROM user WHERE email = '$input_email'")) {
        return "error";
    }
    if (!$user = $sql->fetch(PDO::FETCH_ASSOC)) {
        return "email";
    }
    $user_id = $user['id'];
    $user_email = $user['email'];
    $user_password = $user['password'];

    if(!password_verify($input_password, $user_password)) {
        return "password";
    }

    $_SESSION['id'] = $user_id;
    return "success";
}

$response = loginRequestHandler();
echo $response;