<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('Query failed');
    header('Location: admin_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Admin Users</title>
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
         margin-left: 260px;
         padding: 20px;
         width: 100%;
      }
      .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
         gap: 20px;
         margin-top: 20px;
      }
      .box {
         background: white;
         padding: 15px;
         border-radius: 10px;
         box-shadow: 0 2px 5px rgba(0,0,0,0.1);
         border-left: 5px solid #573818;
      }
      .box p {
         margin: 5px 0;
      }
      .delete-btn {
         display: inline-block;
         margin-top: 10px;
         padding: 5px 10px;
         background-color: #dc3545;
         color: white;
         border-radius: 5px;
         text-decoration: none;
      }
      .delete-btn:hover {
         background-color: #c82333;
      }
      .title {
         font-size: 24px;
         font-weight: bold;
         margin-bottom: 10px;
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
   <h1 class="title">Users Account</h1>

   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('Query failed');
         if (mysqli_num_rows($select_users) > 0) {
            while ($fetch_users = mysqli_fetch_assoc($select_users)) {
      ?>
         <div class="box">
            <p>User ID: <span><?php echo $fetch_users['id']; ?></span></p>
            <p>Username: <span><?php echo $fetch_users['name']; ?></span></p>
            <p>Email: <span><?php echo $fetch_users['email']; ?></span></p>
            <p>User Type: 
               <span style="color: <?php echo ($fetch_users['user_type'] == 'admin') ? 'orange' : 'black'; ?>">
                  <?php echo $fetch_users['user_type']; ?>
               </span>
            </p>
            <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Delete</a>
         </div>
      <?php
            }
         } else {
            echo "<p>No users found.</p>";
         }
      ?>
   </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>

</body>
</html>
