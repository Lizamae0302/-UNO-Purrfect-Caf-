<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['user_email']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$step = isset($_GET['step']) ? $_GET['step'] : 'review';
$room = $_SESSION['selected_room'] ?? null;
$room_name = $room['name'] ?? null;

// Handle room selection from shop
if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    $result = mysqli_query($conn, "SELECT * FROM rooms WHERE id = '$room_id'");
    $_SESSION['selected_room'] = mysqli_fetch_assoc($result);
    header("Location: booking_cart.php?step=review");
    exit();
}

// Move to next step (review → details)
if (isset($_POST['next_step'])) {
    $_SESSION['booking_details'] = $_POST;
    header("Location: booking_cart.php?step=details");
    exit();
}

// Handle final confirmation (details → done)
if (isset($_POST['confirm_booking'])) {
    $booking = $_SESSION['booking_details'];
    $room = $_SESSION['selected_room'];
    $user_email = $_SESSION['user_email'];

    // Get user ID
    $user_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE email = '$user_email'"));
    $user_id = $user_info['id'];

    $booking_date = $booking['date'];
    $booking_time = $booking['time'];
    $room_name = $room['name'];
    $room_id = $room['id'];

    // Check if room is fully booked
    $check_query = "SELECT COUNT(*) AS total FROM room_bookings 
                    WHERE room_name = ? AND booking_date = ? AND booking_time = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "sss", $room_name, $booking_date, $booking_time);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_bind_result($check_stmt, $existing_bookings);
    mysqli_stmt_fetch($check_stmt);
    mysqli_stmt_close($check_stmt);

    // Get room capacity
    $room_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT availability FROM rooms WHERE id = $room_id"));
    $room_capacity = $room_info['availability'] ?? 1;

    // Determine booking status
    $status = ($existing_bookings >= $room_capacity) ? 'Fully Booked' : 'Available';

    // Insert booking
    $insert_stmt = mysqli_prepare($conn, "INSERT INTO room_bookings 
        (user_id, room_name, guests, booking_date, booking_time, status) 
        VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($insert_stmt, "isisss", $user_id, $room_name, $booking['guests'], $booking_date, $booking_time, $status);
    mysqli_stmt_execute($insert_stmt);
    $reservation_id = mysqli_insert_id($conn);
    mysqli_stmt_close($insert_stmt);

    // booking_cart.php

if ($_SESSION['step'] === 'done' && isset($_SESSION['booking_room_id'])) {
    $roomId = $_SESSION['booking_room_id'];

    // Restore room status to 'Available'
    $updateRoom = $conn->prepare("UPDATE rooms SET status = 'Available' WHERE id = ?");
    $updateRoom->bind_param("i", $roomId);
    $updateRoom->execute();
    $updateRoom->close();

    // Clear session variables
    unset($_SESSION['booking_room_id']);
    unset($_SESSION['step']);
}


    // Redirect to confirmation
    header("Location: booking_cart.php?step=done&reservation_id=$reservation_id");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Cart</title>
     <!-- animation links -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation links -->
     

    <!-- fonts links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <!-- fonts links -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
   <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

   <style>
      body {
         font-family: "DynaPuff", system-ui;
         background-color: #F7E6CA;
         display: flex;
      }
      h2{
      font-size:3rem;
        color:#573818;
    }
    .stepper {
      font-family: "DynaPuff", system-ui;
      font-size:1.5rem;
      color:#573818;
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }
    .step {
      text-align: center;
      flex: 1;
      position: relative;
    }
    .step .room{
      color:#573818;
    }
    .step::before {
      content: '';
      height: 4px;
      background: #ccc;
      position: absolute;
      top: 15px;
      left: 50%;
      right: -50%;
      z-index: -1;
    }
    .step:last-child::before {
      display: none;
    }
    .step .circle {
      width: 30px;
      height: 30px;
      margin: 0 auto 10px;
      border-radius: 50%;
      background-color: #ccc;
      line-height: 30px;
      font-size:1.3rem;
      color: white;
    }
    .step.active .circle, .step.complete .circle {
      background-color: #28a745;
    }
    .step.complete .circle {
      background-color: #17a2b8;
    }
      h2{
        font-size:3rem;
        font-weight:bold;
        color:#573818;
        font-family: "DynaPuff", system-ui;
      }
      h4{
        color:#573818;
      }
      h5{
      font-size:2.5rem;
      color:#d68c00;
      font-family: "DynaPuff", system-ui;
     }
     .container{
      color:transparent;
     }
      .btn-primary{
        font-size:1.2rem;
      }
      .btn-success{
        font-size:1.2rem;
      }
      a{
        font-size:1.2rem;
      }
      p strong{
        padding-left:1rem;
        font-family: "DynaPuff", system-ui;
        font-weight:normal;
        font-size:1.3rem;
        color:rgb(199, 139, 28);
      }
      h3{
        color:rgb(228, 59, 163);
      }
      p{
        color:#573818;
        font-size:1.5rem;
        font-weight:normal;
      }
      label{
        font-size:1.3rem;
        font-family: "DynaPuff", system-ui;
        color:rgb(199, 139, 28);
      }
      .list-group{
        background-color:transparent;
      }
      .mb-3 strong{
        color:rgb(233, 119, 189);
      }
      li{
        padding-left:2rem;
      }
      strong{
        font-size:1.3rem;
        color:pink;
      }
      .btn-outline-secondary:hover{
        background-color:crimson;
      }

.banner {
  position: relative;
  background-color: #f8f9fa;
  padding: 2rem;
  border-radius: 10px;
  margin-bottom: 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  overflow: hidden;
}

.banner .content {
  max-width: 0%;
  color: #333;
}

.banner .content h3 {
  font-size: 2rem;
  margin: 0;
  font-weight: 700;
}

.banner .content h2 {
  font-weight: 400;
  font-size: 1.25rem;
  margin-top: 1rem;
  line-height: 1.4;
  color: #555;
}

.banner .content ul {
  list-style: none;
  padding: 0;
  margin-top: 1rem;
  font-size: 1rem;
  color: #444;
  margin-left:30rem;
}

.banner .content ul li {
  margin-bottom: 0.5rem;
}

.banner-overlay-image {
  max-width: 50%;
  display: flex;
  justify-content: flex-end;
}

.banner-overlay-image img {
  width: 200%;
  height: 300%;
  user-select: none;
  pointer-events: none;
}

/* Responsive for smaller screens */
@media (max-width: 768px) {
  .banner {
    flex-direction: column;
    padding: 1.5rem;
  }
  .banner .content {
    max-width: 50%;
    margin-bottom: 1.5rem;
  }
  .banner-overlay-image {
    max-width: 60%;
    justify-content: center;
  }
}


@media print {
  body * {
    visibility: hidden;
  }
  #ticket, #ticket * {
    visibility: visible;
  }
  #ticket {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
}

  </style>
