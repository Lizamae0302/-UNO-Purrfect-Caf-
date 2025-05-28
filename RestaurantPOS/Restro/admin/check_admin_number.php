<?php
include('config/config.php');

// Read JSON input
$input = json_decode(file_get_contents('php://input'), true);
$admin_number = $input['admin_number'] ?? '';

header('Content-Type: application/json');

if (!$admin_number) {
  echo json_encode(['exists' => false]);
  exit;
}

$stmt = $mysqli->prepare("SELECT admin_id FROM rpos_admin WHERE admin_number = ?");
$stmt->bind_param('s', $admin_number);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo json_encode(['exists' => true]);
} else {
  echo json_encode(['exists' => false]);
}
$stmt->close();
?>
