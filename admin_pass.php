<?php
@include 'config.php';
session_start();


if (isset($_POST['book_now'])) {
    $pass_id = $_POST['pass_id'];
    $date = $_POST['reservation_date'];
    $time = $_POST['reservation_time'];

    // Insert booking with status 'Pending'
    $insert = "INSERT INTO reservations (user_id, pass_id, reservation_date, reservation_time, status, created_at)
               VALUES ('$user_id', '$pass_id', '$date', '$time', 'Pending', NOW())";
    mysqli_query($conn, $insert);

    $message[] = "Reservation submitted successfully!";
}
?>

<form method="post">
  <input type="hidden" name="pass_id" value="<?= $_GET['pass_id'] ?>">
  <label>Date:</label>
  <input type="date" name="reservation_date" required class="form-control">
  <label>Time:</label>
  <input type="time" name="reservation_time" required class="form-control">
  <button type="submit" name="book_now" class="btn btn-success mt-3">Submit Reservation</button>
</form>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Booking Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
      padding: 40px;
      background-color: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }

    h2 {
      font-size: 3rem;
      margin-bottom: 30px;
      color: #573818;
    }

    table {
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th {
      background: #573818;
      color: white;
    }

    .btn-confirm {
      background-color: #28a745;
      color: white;
    }

    .btn-confirm[disabled] {
      background-color: #ccc;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Bookings Management</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>User</th>
        <th>Pass</th>
        <th>Date Booked</th>
        <th>Reservation Schedule</th>
        <th>Status</th>
        <th>Confirm</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($reservations)): ?>
        <tr>
          <td><?= htmlspecialchars($row['user_name']) ?></td>
          <td><?= htmlspecialchars($row['pass_name']) ?></td>
          <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
          <td><?= htmlspecialchars($row['reservation_date']) ?> - <?= htmlspecialchars($row['reservation_time']) ?></td>
          <td><?= $row['status'] ?></td>
          <td>
            <?php
              $created_time = strtotime($row['created_at']);
              $now = time();
              $diff = $now - $created_time;
              $can_confirm = $diff >= 3600; // 1 hour in seconds
            ?>
            <?php if ($row['status'] != 'Confirmed'): ?>
              <a href="?confirm_id=<?= $row['id'] ?>" class="btn btn-confirm btn-sm" <?= $can_confirm ? '' : 'disabled' ?>>
                Confirm
              </a>
            <?php else: ?>
              <span class="text-success">✓ Confirmed</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
