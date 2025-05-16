<?php
@include 'config.php';
session_start();

// Handle room selection from shop
if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    $_SESSION['selected_room'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rooms WHERE id = '$room_id'"));
}

// Move to next step
if (isset($_POST['next_step'])) {
    $_SESSION['booking_details'] = $_POST;
    header("Location: booking_cart.php?step=confirm");
    exit();
}

// Save reservation on final step
if (isset($_POST['confirm_booking'])) {
    $d = $_SESSION['booking_details'];
    $room = $_SESSION['selected_room'];

    $insert = mysqli_query($conn, "INSERT INTO reservations (name, email, branch, room, date, time, guests, notes) VALUES (
        '".mysqli_real_escape_string($conn, $d['name'])."',
        '".mysqli_real_escape_string($conn, $d['email'])."',
        '".mysqli_real_escape_string($conn, $room['branch'])."',
        '".mysqli_real_escape_string($conn, $room['name'])."',
        '".$d['date']."',
        '".$d['time']."',
        '".$d['guests']."',
        '".mysqli_real_escape_string($conn, $d['notes'])."'
    )") or die('query failed');

    unset($_SESSION['selected_room']);
    unset($_SESSION['booking_details']);

    header("Location: booking_cart.php?step=done");
    exit();
}

$step = $_GET['step'] ?? 'review';
$room = $_SESSION['selected_room'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Cart</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .stepper {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }
    .step {
      text-align: center;
      flex: 1;
      position: relative;
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
      color: white;
    }
    .step.active .circle, .step.complete .circle {
      background-color: #28a745;
    }
    .step.complete .circle {
      background-color: #17a2b8;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2 class="mb-4 text-center">Your Booking Progress</h2>

  <!-- Stepper -->
  <div class="stepper">
    <div class="step <?= $step === 'review' ? 'active' : ($step !== 'review' ? 'complete' : '') ?>">
      <div class="circle">1</div>
      <div>Review</div>
    </div>
    <div class="step <?= $step === 'details' ? 'active' : ($step === 'confirm' || $step === 'done' ? 'complete' : '') ?>">
      <div class="circle">2</div>
      <div>Details</div>
    </div>
    <div class="step <?= $step === 'confirm' ? 'active' : ($step === 'done' ? 'complete' : '') ?>">
      <div class="circle">3</div>
      <div>Confirm</div>
    </div>
  </div>

  <!-- Step Content -->
  <?php if ($step === 'review' && $room): ?>
    <div class="card mb-4">
      <div class="card-body">
        <h5><?= $room['name']; ?></h5>
        <p><strong>Branch:</strong> <?= $room['branch']; ?></p>
        <p><strong>Price:</strong> ₱<?= $room['price']; ?></p>
      </div>
    </div>
    <a href="booking_cart.php?step=details" class="btn btn-primary">Continue to Details</a>

  <?php elseif ($step === 'details' && $room): ?>
    <form method="POST">
      <div class="form-group">
        <label>Your Name</label>
        <input type="text" name="name" required class="form-control">
      </div>
      <div class="form-group">
        <label>Your Email</label>
        <input type="email" name="email" required class="form-control">
      </div>
      <div class="form-group">
        <label>Booking Date</label>
        <input type="date" name="date" required class="form-control">
      </div>
      <div class="form-group">
        <label>Time</label>
        <input type="time" name="time" required class="form-control">
      </div>
      <div class="form-group">
        <label>Guests</label>
        <input type="number" name="guests" min="1" required class="form-control">
      </div>
      <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" class="form-control"></textarea>
      </div>
      <button type="submit" name="next_step" class="btn btn-success">Continue to Confirm</button>
    </form>

  <?php elseif ($step === 'confirm' && isset($_SESSION['booking_details'])): ?>
    <h4>Confirm Your Booking</h4>
    <ul class="list-group mb-3">
      <li class="list-group-item">Room: <?= $room['name']; ?></li>
      <li class="list-group-item">Branch: <?= $room['branch']; ?></li>
      <li class="list-group-item">Name: <?= $_SESSION['booking_details']['name']; ?></li>
      <li class="list-group-item">Email: <?= $_SESSION['booking_details']['email']; ?></li>
      <li class="list-group-item">Date: <?= $_SESSION['booking_details']['date']; ?></li>
      <li class="list-group-item">Time: <?= $_SESSION['booking_details']['time']; ?></li>
      <li class="list-group-item">Guests: <?= $_SESSION['booking_details']['guests']; ?></li>
    </ul>
    <form method="POST">
      <button type="submit" name="confirm_booking" class="btn btn-success">Confirm Booking</button>
    </form>

  <?php elseif ($step === 'done'): ?>
    <div class="alert alert-success text-center">
      <h4>🎉 Booking Confirmed!</h4>
      <p>Thank you! We'll contact you shortly.</p>
      <a href="shop.php" class="btn btn-primary mt-3">Return to Shop</a>
    </div>
  <?php else: ?>
    <p class="text-danger">No booking selected. <a href="shop.php">Return to shop</a>.</p>
  <?php endif; ?>

</div>
</body>
</html>
