<?php
require_once __DIR__ . '/../config.php';
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $family_name = trim($_POST["family_name"]);
    $surname = trim($_POST["surname"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($family_name) || empty($surname) || empty($username) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $dbh->prepare("INSERT INTO users (family_name, surname, username, password) VALUES (?, ?, ?, ?)");

        try {
            $stmt->execute([$family_name, $surname, $username, $hashed]);
            $success = true;
        } catch (PDOException $e) {
            $errors[] = "Username already exists.";
        }
    }
}
?>
<div class="register-box">
  <h2>Register</h2>

  <?php foreach ($errors as $e): ?>
    <p style='color:red;'><?= htmlspecialchars($e) ?></p>
  <?php endforeach; ?>

  <?php if ($success): ?>
    <p style='color:green;'>Registration successful! <a href="index.php?page=login">Login here</a></p>
  <?php endif; ?>

  <form method="POST">
    <label>Family Name: <input name="family_name" required></label><br><br>
    <label>Surname: <input name="surname" required></label><br><br>
    <label>Username: <input name="username" required></label><br><br>
    <label>Password: <input type="password" name="password" required></label><br><br>
    <button type="submit">Register</button>
  </form>
</div>