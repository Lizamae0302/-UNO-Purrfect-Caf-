<?php
session_start();
include 'config.php'; // DB connection

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo "Please login to view your orders.";
    exit;
}

// Fetch all orders by user
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-card img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
        .section-title { margin-top: 30px; margin-bottom: 10px; }
        .status-badge { font-size: 0.8rem; }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4">🛍️ My Orders</h2>

    <!-- CART ORDERS -->
    <h4 class="section-title">🛒 My Cart / Orders</h4>
    <div class="row">
        <?php foreach ($orders as $order): ?>
            <?php if (in_array($order['status'], ['pending', 'processing'])): ?>
            <div class="col-md-4">
                <div class="card mb-3 order-card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <img src="<?= $order['product_image'] ?>" class="me-3">
                        <div>
                            <h6><?= $order['product_name'] ?></h6>
                            <p class="mb-1">Qty: <?= $order['quantity'] ?> | ₱<?= $order['price'] ?></p>
                            <span class="badge bg-warning text-dark status-badge"><?= ucfirst($order['status']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- DELIVERY STATUS -->
    <h4 class="section-title">📦 Delivery Status</h4>
    <div class="row">
        <?php foreach ($orders as $order): ?>
            <?php if ($order['status'] === 'delivering'): ?>
            <div class="col-md-4">
                <div class="card mb-3 order-card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <img src="<?= $order['product_image'] ?>" class="me-3">
                        <div>
                            <h6><?= $order['product_name'] ?></h6>
                            <p class="mb-1">Qty: <?= $order['quantity'] ?> | ₱<?= $order['price'] ?></p>
                            <span class="badge bg-info text-dark status-badge">On the way</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- COMPLETED ORDERS -->
    <h4 class="section-title">✅ Completed Orders</h4>
    <div class="row">
        <?php foreach ($orders as $order): ?>
            <?php if ($order['status'] === 'completed'): ?>
            <div class="col-md-4">
                <div class="card mb-3 order-card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <img src="<?= $order['product_image'] ?>" class="me-3">
                        <div>
                            <h6><?= $order['product_name'] ?></h6>
                            <p class="mb-1">Qty: <?= $order['quantity'] ?> | ₱<?= $order['price'] ?></p>
                            <span class="badge bg-success status-badge">Delivered</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- ORDER HISTORY -->
    <h4 class="section-title">📜 Order History</h4>
    <div class="row">
        <?php foreach ($orders as $order): ?>
            <?php if (in_array($order['status'], ['completed', 'canceled'])): ?>
            <div class="col-md-4">
                <div class="card mb-3 order-card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <img src="<?= $order['product_image'] ?>" class="me-3">
                        <div>
                            <h6><?= $order['product_name'] ?></h6>
                            <p class="mb-1">Qty: <?= $order['quantity'] ?> | ₱<?= $order['price'] ?></p>
                            <span class="badge <?= $order['status'] === 'completed' ? 'bg-success' : 'bg-danger' ?> status-badge">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

</div>
</body>
</html>
