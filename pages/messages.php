<?php
require 'config.php';

$stmt = $dbh->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Messages</h1>
<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>Name</th><th>Email</th><th>Message</th><th>Date</th>
  </tr>
  <?php foreach ($messages as $msg): ?>
    <tr>
      <td><?= htmlspecialchars($msg['name']) ?></td>
      <td><?= htmlspecialchars($msg['email']) ?></td>
      <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
      <td><?= $msg['created_at'] ?></td>
    </tr>
  <?php endforeach; ?>
</table>
