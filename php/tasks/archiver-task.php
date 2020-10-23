<?php
require '../includes/connect.php';

$task = htmlspecialchars($_GET['task']);
$id = htmlspecialchars($_GET['id']);

$sth = $db->query("UPDATE $task SET archived = 1 WHERE id = $id");

if ($sth) {
    echo "success";
} else {
    echo "error";
}

