<?php
@include 'config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php"); // redirect to login if not logged in
    exit();
}

$email = $_SESSION['user_email'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- bootstrap links -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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

   
  <style>
    body{
        background-color:#F7E6CA;
    }
    .stepper {
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
    .step::before {
      content: '';
      height: 6px;
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
      width: 35px;
      height: 35px;
      margin: 0 auto 10px;
      border-radius: 50%;
      background-color: #ccc;
      line-height: 30px;
      font-size:1.5rem;
      color: white;
    }
    .step.active .circle, .step.complete .circle {
      background-color: #28a745;
    }
    .step.complete .circle {
      background-color: #17a2b8;
    }
       h2{
        font-size:2.7rem;
        font-weight:bold;
        color:#573818;
      }
      p{
        font-size:1.5rem;
      }
      h3{
        font-size:2rem;
        font-weight:bold;
        color:#573818;
      }
      th{
        font-size:1.5rem;
        font-weight:1px;
        color:crimson;
      }
      td{
        font-size:1.3rem;
        color:dark gray;
      }
      .table-bordered{
        border-color:green;
        padding:50rem;
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

<p class="text-danger">No booking selected. <a href="shop.php">Return to shop</a>.</p><br>

<div class="container mt-5">
  <h3 class="mb-4">Welcome! Here is your Booking History</h3>

  <?php
    $query = mysqli_query($conn, "SELECT * FROM reservations WHERE email = '".mysqli_real_escape_string($conn, $_SESSION['user_email'])."'
 ORDER BY id DESC");

    if (mysqli_num_rows($query) > 0):
  ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Reservation ID</th>
          <th>Room</th>
          <th>Branch</th>
          <th>Date</th>
          <th>Time</th>
          <th>Guests</th>
          <th>Notes</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['room'] ?></td>
          <td><?= $row['branch'] ?></td>
          <td><?= $row['date'] ?></td>
          <td><?= $row['time'] ?></td>
          <td><?= $row['guests'] ?></td>
          <td><?= $row['notes'] ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-warning">You have no bookings yet.</div>
  <?php endif; ?>
</div>

</body>
</html>
