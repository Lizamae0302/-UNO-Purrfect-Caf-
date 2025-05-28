<?php
@include 'config.php';
session_start();

if (!isset($_POST['room_id']) || !isset($_SESSION['user_id'])) {
    header("Location: shop.php");
    exit;
}

$room_id = $_POST['room_id'];
$user_id = $_SESSION['user_id'];

// Get room/pass info
$room = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rooms WHERE id = $room_id"));

if (!$room) {
    echo "Invalid Room.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Review Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4>Review Your Booking</h4>
        </div>
        <div class="card-body">
            <p><strong>Pass:</strong> <?= htmlspecialchars($room['name']) ?></p>
            <p><strong>Branch:</strong> <?= htmlspecialchars($room['branch']) ?></p>
            <p><strong>Price:</strong> ₱<?= number_format($room['price'], 2) ?></p>

            <form action="confirm_booking.php" method="POST">
                <input type="hidden" name="room_id" value="<?= $room_id ?>">
                <button type="submit" class="btn btn-success">Confirm Booking</button>
                <a href="shop.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
