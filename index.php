<?php
session_start();
require_once 'config.php';

$page = $_GET['page'] ?? 'main';

if (!array_key_exists($page, $menu)) {
    $page = 'main'; // varsayılan sayfa
}

include 'templates/header.php';

$page_path = "pages/$page.php";
if (file_exists($page_path)) {
    include $page_path;
} else {
    echo "<h2>Page not found.</h2>";
}

include 'templates/footer.php';
?>