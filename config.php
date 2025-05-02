<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$menu = [
    'main' => 'Home',
    'images' => 'Images',
    'contact' => 'Contact',
    'messages' => 'Messages',
    'login' => 'Login',
    'logout' => 'Logout',
    'recipes' => 'Recipes',
    'register' => null
];


$site_title = "TastyShare";


$host = '127.0.0.1';
$dbname = 'tastyshare';     
$dbuser = 'root';         
$dbpass = '';               

$dsn = "mysql:host=127.0.0.1;dbname=tastyshare;charset=utf8mb4";

try {
    $dbh = new PDO($dsn, $dbuser, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>