<?php
session_start();
include_once "config.php";

if (isset($_SESSION['unique_id']) && isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $update_seen_query = "UPDATE messages SET seen_at = NOW() WHERE incoming_msg_id = {$_SESSION['unique_id']} AND outgoing_msg_id = {$user_id} AND seen_at IS NULL";
    mysqli_query($conn, $update_seen_query);
    echo "updated";
}
?>
