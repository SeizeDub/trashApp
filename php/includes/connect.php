<?php
ob_start();
session_start();

$host = 'localhost';
$dbname='trashapp';
$user='root'; 
$password='';

$db = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
?>