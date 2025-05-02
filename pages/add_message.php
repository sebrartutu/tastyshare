<?php
require 'config.php';

if ($dbh) {
    echo "✅ VERİTABANI BAĞLANTISI BAŞARILI<br>";
} else {
    echo "❌ BAĞLANTI YOK<br>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if ($name && $email && $message) {
        $stmt = $dbh->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        header("Location: contact.php?success=1");
        exit;
    } else {
        echo "Lütfen tüm alanları doldurun.";
    }
}
?>
