<?php
session_start();
include('config/config.php');

// If staff is logged in, log their time out
if (isset($_SESSION['staff_id'])) {
    $staff_id = $_SESSION['staff_id'];

    // Update the latest attendance record (today's) with time_out
    $stmt = $mysqli->prepare("
        UPDATE rpos_staff_attendance
        SET time_out = NOW()
        WHERE staff_id = ? AND log_date = CURDATE() AND time_out IS NULL
    ");
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $stmt->close();
}

// Clear session
unset($_SESSION['staff_id']);
session_destroy();

// Redirect to login page
header("Location: ../../index.php");
exit;
