<?php
@include 'config.php';
session_start();

$conv_id = intval($_GET['id']);

if (!$conv_id) {
    die('Invalid conversation ID.');
}

if (isset($_POST['reply'])) {
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    $imgPath = '';

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image']['name'];
        $target_dir = "uploads/";
        // Create uploads folder if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $imgPath = $target_dir . time() . '_' . basename($img);
        move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);
    }

    // Insert the reply message into DB
    mysqli_query($conn, "INSERT INTO conversation_messages (conversation_id, sender, message, image)
                         VALUES ($conv_id, 'admin', '$msg', '$imgPath')") or die(mysqli_error($conn));

    // Store success message in session
    $_SESSION['success'] = "Reply sent successfully.";

    // Redirect to the same page to prevent form resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $conv_id);
    exit;
}

// Fetch conversation messages
$messages = mysqli_query($conn, "
  SELECT * FROM conversation_messages
  WHERE conversation_id = $conv_id
  ORDER BY sent_at ASC
") or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Admin Products</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <!-- fonts links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <!-- fonts links -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
    body {
         font-family: "DynaPuff", system-ui;
         background-color: #F7E6CA;
         display: flex;
      }
      .sidebar {
         width: 250px;
         background: #2e1700;
         color: white;
         height: 100vh;
         padding: 20px;
         position: fixed;
      }
      .sidebar a {
         display: block;
         color: white;
         margin-bottom: 15px;
         text-decoration: none;
      }
      .container {
         margin-left: 260px;
         font-family: "DynaPuff", system-ui;
         padding: 20px;
         width: 100%;
      }
      h3{
        font-size:3rem;
        color:#573818;
      }
      .mb-3 strong{
      font-size:1rem;
      font-weight:normal;
      color:#573818;
    }
    .mb-3{
      font-size:1rem;
      font-weight:normal;
      color:rgb(199, 139, 28);
    }
    h4{
   background-image: linear-gradient(45deg, #ff6b6b, #ffcc5c, #4ecdc4, #556270, #eb41c0);
   background-size: 300% 300%;
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   animation: movingColors 3s infinite linear;
   padding-top: 30px;
   font-size: 1.3rem;
   margin: 0;
}
      @keyframes movingColors {
   0% { background-position: 0% 50%; }
   50% { background-position: 100% 50%; }
   100% { background-position: 0% 50%; }
}
</style>  
</head>
<body>
    <div class="sidebar">
   <h4>Purrfect Café</h4><br>
   <a href="admin_page.php">Dashboard</a>
   <a href="admin_products.php">Products</a>
   <a href="admin_bookings.php">Bookings</a>
   <a href="admin_users.php">Users</a>
   <a href="admin_logbook.php">Log Book</a>
   <a href="admin_messages.php">Messages</a>
   <a href="admin_reviews.php">Reviews</a>
   <a href="logout.php" onclick="return confirm('Logout?')">Logout</a>
</div>

<div class="container mt-5">
  <h3>Conversation</h3>

  <?php 
    if (!empty($_SESSION['success'])) {
      echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
      unset($_SESSION['success']);
    }
  ?>

  <div class="border p-3 mb-4" style="height: 400px; overflow-y: scroll;">
    <?php while ($msg = mysqli_fetch_assoc($messages)): ?>
      <div class="mb-3">
        <strong><?= ucfirst(htmlspecialchars($msg['sender'])) ?>:<br></strong> <?= nl2br(htmlspecialchars($msg['message'])) ?><br>
        <?php if (!empty($msg['image'])): ?>
          <img src="<?= htmlspecialchars($msg['image']) ?>" width="130" class="mt-2" /><br>
        <?php endif; ?>
        <small class="text-muted"><?= $msg['sent_at'] ?></small>
      </div>
    <?php endwhile; ?>
  </div>

  <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <textarea name="message" class="form-control" rows="3" placeholder="Type your reply..." required></textarea>
    </div>
    <div class="form-group">
      <input type="file" name="image" class="form-control-file" />
    </div>
    <button type="submit" name="reply" class="btn btn-success">Send Reply</button>
  </form>
</div>
</body>
</html>
