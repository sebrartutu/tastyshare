<?php
$uploadDir = "assets/uploads/";
$uploadSuccess = false;
$error = "";

// Klasör yoksa oluştur
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Resim yüklendiyse işle
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
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

// Yüklenmiş resimleri al
$images = array_diff(scandir($uploadDir), ['.', '..']);
?>

<h2>Image Gallery</h2>

<?php if ($uploadSuccess): ?>
    <p style="color: green;">✅ Image uploaded successfully!</p>
<?php elseif ($error): ?>
    <p style="color: red;">❌ <?= $error ?></p>
<?php endif; ?>

<
<form method="POST" enctype="multipart/form-data">
    <label>Select Image:
        <input type="file" name="image" accept="image/*" required>
    </label>
    <button type="submit">Upload</button>
</form>

<hr>


<div style="display: flex; flex-wrap: wrap; gap: 10px;">
    <?php foreach ($images as $img): ?>
        <div>
            <img src="assets/uploads/<?= htmlspecialchars($img) ?>" width="150" alt="Image">
        </div>
   <?php endforeach; ?>
</div> 
