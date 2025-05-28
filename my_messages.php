<?php
@include 'config.php';
session_start();
$user_id = $_SESSION['user_id'] ?? 0;

$messages = mysqli_query($conn, "SELECT * FROM messages WHERE user_id=$user_id ORDER BY created_at DESC") or die('Query failed');
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Messages</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" />
</head>
<body>
<div class="container mt-5">
  <h2>My Messages & Replies</h2>
  <?php while ($msg = mysqli_fetch_assoc($messages)): ?>
    <div class="card mb-3">
      <div class="card-header">
        <strong>Subject:</strong> <?= htmlspecialchars($msg['subject']) ?>
        <span class="float-right"><?= $msg['created_at'] ?></span>
      </div>
      <div class="card-body">
        <p><strong>Your Message:</strong><br><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
        <?php if ($msg['reply']): ?>
          <div class="alert alert-success">
            <strong>Admin Reply:</strong><br><?= nl2br(htmlspecialchars($msg['reply'])) ?><br>
            <small><i>Replied on <?= $msg['replied_at'] ?></i></small>
          </div>
        <?php else: ?>
          <div class="alert alert-warning">No reply yet.</div>
        <?php endif; ?>
      </div>
    </div>
  <?php endwhile; ?>
</div>
</body>
</html>