</head>
<body>

<div class="container mt-5" data-aos="fade-up" data-aos-duration="1000">
  <h2 class="mb-4 text-center">Your Booking Progress</h2>

  <!-- Stepper -->
<div class="stepper">
  <div class="step <?= $step === 'review' ? 'active' : 'complete' ?>">
    <div class="circle">1</div>
    <div>Review</div>
  </div>
  <div class="step <?= $step === 'details' ? 'active' : ($step === 'done' ? 'complete' : '') ?>">
    <div class="circle">2</div>
    <div>Details</div>
  </div>
  <div class="step <?= $step === 'done' ? 'active' : '' ?>">
    <div class="circle">3</div>
    <div>Done</div>
  </div>
</div>

<?php if ($step === 'review' && $room_name): ?>
  <form method="POST">
    <p><strong>Name:</strong> <?= $_SESSION['user_name']; ?></p>
    <p><strong>Email:</strong> <?= $_SESSION['user_email']; ?></p>
    <p><strong>Room:</strong> <?= htmlspecialchars($_SESSION['selected_room']['name'] ?? 'N/A'); ?></p><br>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label">Booking Date</label>
        <input type="date" name="date" required class="form-control">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Time</label>
        <input type="time" name="time" required class="form-control">
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Guests</label>
        <input type="number" name="guests" min="1" required class="form-control">
      </div>
    </div>

    <button type="submit" name="next_step" class="btn btn-success">Continue to Details</button><br><br>
    <a href="shop.php" class="btn btn-outline-secondary">Return to Shop</a>
  </form>

