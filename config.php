<?php
if (session_status() === PHP_SESSION_NONE) session_start();


$menus = [
    'main' => 'Home',
    'images' => 'Images',
    'contact' => 'Contact',
    'messages' => 'Messages',
    'login' => 'Login',
    'logout' => 'Logout'
];

$site_title = "TastyShare";
?>
