<?php
require_once 'config.php';
require_once 'db.php';

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($name) || empty($username) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO users (name, username, password) VALUES (?, ?, ?)");
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt->execute([$name, $username, $hashed]);
            $success = true;
        } catch (PDOException $e) {
            $errors[] = "Username already exists.";
        }
    }
}
?>

<h2>Register</h2>
<?php foreach ($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>
<?php if ($success) echo "<p style='color:green;'>Registration successful!</p>"; ?>

<form method="POST">
    <label>Name: <input name="name"></label><br><br>
    <label>Username: <input name="username"></label><br><br>
    <label>Password: <input type="password" name="password"></label><br><br>
    <button type="submit">Register</button>
</form>
