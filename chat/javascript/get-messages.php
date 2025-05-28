<?php
session_start();
include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];
$incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

$sql = "SELECT * FROM messages WHERE 
        (incoming_msg_id = {$incoming_id} AND outgoing_msg_id = {$outgoing_id}) 
        OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
        ORDER BY msg_id ASC";

$query = mysqli_query($conn, $sql);
$output = "";

while ($msg = mysqli_fetch_assoc($query)) {
    $position = ($msg['outgoing_msg_id'] == $outgoing_id) ? 'outgoing' : 'incoming';
    
    // Ensure "Seen" status updates correctly
    $seen_status = ($msg['seen_status'] == 1) ? "<span class='seen'>✔ Seen</span>" : "<span class='delivered'>✔ Delivered</span>";
    
    // Format time properly
    $formatted_time = date("h:i A", strtotime($msg['msg_time']));

    $output .= '
        <div class="message '.$position.'" data-msgid="'.$msg['msg_id'].'">
            <p>'.$msg['msg'].'</p>
            <small class="message-time">'.$formatted_time.'</small> 
            <small class="seen-status">'.$seen_status.'</small>
            <button class="btn btn-danger delete-msg" data-id="'.$msg['msg_id'].'">Delete</button>
        </div>';
}

// Mark messages as "seen" when retrieved
$update_seen = "UPDATE messages SET seen_status = 1 
                WHERE incoming_msg_id = {$outgoing_id} AND outgoing_msg_id = {$incoming_id}";
mysqli_query($conn, $update_seen);

echo $output;
?>
