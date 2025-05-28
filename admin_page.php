<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch total counts from database
// Adjust table names and column names if needed

// Total room reservations
$result_reservations = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `room_bookings`") or die('Query failed');
$total_reservations = mysqli_fetch_assoc($result_reservations)['total'] ?? 0;

// Total quantity of ordered products
$result_orders = mysqli_query($conn, "SELECT SUM(quantity) AS total_quantity FROM `product_orders`") or die('Query failed');
$total_orders = mysqli_fetch_assoc($result_orders)['total_quantity'] ?? 0;

// Total messages
$result_messages = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `messages`") or die('Query failed');
$total_messages = mysqli_fetch_assoc($result_messages)['total'] ?? 0;

// Total reviews
$result_reviews = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `reviews`") or die('Query failed');
$total_reviews = mysqli_fetch_assoc($result_reviews)['total'] ?? 0;

// Total added products
$result_products = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `products`") or die('Query failed');
$total_products = mysqli_fetch_assoc($result_products)['total'] ?? 0;

// Total added rooms
$result_rooms = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `rooms`") or die('Query failed');
$total_rooms = mysqli_fetch_assoc($result_rooms)['total'] ?? 0;

// Total users
$result_users = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `users`") or die('Query failed');
$total_users = mysqli_fetch_assoc($result_users)['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Admin Dashboard - Totals</title>
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
      .main {
         margin-top:20px;
         margin-left: 260px;
         padding: 30px;
         width: 100%;
      }
      h1{
         color: #573818;
      }
      .card {
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
         background: white;
         padding: 20px;
         text-align: center;
         margin-bottom: 20px;
      }
      .card h2 {
         font-size: 48px;
         margin-bottom: 10px;
         color: #2e1700;
      }
      .card p {
         font-size: 18px;
         color: #555;
         margin: 0;
      }
      .dashboard-grid {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
         gap: 20px;
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

<div class="main">
   <h1>Admin Dashboard</h1><br>
   <div class="dashboard-grid">
      <div class="card">
         <h2><?php echo $total_reservations; ?></h2>
         <p>Total Room Reservations</p>
      </div>
      <div class="card">
         <h2><?php echo $total_orders; ?></h2>
         <p>Total Ordered Products</p>
      </div>
      <div class="card">
         <h2><?php echo $total_messages; ?></h2>
         <p>Total Messages</p>
      </div>
      <div class="card">
         <h2><?php echo $total_reviews; ?></h2>
         <p>Total Reviews</p>
      </div>
      <div class="card">
         <h2><?php echo $total_products; ?></h2>
         <p>Total Added Products</p>
      </div>
      <div class="card">
         <h2><?php echo $total_rooms; ?></h2>
         <p>Total Added Rooms</p>
      </div>
      <div class="card">
         <h2><?php echo $total_users; ?></h2>
         <p>Total Users</p>
      </div>
   </div>
</div>

</body>
</html>
