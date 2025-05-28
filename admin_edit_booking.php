<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: admin_bookings.php');
    exit();
}

$id = intval($_GET['id']);
$booking = $conn->query("SELECT * FROM reservations WHERE id = $id")->fetch_assoc();

if (!$booking) {
    die('Booking not found');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = intval($_POST['guests']);
    $notes = $conn->real_escape_string($_POST['notes']);

    $stmt = $conn->prepare("UPDATE reservations SET date=?, time=?, guests=?, notes=? WHERE id=?");
    $stmt->bind_param('ssisi', $date, $time, $guests, $notes, $id);
    $stmt->execute();
    $stmt->close();

    header('Location: admin_bookings.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Edit Booking #<?= $id ?></title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>
<div class="container mt-4">
  <h2>Edit Booking #<?= $id ?></h2>
  <form method="POST">
    <div class="form-group">
      <label>Name</label>
      <input class="form-control" value="<?= htmlspecialchars($booking['name']) ?>" disabled>
    </div>
    <div class="form-group">
      <label>Email</label>
      <input class="form-control" value="<?= htmlspecialchars($booking['email']) ?>" disabled>
    </div>
    <div class="form-group">
      <label>Branch</label>
      <input class="form-control" value="<?= htmlspecialchars($booking['branch']) ?>" disabled>
    </div>
    <div class="form-group">
      <label>Room</label>
      <input class="form-control" value="<?= htmlspecialchars($booking['room']) ?>" disabled>
    </div>
    <div class="form-group">
      <label>Date</label>
      <input type="date" name="date" class="form-control" value="<?= $booking['date'] ?>" required>
    </div>
    <div class="form-group">
      <label>Time</label>
      <input type="time" name="time" class="form-control" value="<?= $booking['time'] ?>" required>
    </div>
    <div class="form-group">
      <label>Guests</label>
      <input type="number" name="guests" class="form-control" min="1" value="<?= $booking['guests'] ?>" required>
    </div>
    <div class="form-group">
      <label>Notes</label>
      <textarea name="notes" class="form-control"><?= htmlspecialchars($booking['notes']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-success">Save Changes</button>
    <a href="admin_bookings.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
