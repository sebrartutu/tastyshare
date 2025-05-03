<?php
require 'config.php';

$stmt = $dbh->query("SELECT messages.*, IFNULL(users.name, 'Guest') AS sender_name 
                     FROM messages 
                     LEFT JOIN users ON messages.user_id = users.user_id 
                     ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please Login.";
    exit;
}
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
