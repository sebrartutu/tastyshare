<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $site_title ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1><?= $site_title ?></h1>
    <nav>
        <ul>
            <?php
            foreach ($menus as $key => $value) {
                if (isset($_SESSION['user']) && $key == 'login') continue;
                if (!isset($_SESSION['user']) && $key == 'logout') continue;

                echo "<li><a href='?page=$key'>$value</a></li>";
            }
            ?>
        </ul>
    </nav>
    <?php if (isset($_SESSION['user'])): ?>
        <p>Logged-in: <?= $_SESSION['user']['name'] ?> (<?= $_SESSION['user']['username'] ?>)</p>
    <?php endif; ?>
</header>
<main>