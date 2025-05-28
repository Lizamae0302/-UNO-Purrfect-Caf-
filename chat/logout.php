<?php
session_start();
include_once "php/config.php";

if (isset($_SESSION['unique_id'])) {
    $logout_id = $_SESSION['unique_id'];
    
    // Set status to "Offline"
    $status = "Offline";
    $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$logout_id}");

    if ($sql) {
        session_unset();
        session_destroy();
        header("location: login.php");
    }
}
?>
