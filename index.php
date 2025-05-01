<?php
session_start();
include 'config.php';

$page = $_GET['page'] ?? 'main';
$page_path = "pages/$page.php";

// Header
include 'templates/header.php';

// Content
if (file_exists($page_path)) {
    include $page_path;
} else {
    echo "<h2>Page not found.</h2>";
}

// Footer
include 'templates/footer.php';

require_once 'config.php';

$page = $_GET['page'] ?? 'home';

if (!array_key_exists($page, $menu)) {
    $page = 'home'; // Varsayılan sayfa
}

include 'header.php';
include 'pages/' . $page . '.php';
include 'footer.php';
?>