<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isset($_SESSION['user']);

$uploadDir = __DIR__ . "/../assets/uploads_recipes/";
$webPath = "../assets/uploads_recipes/";
$uploadSuccess = false;
$error = "";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($loggedIn && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["recipe_image"])) {
    $file = $_FILES["recipe_image"];
    $description = trim($_POST["description"] ?? '');
    $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
    $maxSize = 2 * 1024 * 1024; 

    if (
        $file["error"] === 0 &&
        in_array($file["type"], $allowedTypes) &&
        !empty($description) &&
        $file["size"] <= $maxSize
    ) {
        $filenameBase = time();
        $safeName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", basename($file["name"]));
        $filename = $filenameBase . "_" . $safeName;

        $targetPath = $uploadDir . $filename;
        $textPath = $uploadDir . $filenameBase . ".txt";

        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            if (file_put_contents($textPath, $description)) {
                $uploadSuccess = true;
            } else {
                $error = "Image uploaded, but description could not be saved.";
            }
        } else {
            $error = "Image upload failed.";
        }
    } else {
        $error = "Invalid file, too large (max 2MB), or missing description.";
    }
}

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipe Gallery</title>
</head>
<body>

<h2>Recipe Gallery</h2>

<?php if ($uploadSuccess): ?>
    <p style="color: green;">✅ Recipe uploaded successfully!</p>
<?php elseif ($error): ?>
    <p style="color: red;">❌ <?= htmlspecialchars($error) ?></p>
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

<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <?php foreach ($recipes as $r): ?>
        <div style="text-align: center; width: 220px;">
            <img src="<?= $webPath . htmlspecialchars($r['image']) ?>" width="200" alt="Recipe"><br>
            <p><?= nl2br(htmlspecialchars($r['description'])) ?></p>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>