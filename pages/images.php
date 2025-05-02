<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isset($_SESSION['user_id']);
$uploadDir = "../assets/uploads/";
$uploadSuccess = false;
$error = "";

// Klasör yoksa oluştur
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Silme işlemi (sadece giriş yapmış kullanıcı için)
if ($loggedIn && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $fileToDelete = basename($_POST['delete']);
    $filePath = $uploadDir . $fileToDelete;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Yükleme işlemi (sadece giriş yapmış kullanıcı için)
if ($loggedIn && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
    $file = $_FILES["image"];
    $allowedTypes = ["image/jpeg", "image/png", "image/gif"];

    if ($file["error"] === 0 && in_array($file["type"], $allowedTypes)) {
        $filename = time() . "_" . basename($file["name"]);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($file["tmp_name"], $targetPath)) {
            $uploadSuccess = true;
        } else {
            $error = "Upload failed.";
        }
    } else {
        $error = "Invalid file type or upload error.";
    }
}

// Mevcut resimleri al
$images = array_diff(scandir($uploadDir), ['.', '..']);
?>

<h2>Image Gallery</h2>

<?php if ($uploadSuccess): ?>
    <p style="color: green;">✅ Image uploaded successfully!</p>
<?php elseif ($error): ?>
    <p style="color: red;">❌ <?= $error ?></p>
<?php endif; ?>

<!-- Yükleme Formu -->
<?php if ($loggedIn): ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Select Image:
            <input type="file" name="image" accept="image/*" required>
        </label>
        <button type="submit">Upload</button>
    </form>
<?php else: ?>
    <p style="color: red;">⚠ You must be logged in to upload or delete images.</p>
<?php endif; ?>

<hr>

<!-- Galeri -->
<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <?php foreach ($images as $img): ?>
        <div style="text-align: center;">
            <img src="../assets/uploads/<?= htmlspecialchars($img) ?>" width="180" alt="Image"><br>
            <?php if ($loggedIn): ?>
                <form method="POST" onsubmit="return confirm('Delete this image?');">
                    <input type="hidden" name="delete" value="<?= htmlspecialchars($img) ?>">
                    <button type="submit">Delete</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
