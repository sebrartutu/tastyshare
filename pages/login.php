<?php
require_once 'config.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $stmt = $dbh->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user; 
            header("Location: index.php"); 
            exit;
        } else {
            $errors[] = "Invalid username or password.";
        }
    }
}
?>
<div class="register_box">
  <h2>Login</h2>

  <?php foreach ($errors as $e): ?>
    <p style='color:red;'><?= htmlspecialchars($e) ?></p>
  <?php endforeach; ?>

  <form method="POST">
    <label>Username: <input name="username" required></label><br><br>
    <label>Password: <input type="password" name="password" required></label><br><br>
    <button type="submit">Login</button>
  </form>

  <p>Don't have an account? <a href="index.php?page=register">Register here</a></p>
</div>
