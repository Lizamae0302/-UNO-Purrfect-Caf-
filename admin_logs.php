<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Admin check – add your own session validation here if needed

// Fetch all users
$users_result = mysqli_query($conn, "SELECT id, name FROM users");
$selected_user_id = $_GET['user_id'] ?? null;

// Fetch user logs if user is selected
$product_logs = [];
$reservation_logs = [];

if ($selected_user_id) {
    $product_logs = mysqli_query($conn, "SELECT * FROM user_logs WHERE user_id = '$selected_user_id' ORDER BY order_time DESC");
    $reservation_logs = mysqli_query($conn, "SELECT * FROM reservations WHERE email = (SELECT email FROM users WHERE id = '$selected_user_id') ORDER BY date DESC, time DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - User Logbook</title>
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
    h2 {
      font-size:3rem;
        color: #573818;
    }
    .log-table th {
        background-color: #573818;
        color: white;
        font-weight:normal;
    }
    .container {
         margin-left: 260px;
         font-family: "DynaPuff", system-ui;
         padding: 20px;
         width: 100%;
      }
      h3 {
      font-size:1.7rem;
        color: #573818;
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
   <a href="admin_orders.php">Orders</a>
   <a href="admin_users.php">Users</a>
   <a href="admin_logs.php">Log Book</a>
   <a href="admin_messages.php">Messages</a>
   <a href="admin_reviews.php">Reviews</a>
   <a href="logout.php">Logout</a>
</div>

<div class="container mt-5">
  <h2 class="text-center mb-4">📖 Admin Logbook</h2>

  <form method="GET" class="form-inline mb-4 justify-content-center">
    <label class="mr-2">Select User:</label>
    <select name="user_id" class="form-control mr-2" onchange="this.form.submit()">
      <option value="">-- Select a user --</option>
      <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
        <option value="<?= $user['id']; ?>" <?= ($user['id'] == $selected_user_id) ? 'selected' : ''; ?>>
          <?= $user['name']; ?>
        </option>
      <?php endwhile; ?>
    </select>
  </form>

  <?php if ($selected_user_id): ?>
    <h3>📅 Room Reservation Log</h3>
    <table class="table table-bordered log-table">
      <thead>
        <tr>
          <th>Room</th>
          <th>Branch</th>
          <th>Date</th>
          <th>Time</th>
          <th>Guests</th>
          <th>Notes</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($reservation_logs) > 0): ?>
          <?php while ($res = mysqli_fetch_assoc($reservation_logs)): ?>
            <tr>
              <td><?= htmlspecialchars($res['room']); ?></td>
              <td><?= htmlspecialchars($res['branch']); ?></td>
              <td><?= $res['date']; ?></td>
              <td><?= $res['time']; ?></td>
              <td><?= $res['guests']; ?></td>
              <td><?= htmlspecialchars($res['notes']); ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center">No reservations found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info text-center">Please select a user to view their logbook.</div>
  <?php endif; ?>

</div>
</body>
</html>
