<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isset($_SESSION['user_id']);
$uploadDir = "../assets/uploads_recipes/";
$uploadSuccess = false;
$error = "";

// Klasör yoksa oluştur
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Tarif yükleme işlemi (sadece giriş yapanlar)
if ($loggedIn && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["recipe_image"])) {
    $file = $_FILES["recipe_image"];
    $description = trim($_POST["description"] ?? '');
    $allowedTypes = ["image/jpeg", "image/png", "image/gif"];

    if ($file["error"] === 0 && in_array($file["type"], $allowedTypes) && !empty($description)) {
        $filenameBase = time();
        $filename = $filenameBase . "_" . basename($file["name"]);
        $targetPath = $uploadDir . $filename;
        $textPath = $uploadDir . $filenameBase . ".txt";

        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            file_put_contents($textPath, $description);
            $uploadSuccess = true;
        } else {
            $error = "Upload failed.";
        }
    } else {
        $error = "Invalid file or missing description.";
    }
}

// Tarifleri oku
$recipes = [];
foreach (scandir($uploadDir) as $file) {
    if (preg_match('/^\d+_.+\.(jpg|jpeg|png|gif)$/i', $file)) {
        $base = explode('_', $file)[0];
        $textFile = $uploadDir . $base . ".txt";
        $desc = file_exists($textFile) ? file_get_contents($textFile) : "(No description)";
        $recipes[] = [
            'image' => $file,
            'description' => $desc
        ];
    }
}
?>

<h2>Recipe Gallery</h2>

<?php if ($uploadSuccess): ?>
    <p style="color: green;">✅ Recipe uploaded successfully!</p>
<?php elseif ($error): ?>
    <p style="color: red;">❌ <?= $error ?></p>
<?php endif; ?>

<?php if ($loggedIn): ?>
    <!-- Tarif ekleme formu -->
    <form method="POST" enctype="multipart/form-data">
        <label>Select Image:
            <input type="file" name="recipe_image" accept="image/*" required>
        </label><br><br>
        <label>Recipe Description:<br>
            <textarea name="description" rows="4" cols="40" required></textarea>
        </label><br><br>
        <button type="submit">Add Recipe</button>
    </form>
<?php else: ?>
    <p style="color: red;">⚠️ You must be logged in to add a recipe.</p>
<?php endif; ?>

<hr>

<!-- Tarif listesi -->
<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <?php foreach ($recipes as $r): ?>
        <div style="text-align: center; width: 220px;">
            <img src="../assets/uploads_recipes/<?= htmlspecialchars($r['image']) ?>" width="200" alt="Recipe"><br>
            <p><?= nl2br(htmlspecialchars($r['description'])) ?></p>
        </div>
    <?php endforeach; ?>
</div>
