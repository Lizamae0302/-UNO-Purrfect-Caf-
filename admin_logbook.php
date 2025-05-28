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

// Get selected user ID from GET, and sanitize it as integer
$selected_user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

// Initialize arrays
$product_logs = [];
$room_bookings = [];

if ($selected_user_id) {
    // Use prepared statements to avoid SQL injection (recommended)
    // But if you want a quick fix without prepared statements:

    // Fetch product logs for selected user
    $product_logs_result = mysqli_query($conn, "SELECT * FROM product_orders WHERE user_id = $selected_user_id ORDER BY order_time DESC");

    // Fetch room bookings for selected user (using user_id)
    $room_bookings_result = mysqli_query($conn, "SELECT * FROM room_bookings WHERE user_id = $selected_user_id ORDER BY booking_date DESC, booking_time DESC");

    // Fetch results into arrays
    if ($product_logs_result) {
        $product_logs = mysqli_fetch_all($product_logs_result, MYSQLI_ASSOC);
    }

    if ($room_bookings_result) {
        $room_bookings = mysqli_fetch_all($room_bookings_result, MYSQLI_ASSOC);
    }
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
    .table-striped th {
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
   <a href="admin_users.php">Users</a>
   <a href="admin_logbook.php">Log Book</a>
   <a href="admin_messages.php">Messages</a>
   <a href="admin_reviews.php">Reviews</a>
   <a href="logout.php" onclick="return confirm('Logout?')">Logout</a>
</div>

<div class="container mt-4">
    <h2 class="mb-4">Admin Logbook</h2>

    <!-- User Selection -->
    <form method="GET" class="form-inline mb-4">
        <label class="mr-2">Select User:</label>
        <select name="user_id" class="form-control mr-2" onchange="this.form.submit()">
            <option value="">-- Select User --</option>
            <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
        <option value="<?= $user['id']; ?>" <?= ($user['id'] == $selected_user_id) ? 'selected' : ''; ?>>
          <?= $user['name']; ?>
        </option>
      <?php endwhile; ?>
        </select>
    </form>

    <?php if ($selected_user_id): ?>
    <!-- Room Reservation Log -->
<div class="mb-5">
    <h3>Room Reservation Log</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Reserve #</th>
                <th>Room</th>
                <th>Date</th>
                <th>Time</th>
                <th>Guests</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $room_query = mysqli_query($conn, "SELECT * FROM room_bookings WHERE user_id = '$selected_user_id'");
            if (mysqli_num_rows($room_query) > 0) {
                while ($row = mysqli_fetch_assoc($room_query)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['room_name']}</td>
                            <td>{$row['booking_date']}</td>
                            <td>{$row['booking_time']}</td>
                            <td>{$row['guests']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <a href='edit_room_log.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                                <a href='delete_room_log.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No reservations found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Product Order Log -->
<div>
    <h3>Product Order Log</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Ordered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $order_query = mysqli_query($conn, "SELECT * FROM product_orders WHERE user_id = '$selected_user_id'");
$grand_total = 0; // Initialize grand total

if (mysqli_num_rows($order_query) > 0) {
    while ($row = mysqli_fetch_assoc($order_query)) {
        $subtotal = $row['quantity'] * $row['price']; // Calculate subtotal
        $grand_total += $subtotal; // Add to grand total

        echo "<tr>
                <td><img src='image/{$row['product_image']}' width='50' height='50'></td>
                <td>{$row['product_name']}</td>
                <td>{$row['quantity']}</td>
                <td>₱{$row['price']}</td>
                <td>₱" . number_format($subtotal, 2) . "</td>
                <td>{$row['order_time']}</td>
                <td>
                    <a href='edit_order.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                    <a href='delete_order.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
            </tr>";
    }

    // Show grand total row
    echo "<tr>
            <td colspan='4' class='text-end'><strong>Total</strong></td>
            <td><strong>₱" . number_format($grand_total, 2) . "</strong></td>
            <td colspan='2'></td>
        </tr>";
} else {
    echo "<tr><td colspan='7'>No product orders found.</td></tr>"; // Update colspan to match new column
}
            ?>
        </tbody>
    </table>
</div>

    <?php else: ?>
        <div class="alert alert-info">Please select a user to view logs.</div>
    <?php endif; ?>
</div>
</body>
</html>
