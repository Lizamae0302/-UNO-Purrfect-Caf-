<?php
include('config/config.php');
$data = json_decode(file_get_contents("php://input"), true);
$user_number = $data['user_number'];

$response = ['exists' => false];

if ($stmt = $mysqli->prepare("SELECT admin_id FROM rpos_admin WHERE admin_number = ?")) {
  $stmt->bind_param("s", $user_number);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) $response['exists'] = true;
  $stmt->close();
}

if (!$response['exists']) {
  if ($stmt = $mysqli->prepare("SELECT staff_id FROM rpos_staff WHERE staff_number = ?")) {
    $stmt->bind_param("s", $user_number);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $response['exists'] = true;
    $stmt->close();
  }
}

echo json_encode($response);
