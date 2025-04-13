<?php
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    if (empty($name)) $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
    if (empty($message)) $errors[] = "Message is required.";

    if (empty($errors)) {
        $success = true;
    }
}
?>

<h2>Contact Us</h2>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="color: green;">
        <p>Thank you for your message!</p>
        <p><strong><?php echo htmlspecialchars($name); ?></strong> (<?php echo htmlspecialchars($email); ?>):</p>
        <p><?php echo nl2br(htmlspecialchars($message)); ?></p>
    </div>
<?php endif; ?>

<form id="contactForm" method="POST" onsubmit="return validateForm();">
    <label>Name: <input type="text" name="name" id="name"></label><br><br>
    <label>Email: <input type="text" name="email" id="email"></label><br><br>
    <label>Message:<br>
        <textarea name="message" id="message" rows="5" cols="40"></textarea>
    </label><br><br>
    <button type="submit">Send</button>
</form>

<script>
function validateForm() {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let message = document.getElementById("message").value.trim();
    let errorMsg = "";

    if (name === "") errorMsg += "Name is required.\n";
    if (email === "" || !email.includes("@")) errorMsg += "Valid email is required.\n";
    if (message === "") errorMsg += "Message is required.\n";

    if (errorMsg !== "") {
        alert(errorMsg);
        return false;
    }

    return true;
}
</script>