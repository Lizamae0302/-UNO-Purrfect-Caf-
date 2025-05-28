<?php
@include 'config.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM reviews WHERE id = $delete_id");
    header('Location: admin_reviews.php');
    exit;
}

// Handle update
if (isset($_POST['update_review'])) {
    $id = intval($_POST['review_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $rating = intval($_POST['rating']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    mysqli_query($conn, "UPDATE reviews SET name='$name', rating=$rating, message='$message' WHERE id=$id");
    header('Location: admin_reviews.php');
    exit;
}

// If edit mode
$edit_review = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM reviews WHERE id = $edit_id");
    $edit_review = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Reviews</title>

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
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
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
      .main {
         margin-left: 260px;
         padding: 20px;
         width: 100%;
      }
      .review-grid {
         display: flex;
         flex-wrap: wrap;
         gap: 20px;
      }
      .review-card {
         background: white;
         border-radius: 10px;
         box-shadow: 0 2px 5px rgba(0,0,0,0.1);
         padding: 15px;
         width: calc(50% - 10px);
         box-sizing: border-box;
      }
      .review-stars {
         color: #ffcc00;
         font-size: 1.2rem;
         margin: 5px 0;
      }
      .review-header {
         display: flex;
         justify-content: space-between;
         align-items: center;
         font-weight: bold;
      }
      .review-date {
         font-size: 0.9rem;
         color: gray;
         font-weight: normal;
      }
      h2{
        font-size:3rem;
        font-family: "DynaPuff", system-ui;
        color:#573818;
      }
      .review-card .mb-4 input text{
        color:#573818;
      }
      .form-group textarea .message{
        color:#573818;
      }
      p{
        color:#573818;}
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

<div class="main">
    <h2>Manage Reviews</h2>

    <?php if ($edit_review): ?>
        <div class="review-card mb-4">
            <h5>Edit Review #<?= $edit_review['id'] ?></h5>
            <form method="POST">
                <input type="hidden" name="review_id" value="<?= $edit_review['id'] ?>">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($edit_review['name']) ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Rating</label>
                    <select name="rating" class="form-control" required>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>" <?= ($edit_review['rating'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" class="form-control" rows="4" required><?= htmlspecialchars($edit_review['message']) ?></textarea>
                </div>
                <button type="submit" name="update_review" class="btn btn-primary">Update Review</button>
                <a href="admin_reviews.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    <?php endif; ?>

    <div class="review-grid">
        <?php
        $reviews = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC");
        if (mysqli_num_rows($reviews) > 0):
            while ($review = mysqli_fetch_assoc($reviews)):
        ?>
            <div class="review-card">
                <div class="review-header">
                    <div><?= htmlspecialchars($review['name']) ?></div>
                    <div class="review-date"><?= date('F j, Y', strtotime($review['created_at'])) ?></div>
                </div>
                <div class="review-stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa<?= $i <= $review['rating'] ? 's' : 'r' ?> fa-star"></i>
                    <?php endfor; ?>
                </div>
                <p><?= nl2br(htmlspecialchars($review['message'])) ?></p>
                <div>
                    <a href="admin_reviews.php?edit=<?= $review['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="admin_reviews.php?delete=<?= $review['id'] ?>" onclick="return confirm('Delete this review?')" class="btn btn-sm btn-danger">Delete</a>
                </div>
            </div>
        <?php endwhile; else: ?>
            <div class="col-12">
                <div class="alert alert-info">No reviews found.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
