<?php
session_start();
include_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['message_id'])) {
    $message_id = mysqli_real_escape_string($conn, $_POST['message_id']);
    $sql = "DELETE FROM messages WHERE msg_id = {$message_id} AND outgoing_msg_id = {$_SESSION['unique_id']}";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
