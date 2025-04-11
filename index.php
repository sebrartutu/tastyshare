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
?>