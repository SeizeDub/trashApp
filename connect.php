<?php 
session_start();

$host = 'localhost';
$dbname='trashApp';
$user='root'; 
$password='';

$db = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
?>