<?php
session_start();
include('config/config.php');

$filter = $_GET['filter'] ?? 'this_month';
$staff_id = intval($_GET['staff_id'] ?? 0); // enforce int

if ($staff_id === 0) {
    echo json_encode(["labels" => [], "sales" => []]);
    exit;
}

$where = "WHERE o.staff_id = ?";
$params = [$staff_id];
$types = "i";

switch ($filter) {
    case 'today':
        $where .= " AND DATE(o.created_at) = CURDATE()";
        break;
    case 'yesterday':
        $where .= " AND DATE(o.created_at) = CURDATE() - INTERVAL 1 DAY";
        break;
    case 'this_week':
        $where .= " AND YEARWEEK(o.created_at, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'this_month':
    default:
        $where .= " AND MONTH(o.created_at) = MONTH(CURDATE()) AND YEAR(o.created_at) = YEAR(CURDATE())";
        break;
}

$sql = "
    SELECT p.prod_name, SUM(oi.quantity * oi.price) AS total_sales
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN rpos_products p ON oi.product_id = p.prod_id
    $where
    GROUP BY p.prod_name
    ORDER BY total_sales DESC
";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

if ($stmt->error) {
    echo json_encode(["error" => $stmt->error]);
    exit;
}

$result = $stmt->get_result();
$labels = [];
$sales = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['prod_name'];
    $sales[] = round($row['total_sales'], 2);
}

echo json_encode([
    "labels" => $labels,
    "sales" => $sales
]);
