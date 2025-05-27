<?php
include('config/config.php');

$input = json_decode(file_get_contents('php://input'), true);
$staff_number = $input['staff_number'] ?? '';

header('Content-Type: application/json');

if (!$staff_number) {
  echo json_encode(['exists' => false]);
  exit;
}

$stmt = $mysqli->prepare("SELECT staff_id FROM rpos_staff WHERE staff_number = ?");
$stmt->bind_param('s', $staff_number);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo json_encode(['exists' => true]);
} else {
  echo json_encode(['exists' => false]);
}
$stmt->close();
?>
