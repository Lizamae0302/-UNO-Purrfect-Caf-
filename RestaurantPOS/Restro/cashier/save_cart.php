<?php
session_start();
include('config/config.php');

// Ensure user is logged in
if (!isset($_SESSION['staff_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

$staff_id = $_SESSION['staff_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !is_array($data)) {
    echo json_encode(["success" => false, "message" => "No cart data"]);
    exit;
}

// Generate unique order ID
$order_id = uniqid('ORD-');

// Calculate total
$total_price = 0;
foreach ($data as $item) {
    $total_price += floatval($item['price']) * intval($item['qty']);
}

// Insert into `orders`
$order_stmt = $mysqli->prepare("INSERT INTO rpos_orders (order_id, total_price, staff_id, created_at) VALUES (?, ?, ?, NOW())");
$order_stmt->bind_param("sdi", $order_id, $total_price, $staff_id);
$order_stmt->execute();

// Insert each item into `order_items`
$item_stmt = $mysqli->prepare("INSERT INTO rposorder_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

foreach ($data as $product_id => $item) {
    $qty = intval($item['qty']);
    $price = floatval($item['price']);
    $item_stmt->bind_param("siid", $order_id, $product_id, $qty, $price);
    $item_stmt->execute();
}

// Save order_id in session (for payment)
$_SESSION['order_id'] = $order_id;
$_SESSION['cart'] = $data; // Optional: keep cart data

echo json_encode(["success" => true, "order_id" => $order_id]);
?>
