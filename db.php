<?php
$host = 'localhost'; 
$dbname = 'your_db_name';
$dbuser = 'your_db_user';
$dbpass = 'your_db_password';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $dbh = new PDO($dsn, $dbuser, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>