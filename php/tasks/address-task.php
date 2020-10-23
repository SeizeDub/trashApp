<?php
require '../includes/connect.php';

if (!isset($_SESSION['id'])) exit;
$user_id = htmlspecialchars($_SESSION['id']);

$sql = $db->query("SELECT address, address_lat, address_lng FROM user WHERE id = $user_id");
$data = $sql->fetch(PDO::FETCH_ASSOC);

$data = (object) $data;
$data = json_encode($data);

echo $data;