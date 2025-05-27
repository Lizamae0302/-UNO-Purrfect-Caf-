<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$filter = $_GET['filter'] ?? 'this_month';

switch ($filter) {
    case 'today':
        $date_condition = "DATE(a.log_date) = CURDATE()";
        break;
    case 'yesterday':
        $date_condition = "DATE(a.log_date) = CURDATE() - INTERVAL 1 DAY";
        break;
    case 'this_week':
        $date_condition = "YEARWEEK(a.log_date, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'this_month':
        $date_condition = "YEAR(a.log_date) = YEAR(CURDATE()) AND MONTH(a.log_date) = MONTH(CURDATE())";
        break;
    case 'all_time':
    default:
        $date_condition = "1";
        break;
}

$query = "
    SELECT s.staff_name, a.log_date,
           TIME_FORMAT(a.time_in, '%h:%i %p') AS time_in,
           TIME_FORMAT(a.time_out, '%h:%i %p') AS time_out,
           TIMEDIFF(a.time_out, a.time_in) AS total_hours
    FROM rpos_staff_attendance a
    JOIN rpos_staff s ON a.staff_id = s.staff_id
    WHERE $date_condition
    ORDER BY a.log_date DESC, a.time_in DESC
";

$stmt = $mysqli->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$attendance = [];
while ($row = $result->fetch_assoc()) {
    $attendance[] = $row;
}

header('Content-Type: application/json');
echo json_encode($attendance);
exit;
