<?php
@include 'config.php';
session_start();

if (!isset($_POST['room_id']) || !isset($_SESSION['user_id'])) {
    header("Location: shop.php");
    exit;
}

$room_id = $_POST['room_id'];
$user_id = $_SESSION['user_id'];

// Get room info
$room = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM rooms WHERE id = $room_id"));
if (!$room) {
    echo "Room not found.";
    exit;
}
$price = $room['price'];

// Insert booking
mysqli_query($conn, "INSERT INTO bookings (user_id, room_id, price, status, booked_at) VALUES ('$user_id', '$room_id', '$price', 'Pending', NOW())");

$booking_id = mysqli_insert_id($conn);

// Redirect to receipt page
header("Location: receipt.php?booking_id=$booking_id");
exit;
?>