<?php elseif ($step === 'details' && isset($_SESSION['booking_details'])): ?>
  <div class="banner" style="position: relative; background-color: #573818; border-radius: 10px; margin-bottom: 2rem; display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap;">
    <div class="left-content" style="flex: 1; min-width: 250px;">
      <h3 data-aos="fade-in" data-aos-duration="1500" style="font-size: 2.3rem; color: rgb(199, 139, 28);">
        <?= htmlspecialchars($room['name']); ?>
      </h3>
      <h2 data-aos="fade-up" data-aos-duration="1500" style="font-weight: normal; font-size: 1.2rem; margin-top: 1rem; color:gray;">
        Please confirm your details below:
      </h2>
      <div class="banner-overlay-image" data-aos="fade-right" data-aos-duration="1000" style="margin-top: 1rem;">
        <img src="./image/cup.png" alt="Cup" style="width: 180px; height: 180px;">
      </div>
    </div>

    <div class="right-content" style="flex: 1; min-width: 250px;">
      <ul style="list-style: none; padding: 0; margin-top: 0; font-size: 1.1rem; color: #E8D59E; word-spacing: 15px; line-height: 1.8;">
        <li><strong>Name:</strong> <?= htmlspecialchars($_SESSION['user_name']); ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user_email']); ?></li>
        <li><strong>Date:</strong> <?= htmlspecialchars($_SESSION['booking_details']['date']); ?></li>
        <li><strong>Time:</strong> <?= htmlspecialchars($_SESSION['booking_details']['time']); ?></li>
        <li><strong>Guests:</strong> <?= htmlspecialchars($_SESSION['booking_details']['guests']); ?></li>
        <li><strong>Branch:</strong> <?= htmlspecialchars($room['branch']); ?></li>
        <li><strong>Price:</strong> ₱<?= htmlspecialchars($room['price']); ?></li>
      </ul>
    </div>
  </div>

  <form method="POST" class="text-center mt-4">
    <button type="submit" name="confirm_booking" class="btn btn-success w-80">✅ Confirm Booking</button>
  </form>

<?php elseif ($step === 'done' && isset($_GET['reservation_id'])): ?>
  <?php
    $reservation_id = intval($_GET['reservation_id']);
    $user_email = $_SESSION['user_email'];

    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE email = '$user_email'"));
    $user_id = $user['id'] ?? 0;

    $res_sql = "SELECT * FROM room_bookings WHERE id = $reservation_id AND user_id = $user_id";
    $res_result = mysqli_query($conn, $res_sql);
    $reservation = mysqli_fetch_assoc($res_result);

    $room_name = $reservation['room_name'] ?? 'N/A';
    $date = $reservation['booking_date'] ?? '';
    $time = $reservation['booking_time'] ?? '';
    $formattedDate = $date ? date("F j, Y", strtotime($date)) : 'Unknown Date';
  ?>

  <div class="container d-flex justify-content-center">
    <div id="ticket" class="card p-4 shadow" style="max-width: 400px; width: 100%;">
      <div class="text-center mb-3">
        <h3><img src="image/Pi.png" alt="" width="50px"> Booking Ticket</h3>
        <small class="text-muted">Please present this ticket upon arrival</small>
      </div>

      <ul class="list-group mb-3" style="color:rgb(238, 189, 124); word-spacing:10px;">
        <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($_SESSION['user_name']); ?></li>
        <li class="list-group-item"><strong>Room:</strong> <?= htmlspecialchars($room_name); ?></li>
        <li class="list-group-item"><strong>Pass:</strong> <?= 'Reservation #' . htmlspecialchars($reservation_id); ?></li>
        <li class="list-group-item"><strong>Schedule:</strong> <?= htmlspecialchars($date . ' at ' . $time); ?></li>
      </ul>

      <div class="text-center">
        <button onclick="window.print()" class="btn btn-outline-primary mb-2">🖨️ Print Ticket</button><br>
        <a href="shop.php" class="btn btn-success">Return to Shop</a>
      </div>
    </div>
  </div>

<?php else: ?>
  <p class="text-danger">No booking selected. <a href="shop.php">Return to shop</a>.</p>
<?php endif; ?>



<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init();
</script>

</div>
</body>
</html>
