<?php
@include 'config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'] ?? 0;

if (!$user_id) {
    die('You must be logged in to send a message.');
}

// Handle form submission
if (isset($_POST['send'])) {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $imgPath = '';

    // Handle image upload if exists
    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image']['name'];
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $imgPath = $target_dir . time() . '_' . basename($img);
        move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);
    }

    // Get or create conversation
    $conv = mysqli_query($conn, "SELECT id FROM conversations WHERE user_id = $user_id");
    if (mysqli_num_rows($conv) > 0) {
        $conv_id = mysqli_fetch_assoc($conv)['id'];
    } else {
        mysqli_query($conn, "INSERT INTO conversations (user_id) VALUES ($user_id)");
        $conv_id = mysqli_insert_id($conn);
    }

    // Insert the message
    mysqli_query($conn, "INSERT INTO conversation_messages (conversation_id, sender, message, image)
                         VALUES ($conv_id, 'user', '$message', '$imgPath')");

    // Set success message in session
    $_SESSION['success'] = "Message sent!";

    // Redirect to same page to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch conversation and messages
$conv = mysqli_query($conn, "SELECT id FROM conversations WHERE user_id = $user_id");
$messages = [];
if (mysqli_num_rows($conv) > 0) {
    $conv_id = mysqli_fetch_assoc($conv)['id'];
    $messages = mysqli_query($conn, "SELECT * FROM conversation_messages WHERE conversation_id = $conv_id ORDER BY sent_at ASC");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Contact Admin</title>
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

    <!-- icons links -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- icons links -->
     
    <!-- animation links -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation links -->

    <!-- Swiper CSS -->
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" />
  <style>
    .container{
        margin-top:30px;
    }
    .section .container{
        margin-top:1000px;
    }
    h3{
      padding-top:10rem;
    }
    .container h3{
      font-size:4rem;
      font-weight:bold;
      color:#573818;
    }
    .form-group label{
      font-size:2rem;
      color:rgb(199, 139, 28);
    }
    .form-group textarea{
      height:80px;
      width:350px;
    }
    .form-group input{
      font-size:1.5rem;
    }
    .col-md-8 strong{
      font-size:2rem;
      font-weight:normal;
      color:#573818;
    }
    .col-md-8{
      font-size:2rem;
      font-weight:normal;
      color:rgb(199, 139, 28);
    }
    .col-md-4 button{
      margin-left:1rem;
      margin-right:10rem;
      padding-left:2rem;
      padding-right:2rem;
    }
  </style>
</head>
<body>
  <?php @include 'headerr.php'; ?>

<div class="container mt-5">
  <h3 data-aos="fade-up" data-aos-duration="1000">Message Admin</h3>

  <?php 
    if (!empty($_SESSION['success'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']);
    }
  ?>

  <div class="container">
  <div class="row">
    <!-- Message Display Area (Left Column) -->
    <div class="col-md-8" data-aos="fade-up" data-aos-duration="1000">
      <div class="border p-3 mb-4" style="height: 400px; overflow-y: auto; width:550px;">
        <?php if ($messages && mysqli_num_rows($messages) > 0): ?>
          <?php while ($msg = mysqli_fetch_assoc($messages)): ?>
            <div class="mb-3">
              <strong><?= ucfirst(htmlspecialchars($msg['sender'])) ?>:<br></strong> <?= nl2br(htmlspecialchars($msg['message'])) ?><br>
              <?php if (!empty($msg['image'])): ?>
                <img src="<?= htmlspecialchars($msg['image']) ?>" width="150" class="mt-2" />
              <?php endif; ?>
              <small class="text-muted d-block"><?= $msg['sent_at'] ?></small>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-muted">No messages yet. Start a conversation below.</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Input Form (Right Column) -->
    <div class="col-md-4" data-aos="fade-left" data-aos-duration="2000">
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group mb-2">
          <label class="small">Your Message</label>
          <textarea name="message" class="form-control form-control-sm" rows="3" required></textarea><br><br>
        </div>
        <div class="form-group">
          <label class="small">Attach Image (optional)</label>
          <input type="file" name="image" class="form-control-file" /><br>
        </div>
        <button type="submit" name="send" class="btn btn-sm btn-primary">Send</button>
      </form>
    </div>
  </div>
</div>

<script src="js/script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>

      <script>
  // Save current scroll position
  document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", () => {
      localStorage.setItem("scrollY", window.scrollY);
    });
  });

  // Restore scroll position on page load
  window.addEventListener("load", () => {
    const scrollY = localStorage.getItem("scrollY");
    if (scrollY) {
      window.scrollTo(0, scrollY);
      localStorage.removeItem("scrollY");
    }
  });
</script>
</body>
</html>